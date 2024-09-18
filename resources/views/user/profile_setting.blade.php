@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('user.sidebar')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile Setting Dashboard') }}
                    <a href="{{ route('write.review') }}" style="float: right;" class="text-dark"><i class="fa-solid fa-pencil"></i> Write a Review</a></div>
                    <div class="card-body">
                       <h4 style="font-size: 20px; font-style: italic;">Your default shipping credentials.</h4><br>
                       <form action="{{ route('website.review.store') }}" method="post">
                        @csrf
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Shipping Name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="shipping_name">
                          </div>
                            <div class="row">
                               <div class="mb-3 col-md-6">
                                <label class="form-label">Shipping phone</label>
                                <input type="text" class="form-control"  aria-describedby="emailHelp" name="shipping_phone">
                              </div>
                              <div class="mb-3 col-md-6">
                                <label  class="form-label">Shipping Email</label>
                                <input type="email" class="form-control"  aria-describedby="emailHelp" name="shipping_email">
                              </div>
                            </div>
                           <div class="mb-3">
                                <label  class="form-label">Shipping Adderss</label>
                                <input type="text" class="form-control" aria-describedby="emailHelp" name="shipping_address">
                            </div>
                            <div class="row">
                               <div class="mb-3 col-md-4">
                                <label class="form-label">Shipping Country</label>
                                <input type="text" class="form-control"  aria-describedby="emailHelp" name="shipping_country">
                              </div>
                               <div class="mb-3 col-md-4">
                                <label  class="form-label">Shipping Ctiy</label>
                                <input type="text" class="form-control"  aria-describedby="emailHelp" name="shipping_ctiy">
                              </div>
                              <div class="mb-3 col-md-4">
                                <label  class="form-label">Shipping Zipcode</label>
                                <input type="text" class="form-control"  aria-describedby="emailHelp" name="shipping_zipcode">
                              </div>
                            </div>
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <br><hr>
                    <div class="card-body">
                       <h4 style="font-size: 20px; font-style: italic;">Change Your Password.</h4><br>
                       <form action="{{ route('password.change') }}" method="post">
                        @csrf
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Old Password</label>
                            <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="old_password" required placeholder="old password">
                          </div>
                           <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control  @error('password') is-invalid @enderror" aria-describedby="emailHelp" name="password" placeholder="new password" required>
                             @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                          <div class="mb-3">
                            <label  class="form-label">Confrm Password</label>
                            <input type="password" class="form-control"  aria-describedby="emailHelp" name="password_confirmation" placeholder="re-type password">
                          </div>
                          <button type="submit" class="btn btn-primary">password update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
