@extends('layouts.admin')

@section('admin_content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">CHILD CATEGORY</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#addModal">+Add New</button>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card">
       <div class="card-header">
          <h3 class="card-title">All Child-Categories list here </h3>
        </div>
      <div class="card-body">
        <table id="" class="table table-bordered table-striped table-sm ytable">
          <thead>
          <tr>
            <th>Sl</th>
            <th>ChildCategory Name</th>
            <th>Category name</th>
            <th>Subcategory name</th>
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
      <!-- ChildCategory modals -->
    <form action="{{ route('childcategory.store') }}" method="post" id="add-form">
    @csrf
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h4 class="modal-title">Add a new Sub Category</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>  
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif 
                <div class="modal-body">
                  <div class="row"> 
                      <div class="col-md-12">
                        <div class="form-group"> 
                            <label for="name" class="control-label">Category/Subcategory</label> 
                            <select class="form-control" name="subcategory_id" required>
                             @foreach($category as $row)
                             @php
                             $subcategory=DB::table('subcategories')->where('category_id',$row->id)->get();
                             @endphp
                              <option disabled="">{{ $row->category_name }}</option>
                              @foreach($subcategory as $row)
                              <option value="{{ $row->id }}">----{{ $row->subcategory_name }}</option>
                              @endforeach
                              @endforeach
                            </select>
                        </div>  
                        <div class="form-group"> 
                            <label for="name" class="control-label">Child Category Name</label> 
                            <input type="text" class="form-control" id="name" name="childcategory_name" required>
                            <small class="form-text text-muted">This is your child category</small> 
                        </div> 
                      </div> 
                  </div> 
                </div>  
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
                    <button type="submit" class="btn btn-info waves-effect waves-light"><span class="d-none">loading....</span>submit</button> 
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
                    <h4 class="modal-title">Edit ChildCategory</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>  
                </div>
                <div id="modal_body">
                  
                </div>
            </div> 
        </div>
      </div><!-- /.modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
     
        $(function childcategory(){
            var table=$('.ytable').DataTable({
                processing:true,
                serverSide:true,
                ajax:"{{ route('childcategory.index') }}",
                columns:[
                    {data:'DT_RowIndex' , name:'DT_RowIndex'},
                    {data:'childcategory_name' , name:'childcategory_name'},
                    {data:'category_name' , name:'category_name'},
                    {data:'subcategory_name' , name:'subcategory_name'},
                    {data:'action' , name:'action', orderable:true, searchable:true},
                ]
            });
        });

	    //Edit==================
	    $('body').on('click','.edit',function(){
	        let id=$(this).data('id');
	        $.get("childcategory/edit/"+id,function(data){
	          $("#modal_body").html(data);
	        });
	    });
    </script>
    
@endsection