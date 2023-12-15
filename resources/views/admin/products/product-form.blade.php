@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Produk')

@section('content')
    <div class="row">
        <div class="col-xl">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Produk</h5>
                </div>

                <div class="card-body">
                    <form method="post"
                        action="{{ isset($product) && $product->id ? route('admin-products-update', $product->id) : route('admin-products-store') }}"
                        enctype="multipart/form-data">

                        @csrf

                        @if (isset($product->id))
                            <input type="hidden" name="_method" value="PUT" />
                        @endif

                        <div class="mb-4">
                            @if (isset($product->image))
                                <img src="{{ url('storage/' . $product->image) }}" class="mb-3 img-fluid rounded"
                                    style="max-width:150px" /><br />
                            @endif

                            <label for="image" class="form-label">Gambar</label>
                            <input class="form-control" type="file" id="image" name="image"
                                value="{{ old('image') }}">
                        </div>

                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" id="name" name="name" placeholder=""
                                value="{{ $product->name ?? old('name') }}" />
                            <label for="name">Nama</label>
                        </div>

                        <div class="form-floating form-floating-outline mb-4">
                            <textarea type="text" class="form-control" id="description" name="description" placeholder="">{{ $product->description ?? old('description') }}</textarea>
                            <label for="description">Deskripsi</label>
                        </div>

                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" id="price" name="price" placeholder=""
                                value="{{ $product->price ?? old('price') }}" />
                            <label for="price">Harga</label>
                        </div>

                        <div class="d-flex">
                            <a href="{{ route('admin-products-index') }}"
                                class="me-3 btn btn-secondary text-white">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
