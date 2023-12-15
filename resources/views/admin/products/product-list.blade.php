@extends('layouts/contentNavbarLayout')

@section('title', 'Produk')

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session()->get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Produk</h5>
                <a href="{{ route('admin-products-create') }}" class="btn btn-primary text-white">Tambah Data</a>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <img src="{{ url('storage/' . $product->image) }}" class="img-fluid rounded"
                                    style="max-width:80px" />
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>@rupiah($product->price)</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin-products-edit', $product->id) }}"><i
                                                class="mdi mdi-pencil-outline me-1"></i> Ubah</a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin-products-destroy', $product->id) }}"><i
                                                class="mdi mdi-trash-can-outline me-1"></i> Hapus</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
