<x-front-layout>
    <!-- Start Featured Categories Area -->
   <!-- Start Hero Area -->
   <section class="hero-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 custom-padding-right">
                    <div class="slider-head">
                        <!-- Start Hero Slider -->
                        <div class="hero-slider">
                            <!-- Start Single Slider -->
                            @foreach($productBest as $product)
                            <div class="single-slider" style="background-image: url('{{ $product->image_url }}');background-size: 100% auto; background-repeat: repeat;">
                                <div class="content">
                                    <h2>
                                        {{ $product->name }}
                                    </h2>

                                    <h3><span>{{ Currency::format($product->price)}}</span></h3>
                                    <div class="button">
                                 <a href="{{ route('prod.show', $product->slug) }}" class="btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <!-- End Single Slider -->

                        </div>
                        <!-- End Hero Slider -->
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="row">
                        @foreach($highPricedProducts as $product)
                        <div class="col-lg-12 col-md-6 col-12 md-custom-padding">
                            <!-- Start Small Banner -->
                            <div class="hero-small-banner" style="background-image: url('{{ $product->image_url }}');background-size: 100% auto; background-repeat: repeat;">
                                <div class="content">
                                    <h2>
                                        <a href="{{ route('prod.show', $product->slug) }}">{{ $product->name }}</a>
                                    </h2>

                                </div>
                            </div>
                            <!-- End Small Banner -->
                        </div>
                        @endforeach
                        <div class="col-lg-12 col-md-6 col-12">
                            <!-- Start Small Banner -->
                            <div class="hero-small-banner style2">
                                <div class="content">
                                    <h2>Weekly Sale!</h2>
                                    <p>Saving up to 50% off all online store items this week.</p>
                                    <div class="button">
                                    <a class="btn" href="{{ route('all-products') }}">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Start Small Banner -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


        <section class="featured-categories section1">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title mb-6">
                            <h2>Featured Categories</h2>
                        </div>
                        <div class="featured-categories-slider">
                            <div class="nav-arrow left" onclick="moveSlider('left')">&larr;</div>
                            <div class="slider-content">
                                @foreach($groupedCategories as $categoryName => $categories)
                                <div class="category-card1">
                                    <x-categories-card :category="$categories[0]" />
                                </div>
                                @endforeach
                            </div>
                            <div class="nav-arrow right" onclick="moveSlider('right')">&rarr;</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- Best seller -->

        <div class="sectionBest">
            <h3 class="text12">Best seller</h3>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($productBest as $product)
                <div class="col-md-3 codes">
                    <div class="card">
                        <img src="{{ $product->image_url }}" style="height: 180px;" class="card-img-top" alt="...">
                        <a href="{{ route('prod.show', $product->slug) }}">
                            <div class="card-body">
                                <h5 class="card-title">Store: {{ $product->store->name }}</h5>
                                <h6 class="card-title">Category: {{ $product->category->name }}</h6>
                                <ul class="review" style="font-size: 12px">
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><span>5.0 Review(s)</span></li>
                                </ul>
                                <p class="card-text"><b>{{ $product->price }}$</b></p>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a class="btn btn-outline-dark" href="{{ route('best-products') }}">See More</a>
            </div>
            <p>&nbsp;</p>
        </div>


   <!-- The Top rated -->
<div class="sectionTopRated">
    <div class="container">
        <h4 class="section-title1">Top rated</h4>
        <div class="row">
            @foreach ($storeRated as $index => $store)
            <div class="col-md-6 mb-3"> <!-- Use col-md-6 for two cards per row with margin-bottom -->
                <div class="card">
                    <a href="{{ url('/store/' . $store->slug) }}">
                        <div class="row g-0">
                            <div class="col-md-4 imageRated">
                                <img src="{{ $store->image_url }}" class="img-fluid rounded-start" alt="{{ $store->name }}">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $store->name }}</h5>
                                    <div class="rating">
                                        <div class="stars">
                                            <i class="lni lni-star-filled fad1"></i>
                                            <i class="lni lni-star-filled fad1"></i>
                                            <i class="lni lni-star-filled fad1"></i>
                                            <i class="lni lni-star-filled fad1"></i>
                                            <i class="lni lni-star-filled fad1"></i>
                                        </div>
                                        <span class="ml-2">5.0 Review(s)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            @if ($index == 1) <!-- Add another section after the second card -->
            {{-- <div class="col-md-6">
                <!-- Add your other section content here -->
            </div> --}}
            @endif
            @endforeach
        </div>
    </div>
</div>
<!-- End Top rated -->



        <!-- End Top rated -->
        <!-- End Best seller -->
        <!-- End Extra 30% off, use the code -->
        <!-- End Featured Categories Area -->
        @push('scripts')
        <script type="text/javascript">
            //========= Hero Slider
            tns({
                container: '.hero-slider',
                slideBy: 'page',
                autoplay: true,
                autoplayButtonOutput: false,
                mouseDrag: true,
                gutter: 0,
                items: 1,
                nav: false,
                controls: true,
                controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
            });

            //======== Brand Slider
            tns({
                container: '.brands-logo-carousel',
                autoplay: true,
                autoplayButtonOutput: false,
                mouseDrag: true,
                gutter: 15,
                nav: false,
                controls: false,
                responsive: {
                    0: {
                        items: 1,
                    },
                    540: {
                        items: 3,
                    },
                    768: {
                        items: 5,
                    },
                    992: {
                        items: 6,
                    }
                }
            });
        </script>
        <script>
            const finaleDate = new Date("February 15, 2023 00:00:00").getTime();

            const timer = () => {
                const now = new Date().getTime();
                let diff = finaleDate - now;
                if (diff < 0) {
                    document.querySelector('.alert').style.display = 'block';
                    //document.querySelector('.container').style.display = 'none';
                }

                let days = Math.floor(diff / (1000 * 60 * 60 * 24));
                let hours = Math.floor(diff % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
                let minutes = Math.floor(diff % (1000 * 60 * 60) / (1000 * 60));
                let seconds = Math.floor(diff % (1000 * 60) / 1000);

                days <= 99 ? days = `0${days}` : days;
                days <= 9 ? days = `00${days}` : days;
                hours <= 9 ? hours = `0${hours}` : hours;
                minutes <= 9 ? minutes = `0${minutes}` : minutes;
                seconds <= 9 ? seconds = `0${seconds}` : seconds;

                document.querySelector('#days').textContent = days;
                document.querySelector('#hours').textContent = hours;
                document.querySelector('#minutes').textContent = minutes;
                document.querySelector('#seconds').textContent = seconds;

            }
            timer();
            setInterval(timer, 1000);
        </script>
        <script>
            let currentSlide = 0;
            const numSlides = document.querySelectorAll('.category-card1').length;
            const slideWidth = document.querySelector('.category-card1').offsetWidth;
            const sliderContent = document.querySelector('.slider-content');

            function moveSlider(direction) {
                if (direction === 'left') {
                    currentSlide = Math.max(currentSlide - 1, 0);
                } else if (direction === 'right') {
                    currentSlide = Math.min(currentSlide + 1, numSlides - 1);
                }
                sliderContent.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
            }
        </script>
        @endpush
</x-front-layout>
