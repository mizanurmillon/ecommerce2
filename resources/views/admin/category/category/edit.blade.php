
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"/>
<form action="{{ route('category.update') }}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="modal-body">
      <div class="row"> 
          <div class="col-md-12"> 
              <div class="form-group"> 
                  <label for="name" class="control-label">Category Name</label> 
                  <input type="text" class="form-control" id="name" name="category_name" value="{{ $data->category_name }}" required> 
                  <small class="form-text text-muted">This is your main category</small>
              </div> 
              <input type="hidden" name="id" value="{{ $data->id }}">
              <div class="form-group"> 
                  <label for="icon" class="control-label">Category Icon</label> 
                  <input type="file" class="dropify" data-default-file="url_of_your_file" data-height="100" id="icon" name="icon"> 
                  <input type="hidden" name="old_icon" value="{{ $data->icon }}">
              </div> 
              <div class="form-group"> 
                  <label for="name" class="control-label">Show on Homepage</label> 
                  <select class="form-control" name="home_page">
                    <option value="1" @if($data->home_page==1) selected="" @endif>Yes</option>
                    <option value="0" @if($data->home_page==0) selected="" @endif>No</option>
                  </select>
              </div> 
          </div> 
      </div> 
    </div>  
    <div class="modal-footer"> 
        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
        <button type="submit" class="btn btn-info waves-effect waves-light">Update</button> 
    </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
     <script type="text/javascript">
      $('.dropify').dropify({
        messages:{
          'default':'Click Here',
          'replace':'Drag and Drop to replace',
          'remove':'remove',
          'error':'Ooops, something wrong.'
        }
      });
</script>