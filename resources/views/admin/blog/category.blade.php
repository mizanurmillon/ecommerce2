@extends('layouts.admin')

@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"/>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">BLOG CATEGORY</h1>
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
          <h3 class="card-title">All Blog Categories list here </h3>
        </div>
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped table-sm">
          <thead>
          <tr>
            <th>Sl</th>
            <th>Category Name</th>
            <th>Category slug</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($category as $key=>$row)
          <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $row->category_name }}</td>
            <td>{{ $row->category_slug }}</td>
            <td> 
              <a href="#" class="btn btn-info btn-sm edit" data-id="{{ $row->id }}" data-toggle="modal" data-target="#EditModal"><i class="fa-solid fa-pen-to-square"></i></a>
              <a href="{{ route('blog.category.delete',$row->id) }}" id="delete" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
      <!-- Category modals -->
    <form action="{{ route('blog.category.store') }}" method="post">
    @csrf
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h4 class="modal-title">Add a new Blog Category</h4>
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
                              <label for="name" class="control-label">Category Name</label> 
                              <input type="text" class="form-control" id="name" name="category_name" required> 
                              <small class="form-text text-muted">This is your main blog category</small>
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
        <div class="modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h4 class="modal-title">Edit Blog Category</h4>
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
                <div id="modal_body">
                  
                </div>  
                
            </div> 
        </div>
      </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    
     <script type="text/javascript">
       $('body').on('click','.edit',function(){
          let id=$(this).data('id');
          $.get("blog-category/edit/"+id,function(data){
            $("#modal_body").html(data);
          });
      });
    </script>
@endsection