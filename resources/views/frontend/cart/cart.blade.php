@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/cart_styles.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/cart_responsive.css">
@include('layouts.front-prtial.collaps_nav')
<div class="cart_section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 ">
				<div class="cart_container">
					<div class="cart_title">Shopping Cart</div>
					<div class="cart_items">
						<ul class="cart_list">
							@foreach($content as $row)
							@php
								$product=DB::table('products')->where('id',$row->id)->first();
								$colors=explode(',',$product->color);
								$sizes=explode(',',$product->size);
							@endphp
							<li class="cart_item clearfix">
								<div class="cart_item_image"><img src="{{ asset('public/backend/files/product/'.$row->options->thumbnail) }}" alt="" height="90%" width="90%"></div>
								<div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
									<div class="cart_item_name cart_info_col">
										<div class="cart_item_title">Name</div>
										<div class="cart_item_text">{{ substr($row->name ,0,14) }}..</div>
									</div>
									@if($row->options->color !=NULL)
									<div class="cart_item_color cart_info_col">
										<div class="cart_item_title">Color</div>
										<div class="cart_item_text">
											<select class="custom-select form-control-sm color" data-id="{{ $row->rowId }}" name="color" style="min-width: 100px;  margin: 0;">
												@foreach($colors as $color)
												<option value="{{ $color }}" @if($color==$row->options->color) selected="" @endif>{{ $color }}</option>
												@endforeach
											</select>
										</div>
									</div>
									@endif
									@if($row->options->size !=NULL)
									<div class="cart_item_color cart_info_col">
										<div class="cart_item_title">Size</div>
										<div class="cart_item_text">
											<select class="custom-select form-control-sm size" data-id="{{ $row->rowId }}" name="size" style="min-width: 100px;  margin: 0;">
												@foreach($sizes as $size)
												<option value="{{ $size }}" @if($size==$row->options->size) selected="" @endif>{{ $size }}</option>
												@endforeach
											</select>
										</div>
									</div>
									@endif
									<div class="cart_item_quantity cart_info_col">
										<div class="cart_item_title">Quantity</div>
										<div class="cart_item_text">
											<input type="number" class="form-control qty" pattern="[1-9]*" min="1" name="qty" value="{{ $row->qty }}" data-id="{{ $row->rowId }}" style="width: 100px; height: 33px;">
										</div>
									</div>
									<div class=" cart_info_col">
										<div class="cart_item_title">Price</div>
										<div class="cart_item_text">{{ $setting->currency }}{{ $row->price }} x{{ $row->qty }}</div>
									</div>
									<div class="cart_item_total cart_info_col">
										<div class="cart_item_title">Subtotal</div>
										<div class="cart_item_text">{{ $setting->currency }}{{ $row->qty * $row->price }}</div>
									</div>
									<div class="cart_item_color cart_info_col">
										<div class="cart_item_title">Action</div>
										<div class="cart_item_text"><a href="#" id="removeProduct" data-id="{{ $row->rowId }}" class="text-danger">X</a></div>
									</div>
								</div>
							</li>
							@endforeach
						</ul>
					</div>
					
					<!-- Order Total -->
					<div class="order_total">
						<div class="order_total_content text-md-right">
							<div class="order_total_title">Order Total:</div>
							<div class="order_total_amount">{{ $setting->currency }}{{ Cart::total() }}</div>
						</div>
					</div>

					<div class="cart_buttons">
						<a href="{{ route('cart.empty') }}" class="btn btn-danger">Empty Cart</a>
						<a href="{{ route('checkout.cart') }}" class="btn btn-info">Checkout Cart</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Newsletter -->

<div class="newsletter">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
					<div class="newsletter_title_container">
						<div class="newsletter_icon"><img src="{{ asset('public/frontend') }}/images/send.png" alt=""></div>
						<div class="newsletter_title">Sign up for Newsletter</div>
						<div class="newsletter_text"><p>...and receive %20 coupon for first shopping.</p></div>
					</div>
					<div class="newsletter_content clearfix">
						<form action="#" class="newsletter_form">
							<input type="email" class="newsletter_input" required="required" placeholder="Enter your email address">
							<button class="newsletter_button">Subscribe</button>
						</form>
						<div class="newsletter_unsubscribe_link"><a href="#">unsubscribe</a></div>
					</div>
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