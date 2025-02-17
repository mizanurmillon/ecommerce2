<form action="{{ route('subcategory.update') }}" method="post">
	@csrf
	<div class="modal-body">
      <div class="row"> 
          <div class="col-md-12">
            <div class="form-group"> 
                <label for="name" class="control-label">Category Name</label> 
                <select class="form-control" name="category_id" required>
                  @foreach($category as $row)
                  <option value="{{ $row->id }}" @if($row->id==$subcategory->category_id) selected @endif>{{ $row->category_name }}</option>
                  @endforeach
                </select>
                <input type="hidden" name="id" value="{{ $subcategory->id }}">
            </div>  
            <div class="form-group"> 
                <label for="name" class="control-label">Sub Category Name</label> 
                <input type="text" class="form-control" id="name" name="subcategory_name" value="{{ $subcategory->subcategory_name }}" required>
                <small class="form-text text-muted">This is your sub category</small> 
            </div> 
          </div> 
      </div> 
    </div> 
    <div class="modal-footer"> 
        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
        <button type="submit" class="btn btn-info waves-effect waves-light">submit</button> 
    </div>
</form>