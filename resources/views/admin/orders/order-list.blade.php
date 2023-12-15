@extends('layouts/contentNavbarLayout')

@section('title', 'Pesanan')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session()->get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Pesanan</h5>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>No. Order</th>
                        <th>Nama Customer</th>
                        <th>Email Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->customer_email }}</td>
                            <td>@rupiah($order->total)</td>
                            <td>
                                @if ($order->status == 'PENDING')
                                <span class="badge rounded-pill bg-label-warning me-1">
                                @elseif ($order->status == 'PROCESS')
                                <span class="badge rounded-pill bg-label-primary me-1">
                                 @elseif ($order->status == 'SHIPPED')
                                <span class="badge rounded-pill bg-label-success me-1">
                                @endif
                                {{ $order->status }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>

                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin-orders-show', $order->id) }}">
                                            <i class="mdi mdi-eye-outline me-1"></i>
                                            Lihat
                                        </a>

                                        @if ($order->status == 'PENDING')
                                        <a class="dropdown-item" href="{{ route('admin-orders-process', $order->id) }}">
                                            <i class="mdi mdi-check-circle-outline me-1"></i> 
                                            Proses
                                        </a>
                                        @endif

                                        @if ($order->status == 'PROCESS')
                                        <a class="dropdown-item" href="{{ route('admin-orders-shipped', $order->id) }}">
                                            <i class="mdi mdi-check-circle-outline me-1"></i> 
                                            Kirim
                                        </a>
                                        @endif
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
