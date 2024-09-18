@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/shop_styles.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/shop_responsive.css">

@include('layouts.front-prtial.collaps_nav')
	<div class="home">
		<div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{ asset('public/frontend') }}/images/shop_background.jpg"></div>
		<div class="home_overlay"></div>
		<div class="home_content d-flex flex-column align-items-center justify-content-center">
			<h2 class="home_title">Track Your Order Now </h2>
		</div>
	</div>
	
	<!-- Shop -->
	<div class="shop" style="padding-bottom: 50px;">

		<div class="container">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<div class="card p-4">
						<form action="{{ route('check.order') }}" method="post">
							@csrf
							<div class="form-group">
								<label for="order_id">Order Id:</label>
								<input type="text" class="form-control" id="order_id" name="order_id" placeholder="write your order id" required>
							</div>
							<button type="submit" class="btn btn-info btn-sm">Track Now</button>
						</form>
					</div>
				</div>
            </div>          
        </div>
    </div><hr>

<script src="{{ asset('public/frontend') }}/js/shop_custom.js"></script>

@endsection