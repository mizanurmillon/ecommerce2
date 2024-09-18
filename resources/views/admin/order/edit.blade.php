<form action="{{ route('update.status') }}" method="post" id="edit_modal">
	@csrf
	<div class="modal-body">
      <div class="row"> 
          <div class="col-md-12"> 
            <div class="row"> 
              <div class="col-md-12"> 
                  <div class="form-group"> 
                      <label for="ware" class="control-label">Customer Name <span class="text-danger">*</span></label> 
                      <input type="text" class="form-control" id="ware" name="c_name" value="{{ $data->c_name }}"> 
                      <input type="hidden" name="id" value="{{ $data->id }}">
                  </div> 
                   <div class="form-group"> 
                      <label for="coupon" class="control-label">Customer Phone <span class="text-danger">*</span></label> 
                      <input type="text" class="form-control" id="coupon" name="c_phone" value="{{ $data->c_phone }}"> 
                  </div> 
                 
                  <div class="form-group"> 
                      <label for="coupon" class="control-label">Customer Email <span class="text-danger">*</span></label> 
                      <input type="email" class="form-control" id="coupon" name="c_email" value="{{ $data->c_email }}"> 
                  </div> 
                  <div class="form-group"> 
                      <label for="phone" class="control-label">Address <span class="text-danger">*</span></label> 
                      <input type="text" class="form-control" id="phone" name="c_address" value="{{ $data->c_address }}"> 
                  </div>
                  <div class="form-group"> 
                    <label for="phone2" class="control-label">Status <span class="text-danger">*</span></label> 
                    <select class="form-control" name="status">
                      <option value="0" @if($data->status==0) selected="" @endif>Pending</option>
                      <option value="1" @if($data->status==1) selected="" @endif>Recieved</option>
                      <option value="2" @if($data->status==2) selected="" @endif>Shipped</option>
                      <option value="3" @if($data->status==3) selected="" @endif>Completed</option>
                      <option value="4" @if($data->status==4) selected="" @endif>Return</option>
                      <option value="5" @if($data->status==5) selected="" @endif>Cancel</option>
                    </select>
                  </div>
              </div>
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
      $('#edit_modal').submit(function(e){
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
                $('#edit_modal')[0].reset();
                $('#EditModal').modal('hide');
                $('.loader').addClass('d-none');
                table.ajax.reload();
              }

           });
        });
</script>