@extends('layouts.admin')

@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">WAREHOUSE</h1>
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
            <th>WareHouse Name</th>
            <th>WareHouse Address</th>
            <th>WareHouse Phone</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
         
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
      <!-- Category modals -->
    <form action="{{ route('warehouse.store') }}" method="post" enctype="multipart/form-data" id="add-form">
    @csrf
    <div id="addmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h4 class="modal-title">Add a new Warehouse</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>  
                </div>
                <div class="modal-body">
                  <div class="row"> 
                      <div class="col-md-12"> 
                          <div class="form-group"> 
                              <label for="ware" class="control-label">Warehouse Name</label> 
                              <input type="text" class="form-control" id="ware" name="warehouse_name" required placeholder="warehouse name"> 
                          </div> 
                          <div class="form-group"> 
                              <label for="address" class="control-label">Warehouse address</label> 
                              <input type="text" class="form-control" id="address" name="warehouse_address" required placeholder="warehouse address"> 
                          </div> 
                          <div class="form-group"> 
                              <label for="phone" class="control-label">Warehouse phone</label> 
                              <input type="text" class="form-control" id="phone" name="phone" required placeholder="phone"> 
                          </div> 
                      </div>
                  </div> 
                </div>  
                <div class="modal-footer">
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
                    <h4 class="modal-title">Update Warehouse</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>  
                </div>
                <div id="modal_body">
                  
                </div>
            </div> 
        </div>
      </div><!-- /.modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
      //edit========
      $('body').on('click','.edit',function(){
          let id=$(this).data('id');
          $.get("warehouse/edit/"+id,function(data){
            $("#modal_body").html(data);
          });
      });

      $(function warehouse(){
            var table=$('.ytable').DataTable({
                processing:true,
                serverSide:true,
                ajax:"{{ route('warehouse.index') }}",
                columns:[
                    {data:'DT_RowIndex' , name:'DT_RowIndex'},
                    {data:'warehouse_name' , name:'warehouse_name'},
                    {data:'warehouse_address' , name:'warehouse_address'},
                    {data:'phone' , name:'phone'},
                    {data:'action' , name:'action', orderable:true, searchable:true},
                ]
            });
        });
      //Form Submit-------
      $('#add-form').on('submit',function(){
          $('.loader').removeClass('d-none');
          $('.submit_btn').addClass('d-none');
      });
    </script>
@endsection