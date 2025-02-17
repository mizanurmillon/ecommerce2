@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/shop_styles.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/shop_responsive.css">

@include('layouts.front-prtial.collaps_nav')
	<div class="home">
		<div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{ asset('public/frontend') }}/images/shop_background.jpg"></div>
		<div class="home_overlay"></div>
		<div class="home_content d-flex flex-column align-items-center justify-content-center">
			<h2 class="home_title">Campaing Product</h2>
		</div>
	</div>
	<!-- Shop -->
	<div class="shop">

		<div class="container">
			<div class="row">

				<div class="col-lg-12">
					
					<!-- Shop Content -->

					<div class="shop_content">
						<div class="shop_bar clearfix">
							<div class="shop_product_count"><span>{{ count($product) }}</span> products found</div>
							<div class="shop_sorting">
								<span>Sort by:</span>
								<ul>
									<li>
										<span class="sorting_text">highest rated<i class="fas fa-chevron-down"></span></i>
										<ul>
											<li class="shop_sorting_button" data-isotope-option='{ "sortBy": "original-order" }'>highest rated</li>
											<li class="shop_sorting_button" data-isotope-option='{ "sortBy": "name" }'>name</li>
											<li class="shop_sorting_button"data-isotope-option='{ "sortBy": "price" }'>price</li>
										</ul>
									</li>
								</ul>
							</div>
						</div>

						<div class="product_grid row">
							<div class="product_grid_border"></div>
							@foreach($product as $row)
							<!-- Product Item -->
							<div class="product_item discount col-lg-2">
								<div class="product_border"></div>
								<div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ asset('public/backend/files/product/'.$row->thumbnail) }}" alt=""></div>
								<div class="product_content">
									<div class="product_price text-dark">{{ $setting->currency }}{{ $row->price }}</div>
									<div class="product_name"><div><a href="{{ route('campaing.product.details',$row->slug) }}">{{ substr($row->name ,0 ,20) }}...</a></div></div>
								</div>
								<div class="product_fav"><a href="{{ route('add.wishlist',$row->product_id) }}"><i class="fas fa-heart"></i></a></div>
								
							</div>
							@endforeach
						</div>

						<!-- Shop Page Navigation -->

						<div class="shop_page_nav d-flex flex-row">
							
							<ul class="page_nav d-flex flex-row">
								{{ $product->links() }}
							</ul>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>

<script src="{{ asset('public/frontend') }}/js/shop_custom.js"></script>

@endsection