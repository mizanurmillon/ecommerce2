@extends('layouts.admin')

@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"/>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">ORDER LIST</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card">
       <div class="card-header">
          <h3 class="card-title">All Order list </h3>
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
            <th>Action</th>
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
    <!-- /.Edit Modal -->
    <div id="EditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h4 class="modal-title">Edit Order Status</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>  
                </div>
                <div id="modal_body">
                  
                </div>
            </div> 
        </div>
      </div><!-- /.modal -->
      {{-- View Modal --}}
      <div id="ViewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h4 class="modal-title">View Order</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>  
                </div>
                <div id="view_modal_body">
                  
                </div>
            </div> 
        </div>
      </div><!-- /.modal -->
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
              {data:'action' , name:'action', orderable:true, searchable:true},
            ]
          });
        });

      //edit order--------
      $('body').on('click','.edit',function(){
        let id=$(this).data('id');
        $.get("order/edit/"+id,function(data){
          $("#modal_body").html(data);
        });
      });

      //view order
      $('body').on('click','.view',function(){
        let id=$(this).data('id');
        $.get("order/view/"+id,function(data){
          $("#view_modal_body").html(data);
        });
      });
       
        //Delete Form----------
      $(document).ready(function(){
        $(document).on("click","#delete_order",function(e){
          e.preventDefault();
          var url = $(this).attr('href');
          $("#deleted_form").attr('action',url);
          swal({
            title: 'Are you went to Delete?',
            text: "Once Delete , This will be Permanently Delete!",
            icon: 'warning',
            buttons: true,
            dangerMode:true,
          })
          .then((willDelete)=>{
            if (willDelete){
               $("#deleted_form").submit();
            }else{
              swal('Safe Data!')
            }
          });
        });
        //Data passed through here----------
        $("#deleted_form").submit(function(e){
          e.preventDefault();
           var url = $(this).attr('action');
           var request = $(this).serialize();
           $.ajax({
              url:url,
              type:'post',
              async:false,
              data:request,
              success:function(data){
                toastr.warning(data);
                $('#deleted_form')[0].reset();
                table.ajax.reload();
              }
           });
        });
      });
      
     //submitable class call for every change
     $(document).on('change','.submitable',function(){
        $('.ytable').DataTable().ajax.reload();
     });
     $(document).on('blur','.submitable_input',function(){
        $('.ytable').DataTable().ajax.reload();
     });
      
    </script>
@endsection