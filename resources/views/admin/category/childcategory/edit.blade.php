<form action="{{ route('childcategory.update') }}" method="post" id="add-form">
    @csrf
    <div class="modal-body">
        <div class="row"> 
            <div class="col-md-12">
                <div class="form-group"> 
                    <label for="name" class="control-label">Category/Subcategory</label> 
                    <select class="form-control" name="subcategory_id" required>
                     @foreach($category as $row)
                     @php
                     $subcategory=DB::table('subcategories')->where('category_id',$row->id)->get();
                     @endphp
                      <option disabled="">{{ $row->category_name }}</option>
                      @foreach($subcategory as $row)
                      <option value="{{ $row->id }}"@if($row->id == $data->subcategory_id) selected="" @endif >----{{ $row->subcategory_name }}</option>
                      @endforeach
                      @endforeach
                    </select>
                </div> 
                <input type="hidden" name="id" value="{{ $data->id }}"> 
                <div class="form-group"> 
                    <label for="name" class="control-label">Child Category Name</label> 
                    <input type="text" class="form-control" id="name" name="childcategory_name" required value="{{ $data->childcategory_name }}">
                    <small class="form-text text-muted">This is your child category</small> 
                </div> 
            </div> 
        </div> 
    </div>  
    <div class="modal-footer"> 
        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
        <button type="submit" class="btn btn-info waves-effect waves-light">Update</button> 
    </div>
</form>