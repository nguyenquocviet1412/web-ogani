@extends('client.layout')
@section('content')

<style>
    .hero__categories .categories-list {
    max-height: 500px; /* Giới hạn chiều cao */
    overflow-y: auto; /* Bật thanh cuộn dọc */
    padding: 0; /* Xóa khoảng cách mặc định */
    margin: 0; /* Xóa khoảng cách mặc định */
    list-style: none; /* Xóa kiểu dấu chấm */
}

.hero__categories .categories-list li {
    margin: 5px 0; /* Khoảng cách giữa các danh mục */
}

.hero__categories .categories-list li a {
    text-decoration: none; /* Xóa gạch chân */
    color: #333; /* Màu chữ */
    display: block; /* Đảm bảo toàn bộ dòng là liên kết */
    padding: 5px 10px; /* Thêm padding cho đẹp */
}

.hero__categories .categories-list li a:hover {
    background-color: #f8f8f8; /* Hiệu ứng hover */
    color: #007bff; /* Màu khi hover */
}
</style>

<!-- Hero Section Begin -->
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All departments</span>
                    </div>
                    <ul class="categories-list">
                        @foreach ($categories as $category)
                            <li><a href="{{route('product.category',$category->id)}}">{{$category->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="{{ route('products.search') }}" method="GET">
                            <input
                                type="text"
                                name="search"
                                placeholder="What do you need?"
                                value="{{ request('search') }}"
                                {{-- Để giữ lại từ khóa khi load lại --}}
                                required
                            >
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>

                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+65 11.188.888</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>
                <div class="hero__item set-bg" data-setbg="{{asset('client/img/hero/banner.jpg')}}">
                    <div class="hero__text">
                        <span>FRUIT FRESH</span>
                        <h2>Vegetable <br />100% Organic</h2>
                        <p>Free Pickup and Delivery Available</p>
                        <a href="#" class="primary-btn">SHOP NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{asset('client/img/categories/cat-1.jpg')}}">
                        <h5><a href="#">Fresh Fruit</a></h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{asset('client/img/categories/cat-2.jpg')}}">
                        <h5><a href="#">Dried Fruit</a></h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{asset('client/img/categories/cat-3.jpg')}}">
                        <h5><a href="#">Vegetables</a></h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{asset('client/img/categories/cat-4.jpg')}}">
                        <h5><a href="#">drink fruits</a></h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{asset('client/img/categories/cat-5.jpg')}}">
                        <h5><a href="#">drink fruits</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->
@if(isset($searchTerm))
<!-- SEARCH PRODUCTS Begin -->
<section class="featured spad">
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="section-title">
                <h2>Search: {{$searchTerm}}</h2>
            </div>
        </div>
    </div>
    <div class="row ">
        @foreach ($searchproducts as $product)
        <div class="col-lg-3 col-md-4 col-sm-6 mix ">
            <div class="featured__item">
                <div class="featured__item__pic set-bg" data-setbg="{{asset('storage'). '/'.$product->image}}">
                    <ul class="featured__item__pic__hover">
                        <li><a href="#"><i class="fa fa-heart"></i></a></li>
                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                        <li><a href="{{route('product.addToCart',$product->Product_id)}}"><i class="fa fa-shopping-cart"></i></a></li>
                    </ul>
                </div>
                <div class="featured__item__text">
                    <h6><a href="{{route('product.detail',$product->Product_id)}}">{{$product->name}}</a></h6>
                    <h5>${{$product->price}}</h5>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</section>
<!-- SEARCH PRODUCTS End -->
@endif


@if(isset($categoryProducts))
<!-- CATEGORY PRODUCTS Begin -->
<section class="featured spad">
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="section-title">
                <h2>Category: {{$nameCategories->name}}</h2>
            </div>
        </div>
    </div>
    <div class="row ">
        @foreach ($categoryProducts as $product)
        <div class="col-lg-3 col-md-4 col-sm-6 mix ">
            <div class="featured__item">
                <div class="featured__item__pic set-bg" data-setbg="{{asset('storage'). '/'.$product->image}}">
                    <ul class="featured__item__pic__hover">
                        <li><a href="#"><i class="fa fa-heart"></i></a></li>
                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                        <li><a href="{{route('product.addToCart',$product->Product_id)}}"><i class="fa fa-shopping-cart"></i></a></li>
                    </ul>
                </div>
                <div class="featured__item__text">
                    <h6><a href="{{route('product.detail',$product->Product_id)}}">{{$product->name}}</a></h6>
                    <h5>${{$product->price}}</h5>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</section>
<!-- CATEGORY PRODUCTS End -->
@endif


    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Product</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            @foreach ($featuredproducts as $category)
                            <li data-filter=".{{ $category->name }}">{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                @foreach ($featuredproducts as $category)
                @if ($category->top_products->count())
                @foreach ($category->top_products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mix {{$category->name}}">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="{{asset('storage'). '/'.$product->image}}">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="{{route('product.addToCart',$product->Product_id)}}"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="{{route('product.detail',$product->Product_id)}}">{{$product->name}}</a></h6>
                            <h5>${{$product->price}}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                @endforeach
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{asset('client/img/banner/banner-1.jpg')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{asset('client/img/banner/banner-2.jpg')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Latest Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            @foreach ($newproducts->chunk(3) as $chunk)
                            <div class="latest-prdouct__slider__item">
                                @foreach ($chunk as $product)
                                <a href="{{route('product.detail',$product->Product_id)}}" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('storage'). '/'.$product->image}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>{{$product->name}}</h6>
                                        <span>${{$product->price}}</span>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Top Rated Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            @foreach ($likeproducts->chunk(3) as $chunk)
                            <div class="latest-prdouct__slider__item">
                                @foreach ($chunk as $product)
                                <a href="{{route('product.detail',$product->Product_id)}}" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('storage'). '/'.$product->image}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>{{$product->name}}</h6>
                                        <span>${{$product->price}}</span>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Review Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            @foreach ($products->chunk(3) as $chunk)
                            <div class="latest-prdouct__slider__item">
                                @foreach ($chunk as $product)
                                <a href="{{route('product.detail',$product->Product_id)}}" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('storage'). '/'.$product->image}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>{{$product->name}}</h6>
                                        <span>${{$product->price}}</span>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->

    <!-- Blog Section Begin -->
    <section class="from-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>From The Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{asset('client/img/blog/blog-1.jpg')}}" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Cooking tips make cooking simple</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{asset('client/img/blog/blog-2.jpg')}}" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">6 ways to prepare breakfast for 30</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{asset('client/img/blog/blog-3.jpg')}}" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Visit the clean farm in the US</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
