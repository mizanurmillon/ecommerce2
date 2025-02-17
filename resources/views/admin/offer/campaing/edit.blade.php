<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"/>
<form action="{{ route('campaing.update') }}" method="post" enctype="multipart/form-data" id="add-form">
    @csrf
  <div class="modal-body">
    <div class="row"> 
        <div class="col-md-12"> 
            <div class="form-group"> 
                <label for="title" class="control-label">Campaing Title <span class="text-danger">*</span></label> 
                <input type="text" class="form-control" id="title" name="campaing_title" value="{{ $data->campaing_title }}"> 
                <small class="form-text text-muted">This is Campaing title/name</small>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group"> 
                    <label for="start_date" class="control-label">Start Date <span class="text-danger">*</span></label> 
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $data->start_date }}" > 
                </div> 
              </div>
              <div class="col-lg-6">
                <div class="form-group"> 
                    <label for="end_date" class="control-label">End Date <span class="text-danger">*</span></label> 
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $data->end_date }}"> 
                </div> 
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group"> 
                    <label for="status" class="control-label">Status <span class="text-danger">*</span></label> 
                    <select class="form-control" name="status">
                      <option value="1" @if($data->status==1) selected="" @endif>Active</option>
                      <option value="0" @if($data->status==0) selected="" @endif>Inactive</option>
                    </select> 
                </div>
                <input type="hidden" name="id" value="{{ $data->id }}">  
              </div>
              <div class="col-lg-6">
                <div class="form-group"> 
                    <label for="discount" class="control-label">Discount (%) <span class="text-danger">*</span></label> 
                    <input type="number" class="form-control" id="discount" name="discount" value="{{ $data->discount }}"> 
                    <small class="form-text text-danger">Discount precentage are apply for all Product selling price.</small>
                </div> 
              </div>
          </div> 
        </div>
        <div class="col-md-12"> 
            <div class="form-group"> 
                <label for="image" class="control-label">Image</label> 
                <input type="file" class="dropify" data-default-file="url_of_your_file" data-height="100" id="image" name="image" data-min-width="200"> 
                <input type="hidden" name="old_image" value="{{ $data->image }}">
            </div> 
        </div>  
    </div> 
  </div>  
  <div class="modal-footer">
      <button type="submit" class="btn btn-info waves-effect waves-light">submit</button> 
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