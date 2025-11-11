<div class="col-lg-4 col-md-6 col-12" style="height: 280px">
    <!-- Start Single Category -->
    <div class="single-category" style="height: 260px">
        <h3 class="heading">
            <a href="{{ route('adminCategory.index', ['category' => $category->id]) }}">
                {{$category->name}}
            </a>
        </h3>
        <ul>
            @foreach ($category->products->take(4) as $product)
                <li><a href="{{ route('prod.show', $product->slug) }}">{{$product->name}}</a></li>
            @endforeach
            {{-- <li><a href="{{ route('products-show'), $category->id }}">View All</a></li> --}}
            <li><a href="{{ route('products-show', $category->slug) }}">View All</a></li>
        </ul>
        <div class="images">
            <img width="200" src="{{asset('storage/'.$category->image)}}" alt="#">
        </div>
    </div>
    <!-- End Single Category -->
</div>
