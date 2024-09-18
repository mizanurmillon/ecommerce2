@extends('layouts.admin')

@section('admin_content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">PAGES</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <a href="{{ route('page.create') }}" class="btn btn-danger btn-sm">+Add New</a>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card">
       <div class="card-header">
          <h3 class="card-title">All Pages list here </h3>
        </div>
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped table-sm">
          <thead>
          <tr>
            <th>Sl</th>
            <th>Page Name</th>
            <th>Page Title</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($page as $key=>$row)
          <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $row->page_name }}</td>
            <td>{{ $row->page_title }}</td>
            <td> 
              <a href="{{ route('page.edit',$row->id) }}" class="btn btn-info btn-sm edit"><i class="fa-solid fa-pen-to-square"></i></a>
              <a href="{{ route('page.delete',$row->id) }}" id="delete" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
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
@endsection