@extends('layouts.admin')

@section('admin_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">NEW ROLE</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">Add Role</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content">
      <div class="container-fluid">
        <form action="{{ route('role.update') }}" method="post">
          @csrf
          <input type="hidden" name="id" value="{{ $data->id }}">
          <div class="row">
            <div class="col-sm-12">
              <div class="card card-primary">
                <div class="card-header">
                  <div class="card-title">Add New Role</div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Employee Name<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="name" required value="{{ $data->name }}">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Employee Email<span class="text-danger">*</span></label>
                      <input type="email" name="email" value="{{ $data->email }}" required class="form-control" > 
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-3">
                      <h6>Category</h6>
                      <input type="checkbox" name="category" value="1" @if($data->category==1) checked="" @endif>
                    </div>
                    <div class="col-3">
                      <h6>Product</h6>
                      <input type="checkbox" name="product" value="1" @if($data->product) checked="" @endif>
                    </div>
                    <div class="col-3">
                      <h6>Offer</h6>
                      <input type="checkbox" name="offer" value="1" @if($data->offer) checked="" @endif>
                    </div>
                    <div class="col-3">
                      <h6>Order</h6>
                      <input type="checkbox" name="order" value="1" @if($data->order) checked="" @endif>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-3">
                      <h6>Blog</h6>
                      <input type="checkbox" name="blog" value="1" @if($data->blog) checked="" @endif>
                    </div>
                    <div class="col-3">
                      <h6>Pickup</h6>
                      <input type="checkbox" name="pickup" value="1" @if($data->pickup) checked="" @endif>
                    </div>
                    <div class="col-3">
                      <h6>Ticket</h6>
                      <input type="checkbox" name="ticket" value="1" @if($data->ticket) checked="" @endif>
                    </div>
                    <div class="col-3">
                      <h6>Contact</h6>
                      <input type="checkbox" name="contact" value="1" @if($data->contact) checked="" @endif>
                    </div>
                  </div>
                  <br>
                   <div class="row">
                    <div class="col-3">
                      <h6>Setting</h6>
                      <input type="checkbox" name="setting" value="1" @if($data->setting) checked="" @endif>
                    </div>
                    <div class="col-3">
                      <h6>Report</h6>
                      <input type="checkbox" name="report" value="1" @if($data->report) checked="" @endif>
                    </div>
                    <div class="col-3">
                      <h6>Userrole</h6>
                      <input type="checkbox" name="userrole" value="1" @if($data->userrole) checked="" @endif>
                    </div>
                  </div><br>
                  <button type="submit" class="btn btn-info btn-sm">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection