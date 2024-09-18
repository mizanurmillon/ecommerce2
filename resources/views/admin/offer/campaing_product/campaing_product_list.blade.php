@extends('layouts.admin')

@section('admin_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">CAMPAING PRODUCT LIST</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card">
       <div class="card-header">
          <h3 class="card-title">Campaing Product List</h3>
        </div>
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped table-sm">
          <thead>
          <tr>
            <th>Sl</th>
            <th>Name</th>
            <th>Image</th>
            <th>Code</th>
            <th>Price</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($product as $key=>$row)
          <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $row->name }}</td>
            <td><img src="{{ asset('public/backend/files/product/'.$row->thumbnail) }}" height="32" width="32"></td>
            <td>{{ $row->code }}</td>
            <td>{{ $row->price }}</td>
            <td>
              	<a href="{{ route('product.remove.campaing',$row->id) }}" id="delete" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
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
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
     
@endsection