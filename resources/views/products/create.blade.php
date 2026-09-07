<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container" style="max-width: 600px;">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4">Tambah Produk Baru</h4>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Produk</label>
                        <input type="file" class="form-control" name="image" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Produk (Title)</label>
                        <input type="text" class="form-control" name="title" placeholder="Masukkan nama produk" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga (Rp)</label>
                            <input type="number" class="form-control" name="price" placeholder="10000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stok</label>
                            <input type="number" class="form-control" name="stock" placeholder="10" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold me-2">SIMPAN</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary w-100 mt-2">BATAL</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>