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

/* nút tăng giảm số lượng */
/* Đặt kiểu cho các nút tăng giảm */
.btn-quantity {
    background-color: #5cb85c;
    color: #fff;
    border: none;
    padding: 10px 15px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s ease;
    border-radius: 50%;
}

.btn-quantity:hover {
    background-color: #4cae4c;
    transform: scale(1.1);
}

.btn-decrease {
    border-radius: 50% 0 0 50%;
}

.btn-increase {
    border-radius: 0 50% 50% 0;
}

/* Căn chỉnh số lượng */
.quantity-input {
    width: 50px;
    text-align: center;
    font-size: 16px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin: 0 10px;
    box-sizing: border-box;
}

/* Hiệu ứng hover cho nút xóa */
.shoping__cart__item__close {
    cursor: pointer;
    font-size: 18px;
    color: #ff5f5f;
    transition: color 0.3s;
}

.shoping__cart__item__close:hover {
    color: #e60000;
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
                    <h2>Shopping Cart</h2>
                    <div class="breadcrumb__option">
                        <a href="{{route('client')}}">Home</a>
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($cartProducts->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Không có sản phẩm trong giỏ hàng.</td>
                            </tr>
                        @else
                            @foreach ($cartProducts as $cart)
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="{{ asset('storage') . '/' . $cart->product->image }}" alt="" style="width: 100px; height: auto;">
                                        <h5>{{ $cart->product->name }}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        $<span class="product-price">{{ $cart->product->price }}</span>
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <button class="btn-quantity btn-decrease" data-id="{{ $cart->id }}">&#8722;</button>
                                            <input type="text" class="quantity-input" value="{{ $cart->Number_of_product }}" data-id="{{ $cart->id }}">
                                            <button class="btn-quantity btn-increase" data-id="{{ $cart->id }}">&#43;</button>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        $<span class="total-price">{{ $cart->price }}</span>
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <button class="btn btn-link btn-delete" data-id="{{ $cart->id }}">
                                            <span class="icon_close"></span>
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        @endif

                        </tbody>


                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="{{route('product.listproducts')}}" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                    <a href="#" class="primary-btn cart-btn cart-btn-right" id="updateCartBtn"><span class="icon_loading"></span>Update Cart</a>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="shoping__continue">
                    <div class="shoping__discount">
                        <h5>Discount Codes</h5>
                        <form id="applyCouponForm">
                            <input type="text" id="couponCode" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">APPLY COUPON</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul>
                        <li>Subtotal <span id="subtotalAmount">$454.98</span></li>
                        <li>Total <span id="totalAmount">$454.98</span></li>
                    </ul>
                    <a href="#" class="primary-btn" id="proceedToCheckoutBtn">PROCEED TO CHECKOUT</a>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Shoping Cart Section End -->




{{-- JavaScrip tăng giảm số lượng sản phẩm trong giỏ hàng không cập nhật trong SQL --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const decreaseBtns = document.querySelectorAll('.btn-decrease');
    const increaseBtns = document.querySelectorAll('.btn-increase');
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const updateCartBtn = document.getElementById('updateCartBtn');  // Nút update giỏ hàng

    // Tăng số lượng
    increaseBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = btn.previousElementSibling;
            let quantity = parseInt(input.value, 10);
            input.value = quantity + 1;
            updatePrice(input); // Cập nhật giá ngay khi số lượng thay đổi
        });
    });

    // Giảm số lượng
    decreaseBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = btn.nextElementSibling;
            let quantity = parseInt(input.value, 10);
            if (quantity > 1) {  // Đảm bảo số lượng không giảm dưới 1
                input.value = quantity - 1;
                updatePrice(input); // Cập nhật giá ngay khi số lượng thay đổi
            }
        });
    });

    // Hàm cập nhật tổng giỏ hàng
    function updatePrice(input) {
        const cartId = input.getAttribute('data-id');
        const quantity = parseInt(input.value, 10);
        const productPrice = parseFloat(input.closest('tr').querySelector('.product-price').textContent);

        // Tính lại tổng giá
        const totalPrice = (quantity * productPrice).toFixed(2);
        input.closest('tr').querySelector('.total-price').textContent = totalPrice;

        // Cập nhật giá trị total trong giỏ hàng nếu cần
        // Ví dụ: bạn có thể tạo một mảng để gửi lại dữ liệu lên server sau
    }

    // Cập nhật giỏ hàng khi nhấn nút "Update Cart"
    if (updateCartBtn) {
        updateCartBtn.addEventListener('click', function (event) {
            event.preventDefault(); // Ngừng hành động mặc định của nút

            const updatedCartItems = [];
            document.querySelectorAll('.quantity-input').forEach(function (input) {
                const cartId = input.getAttribute('data-id');
                const quantity = parseInt(input.value, 10);
                const totalPrice = input.closest('tr').querySelector('.total-price').textContent;

                updatedCartItems.push({
                    cart_id: cartId,
                    quantity: quantity,
                    total_price: totalPrice
                });
            });

            // Gửi yêu cầu AJAX để cập nhật giỏ hàng trên server
            fetch('/update-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    cart_items: updatedCartItems
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Giỏ hàng đã được cập nhật.');
                    location.reload();  // Tải lại trang để cập nhật thông tin mới nhất
                } else {
                    alert('Đã có lỗi xảy ra. Vui lòng thử lại.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Lỗi kết nối. Vui lòng thử lại.');
            });

        });
    }
});



///////////////////Xóa sản phẩm trong giỏ hàng////////////////////////////////
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function () {
        let cartId = this.getAttribute('data-id');
        if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            fetch(`/cart/delete/${cartId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Sản phẩm đã được xóa khỏi giỏ hàng!');
                    // Cập nhật giao diện giỏ hàng (có thể xóa sản phẩm khỏi bảng hoặc làm mới trang)
                    location.reload();
                } else {
                    alert('Đã có lỗi xảy ra. Không thể xóa sản phẩm!');
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert('Lỗi kết nối. Vui lòng thử lại.');
            });
        }
    });
});
///////////////////////tính tổng giá và mã giảm giá/////////////////////
// Hàm tính Subtotal và cập nhật giao diện
function updateCartTotal() {
    let subtotal = 0;

    // Lấy tất cả giá trị 'total-price' từ giao diện
    document.querySelectorAll('.shoping__cart__total .total-price').forEach(function (totalElement) {
        // Cộng dồn tổng giá trị của các sản phẩm vào subtotal
        let totalValue = parseFloat(totalElement.textContent.replace('$', '').trim());
        subtotal += totalValue;
    });

    // Cập nhật giá trị Subtotal vào giao diện
    document.getElementById('subtotalAmount').innerText = `$${subtotal.toFixed(2)}`;

    // Cập nhật Total ban đầu bằng Subtotal
    document.getElementById('totalAmount').innerText = `$${subtotal.toFixed(2)}`;
}

// Lắng nghe sự kiện khi người dùng nhập mã giảm giá
document.getElementById('applyCouponForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Ngăn chặn form tự động submit

    // Lấy mã giảm giá từ input
    const couponCode = document.getElementById('couponCode').value.trim();

    // Lấy giá trị Subtotal từ giao diện
    let subtotal = parseFloat(document.getElementById('subtotalAmount').innerText.replace('$', '').trim());

    // Kiểm tra mã giảm giá
    if (couponCode === 'discount10') {
        // Áp dụng giảm giá 10%
        let discount = 0.10; // 10%
        let discountAmount = subtotal * discount;
        let total = subtotal - discountAmount;

        // Cập nhật lại Total sau khi áp dụng mã giảm giá
        document.getElementById('totalAmount').innerText = `$${total.toFixed(2)}`;
    } else {
        alert('Mã giảm giá không hợp lệ.');
    }
});

// Gọi hàm updateCartTotal khi trang tải để tính toán Subtotal và Total ban đầu
window.onload = function () {
    updateCartTotal();
};

///////////////// Lưu Subtotal và Total vào Session và chuyển trang ////////////////////////
document.querySelector('#proceedToCheckoutBtn').addEventListener('click', function (e) {
    e.preventDefault(); // Ngăn chuyển trang ngay lập tức

    // Lấy giá trị Subtotal và Total từ giao diện
    const subtotalAmount = document.getElementById('subtotalAmount').textContent.trim().replace('$', '');
    const totalAmount = document.getElementById('totalAmount').textContent.trim().replace('$', '');

    // Gửi dữ liệu lên server để lưu Subtotal và Total trong Session
    fetch('/cart/save-total', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ subtotal: subtotalAmount, total: totalAmount }),
    })
        .then(response => {
            if (response.ok) {
                // Chuyển sang trang Thanh Toán
                window.location.href = '/checkout';
            } else {
                alert('Không thể chuyển sang trang thanh toán. Vui lòng thử lại.');
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Lỗi kết nối. Vui lòng thử lại.');
        });
});




</script>
@endsection
