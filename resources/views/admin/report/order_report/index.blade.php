@extends('layouts.admin')

@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"/>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">ORDER REPORT</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <button type="submit" class="btn btn-info btn-sm print" style="float: right;"><span class="d-none loader">...loading</span> Print</button>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card">
       <div class="card-header">
          <h3 class="card-title">All Order Report </h3>
        </div>
        <br>
        <div class="row p-2">
          <div class="form-group col-4">
            <label>Payment Type</label>
            <select class="form-control submitable" name="payment_type" id="payment_type">
              <option value="">All</option>
              <option value="Hand Cash">Hend Cash</option>
              <option value="Aamerpay">Aamerpay</option>
              <option value="Paypal">Paypal</option>
             
            </select>
          </div>
          
            <div class="form-group col-4">
              <label>Date</label>
              <input type="date" class="form-control submitable_input" name="date" id="date">
          </div>
          <div class="form-group col-4">
            <label>Status</label>
            <select class="form-control submitable" name="status" id="status">
              <option value="0">All</option>
              <option value="0">Pending</option>
              <option value="1">Recieved</option>
              <option value="2">Shipped</option>
              <option value="3">Completed</option>
              <option value="4">Return</option>
              <option value="5">Cancel</option>
            </select>
          </div>
      <div class="card-body">
        <table id="" class="table table-bordered table-striped table-sm ytable">
          <thead>
          <tr>
            <th>Sl</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Subtotal ({{ $setting->currency }})</th>
            <th>Total ({{ $setting->currency }})</th>
            <th>Payment Type</th>
            <th>Date</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
          
          </tbody>
        </table>
        <form action="" method="delete" id="deleted_form">
          @csrf @method('DELETE')
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script type="text/javascript">

      $(function product(){
          table=$('.ytable').DataTable({
            "processing":true,
            "serverSide":true,
            "searching":true,
            "ajax":{
                "url":"{{ route('admin.order.index') }}",
                "data":function(e){
                  e.payment_type=$("#payment_type").val();
                  e.date=$("#date").val();
                  e.status=$("#status").val();
                }
           },
            columns:[
              {data:'DT_RowIndex' , name:'DT_RowIndex'},
              {data:'c_name' , name:'c_name'},
              {data:'c_phone' , name:'c_phone'},
              {data:'c_email' , name:'c_email'},
              {data:'subtotal' , name:'subtotal'},
              {data:'total' , name:'total'},
              {data:'payment_type' , name:'payment_type'},
              {data:'date' , name:'date'},
              {data:'status' , name:'status'},
            ]
          });
        });
     //submitable class call for every change
     $(document).on('change','.submitable',function(){
        $('.ytable').DataTable().ajax.reload();
     });
     $(document).on('blur','.submitable_input',function(){
        $('.ytable').DataTable().ajax.reload();
     });
     $('.print').on('click', function(e){
          e.preventDefault();
          $('.loader').removeClass('d-none');
           $.ajax({
              url:'{{ route('report.order.print') }}',
              data:{status: $('#status').val(), payment_type: $('#payment_type').val(), date: $('#date').val()},
              success:function(data){
                $('.loader').addClass('d-none');
                $(data).printThis({
                  debug:false,
                  importCSS:true,
                  importStyle:true,
                  importInline:true,
                  prinDelay:500,
                  header:null,
                  footer:null,
                });
              }

           });
        });
      
    </script>
@endsection