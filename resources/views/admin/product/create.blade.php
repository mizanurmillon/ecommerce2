@extends('layouts.admin')

@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"/>
<link rel="stylesheet" type="text/css" href="{{ asset("public/backend") }}/plugins/tagsinput.css">
<style type="text/css">
  .bootstrap-tagsinput .tag{
    background:#428bca;
    border:1px solid white;
    padding: 1px 6px;
    padding-left:2px;
    margin-right: 2px;
    color:white;
    border-radius:4px;
  }
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">New Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">Add Product</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
          @csrf
        <!-- Info boxes -->
        <div class="row">
          <div class="col-md-8">
            <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Add New Product</h3>
            </div>
             @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif 
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="name">Product Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="name" required>
                  </div>
                  <div class="form-group col-lg-6">
                    <label>Product Code<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="code" value="{{ old('code') }}" required>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label>Category\Subcategory<span class="text-danger">*</span></label>
                    <select class="form-control" name="subcategory_id" id="subcategory_id">
                      <option disabled="" selected="">==chooes category==</option>
                      @foreach($category as $row)
                      @php
                      $subcategory=DB::table('subcategories')->where('category_id',$row->id)->get();
                      @endphp
                      <option style="color: blue;" disabled="">{{ $row->category_name }}</option>
                          @foreach($subcategory as $row)
                          <option value="{{ $row->id }}">-- {{ $row->subcategory_name }}</option>
                          @endforeach
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-lg-6">
                    <label>ChildCategory<span class="text-danger">*</span></label>
                    <select class="form-control" name="childcategory_id" id="childcategory_id">
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label>Brand<span class="text-danger">*</span></label>
                    <select class="form-control" name="brand_id">
                      @foreach($brand as $row)
                        <option value="{{ $row->id }}">{{ $row->brand_name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-lg-6">
                    <label>Pickup Point<span class="text-danger">*</span></label>
                    <select class="form-control" name="pickup_point_id">
                      @foreach($pickup_point as $row)
                      <option value="{{ $row->id }}">{{ $row->pickup_point_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="unit">Unit<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="unit" id="unit" value="{{ old('unit') }}" required>
                  </div>
                  <div class="form-group col-lg-6">
                    <label>Tags<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="tags" value="{{ old('tags') }}" required data-role="tagsinput">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-4">
                    <label for="purchase_price">Purchase Price<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="purchase_price" id="purchase_price" value="{{ old('purchase_price') }}" required>
                  </div>
                  <div class="form-group col-lg-4">
                    <label>Selling Price<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="selling_price" value="{{ old('selling_price') }}" required>
                  </div>
                  <div class="form-group col-lg-4">
                    <label>Discount Price<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="discount_price" value="{{ old('discount_price') }}" >
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label>Ware House<span class="text-danger">*</span></label>
                    <select class="form-control" name="warehouse_id">
                      @foreach($warehouse as $row)
                      <option value="{{ $row->id }}">{{ $row->warehouse_name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-lg-6">
                    <label>Stock Quantity<span class="text-danger">*</span></label>
                     <input type="text" class="form-control" name="stock_quantity" value="{{ old('stock_quantity') }}" required>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="color">Color<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="color" id="color" value="{{ old('color') }}" required data-role="tagsinput">
                  </div>
                  <div class="form-group col-lg-6">
                    <label>Size<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="size" value="{{ old('size') }}" data-role="tagsinput">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-12">
                    <label>Product Details<span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" id="summernote">{{ old('description') }}</textarea>
                  </div>
                  <div class="form-group col-lg-12">
                    <label>Video Embad Code<span class="text-danger">*</span></label>
                    <input name="video" class="form-control" value="{{ old('video') }}" placeholder="Only Embed Code After Embed Work">
                    <small class="text-danger">Only Embed Code After Embed Work</small>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
            <div class="col-md-4">
              <div class="card card-primary">
                <div class="card-body">
                    <div class="form-group">
                      <label>Thumbnail<span class="text-danger">*</span></label>
                      <input type="file" accept="image/*" class="dropify" data-default-file="url_of_your_file" name="thumbnail" required>
                    </div>
                    <div class="">
                      <table class="table table-bordered" id="dynamic_field">
                        <div class="card-header">
                          <h3 class="card-title" style="font-size:10px;">More Images (Click Add For More Image)</h3>
                        </div>
                        <tr>
                          <td><input type="file" accept="image/*" name="images[]" class="form-control name_list"/></td>
                          <td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td>
                        </tr>
                      </table>
                    </div>
                
                  <div class="card p-4">
                    <h6>Featured Product</h6>
                      <input type="checkbox" name="featured" value="1" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                  </div>
                  <div class="card p-4">
                    <h6>Today Deal</h6>
                      <input type="checkbox" name="today_deal" value="1" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                  </div>
                  <div class="card p-4">
                    <h6>Product Slider</h6>
                      <input type="checkbox" name="product_slider" value="1" data-bootstrap-switch data-off-color="danger" data-on-color="success">
                  </div>
                  <div class="card p-4">
                    <h6>Trendy Product</h6>
                      <input type="checkbox" name="trendy" value="1" data-bootstrap-switch data-off-color="danger" data-on-color="success">
                  </div>
                  <div class="card p-4">
                    <h6>Status</h6>
                      <input type="checkbox" name="status" value="1" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-info">Submit</button>
          </form>
        </div>
        <!-- /.row -->
        
       
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.min.js">
</script>
<script src="{{ asset("public/backend") }}/plugins/bootstrap-switch.min.js"></script>
<script>

   $('.dropify').dropify({
        messages:{
          'default':'Click Here',
          'replace':'Drag and Drop to replace',
          'remove':'remove',
          'error':'Ooops, something wrong.'
        }
      });
  $("input[data-bootstrap-switch]").each(function(){
    $(this).bootstrapSwitch('state',$(this).prop('checked'));

  });
  $(document).ready(function(){
    var postURL="<?php echo url('addmore'); ?>";
    var i=1;

    $('#add').click(function(){
      i++;
      $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="file" name="images[]" accept="image/*" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
    });
    $(document).on('click','.btn_remove',function(){
      var button_id=$(this).attr("id");
      $('#row'+button_id+'').remove();
    })
  });
  //ajax request send for collect childcategory
    $('#subcategory_id').change(function(){
      var id = $(this).val();
      $.ajax({
        url:"{{ url("/get-child-category/") }}/"+id,
        type:'get',
        success:function(data) {
          $('select[name="childcategory_id"]').empty();
          $.each(data,function(key,data){
            $('select[name="childcategory_id"]').append('<option value="'+data.id+'">'+data.childcategory_name+'</option>');
          });
        }

      });
    });
</script>
@endsection