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
              <li class="breadcrumb-item active">Website Setting</li>
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
            <h3 class="card-title">Website setting page</h3>
            </div>
            <form action="{{ route('website.setting.update',$setting->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label>Currency</label>
                   <select class="form-control" name="currency">
                   	<option value="৳" {{ $setting->currency=='৳' ? 'selected' : '' }}>Taka(৳)</option>
                   	<option value="$" {{ $setting->currency=='$' ? 'selected' : '' }}>USD($)</option>
                    <option value="₹" {{ $setting->currency=='₹' ? 'selected' : '' }}>Rupee(₹)</option>
                   </select>
                </div>
                <div class="form-group">
                  <label>Phone One</label>
                  <input type="text" class="form-control" value="{{ $setting->phone_one }}" name="phone_one">
                </div>
                <div class="form-group">
                  <label>Phone Two</label>
                  <input type="text" class="form-control"  value="{{ $setting->phone_two }}" name="phone_two">
                </div>
                <div class="form-group">
                  <label>Main Email</label>
                  <input type="email" class="form-control" value="{{ $setting->main_email }}" name="main_email">
                </div>
                <div class="form-group">
                  <label>Support Email</label>
                  <input type="email" class="form-control" value="{{ $setting->support_email }}" name="support_email">
                </div>
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" class="form-control" value="{{ $setting->address }}" name="address">
                </div>
                <strong class="text-center text-info">--- Sociual Link ---</strong>
                <div class="form-group">
                  <label>Facebook</label>
                  <input type="text" class="form-control" value="{{ $setting->facebook }}" name="facebook">
                </div>
                <div class="form-group">
                  <label>Twitter</label>
                  <input type="text" class="form-control" value="{{ $setting->twitter }}" name="twitter">
                </div>
                <div class="form-group">
                  <label>Instagram</label>
                  <input type="text" class="form-control" value="{{ $setting->instagram }}" name="instagram">
                </div>
                <div class="form-group">
                  <label>Linkedin</label>
                  <input type="text" class="form-control" value="{{ $setting->linkedin }}" name="linkedin">
                </div>
                <div class="form-group">
                  <label>YouTube</label>
                  <input type="text" class="form-control" value="{{ $setting->youtube }}" name="youtube">
                </div>
                <strong class="text-center text-info">Logo & Favicon</strong>
                <div class="form-group">
                  <label>Main Logo</label>
                  <input type="file" class="form-control"  name="logo">
                  <input type="hidden" name="old_logo" value="{{ $setting->logo }}">
                </div>
                <div class="form-group">
                  <label>Favicon</label>
                  <input type="file" class="form-control" name="favicon">
                  <input type="hidden" name="old_favicon" value="{{ $setting->favicon }}">
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