@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Konnco Product List</h1>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-truncate">{{ $product->description }}</p>
                            <p class="card-text">Price: Rp.{{ $product->price }}</p>
                            <p class="card-text {{ $product->stock == 0 ? 'text-danger' : '' }}">Stock: {{ $product->stock }}
                            </p>
                        </div>
                        <div class="card-footer text-center d-flex justify-content-between">
                            @if ($product->stock != 0)
                                <button class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#productModal{{ $product->id }}">View Product</button>
                            @endif
                            <button class="btn {{ $product->stock == 0 ? 'btn-danger' : 'btn-primary' }}"
                                data-bs-toggle="modal" data-bs-target="#paymentModal{{ $product->id }}"
                                {{ $product->stock == 0 ? 'disabled' : '' }}>
                                {{ $product->stock == 0 ? 'Out of Stock' : 'Buy Product' }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Include Product Modal -->
                @include('components.product-modal', ['product' => $product])

                <!-- Include Payment Modal -->
                @include('components.payment-modal', ['product' => $product])
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
@endsection
