@extends('layouts.admin')

@section('admin_content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Setting Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">SMTP Setting</li>
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
            <h3 class="card-title">SMTP setting page</h3>
            </div>
            <form action="{{ route('smtp.setting.update',$smtp->id) }}" method="post">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label>Mail mailer</label>
                  <input type="text" class="form-control" placeholder="mail mailer" value="{{ $smtp->mail_mailer }}" name="mail_mailer">
                </div>
                <div class="form-group">
                  <label>Mail Host</label>
                  <input type="text" class="form-control" placeholder="Mail host" value="{{ $smtp->mail_host }}" name="mail_host">
                </div>
                <div class="form-group">
                  <label>Mail Port</label>
                  <input type="text" class="form-control" placeholder="Meta Tag" value="{{ $smtp->mail_port }}" name="mail_port">
                </div>
                <div class="form-group">
                  <label>Mail UserName</label>
                  <input type="text" class="form-control" placeholder="mail username" value="{{ $smtp->mail_username }}" name="mail_username">
                </div>
                <div class="form-group">
                  <label>Mail Password</label>
                  <input type="text" class="form-control" placeholder="mail password" value="{{ $smtp->mail_password }}" name="mail_password">
                </div>
                <div class="input-group-append">
                 <button type="submit" class="btn btn-primary">Update</button>
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