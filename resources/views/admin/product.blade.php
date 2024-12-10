@extends('admin.layout')
@section('title')
Danh sách sản phẩm | Quản trị Admin
@endsection
@section('title2')
Danh sách sản phẩm
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">

                      <a class="btn btn-add btn-sm" href="{{route('admin.sanpham.them')}}" title="Thêm"><i class="fas fa-plus"></i>
                        Tạo mới sản phẩm</a>
                        @if(session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>

                  </div>
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Số lượng</th>
                            <th>Tình trạng</th>
                            <th>Giá tiền</th>
                            <th>Danh mục</th>
                            <th>Xuất xứ</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listProducts as $product)
                        <tr>
                            <td width="10"><input type="checkbox" name="check1" value="1"></td>
                            <td>{{$product->Product_id}}</td>
                            <td>{{$product->name}}</td>
                            <td><img src="{{asset('storage'). '/'.$product->image}}" alt="" width="100px;"></td>
                            <td>{{$product->quantity}}</td>
                            <td>
                                @if ($product->quantity > 5)
                                <span class="badge bg-success">Còn hàng</span>
                                @elseif ($product->quantity == 0)
                                <span class="badge bg-danger">Hét hàng</span>
                                @else
                                <span class="badge bg-warning">Sắp hết</span>
                                @endif
                            </td>
                            <td>{{$product->price}}$</td>
                            <td>{{$product->category->name}}</td>
                            <td>
                                {{$product->origin->name}}
                            <td class="table-td-center d-flex">
                                <form action="{{route('admin.sanpham.destroy',$product->Product_id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-primary btn-sm trash" type="submit" title="Xóa"
                                        onclick="myFunction(this)"><i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.sanpham.edit',$product->Product_id) }}" class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp"
                                    ><i class="fas fa-edit"></i>
                                </a>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</main>

<!--
MODAL
-->
<div class="modal fade" id="ModalUP" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"
data-keyboard="false">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">

<div class="modal-body">
<div class="row">
<div class="form-group  col-md-12">
  <span class="thong-tin-thanh-toan">
    <h5>Chỉnh sửa thông tin sản phẩm cơ bản</h5>
  </span>
</div>
</div>
<div class="row">
<div class="form-group col-md-6">
    <label class="control-label">Mã sản phẩm </label>
    <input class="form-control" type="number" value="71309005">
  </div>
<div class="form-group col-md-6">
    <label class="control-label">Tên sản phẩm</label>
  <input class="form-control" type="text" required value="Bàn ăn gỗ Theresa">
</div>
<div class="form-group  col-md-6">
    <label class="control-label">Số lượng</label>
  <input class="form-control" type="number" required value="20">
</div>
<div class="form-group col-md-6 ">
    <label for="exampleSelect1" class="control-label">Tình trạng sản phẩm</label>
    <select class="form-control" id="exampleSelect1">
      <option>Còn hàng</option>
      <option>Hết hàng</option>
      <option>Đang nhập hàng</option>
    </select>
  </div>
  <div class="form-group col-md-6">
    <label class="control-label">Giá bán</label>
    <input class="form-control" type="text" value="5.600.000">
  </div>
  <div class="form-group col-md-6">
    <label for="exampleSelect1" class="control-label">Danh mục</label>
    <select class="form-control" id="exampleSelect1">
      <option>Bàn ăn</option>
      <option>Bàn thông minh</option>
      <option>Tủ</option>
      <option>Ghế gỗ</option>
      <option>Ghế sắt</option>
      <option>Giường người lớn</option>
      <option>Giường trẻ em</option>
      <option>Bàn trang điểm</option>
      <option>Giá đỡ</option>
    </select>
  </div>
</div>
<BR>
<a href="#" style="    float: right;
font-weight: 600;
color: #ea0000;">Chỉnh sửa sản phẩm nâng cao</a>
<BR>
<BR>
<button class="btn btn-save" type="button">Lưu lại</button>
<a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
<BR>
</div>
<div class="modal-footer">
</div>
</div>
</div>
</div>
<!--
MODAL
-->

<!-- Essential javascripts for application to work-->
<script src="{{asset('admin/doc/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('admin/doc/js/popper.min.js')}}"></script>
<script src="{{asset('admin/doc/js/bootstrap.min.js')}}"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="src/jquery.table2excel.js"></script>
<script src="{{asset('admin/doc/js/main.js')}}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="js/plugins/pace.min.js"></script>
<!-- Page specific javascripts-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<!-- Data table plugin-->
<script type="text/javascript" src="{{asset('admin/doc/js/plugins/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/doc/js/plugins/dataTables.bootstrap.min.js')}}"></script>
<script type="text/javascript">
$('#sampleTable').DataTable();
//Thời Gian
function time() {
var today = new Date();
var weekday = new Array(7);
weekday[0] = "Chủ Nhật";
weekday[1] = "Thứ Hai";
weekday[2] = "Thứ Ba";
weekday[3] = "Thứ Tư";
weekday[4] = "Thứ Năm";
weekday[5] = "Thứ Sáu";
weekday[6] = "Thứ Bảy";
var day = weekday[today.getDay()];
var dd = today.getDate();
var mm = today.getMonth() + 1;
var yyyy = today.getFullYear();
var h = today.getHours();
var m = today.getMinutes();
var s = today.getSeconds();
m = checkTime(m);
s = checkTime(s);
nowTime = h + " giờ " + m + " phút " + s + " giây";
if (dd < 10) {
dd = '0' + dd
}
if (mm < 10) {
mm = '0' + mm
}
today = day + ', ' + dd + '/' + mm + '/' + yyyy;
tmp = '<span class="date"> ' + today + ' - ' + nowTime +
'</span>';
document.getElementById("clock").innerHTML = tmp;
clocktime = setTimeout("time()", "1000", "Javascript");

function checkTime(i) {
if (i < 10) {
  i = "0" + i;
}
return i;
}
}
</script>
<script>
function deleteRow(r) {
    var i = r.parentNode.parentNode.rowIndex;
    document.getElementById("myTable").deleteRow(i);
}
jQuery(function () {
    jQuery(".trash").click(function () {
        swal({
            title: "Cảnh báo",
            text: "Bạn có chắc chắn là muốn xóa sản phẩm này?",
            buttons: ["Hủy bỏ", "Đồng ý"],
        })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Đã xóa thành công.!", {

                    });
                }
            });
    });
});
oTable = $('#sampleTable').dataTable();
$('#all').click(function (e) {
    $('#sampleTable tbody :checkbox').prop('checked', $(this).is(':checked'));
    e.stopImmediatePropagation();
});
</script>
@endsection
