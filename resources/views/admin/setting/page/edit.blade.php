@extends('layouts.admin')

@section('admin_content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Admin Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">Edit Pages</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<br>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
            <div class="card-header">
            <h3 class="card-title">Edit & Update page</h3>
            </div>
            <form action="{{ route('page.update',$page->id) }}" method="post">
              @csrf
              <div class="card-body">
              	<div class="form-group">
                  <label for="page">Page Position</label>
                 	<select class="form-control" name="page_position">
                 		<option value="1" @if($page->page_position==1) selected="" @endif >Line One</option>
                 		<option value="2" @if($page->page_position==2) selected="" @endif >Line Two</option>
                 	</select>
                </div>
                <div class="form-group">
                  <label for="page">Page Name</label>
                  <input type="text" class="form-control" id="page" value="{{ $page->page_name }}" name="page_name">
                </div>
                <div class="form-group">
                  <label for="page1">Page Title</label>
                  <input type="text" class="form-control" id="page1" value="{{ $page->page_title }}" name="page_title">
                </div>
                <div class="form-group">
                  <label for="page">Page Description</label>
                  <textarea name="page_description" class="form-control" id="summernote">{{ $page->page_description }}</textarea>
                </div>
                
                <div class="input-group-append">
                 <button type="submit" class="btn btn-primary">update page</button>
                </div>
                </div>
            </form>
            </div>
          </div>
          
        </div>
        <!-- /.row -->
       
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection