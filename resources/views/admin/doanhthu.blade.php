@extends('admin.layout')

@section('title', 'Danh sách Đơn hàng | Quản trị Admin')
@section('title2', 'Danh sách Đơn hàng')

@section('content')
<form method="GET" action="{{ route('doanhthu.index') }}" class="mb-3">
    <label for="month">Chọn tháng:</label>
    <input type="month" id="month" name="month" value="{{ request('month', now()->format('Y-m')) }}">
    <button type="submit" class="btn btn-primary">Lọc</button>
</form>

<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon"><i class='icon bx bxs-user fa-3x'></i>
            <div class="info">
                <h4>Tổng Nhân viên</h4>
                <p><b>{{ $totalEmployees }} nhân viên</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class='icon bx bxs-purchase-tag-alt fa-3x'></i>
            <div class="info">
                <h4>Tổng sản phẩm</h4>
                <p><b>{{ $totalProducts }} sản phẩm</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small warning coloured-icon"><i class='icon bx bxs-shopping-bag-alt fa-3x'></i>
            <div class="info">
                <h4>Tổng đơn hàng tháng {{ $currentMonth }}/{{ $currentYear }}</h4>
                <p><b>{{ $totalOrders }} đơn hàng</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon"><i class='icon bx bxs-info-circle fa-3x'></i>
            <div class="info">
                <h4>Bị cấm</h4>
                <p><b>{{ $bannedEmployees }} nhân viên</b></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon"><i class='icon bx bxs-chart fa-3x'></i>
            <div class="info">
                <h4>Tổng thu nhập tháng {{ $currentMonth }}/{{ $currentYear }}</h4>
                <p><b>{{ number_format($totalIncome, 2, ',', '.') }} $</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class='icon bx bxs-user-badge fa-3x'></i>
            <div class="info">
                <h4>Nhân viên mới tháng {{ $currentMonth }}/{{ $currentYear }}</h4>
                <p><b>{{ $newEmployees }} nhân viên</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small warning coloured-icon"><i class='icon bx bxs-tag-x fa-3x'></i>
            <div class="info">
                <h4>Hết hàng</h4>
                <p><b>{{ $outOfStockProducts }} sản phẩm</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon"><i class='icon bx bxs-receipt fa-3x'></i>
            <div class="info">
                <h4>Đơn hàng hủy tháng {{ $currentMonth }}/{{ $currentYear }}</h4>
                <p><b>{{ $canceledOrders }} đơn hàng</b></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div>
                <h3 class="tile-title">SẢN PHẨM BÁN CHẠY</h3>
            </div>
            <div class="tile-body">
                @if($topSellingProducts->isEmpty())
                    <p>Không có sản phẩm nào bán chạy.</p>
                @else
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá tiền</th>
                                <th>Danh mục</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topSellingProducts as $product)
                            <tr>
                                <td>{{ $product->Product_id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ number_format($product->price, 2, ',', '.') }} $</td>
                                <td>{{ $product->category->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div>
                <h3 class="tile-title">TỔNG ĐƠN HÀNG</h3>
            </div>
            <div class="tile-body">
                @if($orders->isEmpty())
                    <p>Không có đơn hàng nào.</p>
                @else
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>ID đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Đơn hàng</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->fullname }}</td>
                                <td>{{ $order->orderDetails->pluck('product.name')->implode(', ') }}</td>
                                <td>{{ $order->orderDetails->sum('Number_of_products') }} sản phẩm</td>
                                <td>{{ number_format($order->Total_money, 2, ',', '.') }} $</td>
                            </tr>
                            @endforeach
                            <tr>
                                <th colspan="4">Tổng cộng:</th>
                                <td>{{ number_format($orders->sum('Total_money'), 2, ',', '.') }} $</td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div>
                <h3 class="tile-title">SẢN PHẨM ĐÃ HẾT</h3>
            </div>
            <div class="tile-body">
                @if($outOfStockProducts2->isEmpty())
                    <p>Không có sản phẩm nào đã hết hàng.</p>
                @else
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Ảnh</th>
                                <th>Số lượng</th>
                                <th>Tình trạng</th>
                                <th>Giá tiền</th>
                                <th>Danh mục</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($outOfStockProducts2 as $product)
                            <tr>
                                <td>{{ $product->Product_id }}</td>
                                <td>{{ $product->name }}</td>
                                <td><img src="{{ asset('storage/' . $product->image) }}" alt="" width="100px;"></td>
                                <td>{{ $product->quantity }}</td>
                                <td><span class="badge bg-danger">Hết hàng</span></td>
                                <td>{{ number_format($product->price, 2, ',', '.') }} $</td>
                                <td>{{ $product->category->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div>
                <h3 class="tile-title">NHÂN VIÊN MỚI</h3>
            </div>
            <div class="tile-body">
                @if($newEmployees2->isEmpty())
                    <p>Không có nhân viên mới nào.</p>
                @else
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Họ và tên</th>
                                <th>Địa chỉ</th>
                                <th>Giới tính</th>
                                <th>SĐT</th>
                                <th>Chức vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($newEmployees2 as $employee)
                            <tr>
                                <td>{{ $employee->Fullname }}</td>
                                <td>{{ $employee->address }}</td>
                                <td>{{ $employee->gender == 1 ? 'Nam' : 'Nữ' }}</td>
                                <td>{{ $employee->Phone_number }}</td>
                                <td>{{ $employee->Role_id }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">DỮ LIỆU HÀNG THÁNG</h3>
            <div class="embed-responsive embed-responsive-16by9">
                <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">THỐNG KÊ DOANH SỐ</h3>
            <div class="embed-responsive embed-responsive-16by9">
                <canvas class="embed-responsive-item" id="barChartDemo"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="text-right" style="font-size: 12px">
    <p><b>Hệ thống quản lý V2.0 | Code by Trường</b></p>
</div>
</main>
<!-- Essential javascripts for application to work-->
<script src="{{asset('admin/doc/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('admin/doc/js/popper.min.js')}}"></script>
<script src="{{asset('admin/doc/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/doc/js/main.js')}}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{{asset('admin/doc/js/plugins/pace.min.js')}}"></script>
<!-- Page specific javascripts-->
<script type="text/javascript" src="{{asset('admin/doc/js/plugins/chart.js')}}"></script>
<script type="text/javascript">
var data = {
labels: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
datasets: [{
  label: "Dữ liệu đầu tiên",
  fillColor: "rgba(255, 255, 255, 0.158)",
  strokeColor: "black",
  pointColor: "rgb(220, 64, 59)",
  pointStrokeColor: "#fff",
  pointHighlightFill: "#fff",
  pointHighlightStroke: "green",
  data: [20, 59, 90, 51, 56, 100, 40, 60, 78, 53, 33, 81]
},
{
  label: "Dữ liệu kế tiếp",
  fillColor: "rgba(255, 255, 255, 0.158)",
  strokeColor: "rgb(220, 64, 59)",
  pointColor: "black",
  pointStrokeColor: "#fff",
  pointHighlightFill: "#fff",
  pointHighlightStroke: "green",
  data: [48, 48, 49, 39, 86, 10, 50, 70, 60, 70, 75, 90]
}
]
};


var ctxl = $("#lineChartDemo").get(0).getContext("2d");
var lineChart = new Chart(ctxl).Line(data);

var ctxb = $("#barChartDemo").get(0).getContext("2d");
var barChart = new Chart(ctxb).Bar(data);
</script>
<!-- Google analytics script-->
<script type="text/javascript">
if (document.location.hostname == 'pratikborsadiya.in') {
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-72504830-1', 'auto');
    ga('send', 'pageview');
}
</script>


@endsection
