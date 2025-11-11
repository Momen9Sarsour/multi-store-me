<x-front-layout>
    <section class="featured-categories section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Featured Categories</h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                            suffered alteration in some form.</p>
                    </div>
                </div>
            </div>
            <div class="row">

                @foreach ($categorystore as $category)
                <div class="col-lg-4 col-md-6 col-12" style="height: 280px">
                    <!-- Start Single Category -->
                    <div class="single-category" style="height: 260px">
                        <h3 class="heading">
                            <a href="{{ route('adminCategory.index', ['category' => $category->id]) }}">
                                {{$category->name}}
                            </a>
                        </h3>
                        <ul>
                            @foreach ($category->products as $product)
                            <li><a href="{{ route('prod.show', $product->slug) }}">{{$product->name}}</a></li>
                            @endforeach
                            <li><a href="{{ route('products.index') }}">View All</a></li>
                        </ul>
                        <div class="images">
                            <img width="200" src="{{asset('storage/'.$category->image)}}" alt="#">
                        </div>
                    </div>
                    <!-- End Single Category -->
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
                {{ $categorystore->links() }}
                </div>
              </div>
    </section>
</x-front-layout>