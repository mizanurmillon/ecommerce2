@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/product_styles.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/product_responsive.css">
<style>
.checked {
  color: orange;
}
@php
	$review_5=App\Models\Review::where('product_id',$product->id)->where('rating',5)->count();
	$review_4=App\Models\Review::where('product_id',$product->id)->where('rating',4)->count();
	$review_3=App\Models\Review::where('product_id',$product->id)->where('rating',3)->count();
	$review_2=App\Models\Review::where('product_id',$product->id)->where('rating',2)->count();
	$review_1=App\Models\Review::where('product_id',$product->id)->where('rating',1)->count();
	$sum_rating=App\Models\Review::where('product_id',$product->id)->sum('rating');
	$count_rating=App\Models\Review::where('product_id',$product->id)->count('rating');
@endphp
</style>
@include('layouts.front-prtial.collaps_nav')
	<!-- Single Product -->

	<div class="single_product">
		<div class="container">
			<div class="row">
				@php
				$images=json_decode($product->images,true);
				$color=explode(',',$product->color);
				$size=explode(',',$product->size);
				@endphp
				<!-- Images -->
				<div class="col-lg-1 order-lg-1 order-2">
					<ul class="image_list">
						@isset($images)
						@foreach($images as $key => $image)
						<li data-image="{{ asset('public/backend/files/product/'.$image) }}">
							<img src="{{ asset('public/backend/files/product/'.$image) }}">
						</li>
						@endforeach
						@endisset
					</ul>
				</div>

				<!-- Selected Image -->
				<div class="col-lg-4 order-lg-2 order-1">
					<div class="image_selected"><img src="{{ asset('public/backend/files/product/'.$product->thumbnail) }}" alt=""></div>
				</div>

				<!-- Description -->
				<div class="col-lg-4 order-3">
					<div class="product_description">
						<div class="product_category">{{ $product->category->category_name }} > {{ $product->subcategory->subcategory_name }}</div>
						<div class="product_name" style="font-size: 20px;">{{ $product->name }}</div>
						<div class="product_category"><b>Brand: {{ $product->brand->brand_name }}</b></div>
						<div class="product_category"><b>Stock: {{ $product->stock_quantity }}</b></div>
						<div class="product_category"><b>Unit: {{ $product->unit }}</b></div>
						<div>
							@if($sum_rating != NULL)
								@if(intval($sum_rating/$count_rating) == 5)
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								@elseif(intval($sum_rating/$count_rating) >= 4 && intval($sum_rating/5) < $count_rating)
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								@elseif(intval($sum_rating/$count_rating) >= 3 && intval($sum_rating/5) < $count_rating)
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								@elseif(intval($sum_rating/$count_rating) >= 2 && intval($sum_rating/5) < $count_rating)
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								@else
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								@endif
							@endif
						</div>
						<div>
						<b>Price:</b>
							
                <div class="product_price" style="margin-top: 20px; font-size: 15px;">{{ $setting->currency }}{{ $product_price->price }}</div>
               
            </div>
				<div class="order_info d-flex flex-row">
					<form action="{{ route('add.to.cart.Quickview') }}" method="post" id="add_to_cart">
						@csrf
      					<input type="hidden" name="id" value="{{ $product->id }}">
      	
      					<input type="hidden" name="price" value="{{ $product_price->price }}">
      
						<div class="form-group">
							<div class="row">
								@isset($product->size)
								<div class="col-lg-6">
									<label>Pick Size:</label>
									<select class="custom-select form-control-sm" name="size" style="min-width: 120px;  margin: 0;">
										@foreach($size as $row)
										<option value="{{ $row }}">{{ $row }}</option>
										@endforeach
									</select>
								</div>
								@endisset
								@isset($product->color)
								<div class="col-lg-6">
									<label>Pick Color:</label>
									<select class="custom-select form-control-sm" name="color" style="min-width: 120px; margin: 0;">
										@foreach($color as $row)
										<option value="{{ $row }}">{{ $row }}</option>
										@endforeach
									</select>
								</div>
								@endisset
							</div>
						</div>
						<div class="clearfix" style="z-index: 1000;">
							<!-- Product Quantity -->
							<div class="product_quantity clearfix">
								<span>Quantity: </span>
								<input id="quantity_input" type="text" pattern="[1-9]*" min="1" name="qty" value="1">
								<div class="quantity_buttons">
									<div id="quantity_inc_button" class="quantity_inc quantity_control"><i class="fas fa-chevron-up"></i></div>
									<div id="quantity_dec_button" class="quantity_dec quantity_control"><i class="fas fa-chevron-down"></i></div>
								</div>
							</div>
						</div>
						<div class="button_container">
							<div class="input-group mb-3">
								@if($product->stock_quantity<1)
								<button class="btn btn-outline-danger" disabled="">Add to Cart</button>
								@else
							  <button class="btn btn-outline-info mr-1" type="submit" ><span class="d-none loader">.....</span>Add to Cart</button>
							  @endif

							  <a href="{{ route('add.wishlist',$product->id)  }}" class="btn btn-outline-success">Add to Wishlist</a>
							</div>

						</div>
						
					</form>
				</div>
			</div>
				</div>
				<div class="col-lg-3 order-3" style="border-left: 1px solid #DDD;">
						<strong class="text-muted">Pickup Point of the product:</strong><br>
						<i class="fa-solid fa-map"></i> {{ $product->pickuppoint->pickup_point_name }}<hr><br>
						<strong class="text-muted">Home Delivery :</strong><br>
							->(4-8)days after the order placed.
							->Cash on delivery Available
							<hr><br>
						<strong class="text-muted">Product Return & Werrenty:</strong><br>
						->7 days return guarranty.<br>
						->Warrenty not available
					<hr><br>
					@isset( $product->video )
						<strong class="text-muted">Proudct Video:</strong class="text-muted">
						<iframe width="300" height="200" src="https://www.youtube.com/embed/{{ $product->video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
					@endisset
				</div>
			</div>
			<br>
			<br>
			<br>
			<div class="row">
				<div class="col-lg-11">
					<div class="card">
						<div class="card-header">
							<h4>Proudct Details of {{ $product->name }}</h4>
						</div>
						<div class="card-body">
							{!! $product->description !!}
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-11">
					<div class="card">
						<div class="card-header">
							<h4>Ratings & Reviews of {{ $product->name }}</h4>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-lg-6">
									<div class="row">
										<div class="col-lg-6">
											<div class="review">
												<p style="font-size: 12px; color:#000; margin: 0;">Average Reviews of {{ $product->name }}:</p>
												<div>
													@if($sum_rating != NULL)
														@if(intval($sum_rating/$count_rating) == 5)
														<span class="fa fa-star checked"></span>
														<span class="fa fa-star checked"></span>
														<span class="fa fa-star checked"></span>
														<span class="fa fa-star checked"></span>
														<span class="fa fa-star checked"></span>
														@elseif(intval($sum_rating/$count_rating) >= 4 && intval($sum_rating/5) < $count_rating)
														<span class="fa fa-star checked"></span>
														<span class="fa fa-star checked"></span>
														<span class="fa fa-star checked"></span>
														<span class="fa fa-star checked"></span>
														<span class="fa fa-star"></span>
														@elseif(intval($sum_rating/$count_rating) >= 3 && intval($sum_rating/5) < $count_rating)
														<span class="fa fa-star checked"></span>
														<span class="fa fa-star checked"></span>
														<span class="fa fa-star checked"></span>
														<span class="fa fa-star"></span>
														<span class="fa fa-star"></span>
														@elseif(intval($sum_rating/$count_rating) >= 2 && intval($sum_rating/5) < $count_rating)
														<span class="fa fa-star checked"></span>
														<span class="fa fa-star checked"></span>
														<span class="fa fa-star"></span>
														<span class="fa fa-star"></span>
														<span class="fa fa-star"></span>
														@else
														<span class="fa fa-star checked"></span>
														<span class="fa fa-star"></span>
														<span class="fa fa-star"></span>
														<span class="fa fa-star"></span>
														<span class="fa fa-star"></span>
														@endif
													@endif
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<p style="font-size: 12px; color:#000; margin: 0;">Total Reviews of this Product:</p>
												
												<div>
													<span class="fa fa-star checked"></span>
													<span class="fa fa-star checked"></span>
													<span class="fa fa-star checked"></span>
													<span class="fa fa-star checked"></span>
													<span class="fa fa-star checked"></span>
													<span>Total {{ $review_5 }}</span>
												</div>
												<div>
													<span class="fa fa-star checked"></span>
													<span class="fa fa-star checked"></span>
													<span class="fa fa-star checked"></span>
													<span class="fa fa-star checked"></span>
													<span class="fa fa-star"></span>
													<span>Total {{ $review_4 }}</span>
												</div>
												<div>
													<span class="fa fa-star checked"></span>
													<span class="fa fa-star checked"></span>
													<span class="fa fa-star checked"></span>
													<span class="fa fa-star"></span>
													<span class="fa fa-star"></span>
													<span>Total {{ $review_3 }}</span>
												</div>
												<div>
													<span class="fa fa-star checked"></span>
													<span class="fa fa-star checked"></span>
													<span class="fa fa-star"></span>
													<span class="fa fa-star"></span>
													<span class="fa fa-star"></span>
													<span>Total {{ $review_2 }}</span>
												</div>
												<div>
													<span class="fa fa-star checked"></span>
													<span class="fa fa-star"></span>
													<span class="fa fa-star"></span>
													<span class="fa fa-star"></span>
													<span class="fa fa-star"></span>
													<span>Total {{ $review_1 }}</span>
												</div>
										</div>
									</div>
								</div>
									<div class="col-lg-6">
										<form action="{{ route('product.review') }}" method="post">
											@csrf
											<div class="form-group">
												<label>Write Your Reviews:</label>
												<textarea type="text" class="form-control" name="review"></textarea>
											</div>
											<input type="hidden" name="product_id" value="{{ $product->id }}">
											<div class="form-group">
												<label>Write Your Reviews:</label>
												<select class="custom-select form-control-sm" name="rating" style="min-width: 150px;">
													<option selected disabled class="text-danger">select your review</option>
													<option value="1">1 Star</option>
													<option value="2">2 Star</option>
													<option value="3">3 Star</option>
													<option value="4">4 Star</option>
													<option value="5">5 Star</option>
												</select>
											</div>
											@if(Auth::check())
											<button type="submit" class="btn btn-info btn-sm"><span class="fa fa-star"></span> Submit Review</button>
											@else
											<p>Please at first login your account for submit & review.</p>
											@endif
										</form>
								  </div>
							</div>
							<br>
							<strong>All Review of {{ $product->name }}</strong><hr>
							<div class="row">
								@foreach($review as $row)
								<div class="card col-lg-5 m-2">
									<div class="card-header">
										{{ $row->user->name }} ( {{ date('d F , Y'), strtotime($row->review_date) }} )
									</div>
									<div class="card-body">
										{{ $row->review }}

										@if($row->rating==5)
											<div>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
											</div>
											@elseif($row->rating==4)
											<div>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
											</div>
											@elseif($row->rating==3)
											<div>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
											</div>
											@elseif($row->rating==2)
											<div>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
											</div>
											@elseif($row->rating==1)
											<div>
												<span class="fa fa-star checked"></span>
											</div>
										@endif
									</div>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Random product Viewed -->

	<div class="viewed">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="viewed_title_container">
						<h3 class="viewed_title">Random Product</h3>
						<div class="viewed_nav_container">
							<div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
							<div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
						</div>
					</div>

					<div class="viewed_slider_container">
						
						<!-- Random product Viewed Slider -->

						<div class="owl-carousel owl-theme viewed_slider">
							
							<!-- Random product Viewed Item -->
							@foreach($random_product as $row)
							<div class="owl-item">
								<div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="{{ asset('public/backend/files/product/'.$row->thumbnail) }}" alt="{{ $row->name }}"></div>
									<div class="viewed_content text-center">
										
			                <div class="viewed_price" style="margin-top: 20px; font-size: 15px;">{{ $setting->currency }}{{ $row->price }}</div>
			               
										<div class="viewed_name"><a href="{{ route('campaing.product.details',$row->slug) }}">{{  substr($row->name, 0, 15) }}..</a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">new</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script type="text/javascript">
		// Submit Form & store-----------
    $('#add_to_cart').submit(function(e){
      e.preventDefault();
      $('.loader').removeClass('.d-none');
       var url = $(this).attr('action');
       var request = $(this).serialize();
      $.ajax({
          url:url,
          type:'post',
          async:false,
          data:request,
          success:function(data){
            toastr.success(data);
            $('#add_to_cart')[0].reset();
            $( '.loader').addClass('.d-none');
           cart();
          }

       });
    });
	</script>

	
@endsection