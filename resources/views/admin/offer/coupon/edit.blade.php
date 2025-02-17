<form action="{{ route('coupon.update') }}" method="post" id="edit_modal">
	@csrf
	<div class="modal-body">
      <div class="row"> 
          <div class="col-md-12"> 
              <div class="form-group"> 
                  <label for="ware" class="control-label">Coupon Code</label> 
                  <input type="text" class="form-control" id="ware" name="coupon_code" value="{{ $data->coupon_code }}"> 
                  <input type="hidden" name="id" value="{{ $data->id }}">
              </div> 
              <div class="form-group"> 
                  <label for="address" class="control-label">coupon Type</label> 
                  <select class="form-control" name="type">
                    <option value="1" @if($data->type==1) selected="selected" @endif >Fixed</option>
                    <option value="2" @if($data->type==2) selected="selected" @endif >Precentage</option>
                  </select>
              </div> 
              <div class="form-group"> 
                  <label for="coupon" class="control-label">Amount</label> 
                  <input type="text" class="form-control" id="coupon" name="coupon_amount" value="{{ $data->coupon_amount }}"> 
              </div> 
              <div class="form-group"> 
                  <label for="date" class="control-label">Valid Date</label> 
                  <input type="date" class="form-control" id="date" name="valid_date" value="{{ $data->valid_date }}"> 
              </div>
              <div class="form-group"> 
                  <label for="address" class="control-label">coupon Status</label> 
                  <select class="form-control" name="status">
                    <option value="Active" @if($data->status=='Active') selected="selected" @endif >Active</option>
                    <option value="Inactive" @if($data->status=='Inactive') selected="selected" @endif >Inactive</option>
                  </select>
              </div> 
          </div>
      </div> 
    </div>  
    <div class="modal-footer">
      <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
        <button type="submit" class="btn btn-info waves-effect waves-light"><span class="d-none loader"><i class="fas fa-spinner"></i> loading..</span><span class="submit_btn">submit</span></button>
    </div>
</form>
<script>
	//update coupon----------
      $('#edit_modal').submit(function(e){
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
                $('#edit_modal')[0].reset();
                $('#EditModal').modal('hide');
                table.ajax.reload();
              }

           });
        });
</script>