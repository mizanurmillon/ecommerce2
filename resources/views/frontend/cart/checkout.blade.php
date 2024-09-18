@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/cart_styles.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/cart_responsive.css">
@include('layouts.front-prtial.collaps_nav')
<div class="cart_section">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="cart_container card  p-2">
					<div class="cart_title text-center">Billing Address</div><hr>
						<form action="{{ route('order.place') }}" method="post" id="order_form">
							@csrf
							<div class="row">
								<div class="form-group col-lg-6">
									<label>Customer Name <span class="text-danger">*</span></label>
									<input type="text" name="c_name" class="form-control" required value="{{ Auth::user()->name }}">
								</div>
								<div class="form-group col-lg-6">
									<label>Customer Phone <span class="text-danger">*</span> </label>
									<input type="text" name="c_phone" class="form-control" required value="{{ Auth::user()->phone }}">
								</div>
								<div class="form-group col-lg-6">
									<label>Customer Address <span class="text-danger">*</span></label>
									<input type="text" name="c_address" class="form-control" required>
								</div>
								<div class="form-group col-lg-6">
									<label>Country <span class="text-danger">*</span></label>
									<input type="text" name="c_country" class="form-control" required>
								</div>
								<div class="form-group col-lg-6">
									<label>Email Address <span class="text-danger">*</span> </label>
									<input type="email" name="c_email" class="form-control">
								</div>
								<div class="form-group col-lg-6">
									<label>Zip Code <span class="text-danger">*</span> </label>
									<input type="text" name="c_zip_code" class="form-control" required>
								</div>
								<div class="form-group col-lg-6">
									<label>City name<span class="text-danger">*</span> </label>
									<input type="text" name="c_city" class="form-control">
								</div>
								<div class="form-group col-lg-6">
									<label>Extra Phone <span class="text-danger">*</span> </label>
									<input type="text" name="c_extra_phone" class="form-control">
								</div>
							</div>
							<strong>--- Payment Type ---</strong><hr>
							<div class="row">
								<div class="form-check col-lg-4">
								  <input type="radio" value="Paypal" name="payment_type">
								  <label>
								    Paypal
								  </label>
								</div>
								<div class="form-check col-lg-4">
								  <input type="radio" value="Aamerpay" checked="" name="payment_type">
								  <label  for="flexRadioDefault2">
								    Bkash/Nagad/Rocket
								  </label>
								</div>
								<div class="form-check col-lg-4">
								  <input type="radio" value="Hand Cash" name="payment_type">
								  <label  for="flexRadioDefault2">
								   Hend Cash
								  </label>
								</div>
							</div>

							<div class="form-group">
									<button type="submit" class="btn btn-info btn-sm">Order place</button>
								</div>
					</form>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card">
					<div class="pl-4 pt-2 pr-2">
						<p style="color: black; margin-bottom:5px">Subtotal: <span style="float:right;">{{ Cart::subtotal() }} {{ $setting->currency }}</span></p>
						{{-- Apply Coupon --}}
						@if(Session::has('coupon'))
							<p style="color: black; margin-bottom:5px">Coupon: ({{ Session::get('coupon')['name'] }}) <a href="{{ route('coupon.remove') }}" class="btn btn-danger btn-sm ml-5">X</a> <span style="float: right;">{{ Session::get('coupon')['discount'] }} {{ $setting->currency }}</span> </p>
						@endif

						<p style="color: black; margin-bottom:5px">Tex: <span style="float: right;">0.00%</span></p>
						<p style="color: black; margin-bottom:5px">Shipping: <span style="float: right;">0.00 {{ $setting->currency }}</span></p><hr style="margin-bottom: 0;">

						@if(Session::has('coupon'))
							<p style="color: black; margin:0"><b>Total: <span style="float: right;">{{ Session::get('coupon')['after_discount'] }} {{ $setting->currency }}</span></b></p>
						@else
							<p style="color: black; margin:0"><b>Total: <span style="float: right;">{{ Cart::total() }} {{ $setting->currency }}</span></b></p>
						@endif

					</div>
					
					@if(!Session::has('coupon'))
					<hr>
					<form action="{{ route('apply.coupon') }}" method="post">
						@csrf
						<div class="p-4">
							<div class="form-group">
								<label>Coupon Apply <span class="text-danger">*</span></label>
								<input type="text" name="coupon" class="form-control" required placeholder="coupon code" autocomplete="off">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-info btn-sm">Apply Coupon</button>
							</div>
						</div>
					</form>
					@endif
				</div>
					<div class="cart_buttons">
						<a href="#" class="btn btn-info">Payment Now</a>
					</div>
			</div>
		</div>
	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript">
	//cart remove with ajax----------
	$('body').on('click','#removeProduct',function(){
      let id=$(this).data('id');
      	$.ajax({
	          url:'{{ url('cartproduct-remove/') }}/'+id,
	          type:'get',
          	success:function(data){
	            toastr.success(data);
	           	cart();
	           	location.reload();
          	}
       });
	}); 
    //Qty update with ajax-----
	$('body').on('blur','.qty',function(){
      let qty=$(this).val();
      let rowId=$(this).data('id');
      	$.ajax({
          url:'{{ url('cartproduct-updateqty/') }}/'+rowId+'/'+qty,
          type:'get',
          async:false,
          success:function(data){
            toastr.success(data);
           	location.reload();
          }

       });

	});
	// Color Update with ajax---
	$('body').on('change','.color',function(){
      let color=$(this).val();
      let rowId=$(this).data('id');
      	$.ajax({
          url:'{{ url('cartproduct-updatecolor/') }}/'+rowId+'/'+color,
          type:'get',
          async:false,
          success:function(data){
            toastr.success(data);
          }

       });

	});
	// Size Update with ajax---
	$('body').on('change','.size',function(){
      let size=$(this).val();
      let rowId=$(this).data('id');
      	$.ajax({
          url:'{{ url('cartproduct-updatesize/') }}/'+rowId+'/'+size,
          type:'get',
          async:false,
          success:function(data){
            toastr.success(data);
          }

       });

	});
</script>

@endsection