@extends('admin.layout')
@section('title')
Quản lý nội bộ | Quản trị Admin
@endsection
@section('title2')
Quản lý nội bộ
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="row element-button">
            <div class="col-sm-2">

              <a class="btn btn-add btn-sm" href="{{ route('userbans.create') }}" title="Thêm"><i class="fas fa-plus"></i>
                Tạo mới</a>
            </div>

            <div class="col-sm-2">
              <a class="btn btn-delete btn-sm print-file" type="button" title="In" onclick="myApp.printTable()"><i
                  class="fas fa-print"></i> In dữ liệu</a>
            </div>

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
          </div>
          <table class="table table-hover table-bordered" id="sampleTable">
            <thead>
              <tr>
                <th width="10"><input type="checkbox" id="all"></th>
                <th>Họ và Tên</th>
                <th>Chức vụ</th>
                <th>Lý do cấm</th>
                <th>Tình trạng</th>
                <th>Chức năng</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($userbans as $userban)
                    <tr>
                        <td width="10">
                            <input type="checkbox" name="check1" value="{{ $userban->id }}">
                        </td>
                        <td>{{ $userban->name }}</td>
                        <td>
                            <span class="badge bg-info">
                                @if ($userban->Role_id == 1)
                                    Quản trị
                                @elseif($userban->Role_id == 3)
                                    Nhân viên
                                @endif
                            </span>
                        </td>
                        <td>{{ $userban->note }}</td>
                        <td>
                            @if ($userban->active==0)
                                <span class="badge bg-warning">Khóa tài khoản</span>
                            @elseif($userban->active==1)
                                <span class="badge bg-danger">Sa thải</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('userbans.destroy', $userban->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-primary btn-sm trash" type="submit" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            <a href="{{ route('userbans.edit', $userban->id) }}" class="btn btn-primary btn-sm edit" title="Sửa">
                                <i class="fa fa-edit"></i>
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

 <!-- Essential javascripts for application to work-->
 <script src="{{asset('admin/doc/js/jquery-3.2.1.min.js')}}"></script>
 <script src="{{asset('admin/doc/js/popper.min.js')}}"></script>
 <script src="{{asset('admin/doc/js/bootstrap.min.js')}}"></script>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 <script src="{{asset('admin/doc/src/jquery.table2excel.js')}}"></script>
 <script src="{{asset('admin/doc/js/main.js')}}"></script>
 <!-- The javascript plugin to display page loading on top-->
 <script src="{{asset('admin/doc/js/plugins/pace.min.js')}}"></script>
 <!-- Page specific javascripts-->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
 <!-- Data table plugin-->
 <script type="text/javascript" src="{{asset('admin/doc/js/plugins/jquery.dataTables.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('admin/doc/js/plugins/dataTables.bootstrap.min.js')}}"></script>
 <script type="text/javascript">$('#sampleTable').DataTable();</script>
 <script>
   function deleteRow(r) {
     var i = r.parentNode.parentNode.rowIndex;
     document.getElementById("myTable").deleteRow(i);
   }
   jQuery(function () {
     jQuery(".trash").click(function () {
       swal({
         title: "Cảnh báo",

         text: "Bạn có chắc chắn là muốn xóa?",
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

   //EXCEL
   // $(document).ready(function () {
   //   $('#').DataTable({

   //     dom: 'Bfrtip',
   //     "buttons": [
   //       'excel'
   //     ]
   //   });
   // });


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
   //In dữ liệu
   var myApp = new function () {
     this.printTable = function () {
       var tab = document.getElementById('sampleTable');
       var win = window.open('', '', 'height=700,width=700');
       win.document.write(tab.outerHTML);
       win.document.close();
       win.print();
     }
   }
   //     //Sao chép dữ liệu
   //     var copyTextareaBtn = document.querySelector('.js-textareacopybtn');

   // copyTextareaBtn.addEventListener('click', function(event) {
   //   var copyTextarea = document.querySelector('.js-copytextarea');
   //   copyTextarea.focus();
   //   copyTextarea.select();

   //   try {
   //     var successful = document.execCommand('copy');
   //     var msg = successful ? 'successful' : 'unsuccessful';
   //     console.log('Copying text command was ' + msg);
   //   } catch (err) {
   //     console.log('Oops, unable to copy');
   //   }
   // });


   //Modal
   $("#show-emp").on("click", function () {
     $("#ModalUP").modal({ backdrop: false, keyboard: false })
   });
 </script>

@endsection
