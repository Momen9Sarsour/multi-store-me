<div class="cart-items">
                                    <a href="javascript:void(0)" class="main-btn">
                                        <i class="lni lni-cart"></i>
                                        <span class="total-items">{{$items->count()}} </span>
                                    </a>
                                    <!-- Shopping Item -->
                                    <div class="shopping-item">
                                        <div class="dropdown-cart-header">
                                            <span>{{$items->count()}} Items</span>
                                            <a href="{{route('cart.index')}}">View Cart</a>
                                        </div>
                                        <ul class="shopping-list">
                                            @foreach($items as $item)
                                            <li>
                                                <a class="remove-item remove" data-id="{{ $item->id }}" href="javascript:void(0)" title="Remove this item"><i class="lni lni-close"></i></a>
                                                {{-- <a data-id="{{ $item->id }}" href="javascript:void(0)" class="remove" title="Remove this item"><i
                                                        class="lni lni-close"></i></a> --}}
                                                <div class="cart-img-head">
                                                    <a class="cart-img"
                                                    href="{{route('prod.show',$item->product->slug)}}"><img width="80" height="80"
                                                            src="{{$item->product->image_url}}" alt="No Image"></a>
                                                </div>
                                                <div class="content">
                                                    <h4><a href="product-details.html">{{$item->product->name}}</a></h4>
                                                    <p class="quantity">{{$item->quantity}}x - <span class="amount">
                                                        {{Currency::format($item->product->price)}}
                                                        {{-- {{$item->product->price}}$ --}}
                                                    </span></p>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="bottom">
                                            <div class="total">
                                                <span>Total</span>
                                                <span class="total-amount">{{Currency::format($total)}}</span>
                                                {{-- <span class="total-amount">$</span> --}}
                                            </div>
                                            <div class="button">
                                                <a href="{{ route('checkout') }} "  class="btn animate">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ End Shopping Item -->
                                </div>

                                @push('scripts')
                                <script>
                                    const csrf_token = "{{ csrf_token() }}";
                                </script>
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                                <script src="{{ asset('build/assets/cart-07ea2e5a.js') }}"></script>
                                @endpush
