@extends('layouts.admin')
@section('container')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Products</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Product List</h5>
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">Add New Product</a>
                        </div>

                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama </th>
                                        <th>Kategori </th>
                                        <th>Harga </th>
                                        <th>Jumlah </th>
                                        <th>Gambar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produks as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->nama_produk }}</td>
                                        <td>{{ $product->kategori ? $product->kategori->nama_kategori : 'Tidak ada kategori' }}</td>
                                        <td>Rp.{{ number_format($product->harga_produk, 2, ',', '.') }}</td>
                                        <td>{{ $product->jumlah_produk }}</td>
                                        <td>
                                            @if($product->gambar_produk)
                                            <img src="{{ asset('storage/produk/' . $product->gambar_produk) }}" alt="{{ $product->nama_produk }}" width="100">
                                            @else
                                            <span>Tidak ada gambar</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal-{{ $product->id }}"><i class="bi bi-pen"></i></a>
                                            <form action="{{ route('admin.hapusProductAdmin', $product->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger btn-delete" data-url="{{ route('admin.hapusProductAdmin', $product->id) }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->


<!-- Modal Tambah Produk -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('admin.storeProductAdmin')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Input fields -->
                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" id="nama_produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori_produk" class="form-label">Kategori Produk</label>
                        <div class="input-group">
                            <select name="kategori_produk" class="form-control" id="kategori_produk" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategories as $kategori)
                                <option value="{{ $kategori->nama_kategori }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Tambah Kategori</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="harga_produk" class="form-label">Harga Produk</label>
                        <input type="number" name="harga_produk" class="form-control" id="harga_produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_produk" class="form-label">Jumlah Produk</label>
                        <input type="number" name="jumlah_produk" class="form-control" id="jumlah_produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_produk" class="form-label">Gambar Produk</label>
                        <input type="file" name="gambar_produk" class="form-control" id="gambar_produk">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('admin.storeKategoriAdmin')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_kategori" class="form-label">Gambar Kategori</label>
                        <input type="file" name="gambar_kategori" class="form-control" id="gambar_kategori">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Edit Produk -->
@foreach($produks as $product)
<div class="modal fade" id="editProductModal-{{ $product->id }}" tabindex="-1" aria-labelledby="editProductModalLabel-{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('admin.updateProductAdmin',$product->id)}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel-{{ $product->id }}">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Input fields -->
                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama </label>
                        <input type="text" name="nama_produk" class="form-control" id="nama_produk" value="{{ $product->nama_produk }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori_produk" class="form-label">Kategori </label>
                        <div class="input-group">
                            <select name="kategori_produk" class="form-control" id="kategori_produk" required>
                                @foreach($kategories as $kategori)
                                <option value="{{ $kategori->nama_kategori }}" {{ $kategori->nama_kategori === $product->kategori->nama_kategori ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                                @endforeach
                            </select>


                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="harga_produk" class="form-label">Harga </label>
                        <input type="number" name="harga_produk" class="form-control" id="harga_produk" value="{{ $product->harga_produk }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_produk" class="form-label">Jumlah </label>
                        <input type="number" name="jumlah_produk" class="form-control" id="jumlah_produk" value="{{ $product->jumlah_produk }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_produk" class="form-label">Gambar </label>
                        <input type="file" name="gambar_produk" class="form-control" id="gambar_produk">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.storeKategoriAdmin') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_kategori" class="form-label">Gambar Kategori</label>
                        <input type="file" name="gambar_kategori" class="form-control" id="gambar_kategori">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection