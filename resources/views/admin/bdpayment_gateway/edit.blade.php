@extends('layouts.admin')

@section('admin_content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Payment Gateway Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">Payment Setting</li>
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
          <div class="col-md-4">
            <div class="card card-primary">
            <div class="card-header">
            <h3 class="card-title">Aamerpay Payment Gateway</h3>
            </div>
            <form action="{{ route('aamerpay.update') }}" method="post">
              @csrf
              <div class="card-body">
                <input type="hidden" name="id" value="{{ $aamerpay->id }}">
                <div class="form-group">
                  <label>StoreId</label>
                  <input type="text" class="form-control" value="{{ $aamerpay->store_id }}" name="store_id">
                </div>
                <div class="form-group">
                  <label>Signature Key</label>
                  <input type="text" class="form-control" value="{{ $aamerpay->signature_key }}" name="signature_key">
                </div>
                <div class="form-group">
                  <input type="checkbox"  name="status" value="1"  @if($aamerpay->status==1) checked="" @endif>
                  <label>Live Server</label> <small class="text-danger">(Your checkBox are not checked it working for sendbox only)</small>
                </div>
                <div class="input-group-append">
                 <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </div>
            </form>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-primary">
            <div class="card-header">
            <h3 class="card-title">Surjopay Payment Gateway</h3>
            </div>
            <form action="{{ route('surjopay.update') }}" method="post">
              @csrf
              <div class="card-body">
                <input type="hidden" name="id" value="{{ $surjopay->id }}">
                <div class="form-group">
                  <label>StoreId</label>
                  <input type="text" class="form-control" value="{{ $surjopay->store_id }}" name="store_id">
                </div>
                <div class="form-group">
                  <label>Signature Key</label>
                  <input type="text" class="form-control" value="{{ $surjopay->signature_key }}" name="signature_key">
                </div>
                <div class="form-group">
                  <input type="checkbox" name="status" value="1"  @if($surjopay->status==1) checked="" @endif>
                  <label>Live Server</label> <small class="text-danger">(Your checkBox are not checked it working for sendbox only)</small>
                </div>
                <div class="input-group-append">
                 <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </div>
            </form>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-primary">
            <div class="card-header">
            <h3 class="card-title">SSL Commerz Payment Gateway</h3>
            </div>
            <form action="{{ route('sslcommerz.update') }}" method="post">
              @csrf
              <div class="card-body">
                <input type="hidden" name="id" value="{{ $ssl->id }}">
                <div class="form-group">
                  <label>StoreId</label>
                  <input type="text" class="form-control" value="{{ $ssl->store_id }}" name="store_id">
                </div>
                <div class="form-group">
                  <label>Signature Key</label>
                  <input type="text" class="form-control" value="{{ $ssl->signature_key }}" name="signature_key">
                </div>
                <div class="form-group">
                  <input type="checkbox" name="status" value="1" @if($ssl->status==1) checked="" @endif>
                  <label>Live Server</label>
                   <small class="text-danger">(Your checkBox are not checked it working for sendbox only)</small>
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