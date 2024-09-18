@extends('layouts.app')
    @section('navber')
    @include('layouts.front-prtial.main_nev')
    @endsection
@section('content')
<style>
.checked {
  color: orange;
}
</style>
    <!-- Banner -->
    <div class="banner">
        <div class="banner_background" style="background-image:url({{ asset('public/frontend') }}/images/banner_background.jpg)"></div>
        <div class="container fill_height">
            <div class="row fill_height">
                <div class="banner_product_image"><img src="{{ asset('public/backend/files/product/'.$bannerproduct->thumbnail) }}" alt="{{ $bannerproduct->name }}"></div>
                <div class="col-lg-5 offset-lg-4 fill_height">
                    <div class="banner_content">
                        <h1 class="banner_text" style="font-size:40px;">{{ $bannerproduct->name }}</h1>
                        @if($bannerproduct->discount_price==NULL)
                        <div class="banner_price">{{ $setting->currency }}{{ $bannerproduct->selling_price }}</div>
                        @else
                        <div class="banner_price"><span>{{ $setting->currency }}{{ $bannerproduct->selling_price }}</span>{{ $setting->currency }}{{ $bannerproduct->discount_price }}</div>
                        @endif
                        <div class="banner_product_name">{{ $bannerproduct->brand->brand_name }}</div>
                        <div class="button banner_button"><a href="{{ route('product.details',$bannerproduct->slug) }}">Shop Now</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  @isset($campaing)
  @php
    $today=strtotime(date('Y-m-d'));
    $campaing_start=strtotime($campaing->start_date);
    $campaing_end=strtotime($campaing->end_date);
  @endphp
  @if($today >= $campaing_start && $today <= $campaing_end)
    <div class="characteristics" style="padding-bottom: 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 text-center">
                    <div class="brands_item">
                        <strong>{{ $campaing->campaing_title }}</strong><br>
                        <a href="{{ route('campaing.product',$campaing->id) }}">
                            <img src="{{ asset($campaing->image) }}" class="text-center" alt="{{ $campaing->campaing_title }}" style="width: 90%;">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
  @endisset

    <!-- Brand -->

    <div class="characteristics">
        <div class="container">
            <div class="row">
                @foreach($brand as $row)
                <div class="col-lg-1 col-md-6 char_col" style="border:1px solid #DDD; padding: 5px;">
                    <div class="brands_item ">
                        <a href="{{ route('brandwise.product',$row->id) }}" title="{{ $row->brand_name }}">
                            <img src="{{ asset($row->brand_logo) }}" alt="{{ $row->brand_name }}" height="100%" width="100%">
                        </a>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </div>

    <!-- Deals of the week -->

    <div class="deals_featured">
        <div class="container">
            <div class="row">
                <div class="col d-flex flex-lg-row flex-column align-items-center justify-content-start">
                    
                    <!-- Deals -->

                    <div class="deals">
                        <div class="deals_title">Deals of the Week</div>
                        <div class="deals_slider_container">
                            
                            <!-- Deals Slider -->
                            <div class="owl-carousel owl-theme deals_slider">
                                @foreach($today_product as $row)
                                <!-- Deals Item -->
                                <div class="owl-item deals_item">
                                    <div class="deals_image"><img src="{{ asset('public/backend/files/product/'.$row->thumbnail) }}" alt="{{ $row->name }}"></div>
                                    <div class="deals_content">
                                        <div class="deals_info_line d-flex flex-row justify-content-start">
                                            <div class="deals_item_category"><a href="#">{{ $row->subcategory->subcategory_name }}</a></div>
                                            @if($row->discount_price==NULL)
                                                <div class="deals_item_price_a ml-auto">{{ $setting->currency }}{{ $row->selling_price }}</div>
                                            @else
                                                <div class="deals_item_price_a ml-auto" >
                                                    {{ $setting->currency }}{{ $row->discount_price }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="deals_info_line d-flex flex-row justify-content-start">
                                            <div class="deals_item_name">
                                                <a href="{{ route('product.details',$row->slug) }}">{{ substr($row->name ,0 ,40) }}...</a>
                                            </div>
                                        </div>
                                        <div class="available">
                                            <div class="available_line d-flex flex-row justify-content-start">
                                                <div class="available_title">Available: <span>{{ $row->stock_quantity }}</span></div>
                                                <div class="sold_title ml-auto">Already sold: <span>28</span></div>
                                            </div>
                                            <div class="available_bar"><span style="width:17%"></span></div>
                                        </div>
                                        <div class="deals_timer d-flex flex-row align-items-center justify-content-start">
                                            <div class="deals_timer_title_container">
                                                <div class="deals_timer_title">Hurry Up</div>
                                                <div class="deals_timer_subtitle">Offer ends in:</div>
                                            </div>
                                            <div class="deals_timer_content ml-auto">
                                                <div class="deals_timer_box clearfix" data-target-time="">
                                                    <div class="deals_timer_unit">
                                                        <div id="deals_timer1_hr" class="deals_timer_hr"></div>
                                                        <span>hours</span>
                                                    </div>
                                                    <div class="deals_timer_unit">
                                                        <div id="deals_timer1_min" class="deals_timer_min"></div>
                                                        <span>mins</span>
                                                    </div>
                                                    <div class="deals_timer_unit">
                                                        <div id="deals_timer1_sec" class="deals_timer_sec"></div>
                                                        <span>secs</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>

                        <div class="deals_slider_nav_container">
                            <div class="deals_slider_prev deals_slider_nav"><i class="fas fa-chevron-left ml-auto"></i></div>
                            <div class="deals_slider_next deals_slider_nav"><i class="fas fa-chevron-right ml-auto"></i></div>
                        </div>
                    </div>
                    
                    <!-- Featured -->
                    <div class="featured">
                        <div class="tabbed_container">
                            <div class="tabs">
                                <ul class="clearfix">
                                    <li class="active">Featured Product</li>
                                    <li>Most Populer Product</li>
                                </ul>
                                <div class="tabs_line"><span></span></div>
                            </div>

                            <!-- Product Panel -->
                            <div class="product_panel panel active">
                                <div class="featured_slider slider">

                                    <!-- Slider Item -->
                                    @foreach($featured as $row)
                                    <div class="featured_slider_item">
                                        <div class="border_active"></div>
                                        <div class="product_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                            <div class="product_image d-flex flex-column align-items-center justify-content-center">

                                                <img src="{{ asset('public/backend/files/product/'.$row->thumbnail) }}" alt="{{ $row->name }}" height="100%" width="80%" >

                                            </div>
                                            <div class="product_content">

                                                @if($row->discount_price==NULL)
                                                    <div class="product_price discount">{{ $setting->currency }}{{ $row->selling_price }}</div>
                                                @else
                                                    <div class="product_price discount" >
                                                        {{ $setting->currency }}{{ $row->discount_price }}
                                                        <span>{{ $setting->currency }}{{ $row->selling_price }}</span>
                                                    </div>
                                                @endif
                                                <div class="product_name"><div>
                                                    <a href="{{ route('product.details',$row->slug) }}">{{ substr($row->name ,0 ,20) }}...</a>
                                                </div></div>
                                                <div class="product_extras">
                                                    <div class="product_color">
                                                        <a href="#" class="quick_view" id="{{ $row->id }}" data-toggle="modal" data-target=".bd-example-modal-lg">Quick view</a>
                                                    </div>
                                                    <button class="product_cart_button quick_view" id="{{ $row->id }}" data-toggle="modal" data-target=".bd-example-modal-lg">Add to Cart</button>
                                                </div>
                                            </div>
                                            <a href="{{ route('add.wishlist',$row->id)  }}">
                                                <div class="product_fav">
                                                    <i class="fas fa-heart"></i>
                                                </div>
                                            </a>
                                            <ul class="product_marks">
                                                <li class="product_mark product_discount">new</li>
                                                <li class="product_mark product_new">new</li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="featured_slider_dots_cover"></div>
                            </div>

                            <!-- most populer product -->

                            <div class="product_panel panel">
                                <div class="featured_slider slider">
                                    <!-- Slider Item -->

                                    @foreach($populer_product as $row)
                                    <div class="featured_slider_item">
                                        <div class="border_active"></div>
                                        <div class="product_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                            <div class="product_image d-flex flex-column align-items-center justify-content-center">

                                                <img src="{{ asset('public/backend/files/product/'.$row->thumbnail) }}" alt="{{ $row->name }}" height="100%" width="80%" >

                                            </div>
                                            <div class="product_content">

                                                @if($row->discount_price==NULL)
                                                    <div class="product_price discount">{{ $setting->currency }}{{ $row->selling_price }}</div>
                                                @else
                                                    <div class="product_price discount" >
                                                        {{ $setting->currency }}{{ $row->discount_price }}
                                                        <span>
                                                            {{ $setting->currency }}{{ $row->selling_price }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <div class="product_name"><div>
                                                    <a href="{{ route('product.details',$row->slug) }}">{{ substr($row->name ,0 ,20) }}...</a>
                                                </div></div>
                                                <div class="product_extras">
                                                    <div class="product_color">
                                                        <a href="#" class="quick_view" id="{{ $row->id }}" data-toggle="modal" data-target=".bd-example-modal-lg">Quick view</a>
                                                    </div>
                                                    <button class="product_cart_button quick_view" id="{{ $row->id }}" data-toggle="modal" data-target=".bd-example-modal-lg">Add to Cart</button>
                                                </div>
                                            </div>
                                            <a href="{{ route('add.wishlist',$row->id)  }}">
                                                <div class="product_fav">
                                                    <i class="fas fa-heart"></i>
                                                </div>
                                            </a>
                                            <ul class="product_marks">
                                                <li class="product_mark product_discount">new</li>
                                                <li class="product_mark product_new">new</li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endforeach


                                </div>
                                <div class="featured_slider_dots_cover"></div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Popular Categories -->

    <div class="popular_categories" style="padding-bottom: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="popular_categories_content">
                        <div class="popular_categories_title">Popular Categories</div>
                        <div class="popular_categories_slider_nav">
                            <div class="popular_categories_prev popular_categories_nav"><i class="fas fa-angle-left ml-auto"></i></div>
                            <div class="popular_categories_next popular_categories_nav"><i class="fas fa-angle-right ml-auto"></i></div>
                        </div>
                        <div class="popular_categories_link"><a href="#">full catalog</a></div>
                    </div>
                </div>
                <!-- Popular Categories Slider -->
                <div class="col-lg-9">
                    <div class="popular_categories_slider_container">
                        <div class="owl-carousel owl-theme popular_categories_slider">
                            <!-- Popular Categories Item -->
                             @foreach($category as $row)
                            <div class="owl-item">
                                <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                    <div class="popular_category_image"><img src="{{ asset($row->icon) }}" alt="{{ $row->category_name }}"></div>
                                    <div class="popular_category_text"><a href="{{ route('categorywise.product',$row->id) }}">{{ $row->category_name }}</a></div>
                                </div>
                            </div>
                             @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Home page wise category product -->
@foreach($home_category as $row)
@php
    $cat_product=DB::table('products')->where('category_id',$row->id)->orderBy('id','DESC')->limit(24)->get();
@endphp
    <div class="new_arrivals" style="padding-top: 25px;
padding-bottom: 25px;">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="tabbed_container">
                        <div class="tabs clearfix tabs-right">
                            <div class="new_arrivals_title">{{ $row->category_name }}</div>
                            <ul class="clearfix">
                                <li><a href="#">view more</a></li>
                            </ul>
                            <div class="tabs_line"><span></span></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="z-index:1;">

                                <!-- Product Panel -->
                                <div class="product_panel panel active">
                                    <div class="arrivals_slider slider">
                                        @foreach($cat_product as $row)
                                        <!-- Slider Item -->
                                        <div class="arrivals_slider_item">
                                            <div class="border_active"></div>
                                            <div class="product_item is_new d-flex flex-column align-items-center justify-content-center text-center">
                                                <div class="product_image d-flex flex-column align-items-center justify-content-center">
                                                    <img src="{{ asset('public/backend/files/product/'.$row->thumbnail) }}" alt="{{ $row->name }}" height="100%" width="60%">
                                                </div>
                                                <div class="product_content">
                                                    @if($row->discount_price==NULL)
                                                        <div class="product_price discount">{{ $setting->currency }}{{ $row->selling_price }}</div>
                                                    @else
                                                        <div class="product_price discount" >
                                                        {{ $setting->currency }}{{ $row->discount_price }}
                                                        <span>
                                                            {{ $setting->currency }}{{ $row->selling_price }}
                                                        </span>
                                                        </div>
                                                    @endif
                                                    <div class="product_name"><div>
                                                        <a href="{{ route('product.details',$row->slug) }}">{{ substr($row->name ,0 ,25) }}...</a>
                                                    </div></div>
                                                    <div class="product_extras">
                                                        <div class="product_color">
                                                            <a href="#" class="quick_view" id="{{ $row->id }}" data-toggle="modal" data-target=".bd-example-modal-lg">Quick view</a>
                                                        </div>
                                                        <button class="product_cart_button quick_view" id="{{ $row->id }}" data-toggle="modal" data-target=".bd-example-modal-lg">Add to Cart</button>
                                                    </div>
                                                </div>
                                                <a href="{{ route('add.wishlist',$row->id)  }}">
                                                    <div class="product_fav">
                                                        <i class="fas fa-heart"></i>
                                                    </div>
                                                </a>
                                                
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="arrivals_slider_dots_cover"></div>
                                </div>

                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>      
    </div>
@endforeach
    <!-- Adverts -->

    <div class="adverts" style="padding-top: 30px;">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 advert_col">
                    
                    <!-- Advert Item -->

                    <div class="advert d-flex flex-row align-items-center justify-content-start">
                        <div class="advert_content">
                            <div class="advert_title"><a href="#">Trends 2018</a></div>
                            <div class="advert_text">Lorem ipsum dolor sit amet, consectetur adipiscing Donec et.</div>
                        </div>
                        <div class="ml-auto"><div class="advert_image"><img src="{{ asset('public/frontend') }}/images/adv_1.png" alt=""></div></div>
                    </div>
                </div>

                <div class="col-lg-4 advert_col">
                    
                    <!-- Advert Item -->

                    <div class="advert d-flex flex-row align-items-center justify-content-start">
                        <div class="advert_content">
                            <div class="advert_subtitle">Trends 2018</div>
                            <div class="advert_title_2"><a href="#">Sale -45%</a></div>
                            <div class="advert_text">Lorem ipsum dolor sit amet, consectetur.</div>
                        </div>
                        <div class="ml-auto"><div class="advert_image"><img src="{{ asset('public/frontend') }}/images/adv_2.png" alt=""></div></div>
                    </div>
                </div>

                <div class="col-lg-4 advert_col">
                    
                    <!-- Advert Item -->

                    <div class="advert d-flex flex-row align-items-center justify-content-start">
                        <div class="advert_content">
                            <div class="advert_title"><a href="#">Trends 2018</a></div>
                            <div class="advert_text">Lorem ipsum dolor sit amet, consectetur.</div>
                        </div>
                        <div class="ml-auto"><div class="advert_image"><img src="{{ asset('public/frontend') }}/images/adv_3.png" alt=""></div></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Trends -->

    <div class="trends">
        <div class="trends_background" style="background-image:url({{ asset('public/frontend') }}/images/trends_background.jpg)"></div>
        <div class="trends_overlay"></div>
        <div class="container">
            <div class="row">

                <!-- Trends Content -->
                <div class="col-lg-3">
                    <div class="trends_container">
                        <h2 class="trends_title">Trendy Product</h2>
                        <div class="trends_text"><p>This year best trendy product for you</p></div>
                        <div class="trends_slider_nav">
                            <div class="trends_prev trends_nav"><i class="fas fa-angle-left ml-auto"></i></div>
                            <div class="trends_next trends_nav"><i class="fas fa-angle-right ml-auto"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Trends Slider -->
                <div class="col-lg-9">
                    <div class="trends_slider_container">

                        <!-- Trends Slider -->

                        <div class="owl-carousel owl-theme trends_slider">

                            <!-- Trends Slider Item -->
                            @foreach($trendy_product as $row)
                            <div class="owl-item">
                                <div class="trends_item is_new">
                                    <div class="trends_image d-flex flex-column align-items-center justify-content-center">
                                        <img src="{{ asset('public/backend/files/product/'.$row->thumbnail) }}" alt="{{ $row->name }}">
                                    </div>
                                    <div class="trends_content">
                                        <div class="trends_category">
                                            <a href="#">{{ $row->category->category_name }}</a>
                                            <div class="trends_price">
                                                @if($row->discount_price==NULL)
                                                {{ $setting->currency }}{{ $row->selling_price }}
                                                @else
                                                    {{ $setting->currency }}{{ $row->discount_price }}
                                                    <del class="text-danger">{{ $setting->currency }}{{ $row->selling_price }}</del>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="trends_info clearfix">
                                            <div class="trends_name">
                                                <a href="{{ route('product.details',$row->slug) }}">{{ substr($row->name ,0 ,23) }}...</a>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="trends_marks">
                                        <a href="#" id="{{ $row->id }}" data-toggle="modal" data-target=".bd-example-modal-lg" class="trends_mark trends_new quick_view" style="color: #FFF">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </ul>
                                    <a href="{{ route('add.wishlist',$row->id)  }}">
                                        <div class="trends_fav">
                                            <i class="fas fa-heart"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Reviews -->

    <div class="reviews">
        <div class="container">
            <div class="row">
                <div class="col">
                    
                    <div class="reviews_title_container">
                        <h3 class="reviews_title">Latest Reviews</h3>
                        <div class="reviews_all ml-auto"><a href="#">view all <span>reviews</span></a></div>
                    </div>

                    <div class="reviews_slider_container">
                        
                        <!-- Reviews Slider -->
                        <div class="owl-carousel owl-theme reviews_slider">
                          @foreach($review as $row)
                            <!-- Reviews Slider Item -->
                            <div class="owl-item">
                                <div class="review d-flex flex-row align-items-start justify-content-start">
                                    <div><div class="review_image"><img src="{{ asset('public/backend/files/dummy.jpg') }}" alt=""></div></div>
                                    <div class="review_content">
                                        <div class="review_name">{{ $row->name }}</div>
                                        <div class="review_rating_container">
                                            <div class="rating_r rating_r_4 review_rating">
                                                @if($row->rating == 5)
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                @elseif($row->rating == 4)
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star"></span>
                                                @elseif($row->rating == 3)
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                @elseif($row->rating == 2)
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
                                            </div>
                                            <div class="review_time">{{ $row->date }}</div>
                                        </div>
                                        <div class="review_text"><p style="text-align:justify;">{{ substr($row->review ,0 ,110) }}..</p></div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="reviews_dots"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Random Products For You -->

    <div class="viewed">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="viewed_title_container">
                        <h3 class="viewed_title">Products For You</h3>
                        <div class="viewed_nav_container">
                            <div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
                            <div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
                        </div>
                    </div>

                    <div class="viewed_slider_container">
                        
                        <!-- Recently Viewed Slider -->
                        <div class="owl-carousel owl-theme viewed_slider">
                            
                            <!-- Recently Viewed Item -->
                            @foreach($random_product as $row)
                            <div class="owl-item">
                                <div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="viewed_image"><img src="{{ asset('public/backend/files/product/'.$row->thumbnail) }}" alt="{{ $row->name }}"></div>
                                    <div class="viewed_content text-center">
                                        @if($row->discount_price==NULL)
                                            <div class="viewed_price discount">{{ $setting->currency }}{{ $row->selling_price }}</div>
                                        @else
                                            <div class="viewed_price discount" >
                                            {{ $setting->currency }}{{ $row->discount_price }}
                                            <span>
                                                {{ $setting->currency }}{{ $row->selling_price }}
                                            </span>
                                            </div>
                                        @endif
                                        <div class="viewed_name"><a href="{{ route('product.details',$row->slug) }}">{{ substr($row->name ,0 ,15) }}...</a></div>
                                    </div>
                                    
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Brands -->

    <div class="brands">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="brands_slider_container">
                        
                        <!-- Brands Slider -->

                        <div class="owl-carousel owl-theme brands_slider">
                            @foreach($brand as $row)
                            <div class="owl-item">
                                <div class="brands_item d-flex flex-column justify-content-center">
                                    <a href="{{ route('brandwise.product',$row->id) }}" title="{{ $row->brand_name }}">
                                        <img src="{{ asset($row->brand_logo) }}" alt="{{ $row->brand_name }}" height="50" width="40">
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Brands Slider Navigation -->
                        <div class="brands_nav brands_prev"><i class="fas fa-chevron-left"></i></div>
                        <div class="brands_nav brands_next"><i class="fas fa-chevron-right"></i></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Characteristics -->

    <div class="characteristics" style="padding-top: 20px;">
        <div class="container">
            <div class="row">

                <!-- Char. Item -->
                <div class="col-lg-3 col-md-6 char_col">
                    
                    <div class="char_item d-flex flex-row align-items-center justify-content-start">
                        <div class="char_icon"><img src="{{ asset('public/frontend') }}/images/char_1.png" alt=""></div>
                        <div class="char_content">
                            <div class="char_title">Free Delivery</div>
                            <div class="char_subtitle">from $50</div>
                        </div>
                    </div>
                </div>

                <!-- Char. Item -->
                <div class="col-lg-3 col-md-6 char_col">
                    
                    <div class="char_item d-flex flex-row align-items-center justify-content-start">
                        <div class="char_icon"><img src="{{ asset('public/frontend') }}/images/char_2.png" alt=""></div>
                        <div class="char_content">
                            <div class="char_title">Free Delivery</div>
                            <div class="char_subtitle">from $50</div>
                        </div>
                    </div>
                </div>

                <!-- Char. Item -->
                <div class="col-lg-3 col-md-6 char_col">
                    
                    <div class="char_item d-flex flex-row align-items-center justify-content-start">
                        <div class="char_icon"><img src="{{ asset('public/frontend') }}/images/char_3.png" alt=""></div>
                        <div class="char_content">
                            <div class="char_title">Free Delivery</div>
                            <div class="char_subtitle">from $50</div>
                        </div>
                    </div>
                </div>

                <!-- Char. Item -->
                <div class="col-lg-3 col-md-6 char_col">
                    
                    <div class="char_item d-flex flex-row align-items-center justify-content-start">
                        <div class="char_icon"><img src="{{ asset('public/frontend') }}/images/char_4.png" alt=""></div>
                        <div class="char_content">
                            <div class="char_title">Free Delivery</div>
                            <div class="char_subtitle">from $50</div>
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
                            <form action="{{ route('store.newsletter') }}" method="post" class="newsletter_form" id="newslatter_form">
                                @csrf
                                <input type="email" name="email" class="newsletter_input" required="required" placeholder="Enter your email address">
                                <button class="newsletter_button" type="submit">Subscribe</button>
                            </form>
                            <div class="newsletter_unsubscribe_link"><a href="#">unsubscribe</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- Quick Views Modal --}}
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
      </div>
     <div class="modal-body" id="quick_view_body">
         
     </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript">
    $(document).on('click','.quick_view',function(){
      var id = $(this).attr("id");
      $.ajax({
        url:"{{ url("/product-quick-view/") }}/"+id,
        type:'get',
        success:function(data) {
          $("#quick_view_body").html(data);
        }

      });
    });
    // Submit Form & store-----------
    $('#newslatter_form').submit(function(e){
      e.preventDefault();
       var url = $(this).attr('action');
       var request = $(this).serialize();
      $.ajax({
          url:url,
          type:'post',
          async:false,
          data:request,
          success:function(data){
            toastr.success(data);
            $('#newslatter_form')[0].reset();
           
          }

       });
    });
</script>
@endsection