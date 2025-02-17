@extends('layouts.admin')

@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"/>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">BRANDS</h1>
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
          <h3 class="card-title">All Brands list here </h3>
        </div>
      <div class="card-body">
        <table id="" class="table table-bordered table-striped table-sm ytable">
          <thead>
          <tr>
            <th>Sl</th>
            <th>Brand Name</th>
            <th>Brand slug</th>
            <th>Brand logo</th>
            <th>Home page</th>
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
    <form action="{{ route('brand.store') }}" method="post" enctype="multipart/form-data" id="add-form">
    @csrf
    <div id="addmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h4 class="modal-title">Add a new Brand</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>  
                </div>
                <div class="modal-body">
                  <div class="row"> 
                      <div class="col-md-12"> 
                          <div class="form-group"> 
                              <label for="brand" class="control-label">Brand Name</label> 
                              <input type="text" class="form-control" id="brand" name="brand_name" required> 
                              <small class="form-text text-muted">This is your main Brand</small>
                          </div> 
                          <div class="form-group"> 
                            <label for="brand" class="control-label">Home Page shwo</label> 
                             <select class="form-control" name="front_page">
                               <option value="1">Yes</option>
                               <option value="0">No</option>
                             </select> 
                             <small class="form-text text-muted">if Yes it will be show on your home page</small>
                          </div>
                          <div class="form-group"> 
                              <label for="brand" class="control-label">Brand logo</label> 
                              <input type="file" class="dropify" data-height="100" id="brand" name="brand_logo" required> 
                              <small class="form-text text-muted">This is your main Brand logo</small>
                          </div> 
                      </div>
                  </div> 
                </div>  
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
                    <button type="submit" class="btn btn-info waves-effect waves-light">submit</button> 
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
                    <h4 class="modal-title">Edit Brand</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>  
                </div>
                <div id="modal_body">
                  
                </div>
            </div> 
        </div>
      </div><!-- /.modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script type="text/javascript">
    //edit========
     $('body').on('click','.edit',function(){
          let id=$(this).data('id');
          $.get("brand/edit/"+id,function(data){
            $("#modal_body").html(data);
          });
      });

      $(function brand(){
          var table=$('.ytable').DataTable({
              processing:true,
              serverSide:true,
              ajax:"{{ route('brand.index') }}",
              columns:[
                  {data:'DT_RowIndex' , name:'DT_RowIndex'},
                  {data:'brand_name' , name:'brand_name'},
                  {data:'brand_slug' , name:'brand_slug'},
                  {data:'brand_logo' , name:'brand_logo' , render:function(data,type,full,meta){
                    return "<img src=\""+data+"\" height=\"20\"/>"
                  }},
                  {data:'front_page' , name:'front_page'},
                  {data:'action' , name:'action', orderable:true, searchable:true},
              ]
          });
        });

      $('.dropify').dropify({
        messages:{
          'default':'Click Here',
          'replace':'Drag and Drop to replace',
          'remove':'remove',
          'error':'Ooops, something wrong.'
        }
      });

    </script>
@endsection