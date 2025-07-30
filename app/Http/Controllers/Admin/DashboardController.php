<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get basic statistics
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')
            ->where('status', '!=', 'refunded')
            ->sum('total');
        $totalCustomers = User::where('is_admin', false)->count();
        $totalProducts = Product::count();
        
        // Calculate growth percentages (comparing to previous month)
        $currentMonth = now()->month;
        $previousMonth = now()->subMonth()->month;
        
        $currentMonthOrders = Order::whereMonth('created_at', $currentMonth)->count();
        $previousMonthOrders = Order::whereMonth('created_at', $previousMonth)->count();
        $orderGrowth = $previousMonthOrders > 0 
            ? round((($currentMonthOrders - $previousMonthOrders) / $previousMonthOrders) * 100) 
            : 100;
        
        $currentMonthRevenue = Order::whereMonth('created_at', $currentMonth)
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'refunded')
            ->sum('total');
        $previousMonthRevenue = Order::whereMonth('created_at', $previousMonth)
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'refunded')
            ->sum('total');
        $revenueGrowth = $previousMonthRevenue > 0 
            ? round((($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100) 
            : 100;
        
        $currentMonthCustomers = User::where('is_admin', false)
            ->whereMonth('created_at', $currentMonth)
            ->count();
        $previousMonthCustomers = User::where('is_admin', false)
            ->whereMonth('created_at', $previousMonth)
            ->count();
        $customerGrowth = $previousMonthCustomers > 0 
            ? round((($currentMonthCustomers - $previousMonthCustomers) / $previousMonthCustomers) * 100) 
            : 100;
        
        $currentMonthProducts = Product::whereMonth('created_at', $currentMonth)->count();
        $previousMonthProducts = Product::whereMonth('created_at', $previousMonth)->count();
        $productGrowth = $previousMonthProducts > 0 
            ? round((($currentMonthProducts - $previousMonthProducts) / $previousMonthProducts) * 100) 
            : 100;
        
        // Get recent orders
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Get pending reviews
        $pendingReviews = Review::with(['user', 'product'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Get top selling products
        $topProducts = Product::with('category')
            ->select('products.*')
            ->leftJoin('order_items', 'products.product_id', '=', 'order_items.product_id')
            ->groupBy('products.product_id')
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();
        
        // Get weekly sales data
        $weeklySales = $this->getWeeklySalesData();
        
        // Get monthly sales data
        $monthlySales = $this->getMonthlySalesData();
        
        return view('admin.dashboard', compact(
            'totalOrders', 
            'totalRevenue', 
            'totalCustomers', 
            'totalProducts',
            'orderGrowth',
            'revenueGrowth',
            'customerGrowth',
            'productGrowth',
            'recentOrders',
            'pendingReviews',
            'topProducts',
            'weeklySales',
            'monthlySales'
        ));
    }
    
    private function getWeeklySalesData()
    {
        // Get sales for each day of the current week
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        
        $weeklySales = [];
        $weeklyLabels = [];
        
        for ($day = clone $startOfWeek; $day <= $endOfWeek; $day->addDay()) {
            $date = $day->format('Y-m-d');
            $dayName = $day->format('D');
            
            $sales = Order::whereDate('created_at', $date)
                ->where('payment_status', 'paid')
                ->sum('total');
                
            $weeklySales[] = $sales;
            $weeklyLabels[] = $dayName;
        }
        
        return [
            'labels' => $weeklyLabels,
            'data' => $weeklySales
        ];
    }
    
    private function getMonthlySalesData()
    {
        // Get sales for each month of the current year
        $monthlySales = [];
        $monthlyLabels = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::create(now()->year, $month, 1);
            $monthName = $date->format('M');
            
            $sales = Order::whereYear('created_at', now()->year)
                ->whereMonth('created_at', $month)
                ->where('payment_status', 'paid')
                ->sum('total');
                
            $monthlySales[] = $sales;
            $monthlyLabels[] = $monthName;
        }
        
        return [
            'labels' => $monthlyLabels,
            'data' => $monthlySales
        ];
    }
}