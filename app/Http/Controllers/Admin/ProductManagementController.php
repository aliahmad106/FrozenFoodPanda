<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;        
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductManagementController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }    

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'is_popular' => 'nullable|boolean'
        ]);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            
            // Create directory if it doesn't exist
            $targetPath = public_path('images/products');
            if (!file_exists($targetPath)) {
                mkdir($targetPath, 0755, true);
            }
    
            \Log::info('Processing image:', [
                'original_name' => $image->getClientOriginalName(),
                'target_path' => $targetPath,
                'filename' => $filename
            ]);
    
            try {
                // Move the uploaded file directly to public directory
                $image->move($targetPath, $filename);
                $imageUrl = '/images/products/' . $filename;
                
                \Log::info('Image stored:', [
                    'path' => $targetPath . '/' . $filename,
                    'exists' => file_exists($targetPath . '/' . $filename),
                    'image_url' => $imageUrl
                ]);
            } catch (\Exception $e) {
                \Log::error('Image storage failed:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }
        }
    
        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'image_url' => $imageUrl ?? null,
            'is_active' => $request->has('is_active'),
            'featured' => $request->has('featured'),
            'is_popular' => $request->has('is_popular')
        ]);
    
        return redirect()->route('admin.products')
            ->with('success', 'Product created successfully');
    }
    public function edit(Product $product)
    {
        $categories = Category::all();
        \Log::info('Edit form data:', [
            'product_category_id' => $product->category_id,
            'product' => $product->toArray(),
            'categories' => $categories->toArray()
        ]);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'is_popular' => 'nullable|boolean'
        ]);
    
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_url) {
                $oldImagePath = public_path(ltrim($product->image_url, '/'));
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            
            // Create directory if it doesn't exist
            $targetPath = public_path('images/products');
            if (!file_exists($targetPath)) {
                mkdir($targetPath, 0755, true);
            }
    
            // Move the uploaded file directly to public directory
            $image->move($targetPath, $filename);
            $imageUrl = '/images/products/' . $filename;
            
            $product->image_url = $imageUrl;
        }
    
        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'is_active' => $request->has('is_active'),
            'featured' => $request->has('featured'),
            'is_popular' => $request->has('is_popular')
        ]);
    
        return redirect()->route('admin.products')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        try {
            // Begin transaction
            DB::beginTransaction();
            
            // Delete related records first
            CartItem::where('product_id', $product->product_id)->delete();
            OrderItem::where('product_id', $product->product_id)->delete();
            Review::where('product_id', $product->product_id)->delete();
            
            // Delete the product image if it exists
            if ($product->image_url) {
                Storage::delete(str_replace('/storage', 'public', $product->image_url));
            }
            
            // Delete the product
            $product->delete();
            
            DB::commit();
    
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product deleted successfully'
                ]);
            }
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully');
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Product deletion error: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete product'
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Failed to delete product');
        }
    }
     

    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return redirect()->route('admin.products');
    }

    public function analytics()
    {
        // Calculate total revenue from orders with payment_status = 'paid' only
        $totalRevenue = \App\Models\Order::where('payment_status', 'paid')
            ->sum('total');

        // Get product analytics with proper revenue calculation - only count paid orders
        $productAnalytics = Product::select('products.*')
            ->leftJoin('order_items', 'products.product_id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('reviews', 'products.product_id', '=', 'reviews.product_id')
            ->where(function($query) {
                $query->where('orders.payment_status', 'paid')
                      ->orWhereNull('orders.id'); // Include products with no orders
            })
            ->groupBy('products.product_id')
            ->selectRaw('
                COUNT(DISTINCT CASE WHEN orders.payment_status = "paid" THEN order_items.id ELSE NULL END) as order_items_count,
                SUM(CASE WHEN orders.payment_status = "paid" THEN order_items.price * order_items.quantity ELSE 0 END) as order_items_sum_price_multiply_by_quantity,
                AVG(reviews.rating) as reviews_avg_rating
            ')
            ->get();

        $analytics = [
            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('is_active', true)->count(),
            'totalOrders' => \App\Models\Order::count(),
            'totalRevenue' => $totalRevenue,
            'productAnalytics' => $productAnalytics
        ];
    
        return view('admin.analytics.index', compact('analytics'));
    }    
}