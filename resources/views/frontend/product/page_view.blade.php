@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/shop_styles.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/shop_responsive.css">

@include('layouts.front-prtial.collaps_nav')
	<div class="home">
		<div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{ asset('public/frontend') }}/images/shop_background.jpg"></div>
		<div class="home_overlay"></div>
		<div class="home_content d-flex flex-column align-items-center justify-content-center">
			<h2 class="home_title">{{ $page->page_title }}</h2>
		</div>
	</div>
	
	<!-- Shop -->
	<div class="shop" style="padding-bottom: 50px;">

		<div class="container">
			<div class="row">
				
				{!! $page->page_description !!}		

            </div>          
        </div>
    </div><hr>

<script src="{{ asset('public/frontend') }}/js/shop_custom.js"></script>

@endsection