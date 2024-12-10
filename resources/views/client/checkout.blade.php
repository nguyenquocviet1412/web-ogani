@extends('client.layout')
@section('content')

<style>
    .hero__categories .categories-list {
        max-height: 500px;
        overflow-y: auto;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .hero__categories .categories-list li {
        margin: 5px 0;
    }

    .hero__categories .categories-list li a {
        text-decoration: none;
        color: #333;
        display: block;
        padding: 5px 10px;
    }

    .hero__categories .categories-list li a:hover {
        background-color: #f8f8f8;
        color: #007bff;
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
                    <h2>Checkout</h2>
                    <div class="breadcrumb__option">
                        <a href="{{route('client')}}">Home</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4>Billing Details</h4>
            <form action="{{route('checkout.place-order')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Thông Tin Người Nhận -->
                    <div class="col-lg-8 col-md-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Fullname<span>*</span></p>
                                    <input type="text" name="fullname" value="{{session('user.Fullname')}}" >
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Shipping_address<span>*</span></p>
                            <input type="text" name="address" placeholder="Số nhà, tên đường" value="{{session('user.address')}}">
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Phone_number<span>*</span></p>
                                    <input type="text" name="phone" value="{{session('user.Phone_number')}}" >
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="email" name="email" value="{{session('user.email')}}" >
                                </div>
                            </div>
                        </div>

                        <div class="checkout__input">
                            <p>note<span>*</span></p>
                            <input type="text" name="note" placeholder="Ghi chú đặc biệt (nếu có)">
                        </div>
                    </div>

                    <!-- Thông Tin Đơn Hàng -->
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <ul id="orderItems">
                                @foreach ($cartItems as $cart)
                                    <li>{{$cart->product->name}} <span>${{$cart->product->price}}</span></li>
                                @endforeach
                            </ul>
                            <div class="checkout__order__subtotal">Subtotal
                                <span id="subtotal">${{ $subtotal }}</span>
                            </div>
                            <div class="checkout__order__total">Total
                                <span id="total">$
                                    @if(session()->has('cart_total'))
                                        {{ session('cart_total') }}
                                    @else
                                        Not Set
                                    @endif
                                </span>
                            </div>

                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    Check Payment
                                    <input type="radio" name="payment" value="1" id="payment" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Paypal
                                    <input type="radio" name="payment" value="2" id="paypal">
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <input type="hidden" name="payment_id" id="payment_id">
                            <button type="submit" class="site-btn">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<pre>
    {{ print_r(session()->all(), true) }}
</pre>
<!-- Checkout Section End -->

<script>
     //////////////////////Lấy Dữ Liệu Tổng Từ Giỏ Hàng////////////////////////////////
     document.addEventListener('DOMContentLoaded', function () {
    // Lấy tổng tiền từ session lưu trữ trước đó
    fetch('/cart/save-total', {
        method: 'GET',
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('subtotal').textContent = data.subtotal;
                document.getElementById('total').textContent = data.total;
            } else {
                alert('Không thể lấy thông tin giỏ hàng. Vui lòng thử lại.');
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Lỗi kết nối. Vui lòng thử lại.');
        });
});
    // Cập nhật giá trị payment_id khi người dùng chọn phương thức thanh toán
    document.addEventListener('DOMContentLoaded', function () {
        const paymentRadioButtons = document.querySelectorAll('input[name="payment"]');
        const paymentIdInput = document.getElementById('payment_id');

        // Đảm bảo rằng payment_id được gán giá trị khi người dùng chọn phương thức thanh toán
        paymentRadioButtons.forEach(function(radio) {
            radio.addEventListener('change', function() {
                paymentIdInput.value = radio.value;
            });
        });

        // Gán giá trị mặc định cho payment_id (khi page load, phương thức COD được chọn)
        paymentIdInput.value = document.querySelector('input[name="payment"]:checked').value;
    });

    // Xử lý gửi dữ liệu đơn hàng lên server
    document.getElementById('checkoutForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('/checkout/place-order', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Đơn hàng của bạn đã được đặt thành công!');
                window.location.href = '/order-success';
            } else {
                alert('Không thể đặt đơn hàng. Vui lòng thử lại.');
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Lỗi kết nối. Vui lòng thử lại.');
        });
    });
</script>

@endsection
