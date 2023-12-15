@extends('client.layouts.app')

@section('content')
    <div class="container-fluid py-5">

        @if (session()->has('message'))
            <div class="mx-5 alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <img class="w-100 h-100" src="{{ asset('storage/' . $product->image) }}" alt="Image">
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold">{{ $product->name }}</h3>
                <h3 class="font-weight-semi-bold mb-4">@rupiah($product->price)</h3>
                <p class="mb-4">{{ $product->description }}</p>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <form method="POST" action="{{ route('client-add-to-cart') }}">
                        @csrf

                        <input type="hidden" name="product_id" value="{{ $product->id }}" />

                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>

                            <input type="text" class="form-control bg-secondary text-center" id="qty"
                                name="qty" value="1">

                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="mt-4 btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i>
                            Add To Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
