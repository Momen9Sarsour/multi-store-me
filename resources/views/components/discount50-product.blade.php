
<div class="offer-content">
    <div class="image">
        <img src="{{ $product->image_url }}" alt="#">
        @if($product->sale_percent)
        <span class="sale-tag">{{$product->sale_percent}}%</span>
            @endif
    </div>
    <div class="text">
        <h2><a   href="{{ route('prod.show', $product->slug) }}">{{ $product->name }}</a></h2>
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
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry incididunt ut
            eiusmod tempor labores.</p>
    </div>
    <div class="box-head">
        <div class="box">
            <h1 id="days">000</h1>
            <h2 id="daystxt">Days</h2>
        </div>
        <div class="box">
            <h1 id="hours">00</h1>
            <h2 id="hourstxt">Hours</h2>
        </div>
        <div class="box">
            <h1 id="minutes">00</h1>
            <h2 id="minutestxt">Minutes</h2>
        </div>
        <div class="box">
            <h1 id="seconds">00</h1>
            <h2 id="secondstxt">Secondes</h2>
        </div>
    </div>
    <div style="background: rgb(204, 24, 24);" class="alert">
        <h1 style="padding: 50px 80px;color: white;">We are sorry, Event ended ! </h1>
    </div>
</div>
