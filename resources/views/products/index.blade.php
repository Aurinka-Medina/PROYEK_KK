<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Woven — Trendy Apparel & Lifestyle Catalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --primary-blue: #0d6efd; --dark-blue: #0a3663; --light-blue: #eef5ff; }
        .bg-blue-gradient { background: linear-gradient(135deg, #0d6efd 0%, #0a3663 100%); }
        .badge-blue { background-color: var(--light-blue); color: var(--primary-blue); }
        .btn-blue { background-color: var(--primary-blue); color: #ffffff; transition: all 0.3s ease; }
        .btn-blue:hover { background-color: var(--dark-blue); color: #ffffff; transform: translateY(-2px); }
        .card-product { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card-product:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(13, 110, 253, 0.15) !important; }
    </style>
</head>
<body class="bg-light">

    <!-- Header Navbar khusus User -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-blue-gradient shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="#">
                <i class="bi bi-grid-3x3-gap-fill me-2"></i>WOVEN.
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-blue-gradient text-white py-5 text-center position-relative overflow-hidden mb-5">
        <div class="container py-4">
            <span class="badge badge-blue rounded-pill px-3 py-2 fw-semibold mb-3">NEW COLLECTION 2026</span>
            <h1 class="display-4 fw-extrabold mb-3">Discover Trendy Essentials</h1>
            <p class="lead opacity-75 max-w-2xl mx-auto mb-4">Explore WOVEN's finest curated collection with modern and minimalist styles.</p>
        </div>
    </div>

    <!-- KATALOG PRODUK USER -->
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">Catalog Showcase</h3>
                <p class="text-muted small mb-0">Choose your favorite products and order instantly via WhatsApp</p>
            </div>
            <span class="badge bg-primary rounded-pill px-3 py-2">{{ $products->total() ?? count($products) }} Items</span>
        </div>

        <div class="row">
            @forelse ($products as $product)
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-product">
                        <div class="position-relative">
                           <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->title }}">
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
                                    
                                    <!-- TOMBOL BUY VIA WHATSAPP (GANTI DENGAN NOMOR HP WA ASLI) -->
                                    <a href="https://wa.me/6289510636988?text=Hello%20WOVEN,%20I%20am%20interested%20in%20purchasing%20{{ urlencode($product->title) }}" target="_blank" class="btn btn-blue w-100 rounded-3 fw-bold btn-sm py-2">
                                        <i class="bi bi-bag-check-fill me-1"></i> Buy Product
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
                        No products available in the <strong>WOVEN</strong> catalog right now.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Footer Simple -->
    <footer class="bg-white py-4 border-top text-center text-muted small">
        <div class="container">
            &copy; 2026 WOVEN Store. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>