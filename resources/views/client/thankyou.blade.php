<!-- resources/views/client/checkout/success.blade.php -->

@extends('client.layout')

@section('content')

<style>
    .thank-you-section {
        text-align: center;
        padding: 60px 0;
        background-color: #f4f4f4;
    }
    .thank-you-section h1 {
        font-size: 40px;
        margin-bottom: 20px;
        color: #4CAF50;
    }
    .thank-you-section p {
        font-size: 18px;
        margin-bottom: 40px;
        color: #333;
    }
    .thank-you-section .order-info {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
        max-width: 600px;
    }
    .thank-you-section .order-info h3 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }
    .thank-you-section .order-info ul {
        list-style: none;
        padding: 0;
    }
    .thank-you-section .order-info li {
        margin-bottom: 10px;
        font-size: 16px;
    }
</style>

<section class="thank-you-section">
    <div class="container">
        <h1>Thank You for Your Order!</h1>
        <p>Your order has been successfully placed. We are processing your order and will notify you once it's on the way.</p>

        <p>If you have any questions, feel free to contact us at <strong>+65 11.188.888</strong> or email us at <strong>support@ourstore.com</strong>.</p>

        <a href="{{ route('client') }}" class="btn btn-primary">Continue Shopping</a>
    </div>
</section>

@endsection
