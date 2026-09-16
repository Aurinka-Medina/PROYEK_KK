<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shopping Cart — WOVEN.</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-blue: #0d6efd;
            --dark-blue: #0a3663;
        }

        .bg-blue-gradient {
            background: linear-gradient(135deg, #0d6efd 0%, #0a3663 100%);
        }

        .btn-blue {
            background-color: var(--primary-blue);
            color: white;
        }

        .btn-blue:hover {
            background-color: var(--dark-blue);
            color: white;
        }

        .cart-image {
            width: 100px;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
        }
    </style>
</head>

<body class="bg-light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-blue-gradient shadow-sm">
        <div class="container">

            <a class="navbar-brand fw-bold fs-3" href="{{ route('products.index') }}">
                <i class="bi bi-grid-3x3-gap-fill me-2"></i>WOVEN.
            </a>

            <a href="{{ route('products.index') }}"
                class="btn btn-light rounded-pill">
                <i class="bi bi-arrow-left me-1"></i>
                Continue Shopping
            </a>

        </div>
    </nav>

    <div class="container py-5">

        <h1 class="fw-bold mb-4">
            <i class="bi bi-cart3 me-2"></i>
            Shopping Cart
        </h1>

        <!-- ALERT SUCCESS -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- ALERT ERROR -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(count($cart) > 0)

            <div class="row g-4">

                <!-- DAFTAR PRODUK -->
                <div class="col-lg-8">

                    @foreach($cart as $item)

                        <div class="card border-0 shadow-sm rounded-4 mb-3">

                            <div class="card-body">

                                <div class="row align-items-center g-3">

                                    <!-- FOTO -->
                                    <div class="col-4 col-md-2">
                                        <img
                                            src="{{ asset('storage/products/' . $item['image']) }}"
                                            class="cart-image"
                                            alt="{{ $item['title'] }}">
                                    </div>

                                    <!-- INFORMASI PRODUK -->
                                    <div class="col-8 col-md-4">

                                        <h5 class="fw-bold">
                                            {{ $item['title'] }}
                                        </h5>

                                        <p class="text-primary fw-bold mb-1">
                                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </p>

                                        <small class="text-muted">
                                            Stock: {{ $item['stock'] }} pcs
                                        </small>

                                    </div>

                                    <!-- JUMLAH -->
                                    <div class="col-8 col-md-4">

                                        <form
                                            action="{{ route('cart.update', $item['id']) }}"
                                            method="POST"
                                            class="d-flex align-items-center gap-2">

                                            @csrf
                                            @method('PATCH')

                                            <input
                                                type="number"
                                                name="quantity"
                                                value="{{ $item['quantity'] }}"
                                                min="1"
                                                max="{{ $item['stock'] }}"
                                                class="form-control"
                                                style="width: 85px;">

                                            <button type="submit"
                                                class="btn btn-outline-primary"
                                                title="Update quantity">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>

                                        </form>

                                    </div>

                                    <!-- HAPUS -->
                                    <div class="col-4 col-md-2 text-end">

                                        <form
                                            action="{{ route('cart.remove', $item['id']) }}"
                                            method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-outline-danger"
                                                title="Remove product">

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </div>

                                <hr>

                                <div class="text-end">

                                    <strong>
                                        Subtotal:
                                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </strong>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

                <!-- RINGKASAN PESANAN -->
                <div class="col-lg-4">

                    <div class="card border-0 shadow-sm rounded-4">

                        <div class="card-body p-4">

                            <h4 class="fw-bold mb-4">
                                Order Summary
                            </h4>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Total Items</span>
                                <strong>
                                    {{ collect($cart)->sum('quantity') }}
                                </strong>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-4">

                                <strong>Total</strong>

                                <h4 class="text-primary fw-bold">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </h4>

                            </div>

                            <a href="{{ route('cart.checkout') }}"
                                class="btn btn-success w-100 rounded-3 py-3 fw-bold">

                                <i class="bi bi-whatsapp me-2"></i>
                                Checkout via WhatsApp

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        @else

            <!-- KERANJANG KOSONG -->
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center py-5">

                    <i class="bi bi-cart-x text-muted"
                        style="font-size: 5rem;"></i>

                    <h3 class="fw-bold mt-3">
                        Your cart is empty
                    </h3>

                    <p class="text-muted">
                        Looks like you haven't added anything yet.
                    </p>

                    <a href="{{ route('products.index') }}"
                        class="btn btn-blue rounded-pill px-4 py-2">

                        <i class="bi bi-bag me-2"></i>
                        Start Shopping

                    </a>

                </div>

            </div>

        @endif

    </div>

</body>
</html>