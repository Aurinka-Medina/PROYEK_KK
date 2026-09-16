<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Woven — Trendy Apparel & Lifestyle Catalog</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-blue: #0d6efd;
            --dark-blue: #0a3663;
            --light-blue: #eef5ff;
        }

        body {
            background-color: #f8f9fa;
        }

        /* GRADIENT BLUE */
        .bg-blue-gradient {
            background: linear-gradient(
                135deg,
                #0d6efd 0%,
                #0a3663 100%
            );
        }

        /* BADGE */
        .badge-blue {
            background-color: var(--light-blue);
            color: var(--primary-blue);
        }

        /* BUTTON BLUE */
        .btn-blue {
            background-color: var(--primary-blue);
            color: #ffffff;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-blue:hover {
            background-color: var(--dark-blue);
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* PRODUCT CARD */
        .card-product {
            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease;
        }

        .card-product:hover {
            transform: translateY(-5px);
            box-shadow:
                0 10px 20px rgba(13, 110, 253, 0.15) !important;
        }

        /* PRODUCT IMAGE */
        .product-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        /* CART BUTTON */
        .cart-button {
            transition: all 0.3s ease;
        }

        .cart-button:hover {
            transform: translateY(-2px);
        }

        /* HERO TITLE */
        .hero-title {
            font-weight: 800;
        }

        /* ALERT */
        .alert {
            border: none;
        }

        /* RESPONSIVE IMAGE */
        @media (max-width: 768px) {
            .product-image {
                height: 220px;
            }
        }
    </style>
</head>

<body class="bg-light">

    <!-- ========================================= -->
    <!-- NAVBAR -->
    <!-- ========================================= -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-blue-gradient shadow-sm sticky-top">

        <div class="container">

            <!-- LOGO -->
            <a class="navbar-brand fw-bold fs-3"
                href="{{ route('products.index') }}">

                <i class="bi bi-grid-3x3-gap-fill me-2"></i>
                WOVEN.

            </a>

            <!-- CART BUTTON -->
            <a href="{{ route('cart.index') }}"
                class="btn btn-light rounded-pill px-3 cart-button">

                <i class="bi bi-cart3 me-1"></i>

                Cart

                @if(session('cart'))

                    <span class="badge bg-primary ms-1">

                        {{ collect(session('cart'))->sum('quantity') }}

                    </span>

                @else

                    <span class="badge bg-primary ms-1">
                        0
                    </span>

                @endif

            </a>

        </div>

    </nav>


    <!-- ========================================= -->
    <!-- HERO SECTION -->
    <!-- ========================================= -->

    <section class="bg-blue-gradient text-white py-5 text-center position-relative overflow-hidden mb-5">

        <div class="container py-4">

            <span class="badge badge-blue rounded-pill px-3 py-2 fw-semibold mb-3">

                NEW COLLECTION 2026

            </span>

            <h1 class="display-4 hero-title mb-3">

                Discover Trendy Essentials

            </h1>

            <p class="lead opacity-75 mx-auto mb-4">

                Explore WOVEN's finest curated collection
                with modern and minimalist styles.

            </p>

        </div>

    </section>


    <!-- ========================================= -->
    <!-- MAIN CONTENT -->
    <!-- ========================================= -->

    <div class="container mb-5">


        <!-- ========================================= -->
        <!-- SUCCESS NOTIFICATION -->
        <!-- ========================================= -->

        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm"
                role="alert">

                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        <!-- ========================================= -->
        <!-- ERROR NOTIFICATION -->
        <!-- ========================================= -->

        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm"
                role="alert">

                <i class="bi bi-exclamation-circle-fill me-2"></i>

                {{ session('error') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        <!-- ========================================= -->
        <!-- CATALOG HEADER -->
        <!-- ========================================= -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold text-dark mb-1">

                    Catalog Showcase

                </h3>

                <p class="text-muted small mb-0">

                    Choose your favorite products
                    and add them to your shopping cart.

                </p>

            </div>


            <!-- TOTAL PRODUCTS -->

            <span class="badge bg-primary rounded-pill px-3 py-2">

                {{ $products->total() ?? count($products) }} Items

            </span>

        </div>


        <!-- ========================================= -->
        <!-- PRODUCT GRID -->
        <!-- ========================================= -->

        <div class="row">

            @forelse ($products as $product)


                <!-- PRODUCT ITEM -->

                <div class="col-6 col-md-4 col-lg-3 mb-4">


                    <!-- PRODUCT CARD -->

                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-product">


                        <!-- ========================================= -->
                        <!-- PRODUCT IMAGE -->
                        <!-- ========================================= -->

                        <div class="position-relative">


                            <img src="{{ asset('storage/products/' . $product->image) }}"
                                class="card-img-top product-image"
                                alt="{{ $product->title }}">



                            <!-- STOCK BADGE -->

                            @if($product->stock > 0)

                                <span class="position-absolute top-0 end-0 bg-primary text-white px-2 py-1 m-2 rounded-pill fw-semibold"
                                    style="font-size: 0.75rem;">

                                    In Stock

                                </span>

                            @else

                                <span class="position-absolute top-0 end-0 bg-danger text-white px-2 py-1 m-2 rounded-pill fw-semibold"
                                    style="font-size: 0.75rem;">

                                    Sold Out

                                </span>

                            @endif


                        </div>



                        <!-- ========================================= -->
                        <!-- PRODUCT INFORMATION -->
                        <!-- ========================================= -->

                        <div class="card-body d-flex flex-column p-3">


                            <!-- PRODUCT TITLE -->

                            <h6 class="card-title fw-bold text-dark mb-1 text-truncate">

                                {{ $product->title }}

                            </h6>



                            <!-- PRODUCT PRICE -->

                            <h5 class="text-primary fw-bold mb-3">

                                Rp {{ number_format($product->price, 0, ',', '.') }}

                            </h5>



                            <!-- ========================================= -->
                            <!-- PRODUCT ACTION -->
                            <!-- ========================================= -->

                            <div class="mt-auto">


                                @if($product->stock > 0)


                                    <!-- STOCK INFORMATION -->

                                    <p class="text-muted small mb-2"
                                        style="font-size: 0.8rem;">

                                        Stock:

                                        <strong>
                                            {{ $product->stock }} Pcs
                                        </strong>

                                    </p>



                                    <!-- ========================================= -->
                                    <!-- ADD TO CART FORM -->
                                    <!-- ========================================= -->

                                    <form action="{{ route('cart.add', $product->id) }}"
                                        method="POST">

                                        @csrf


                                        <button type="submit"
                                            class="btn btn-blue w-100 rounded-3 fw-bold btn-sm py-2">

                                            <i class="bi bi-cart-plus-fill me-1"></i>

                                            Add to Cart

                                        </button>


                                    </form>


                                @else


                                    <!-- OUT OF STOCK -->

                                    <p class="text-danger small mb-2"
                                        style="font-size: 0.8rem;">

                                        Out of Stock

                                    </p>


                                    <button class="btn btn-secondary w-100 rounded-3 btn-sm py-2"
                                        disabled>

                                        <i class="bi bi-x-circle me-1"></i>

                                        Out of Stock

                                    </button>


                                @endif


                            </div>


                        </div>


                    </div>


                </div>


            @empty


                <!-- ========================================= -->
                <!-- EMPTY PRODUCT MESSAGE -->
                <!-- ========================================= -->

                <div class="col-12">

                    <div class="alert alert-info text-center rounded-4 shadow-sm py-4">

                        <i class="bi bi-info-circle fs-3 d-block mb-2 text-primary"></i>

                        <h5 class="fw-bold">

                            No Products Available

                        </h5>

                        <p class="mb-0">

                            There are currently no products
                            available in the WOVEN catalog.

                        </p>

                    </div>

                </div>


            @endforelse


        </div>


        <!-- ========================================= -->
        <!-- PAGINATION -->
        <!-- ========================================= -->

        @if(method_exists($products, 'links'))

            <div class="d-flex justify-content-center mt-4">

                {{ $products->links() }}

            </div>

        @endif


    </div>



    <!-- ========================================= -->
    <!-- FOOTER -->
    <!-- ========================================= -->

    <footer class="bg-white py-4 border-top text-center text-muted small">

        <div class="container">

            &copy; 2026 WOVEN Store. All rights reserved.

        </div>

    </footer>



    <!-- ========================================= -->
    <!-- BOOTSTRAP JAVASCRIPT -->
    <!-- ========================================= -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>


</body>

</html>