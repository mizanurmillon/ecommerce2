<form action="{{ route('update.status') }}" method="post" id="view_modal">
	@csrf
	<div class="modal-body">
      <input type="hidden" class="form-control"  name="c_name" value="{{ $order->c_name }}"> 
      <input type="hidden" class="form-control"  name="c_phone" value="{{ $order->c_phone }}"> 
      <input type="hidden" class="form-control"  name="c_email" value="{{ $order->c_email }}"> 
      <input type="hidden" class="form-control" name="c_address" value="{{ $order->c_address }}"> 
      <input type="hidden" name="id" value="{{ $order->id }}">
      <div class="row"> 
          <div class="col-md-12"> 
              <strong>Order details</strong><br>
              <div class="row">
                <div class="col-lg-4">
                  <p>Name: {{ $order->c_name }}</p>
                </div>
                <div class="col-lg-4">
                  <p>Email: {{ $order->c_email }}</p> 
                </div>
                <div class="col-lg-4">
                  <p>Phone: {{ $order->c_phone }}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-4">
                  <p>Country: {{ $order->c_country }}</p>
                </div>
                <div class="col-lg-4">
                  <p>City: {{ $order->c_city }}</p> 
                </div>
                <div class="col-lg-4">
                  <p>Zipcode: {{ $order->c_zip_code }}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-4">
                  <p>orderId: {{ $order->order_id }}</p>
                </div>
                <div class="col-lg-4">
                  <p>subtotal: {{ $order->subtotal }} {{ $setting->currency }}</p> 
                </div>
                <div class="col-lg-4">
                  <p>Total: {{ $order->total }} {{ $setting->currency }}</p>
                </div>
              </div>
              <div>
                <table class="table">
                  <thead>
                      <tr>
                          <th scope="col">Product</th>
                          <th scope="col">Color</th>
                          <th scope="col">Size</th>
                          <th scope="col">Quantity X Price</th>
                          <th scope="col">Subtotal</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($order_details as $row)
                          <tr>
                              <td>{{ $row->product_name }}</td>
                              <td>{{ $row->color }}</td>
                              <td>{{ $row->size }}</td>
                              <td>{{ $row->quantity }} X {{ $row->single_price }} {{ $setting->currency }}</td>
                              <td>{{ $row->subtotal_price }} {{ $setting->currency }}</td>
                              
                          </tr>
                      @endforeach
                  </tbody>
                </table>  
              </div>
              <div class="form-group"> 
                <label for="phone2" class="control-label">Status <span class="text-danger">*</span></label> 
                <select class="form-control" name="status">
                  <option value="0" @if($order->status==0) selected="" @endif>Pending</option>
                  <option value="1" @if($order->status==1) selected="" @endif>Recieved</option>
                  <option value="2" @if($order->status==2) selected="" @endif>Shipped</option>
                  <option value="3" @if($order->status==3) selected="" @endif>Completed</option>
                  <option value="4" @if($order->status==4) selected="" @endif>Return</option>
                  <option value="5" @if($order->status==5) selected="" @endif>Cancel</option>
                </select>
              </div>
          </div>
      </div> 
    </div>  
    <div class="modal-footer"> 
        <button type="submit" class="btn btn-info waves-effect waves-light"><span class="d-none loader"><i class="fas fa-spinner"></i> loading..</span><span class="submit_btn">Update</span></button>
    </div>
</form>
<script>
	//update coupon----------
      $('#view_modal').submit(function(e){
          e.preventDefault();
            $('.loader').removeClass('d-none');
           var url = $(this).attr('action');
           var request = $(this).serialize();
           $.ajax({
              url:url,
              type:'post',
              async:false,
              data:request,
              success:function(data){
                toastr.success(data);
                $('#view_modal')[0].reset();
                $('#ViewModal').modal('hide');
                $('.loader').addClass('d-none');
                table.ajax.reload();
              }

           });
        });
</script>