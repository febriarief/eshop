@extends('client.layouts.app')


@section('content')
    <div class="container-fluid pt-5">
        @if (session()->has('message'))
            <div class="mx-5 alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($products as $product)
                            <tr>
                                <td class="align-middle">
                                    <img src="{{ asset('storage/' . $product['image']) }}" alt=""
                                        style="width: 50px;">
                                    {{ $product['name'] }}
                                </td>
                                <td class="align-middle">
                                    @rupiah($product['price'])
                                </td>
                                <td class="align-middle">
                                    {{ $product['qty'] }}
                                </td>
                                <td class="align-middle">
                                    @rupiah($product['total'])
                                </td>
                                <td class="align-middle">
                                    <form method="POST" action="{{ route('client-delete-cart') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product['id'] }}" />
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Ringkasan Keranjang</h4>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">@rupiah($total)</h5>
                        </div>
                        <a href="/checkout" class="btn btn-block btn-primary my-3 py-3">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
