<form action="{{ route('blog.category.update') }}" method="post">
	@csrf
	<div class="modal-body">
      <div class="row"> 
          <div class="col-md-12"> 
              <div class="form-group"> 
                  <label for="name" class="control-label">Category Name</label> 
                  <input type="text" class="form-control" id="name" name="category_name" value="{{ $data->category_name }}" required> 
                  <small class="form-text text-muted">This is your main blog category</small>
              </div> 
              <input type="hidden" name="id" value="{{ $data->id }}">
          </div> 
      </div> 
    </div>  
    <div class="modal-footer"> 
        <button type="submit" class="btn btn-info waves-effect waves-light">Update</button> 
    </div>
</form>
