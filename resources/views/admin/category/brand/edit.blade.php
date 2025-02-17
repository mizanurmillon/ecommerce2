<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"/>

<form action="{{ route('brand.update') }}" method="post" id="add-form" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="row"> 
            <div class="col-md-12">
                <div class="form-group"> 
                    <label for="name" class="control-label">Brand Name</label> 
                    <input type="text" class="form-control" id="name" name="brand_name" required value="{{ $data->brand_name }}">
                    <small class="form-text text-muted">This is your child category</small> 
                </div>
                <input type="hidden" name="id" value="{{ $data->id }}"> 
                <div class="form-group"> 
                    <label for="brand" class="control-label">Home Page shwo</label> 
                    <select class="form-control" name="front_page">
                       <option value="1" @if($data->front_page==1) selected="" @endif >Yes</option>
                       <option value="0" @if($data->front_page==0) selected="" @endif>No</option>
                    </select> 
                    <small class="form-text text-muted">if Yes it will be show on your home page</small>
                </div>
                <div class="form-group"> 
                  <label for="brand" class="control-label">Brand logo</label> 
                  <input type="file" class="dropify" data-default-file="url_of_your_file" data-height="100" id="brand" name="brand_logo" data-min-width="200">
                  <input type="hidden" name="old_logo" value="{{ $data->brand_logo }}">
                  <small class="form-text text-muted">This is your main Brand logo</small>
              </div>
            </div> 
        </div> 
    </div>  
    <div class="modal-footer"> 
        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
        <button type="submit" class="btn btn-info waves-effect waves-light">Update</button> 
    </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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