<!-- Modal HTML -->
<div class="modal fade" id="paymentModal{{ $product->id }}" tabindex="-1"
    aria-labelledby="paymentModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel{{ $product->id }}">Payment for {{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm{{ $product->id }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_price" value="{{ $product->price }}">
                    <div class="mb-3">
                        <label for="quantity{{ $product->id }}" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity{{ $product->id }}" name="quantity"
                            min="1" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="name{{ $product->id }}" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name{{ $product->id }}" name="name"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="email{{ $product->id }}" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email{{ $product->id }}" name="email"
                            required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitPayment{{ $product->id }}">Submit
                            Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '[id^="submitPayment"]', function(e) {
                e.preventDefault();

                var productId = $(this).attr('id').replace('submitPayment', '');

                $.ajax({
                    url: '/payment',
                    method: 'POST',
                    data: $('#paymentForm' + productId).serialize(),
                    success: function(response) {
                        if (typeof snap !== 'undefined') {
                            snap.pay(response.snapToken, {
                                onSuccess: function(result) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Payment Successful',
                                        text: 'Thank you for your payment!',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.href =
                                            '/';
                                    });
                                },
                                onPending: function(result) {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Payment Pending',
                                        text: 'Your payment is pending. Please complete the payment process.',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.href =
                                            '/';
                                    });
                                },
                                onError: function(result) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Payment Error',
                                        text: 'There was an error processing your payment. Please try again.',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.href =
                                            '/';
                                    });
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Payment system not initialized.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/';
                            });
                        }
                    },
                    error: function(error) {
                        var errorMessage = 'An error occurred while processing your request.';
                        if (error.responseJSON && error.responseJSON.error) {
                            errorMessage = error.responseJSON
                                .error;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endsection
