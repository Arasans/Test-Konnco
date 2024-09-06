<div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1"
    aria-labelledby="productModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel{{ $product->id }}">{{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-wrap">
                <p><strong>Description:</strong></p>
                <p>{{ $product->description }}</p>
                <p><strong>Price:</strong> Rp.{{ $product->price }}</p>
                <p><strong>Stock:</strong> {{ $product->stock }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#paymentModal{{ $product->id }}">Buy Product</button>
            </div>
        </div>
    </div>
</div>
