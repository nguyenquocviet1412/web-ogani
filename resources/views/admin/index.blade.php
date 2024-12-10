@extends('admin.layout')
@section('title')
    Danh sách nhân viên | Quản trị Admin
@endsection
@section('title2')
    Bảng điều khiển
@endsection
@section('content')
<div class="row">
    <!--Left-->
    <div class="col-md-12 col-lg-6">
      <div class="row">
     <!-- col-6 -->
     <div class="col-md-6">
      <div class="widget-small primary coloured-icon"><i class='icon bx bxs-user-account fa-3x'></i>
        <div class="info">
          <h4>Tổng khách hàng</h4>
          <p><b>{{$soUsers}} khách hàng</b></p>
          <p class="info-tong">Tổng số khách hàng được quản lý.</p>
        </div>
      </div>
    </div>
     <!-- col-6 -->
        <div class="col-md-6">
          <div class="widget-small info coloured-icon"><i class='icon bx bxs-data fa-3x'></i>
            <div class="info">
              <h4>Tổng sản phẩm</h4>
              <p><b>{{$tongSP}} sản phẩm</b></p>
              <p class="info-tong">Tổng số sản phẩm được quản lý.</p>
            </div>
          </div>
        </div>
         <!-- col-6 -->
        <div class="col-md-6">
          <div class="widget-small warning coloured-icon"><i class='icon bx bxs-shopping-bags fa-3x'></i>
            <div class="info">
              <h4>Tổng đơn hàng</h4>
              <p><b>{{$soDonHang}} đơn hàng</b></p>
              <p class="info-tong">Tổng số hóa đơn bán hàng trong tháng.</p>
            </div>
          </div>
        </div>
         <!-- col-6 -->
        <div class="col-md-6">
          <div class="widget-small danger coloured-icon"><i class='icon bx bxs-error-alt fa-3x'></i>
            <div class="info">
              <h4>Sắp hết hàng</h4>
              <p><b>{{$sapHetHang}} sản phẩm</b></p>
              <p class="info-tong">Số sản phẩm cảnh báo hết cần nhập thêm.</p>
            </div>
          </div>
        </div>
         <!-- col-12 -->
         <div class="col-md-12">
          <div class="tile">
              <h3 class="tile-title">Tình trạng đơn hàng</h3>
            <div>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>ID đơn hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                  </tr>
                </thead>
                <tbody>

                    @foreach ($litsDonHang as $dh)
                    <tr>
                        <td>{{$dh->id}}</td>
                        <td>{{$dh->fullname}}</td>
                        <td>
                            {{$dh->Total_money}} $
                        </td>
                        <td><span class="badge
                            @if ($dh->status == "pending")
                                bg-secondary
                            @elseif ($dh->status == "processing")
                                bg-info
                            @elseif ($dh->status == "shipped")
                                bg-warning
                            @elseif ($dh->status == "delivered")
                                bg-success
                            @elseif ($dh->status == "cancelled")
                                bg-danger
                            @endif
                            ">{{$dh->status}}</span></td>
                      </tr>
                    @endforeach

                </tbody>
              </table>
            </div>
            <!-- / div trống-->
          </div>
         </div>
          <!-- / col-12 -->
           <!-- col-12 -->
          <div class="col-md-12">
              <div class="tile">
                <h3 class="tile-title">Khách hàng mới</h3>
              <div>
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Tên khách hàng</th>
                      <th>Giới tính</th>
                      <th>Địa chỉ</th>
                      <th>Số điện thoại</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($listkhachHangMoi as $kh)
                    <tr>
                        <td>{{$kh->id}}</td>
                        <td>{{$kh->Fullname}}</td>
                        <td>
                            @if ($kh->gender == 1)
                                Nam
                            @elseif ($kh->gender == 2)
                                Nữ
                            @endif
                        </td>
                        <td>{{$kh->address}}</td>
                        <td><span class="tag tag-success">{{$kh->Phone_number}}</span></td>
                      </tr>
                    @endforeach

                  </tbody>
                </table>
              </div>

            </div>
          </div>
           <!-- / col-12 -->
      </div>
    </div>
    <!--END left-->
    <!--Right-->
    <div class="col-md-12 col-lg-6">
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Dữ liệu 6 tháng đầu vào</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Thống kê 6 tháng doanh thu</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="barChartDemo"></canvas>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!--END right-->
  </div>



</main>
<script src="admin/doc/js/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="admin/doc/js/popper.min.js"></script>
<script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>
<!--===============================================================================================-->
<script src="admin/doc/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="admin/doc/js/main.js"></script>
<!--===============================================================================================-->
<script src="admin/doc/js/plugins/pace.min.js"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="admin/doc/js/plugins/chart.js"></script>
<!--===============================================================================================-->
<script type="text/javascript">
  var data = {
    labels: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6"],
    datasets: [{
      label: "Dữ liệu đầu tiên",
      fillColor: "rgba(255, 213, 59, 0.767), 212, 59)",
      strokeColor: "rgb(255, 212, 59)",
      pointColor: "rgb(255, 212, 59)",
      pointStrokeColor: "rgb(255, 212, 59)",
      pointHighlightFill: "rgb(255, 212, 59)",
      pointHighlightStroke: "rgb(255, 212, 59)",
      data: [20, 59, 90, 51, 56, 100]
    },
    {
      label: "Dữ liệu kế tiếp",
      fillColor: "rgba(9, 109, 239, 0.651)  ",
      pointColor: "rgb(9, 109, 239)",
      strokeColor: "rgb(9, 109, 239)",
      pointStrokeColor: "rgb(9, 109, 239)",
      pointHighlightFill: "rgb(9, 109, 239)",
      pointHighlightStroke: "rgb(9, 109, 239)",
      data: [48, 48, 49, 39, 86, 10]
    }
    ]
  };
  var ctxl = $("#lineChartDemo").get(0).getContext("2d");
  var lineChart = new Chart(ctxl).Line(data);

  var ctxb = $("#barChartDemo").get(0).getContext("2d");
  var barChart = new Chart(ctxb).Bar(data);
</script>
@endsection
