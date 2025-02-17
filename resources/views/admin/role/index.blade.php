@extends('layouts.admin')

@section('admin_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">USER ROLE</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <a href="{{ route('create.role') }}" class="btn btn-danger btn-sm">+Add New</a>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card">
       <div class="card-header">
          <h3 class="card-title">All user role here </h3>
        </div>
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped table-sm">
          <thead>
          <tr>
            <th>Sl</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($data as $key=>$row)
          <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $row->name }}</td>
            <td>{{ $row->email }}</td>
            <td>
              @if($row->category==1)<span class="badge badge-success">category</span> @endif
              @if($row->product==1)<span class="badge badge-success">product</span> @endif
              @if($row->offer==1)<span class="badge badge-success">offer</span> @endif
              @if($row->order==1)<span class="badge badge-success">order</span> @endif
              @if($row->blog==1)<span class="badge badge-success">blog</span> @endif
              @if($row->pickup==1)<span class="badge badge-success">pickup</span> @endif
              @if($row->ticket==1)<span class="badge badge-success">ticket</span> @endif
              @if($row->contact==1)<span class="badge badge-success">contact</span> @endif
              @if($row->report==1)<span class="badge badge-success">report</span> @endif
              @if($row->setting==1)<span class="badge badge-success">setting</span> @endif
              @if($row->userrole==1)<span class="badge badge-success">userrole</span> @endif
            </td>
            <td> 
              <a href="{{ route('role.edit',$row->id) }}" class="btn btn-info btn-sm edit"><i class="fa-solid fa-pen-to-square"></i></a>
              <a href="{{ route('role.delete',$row->id) }}" id="delete" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
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