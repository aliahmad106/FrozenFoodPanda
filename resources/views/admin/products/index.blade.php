@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><i class="fas fa-box me-2 text-primary"></i>Manage Products</h2>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Product
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">Product Inventory</h5>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" id="productSearch" class="form-control" placeholder="Search products...">
                        <button class="btn btn-outline-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Product</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="product-img me-3" style="width: 60px; height: 60px;">
                                        <img src="{{ asset($product->image_url) }}" 
                                             alt="{{ $product->name }}" 
                                             class="img-fluid rounded"
                                             style="max-height: 60px; max-width: 60px; object-fit: contain;">
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $product->name }}</h6>
                                        <small class="text-muted">ID: {{ $product->product_id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>
                                <form action="{{ route('admin.products.toggle-active', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $product->is_active ? 'btn-success' : 'btn-secondary' }}">
                                        @if($product->is_active)
                                            <i class="fas fa-check-circle me-1"></i>Active
                                        @else
                                            <i class="fas fa-times-circle me-1"></i>Inactive
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger delete-product-btn" data-product-id="{{ $product->product_id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $product->product_id }}" action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" class="delete-product-form d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">Showing {{ count($products) }} products</span>
                </div>
                <div>
                    @if(method_exists($products, 'links'))
                        {{ $products->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Product search functionality
    const searchInput = document.getElementById('productSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                const productName = row.querySelector('h6').textContent.toLowerCase();
                const productCategory = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                
                if (productName.includes(searchTerm) || productCategory.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Delete product functionality
    const deleteButtons = document.querySelectorAll('.delete-product-btn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const form = document.getElementById(`delete-form-${productId}`);
            
            if (confirm('Are you sure you want to delete this product?')) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
@endsection