@extends('client.layouts.app')


@section('content')
    <div class="container-fluid pt-5">
        @if ($errors->any())
            <div class="mx-5 alert alert-danger alert-dismissible fade show" role="alert">
                {{ $errors->first() }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form method="post" action="/checkout">
            @csrf

            <div class="row px-xl-5">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <h4 class="font-weight-semi-bold mb-4">Pengiriman</h4>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Nama</label>
                                <input class="form-control" type="text" name="customer_name" id="customer_name"
                                    value="{{ old('customer_name') }}" placeholder="nama" />
                            </div>

                            <div class="col-md-12 form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="customer_address" id="customer_address" {{ old('customer_address') }}
                                    placeholder="alamat"></textarea>
                            </div>

                            <div class="col-md-12 form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" name="customer_email" id="customer_email"
                                    value="{{ old('customer_email') }}" placeholder="email" />
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-medium mb-3">Products</h5>

                            @foreach ($products as $product)
                                <div class="d-flex justify-content-between">
                                    <p>{{ $product['name'] }}</p>
                                    <p>@rupiah($product['total'])</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="card-footer border-secondary bg-transparent">
                            <div class="d-flex justify-content-between mt-2">
                                <h5 class="font-weight-bold">Total</h5>
                                <h5 class="font-weight-bold">@rupiah($total)</h5>
                            </div>
                        </div>
                    </div>

                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Payment</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input checked type="radio" class="custom-control-input" name="payment"
                                        id="paypal">
                                    <label class="custom-control-label" for="paypal">Paypal</label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer border-secondary bg-transparent">
                            <button type="submit"
                                class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Pesan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
