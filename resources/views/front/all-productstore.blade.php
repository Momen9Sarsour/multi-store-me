<x-front-layout>
    <section class="trending-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Product</h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                            suffered alteration in some form.</p>
                    </div>
                </div>
            </div>
            <div class="row">
            @foreach($productstore as $product)
                <div class="col-lg-3 col-md-6 col-12">
                <div class="single-product" style="height: 27rem">
                        <div class="product-image">
                            <img  style="height: 16rem" src="{{ $product->image_url }}" alt="No image Product">
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
                               {{-- <span>{{ $product->price }}$</span>--}}
                                @if($product->compare_price)
                                <span class="discount-price">{{ Currency::format($product->compare_price)}}</span> 
                               {{--<span class="discount-price" style="color: red">{{ $product->compare_price }}$</span>--}}
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
               <style>
               .pagination {
                  display: flex;
                  justify-content: center;
                  list-style: none;
                  padding: 0;
                  margin-bottom: 30px;
                 }
                 .page-item {
                 margin: 0 5px;
                    }
                 </style>
                <div class="d-flex justify-content-center mt-4">
                {{ $productstore->links() }}
                </div>
              </div>
    </section>
</x-front-layout>