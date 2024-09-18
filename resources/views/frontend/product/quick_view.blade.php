<style type="text/css">
	.loader{
		border:16px solid #f3f3f3;
		border-radius:50%;
		border-top:16px solid #3498db;
		width: 30px;
		height: 30px;
		margin-left: 45%;
		margin-top: 15%;
		margin-bottom: 18%;
		-webkit-animation:spin 2s linear infinite;/* Safari */
		animation: spin 2s linear infinite;
	}
	/* Safari */
	@-webkit-keyframes spin{
		0% { -webkit-transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); }

	}
	@keyframes spin {
		0% { -webkit-transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); }
	}
</style>


@php
	$color=explode(',',$product->color);
	$size=explode(',',$product->size);
@endphp
<div class="loader"></div>
 <div class="modal-body product_view d-none">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="">
                    <img src="{{ asset('public/backend/files/product/'.$product->thumbnail) }}" alt="" height="100%" width="100%">
                </div>
            </div>
            <div class="col-lg-8">
                <h3>{{ $product->name }}</h3>
                <p style="margin: 0;">{{ $product->category->category_name }} > {{ $product->subcategory->subcategory_name }}</p>
                <p>Brand: {{ $product->brand->brand_name }}</p>
                <p>Stock: @if($product->stock_quantity<1) <span class="badge badge-danger">Stock Out</span> @else <span class="badge badge-success">Stock Available</span> @endif</p>
                <div class="">
                	@if($product->discount_price==NULL)
		                <div class="" style="font-size: 15px;">
		                	Price: {{ $setting->currency }}{{ $product->selling_price }}
		                </div>
		                @else
		                <div class="" style="margin-top: 20px; font-size: 15px;">
		                	Price: <del class="text-danger">{{ $setting->currency }}{{ $product->selling_price }}</del>
		                	{{ $setting->currency }}{{ $product->discount_price }}
		                </div>
	                @endif
            	</div>
                <br>
                <div class="order_info d-flex flex-row">
                    <form action="{{ route('add.to.cart.Quickview') }}" method="post" id="add_cart_form">
                    	@csrf
                    	<input type="hidden" name="id" value="{{ $product->id }}">
                    	@if($product->discount_price==NULL)
                    		<input type="hidden" name="price" value="{{ $product->selling_price }}">
                    	@else
                    		<input type="hidden" name="price" value="{{ $product->discount_price }}">
                    	@endif
                        <div class="form-group">
                    		<div class="row">
                    			<div class="col-xl-7">
                    				<label>Quantity :</label>
                    				<input type="number" class="form-control" name="qty" min="1" max="100" value="1" style="min-width: 50px;">
                    			</div>
                    		</div>
                        	<br>
                            <div class="row">
                                @isset($product->size)
								<div class="col-xl-6">
									<label>Pick Size: </label><br>
									<select class="custom-select form-control-sm" name="size" style="min-width: 100px;  margin: 0;">
										@foreach($size as $row)
										<option value="{{ $row }}">{{ $row }}</option>
										@endforeach
									</select>
								</div>
								@endisset
                                @isset($product->color)
								<div class="col-xl-6">
									<label>Color: </label><br>
									<select class="custom-select form-control-sm" name="color" style="min-width: 100px; margin: 0;">
										@foreach($color as $row)
										<option value="{{ $row }}">{{ $row }}</option>
										@endforeach
									</select>
								</div>
								@endisset
                            </div>
                            <br>
                            <div class="input-group-prepend">
                            	@if($product->stock_quantity<1)
                            	<span class="text-danger">Stock Out</span>
                            	@else
                                <button class="btn btn-outline-info" type="submit"><span class="d-none loader"><i class="fas fa-spinner"></i> loading..</span>Add to Cart</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

  </div>
  <script>
  	$('.loader').ready(function(){
  		setTimeout(function(){
  			$('.product_view').removeClass("d-none");
  			$('.loader').css("display","none");
  		},500);
  	});
  	// Submit Form & store-----------
    $('#add_cart_form').submit(function(e){
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
            $('#add_cart_form')[0].reset();
            $('.loader').addClass('.d-none');
            cart();
          }

       });
    });
  </script>
  