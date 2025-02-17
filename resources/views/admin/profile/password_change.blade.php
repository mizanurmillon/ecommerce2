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
              <li class="breadcrumb-item active">Password Change</li>
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
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="card card-primary">
            <div class="card-header">
            <h3 class="card-title">Change Your Password</h3>
            </div>
            <form action="{{ route('admin.password.update') }}" method="post">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Old password</label>
                  <input type="password" class="form-control" id="exampleInputEmail1" placeholder="old password" name="old_password" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">New Password</label> 
                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" placeholder="new password" name="password" required>
                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword2">Confirm Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" name="password_confirmation" required>
                </div>
                <div class="input-group-append">
                 <button type="submit" class="btn btn-primary">Submit</button>
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