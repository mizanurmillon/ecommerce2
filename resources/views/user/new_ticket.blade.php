@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('user.sidebar')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ticket Dashboard') }}</div>
                    
                    <div class="card-body">
                       <h4 style="font-size: 17px; font-style: italic;">Submit your ticket we will reply.</h4><br>
                       <form action="{{ route('store.ticket') }}" method="post" enctype="multipart/form-data">
                        @csrf
                          <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"  name="subject">
                          </div>
                          <div class="row">
                          	<div class="form-group col-lg-6">
	                            <label for="exampleInputEmail1" class="form-label">Service</label>
	                            <select class="form-control" name="service" style="min-width: 100%; margin-left: 0;">
	                            	<option value="Technicel">Technicel</option>
	                            	<option value="Payment">Payment</option>
	                            	<option value="Affiliate">Affiliate</option>
	                            	<option value="Return">Return</option>
	                            	<option value="Refund">Refund</option>
	                            </select>
                          	</div>
                          	<div class="form-group col-lg-6">
	                            <label for="exampleInputEmail1" class="form-label">Prortity</label>
	                            <select class="form-control" name="prortity" style="min-width: 100%; margin-left: 0;">
	                            	<option value="Low">Low</option>
	                            	<option value="Medium">Medium</option>
	                            	<option value="High">High</option>
	                            </select>
                          	</div>

                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1" class="form-label">Message</label>
                            <textarea name="message" class="form-control" required></textarea>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                          </div>
                          
                          <button type="submit" class="btn btn-info">Submit Ticket</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
