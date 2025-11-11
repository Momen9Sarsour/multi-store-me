
 <!-- Start Single Product -->
 <div class="single-product">
    <div class="product-image">
        <img src="{{ $product->image_url }}" alt="#" style="height: 12rem">
        @if($product->sale_percent)
          <span class="sale-tag">{{$product->sale_percent}}%</span>
        @endif
        <form action="{{ route('cart.store') }}" method="post">
        @csrf
       <input type="hidden" name="product_id" value="{{ $product->id }}">
         <input type="hidden" name="quantity" value="1">
         <div class="button">
        <button class="btn" type="submit" style="width: 100%; font-size: 11px"><i class="lni lni-cart"></i><b>Add to Cart</b></button>
      </div>
 </form>
    </div>
    <div class="product-info">
        <span class="category">{{ $product->category ? $product->category->name : 'No Category' }}</span>
        <h4 class="title">
        <a href="{{ route('prod.show', $product->slug) }}">{{ $product->name }}</a>
        </h4>
        <ul class="review">
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><span>5.0 Review(s)</span></li>
        </ul>
        <div class="price">
    <span>{{ Currency::format($product->price)}}</span>
    {{--<span>{{ $product->price }}$</span>--}}
    @if($product->compare_price)
    <span class="discount-price" style="color: red">{{ Currency::format($product->compare_price)}}</span>
    {{--<span class="discount-price" style="color: red">{{ $product->compare_price }}$</span>--}}
    @endif

</div>
    </div>
</div>
<!-- End Single Product -->

