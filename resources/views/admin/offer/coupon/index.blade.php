@extends('layouts.admin')

@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">COUPON</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#addmodal">+Add New</button>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card">
       <div class="card-header">
          <h3 class="card-title">All Warehouse list here </h3>
        </div>
      <div class="card-body">
        <table id="" class="table table-bordered table-striped table-sm ytable">
          <thead>
          <tr>
            <th>Sl</th>
            <th>coupon code</th>
            <th>coupun Amount</th>
            <th>coupon date</th>
            <th>coupon status</th>
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
    <!-- /.card -->
  </div>
      <!-- Category modals -->
    <form action="{{ route('coupon.store') }}" method="post" id="add_form">
    @csrf
    <div id="addmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h4 class="modal-title">Add a new Coupon</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>  
                </div>
                <div class="modal-body">
                  <div class="row"> 
                      <div class="col-md-12"> 
                          <div class="form-group"> 
                              <label for="ware" class="control-label">Coupon Code</label> 
                              <input type="text" class="form-control" id="ware" name="coupon_code" required placeholder="coupon code"> 
                          </div> 
                          <div class="form-group"> 
                              <label for="address" class="control-label">coupon Type</label> 
                              <select class="form-control" name="type">
                                <option value="1">Fixed</option>
                                <option value="2">Precentage</option>
                              </select>
                          </div> 
                          <div class="form-group"> 
                              <label for="coupon" class="control-label">Amount</label> 
                              <input type="text" class="form-control" id="coupon" name="coupon_amount" required placeholder="amount"> 
                          </div> 
                          <div class="form-group"> 
                              <label for="date" class="control-label">Valid Date</label> 
                              <input type="date" class="form-control" id="date" name="valid_date" required> 
                          </div>
                          <div class="form-group"> 
                              <label for="address" class="control-label">coupon Status</label> 
                              <select class="form-control" name="status">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                              </select>
                          </div> 
                      </div>
                  </div> 
                </div>  
                <div class="modal-footer">
                  <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
                    <button type="submit" class="btn btn-info waves-effect waves-light"><span class="d-none loader"><i class="fas fa-spinner"></i> loading..</span><span class="submit_btn">submit</span></button>
                </div>
            </div> 
        </div>
      </div><!-- /.modal -->
    </form>
    {{-- Edit modals --}}
    <div id="EditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h4 class="modal-title">Edit Coupon</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>  
                </div>
                <div id="modal_body">
                  
                </div>
            </div> 
        </div>
      </div><!-- /.modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
      $(function coupon(){
              table=$('.ytable').DataTable({
                processing:true,
                serverSide:true,
                ajax:"{{ route('coupon.index') }}",
                columns:[
                    {data:'DT_RowIndex' , name:'DT_RowIndex'},
                    {data:'coupon_code' , name:'coupon_code'},
                    {data:'coupon_amount' , name:'coupon_amount'},
                    {data:'valid_date' , name:'valid_date'},
                    {data:'status' , name:'status'},
                    {data:'action' , name:'action', orderable:true, searchable:true},
                ]
            });
        });
       // Submit Form & store-----------
        $('#add_form').submit(function(e){
          e.preventDefault();
          $('.loader').removeClass('.d-none');
           var url = $(this).attr('action');
           var request = $(this).serialize();
           $.ajax({
              url:url,
              type:'post',
              async:false,
              data:request,
              success:function(data){
                toastr.success(data);
                $('#add_form')[0].reset();
                $('.loader').addClass('.d-none');
                $('#addmodal').modal('hide');
                table.ajax.reload();
              }

           });
        });
      //edit--------
      $('body').on('click','.edit',function(){
        let id=$(this).data('id');
        $.get("coupon/edit/"+id,function(data){
          $("#modal_body").html(data);
        });
      });
      //Delete Form----------
      $(document).ready(function(){
        $(document).on("click","#delete_coupon",function(e){
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
    </script>
@endsection