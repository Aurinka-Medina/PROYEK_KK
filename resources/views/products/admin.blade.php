<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Woven — Trendy Apparel & Lifestyle Catalog</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom Style Trendy Blue Theme -->
     
    <style>
        :root {
            --primary-blue: #0d6efd;
            --dark-blue: #0a3663;
            --light-blue: #eef5ff;
        }
        .bg-blue-gradient {
            background: linear-gradient(135deg, #0d6efd 0%, #0a3663 100%);
        }
        .badge-blue {
            background-color: var(--light-blue);
            color: var(--primary-blue);
        }
        .btn-blue {
            background-color: var(--primary-blue);
            color: #ffffff;
            transition: all 0.3s ease;
        }
        .btn-blue:hover {
            background-color: var(--dark-blue);
            color: #ffffff;
            transform: translateY(-2px);
        }
        .card-product {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-product:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.15) !important;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Header Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-blue-gradient shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3 tracking-wide" href="#">
                <i class="bi bi-grid-3x3-gap-fill me-2"></i>WOVEN.
            </a>
            <a href="#admin-section" class="btn btn-outline-light btn-sm rounded-pill px-3">
                <i class="bi bi-gear-fill me-1"></i> Admin Panel
            </a>
        </div>
    </nav>

    <!-- Trendy Hero Section -->
    <div class="bg-blue-gradient text-white py-5 text-center position-relative overflow-hidden mb-5">
        <div class="container py-4">
            <span class="badge badge-blue rounded-pill px-3 py-2 fw-semibold mb-3">NEW COLLECTION 2026</span>
            <h1 class="display-4 fw-extrabold mb-3">Discover Trendy Essentials</h1>
            <p class="lead opacity-75 max-w-2xl mx-auto mb-4">Explore WOVEN's finest curated collection with modern and minimalist styles.</p>
        </div>
    </div>

    <!-- PRODUCT SHOWCASE CATALOG -->
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">Catalog Showcase</h3>
                <p class="text-muted small mb-0">Choose your favorite products and order instantly</p>
            </div>
            <span class="badge bg-primary rounded-pill px-3 py-2">{{ $products->total() ?? count($products) }} Items</span>
        </div>

        <div class="row">
            @forelse ($products as $product)
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-product">
                        <div class="position-relative">
                            <img src="{{ asset('/storage/products/'.$product->image) }}" class="card-img-top" style="height: 240px; object-fit: cover;" alt="{{ $product->title }}">
                            @if($product->stock > 0)
                                <span class="position-absolute top-0 end-0 bg-primary text-white text-xs px-2 py-1 m-2 rounded-pill fw-semibold" style="font-size: 0.75rem;">In Stock</span>
                            @else
                                <span class="position-absolute top-0 end-0 bg-danger text-white text-xs px-2 py-1 m-2 rounded-pill fw-semibold" style="font-size: 0.75rem;">Sold Out</span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column p-3">
                            <h6 class="card-title fw-bold text-dark mb-1 text-truncate">{{ $product->title }}</h6>
                            <h5 class="text-primary fw-bold mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h5>
                            
                            <div class="mt-auto">
                                @if($product->stock > 0)
                                    <p class="text-muted small mb-2" style="font-size: 0.8rem;">Stock: <strong>{{ $product->stock }} Pcs</strong></p>
                                    <a href="https://wa.me/6289510636988?text=Hello%20WOVEN,%20I%20am%20interested%20in%20purchasing%20{{ urlencode($product->title) }}" target="_blank" class="btn btn-blue w-100 rounded-3 fw-bold btn-sm py-2">
                                        <i class="bi bi-bag-check-fill me-1"></i> Order Now
                                    </a>
                                @else
                                    <p class="text-danger small mb-2" style="font-size: 0.8rem;">Out of Stock</p>
                                    <button class="btn btn-secondary w-100 rounded-3 btn-sm py-2" disabled>Out of Stock</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center rounded-4 border-0 shadow-sm py-4">
                        <i class="bi bi-info-circle fs-3 d-block mb-2 text-primary"></i>
                        No products available in the <strong>WOVEN</strong> catalog. Please add products via the Admin Panel below.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <hr class="my-5 container border-secondary opacity-25">

    <!-- ADMIN MANAGEMENT TABLE (CRUD) -->
    <div class="container pb-5" id="admin-section">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-0">WOVEN Admin Management</h4>
                    <p class="text-muted small mb-0">Manage product availability and catalog inventory</p>
                </div>
                <a href="{{ route('products.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold">
                    <i class="bi bi-plus-lg me-1"></i> Add New Product
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">IMAGE</th>
                            <th class="py-3">TITLE</th>
                            <th class="py-3">PRICE</th>
                            <th class="py-3">STOCK</th>
                            <th class="py-3 text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->title }}">
                                </td>
                                <td class="fw-semibold text-dark">{{ $product->title }}</td>
                                <td class="text-primary fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge badge-blue rounded-pill px-3 py-2">{{ $product->stock }} Pcs</span>
                                </td>
                                <td class="text-center">
                                    <form onsubmit="return confirm('Are you sure you want to delete this product?');" action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary rounded-2 me-1">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-2">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No product data found in the database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>