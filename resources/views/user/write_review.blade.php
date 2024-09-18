@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('user.sidebar')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Review Dashboard') }}
                    <a href="{{ route('write.review') }}" style="float: right;" class="text-dark"><i class="fa-solid fa-pencil"></i> Write a Review</a></div>
                    <div class="card-body">
                       <h4 style="font-size: 20px; font-style: italic;">Write your valuable review on our product quality and services.</h4><br>
                       <form action="{{ route('website.review.store') }}" method="post">
                        @csrf
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name" readonly="" value="{{ Auth::user()->name }}">
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Write Rwview</label>
                            <textarea name="review" class="form-control" required></textarea>
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Rating</label>
                            <select class="form-control" name="rating" style="min-width: 100%; margin-left: 0;">
                                <option value="1">1 star</option>
                                <option value="2">2 star</option>
                                <option value="3">3 star</option>
                                <option value="4">4 star</option>
                                <option value="5" selected="">5 star</option>
                            </select>
                          </div>
                          
                          <button type="submit" class="btn btn-primary">Submit Review</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
