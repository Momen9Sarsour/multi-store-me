

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="single-product" style="height: 27rem">
    <div class="product-image">
        <img style="height: 16rem" src="{{ $product->image_url }}" alt="No image Product">
        {{--@if($product->sale_percent)
        <span class="sale-tag">-{{$product->sale_percent}}%</span>
        @endif--}}

        <form action="{{ route('cart.store') }}" method="post">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
                <div class="button cart-button">
                <button class="btn" type="submit" style="width: 100%;"><i class="lni lni-cart"></i>Add to Cart</button>
                </div>
            </form>

        {{-- <div class="button">
        <a href="{{ route('prod.show', $product->id) }}" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>

        </div>
        <div class="button">
            <form action="{{ route('cart.store') }}" method="POST" class="add-to-cart-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1"> <!-- Customize the quantity if needed -->
                <button type="submit" class="btn add-to-cart-btn"><i class="lni lni-cart"></i> Add to Cart</button>
            </form>
        </div>
        --}}

        </div>
        <div class="product-info">
        {{-- <span class="category">{{ $product->category->name }}</span> --}}
        <span class="category">{{ $product->category ? $product->category->name : 'No Category' }}</span>
        <h4 class="title">
        <a href="{{ route('prod.show', $product->slug) }}">{{ $product->name }}</a>

            </h4>
        <ul class="review">
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star"></i></li>
            <li><span>4.0 Review(s)</span></li>
        </ul>
        <div class="price">
            <span>{{ Currency::format($product->price)}}</span>
            {{-- <span>{{ $product->price }}$</span> --}}
            @if($product->compare_price)
            <span class="discount-price" style="color: red">{{ Currency::format($product->compare_price)}}</span>
            {{-- <span class="discount-price" style="color: red">{{ $product->compare_price }}$</span> --}}
            @endif

        </div>
    </div>
</div>


{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.add-to-cart-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var formData = form.serialize();

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                success: function(response) {
                    // Update cart count
                    var cartCount = response.cartCount;
                    $('#cart-count').text(cartCount);
                },
                error: function(error) {
                    // Handle error if needed
                    console.error(error);
                }
            });
        });
    });
</script> --}}
