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
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All departments</span>
                    </div>
                    <ul class="">
                        @foreach ($categories as $category)
                            <li><a href="#">{{$category->name}}</a></li>
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
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{asset('client/img/breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Organi Shop</h2>
                    <div class="breadcrumb__option">
                        <a href="{{route('client')}}">Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="sidebar">
                    <div class="sidebar__item">
                        <h4>Department</h4>
                        <ul>
                            @foreach ($categories as $category)
                            <li><a href="{{route('product.category',$category->id)}}">{{$category->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="sidebar__item">
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
                </div>
            </div>
            <div class="col-lg-9 col-md-7">
                <div class="product__discount">
                    <div class="section-title product__discount__title">
                        <h2>Sale Off</h2>
                    </div>
                    <div class="row">
                        <div class="product__discount__slider owl-carousel">
                            @foreach ($saleproducts as $product)
                                <div class="col-lg-4">
                                <div class="product__discount__item">
                                    <div class="product__discount__item__pic set-bg"
                                        data-setbg="{{asset('storage'). '/'.$product->image}}">
                                        <div class="product__discount__percent">-20%</div>
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                            <li><a href="{{route('product.addToCart',$product->Product_id)}}"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__discount__item__text">
                                        <span>{{$product->category->name}}</span>
                                        <h5><a href="{{route('product.detail',$product->Product_id)}}">{{$product->name}}</a></h5>
                                        <div class="product__item__price">${{$product->price}}
                                            <span>${{ number_format($product->price * 1.2, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                <span>Sort By</span>
                                <select>
                                    <option value="0">Default</option>
                                    <option value="0">Default</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                <h6><span>{{$totalProducts}}</span> Products found</h6>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3">
                            <div class="filter__option">
                                <span class="icon_grid-2x2"></span>
                                <span class="icon_ul"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{asset('storage'). '/'.$product->image}}">
                                <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                    <li><a href="{{route('product.addToCart',$product->Product_id)}}"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="{{route('product.detail',$product->Product_id)}}">{{$product->name}}</a></h6>
                                <h5>${{$product->price}}</h5>
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>
                <!-- Hiển thị phân trang -->
                <div class="">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
@endsection
