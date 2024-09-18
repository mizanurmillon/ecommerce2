<form action="{{ route('warehouse.update') }}" method="post">
 	@csrf
	<div class="modal-body">
        <div class="row"> 
            <div class="col-md-12"> 
              <div class="form-group"> 
                  <label for="ware" class="control-label">Warehouse Name</label> 
                  <input type="text" class="form-control" id="ware" name="warehouse_name" value="{{ $data->warehouse_name }}"> 
              </div> 
              <div class="form-group"> 
                  <label for="address" class="control-label">Warehouse address</label> 
                  <input type="text" class="form-control" id="address" name="warehouse_address" value="{{ $data->warehouse_address }}"> 
              </div> 
              <input type="hidden" name="id" value="{{ $data->id }}">
              <div class="form-group"> 
                  <label for="phone" class="control-label">Warehouse phone</label> 
                  <input type="text" class="form-control" id="phone" name="phone" value="{{ $data->phone }}"> 
              </div> 
            </div>
        </div> 
    </div>  
    <div class="modal-footer">
        <button type="submit" class="btn btn-info waves-effect waves-light"><span class="d-none loader"><i class="fas fa-spinner"></i> loading..</span><span class="submit_btn">submit</span></button> 
    </div>
</form>
