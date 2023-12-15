@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card mb-5">
                                <div class="card-header bg-light border-0">
                                    <h4 class="font-weight-semi-bold m-0">Ringkasan</h4>
                                </div>
                                <div class="card-footer border-secondary bg-transparent">
                                    <div>
                                        {{ $order->customer_name }}<br />
                                        {{ $order->customer_address }}<br />
                                        {{ $order->customer_email }}<br />
            
                                        <div class="mt-3 font-weight-bold">
                                            Status Pesanan
                                        </div>
                                        @if ($order->status == 'PENDING')
                                            <span class="badge rounded-pill bg-warning text-white me-1">Pending</span>
                                        @elseif ($order->status == 'PROCESS')
                                            <span class="badge rounded-pill bg-primary text-white me-1">Diproses</span>
                                        @elseif ($order->status == 'SHIPPED')
                                            <span class="badge rounded-pill bg-success text-white me-1">Dikirim</span>
                                        @endif
            
                                    </div>
            
                                    <div class="mt-5 d-flex justify-content-between mt-2">
                                        <h5 class="font-weight-bold">Total</h5>
                                        <h5 class="font-weight-bold">@rupiah($order->total)</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-8 table-responsive mb-5">
                            <table class="table table-bordered text-center mb-0">
                                <thead class="bg-light text-dark">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @foreach ($order->detail as $detail)
                                        <tr>
                                            <td class="align-middle">
                                                <img src="{{ asset('storage/' . $detail['product_image']) }}" alt=""
                                                    style="width: 50px;">
                                                {{ $detail['product_name'] }}
                                            </td>
                                            <td class="align-middle">
                                                @rupiah($detail['product_price'])
                                            </td>
                                            <td class="align-middle">
                                                {{ $detail['qty'] }}
                                            </td>
                                            <td class="align-middle">
                                                @rupiah($detail['total'])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex">
                        <a href="{{ route('admin-orders-index') }}" class="me-3 btn btn-secondary text-white">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
