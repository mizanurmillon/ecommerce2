@extends('layouts.admin')

@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"/>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">CAMPAING</h1>
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
          <h3 class="card-title">All Campaing list here </h3>
        </div>
      <div class="card-body">
        <table id="" class="table table-bordered table-striped table-sm ytable">
          <thead>
          <tr>
            <th>Start_date</th>
            <th>End_date</th>
            <th>Title</th>
            <th>Image</th>
            <th>Discount(%)</th>
            <th>Status</th>
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
    <form action="{{ route('campaing.store') }}" method="post" enctype="multipart/form-data" id="add-form">
    @csrf
    <div id="addmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h4 class="modal-title">Add a new Campanig</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>  
                </div>
                <div class="modal-body">
                  <div class="row"> 
                      <div class="col-md-12"> 
                          <div class="form-group"> 
                              <label for="title" class="control-label">Campaing Title <span class="text-danger">*</span></label> 
                              <input type="text" class="form-control" id="title" name="campaing_title" required> 
                              <small class="form-text text-muted">This is Campaing title/name</small>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group"> 
                                  <label for="start_date" class="control-label">Start Date <span class="text-danger">*</span></label> 
                                  <input type="date" class="form-control" id="start_date" name="start_date" required> 
                              </div> 
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group"> 
                                  <label for="end_date" class="control-label">End Date <span class="text-danger">*</span></label> 
                                  <input type="date" class="form-control" id="end_date" name="end_date" required> 
                              </div> 
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group"> 
                                  <label for="status" class="control-label">Status <span class="text-danger">*</span></label> 
                                  <select class="form-control" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                  </select> 
                              </div> 
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group"> 
                                  <label for="discount" class="control-label">Discount (%) <span class="text-danger">*</span></label> 
                                  <input type="number" class="form-control" id="discount" name="discount" required> 
                                  <small class="form-text text-danger">Discount precentage are apply for all Product selling price.</small>
                              </div> 
                            </div>
                        </div> 
                      </div>
                      <div class="col-md-12"> 
                          <div class="form-group"> 
                              <label for="image" class="control-label">Image</label> 
                              <input type="file" class="dropify" data-default-file="url_of_your_file" data-height="100" id="image" name="image" data-min-width="200" required> 
                          </div> 
                      </div>  
                  </div> 
                </div>  
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info waves-effect waves-light">submit</button> 
                </div>
            </div> 
        </div>
      </div><!-- /.modal -->
    </form>
    {{-- Edit modals --}}
    <div id="EditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h4 class="modal-title">Edit Campaing</h4>
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
    

      $(function campaing(){
          var table=$('.ytable').DataTable({
              processing:true,
              serverSide:true,
              ajax:"{{ route('campaing.index') }}",
              columns:[
                  {data:'start_date' , name:'start_date'},
                  {data:'end_date' , name:'end_date'},
                  {data:'campaing_title' , name:'campaing_title'},
                  {data:'image' , name:'image' , render:function(data,type,full,meta){
                    return "<img src=\""+data+"\" height=\"20\"/>"
                  }},
                  {data:'discount' , name:'discount'},
                  {data:'status' , name:'status'},
                  {data:'action' , name:'action', orderable:true, searchable:true},
              ]
          });
        });
      //edit========
     $('body').on('click','.edit',function(){
          let id=$(this).data('id');
          $.get("campaing/edit/"+id,function(data){
            $("#modal_body").html(data);
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