<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container" style="max-width: 600px;">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4">Edit Produk</h4>
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Produk (Kosongkan jika tidak diubah)</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Produk (Title)</label>
                        <input type="text" class="form-control" name="title" value="{{ $product->title }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga (Rp)</label>
                            <input type="number" class="form-control" name="price" value="{{ $product->price }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stok</label>
                            <input type="number" class="form-control" name="stock" value="{{ $product->stock }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold">UPDATE</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary w-100 mt-2">BATAL</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>