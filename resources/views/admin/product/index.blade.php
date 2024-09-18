@extends('layouts.admin')

@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"/>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">PRODUCT</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <a href="{{ route('create.product') }}" class="btn btn-danger btn-sm">+Add New</a>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card">
       <div class="card-header">
          <h3 class="card-title">All Product list </h3>
        </div>
        <br>
        <div class="row p-2">
          <div class="form-group col-4">
            <label>category</label>
            <select class="form-control submitable" name="category_id" id="category_id">
              <option value="">All</option>
              @foreach($category as $row)
                <option value="{{ $row->id }}">{{ $row->category_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-4">
            <label>Brand</label>
            <select class="form-control submitable" name="brand_id" id="brand_id">
              <option value="">All</option>
              @foreach($brand as $row)
                <option value="{{ $row->id }}">{{ $row->brand_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-4">
            <label>Werehouse</label>
            <select class="form-control submitable" name="warehouse_id" id="warehouse_id">
              <option value="">All</option>
              @foreach($warehouse as $row)
                <option value="{{ $row->id }}">{{ $row->warehouse_name }}</option>
              @endforeach
            </select>
          </div>
      <div class="card-body">
        <table id="" class="table table-bordered table-striped table-sm ytable">
          <thead>
          <tr>
            <th>Sl</th>
            <th>Thumbnail</th>
            <th>Name</th>
            <th>Code</th>
            <th>Category</th>
            <th>Subcategory</th>
            <th>Brand</th>
            <th>Featured</th>
            <th>Today Deal</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          
          </tbody>
        </table>
        <form action="" method="delete" id="deleted_form">
          @csrf @method('DELETE')
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script type="text/javascript">
    

      $(function product(){
          table=$('.ytable').DataTable({
            "processing":true,
            "serverSide":true,
            "searching":true,
            "ajax":{
                "url":"{{ route('product.index') }}",
                "data":function(e){
                  e.category_id=$("#category_id").val();
                  e.brand_id=$("#brand_id").val();
                  e.warehouse_id=$("#warehouse_id").val();
                  e.status=$("#status").val();
                }
           },
            columns:[
              {data:'DT_RowIndex' , name:'DT_RowIndex'},
              {data:'thumbnail' , name:'thumbnail'},
              {data:'name' , name:'name'},
              {data:'code' , name:'code'},
              {data:'category_name' , name:'category_name'},
              {data:'subcategory_name' , name:'subcategory_name'},
              {data:'brand_name' , name:'brand_name'},
              {data:'featured' , name:'featured'},
              {data:'today_deal' , name:'today_deal'},
              {data:'status' , name:'status'},
              {data:'action' , name:'action', orderable:true, searchable:true},
            ]
          });
        });
       //deactive_featured----
       $('body').on('click','.deactive_featured',function(){
          var id=$(this).data('id');
          var url="{{ url('product/deactive') }}/"+id;
          $.ajax({
            url:url,
            type:'get',
            success:function(data){
              toastr.warning(data);
              table.ajax.reload();
            }
          });
       });
      
       //active_featured
       $('body').on('click','.active_featured',function(){
            var id=$(this).data('id');
            var url="{{ url('product/active') }}/"+id;
            $.ajax({
              url:url,
              type:'get',
              success:function(data){
                toastr.success(data);
                table.ajax.reload();
              }
            });
        });
       //deactive_toda_deal----
     $('body').on('click','.deactive_deal',function(){
        var id=$(this).data('id');
        var url="{{ url('product/deactive_deal') }}/"+id;
        $.ajax({
          url:url,
          type:'get',
          success:function(data){
            toastr.warning(data);
            table.ajax.reload();
          }
        });
     });
      
     //active_today_deal
     $('body').on('click','.active_deal',function(){
          var id=$(this).data('id');
          var url="{{ url('product/active_deal') }}/"+id;
          $.ajax({
            url:url,
            type:'get',
            success:function(data){
              toastr.success(data);
              table.ajax.reload();
            }
          });
      });
       //deactive_status----
     $('body').on('click','.deactive_status',function(){
        var id=$(this).data('id');
        var url="{{ url('product/deactive_status') }}/"+id;
        $.ajax({
          url:url,
          type:'get',
          success:function(data){
            toastr.warning(data);
            table.ajax.reload();
          }
        });
     });
      
     //active_status
     $('body').on('click','.active_status',function(){
          var id=$(this).data('id');
          var url="{{ url('product/active_status') }}/"+id;
          $.ajax({
            url:url,
            type:'get',
            success:function(data){
              toastr.success(data);
              table.ajax.reload();
            }
          });
      });
     //submitable class call for every change
     $(document).on('change','.submitable',function(){
        $('.ytable').DataTable().ajax.reload();
     });
     //Delete Form----------
      $(document).ready(function(){
        $(document).on("click","#delete_product",function(e){
          e.preventDefault();
          var url = $(this).attr('href');
          $("#deleted_form").attr('action',url);
          swal({
            title: 'Are you went to Delete?',
            text: "Once Delete , This will be Permanently Delete!",
            icon: 'warning',
            buttons: true,
            dangerMode:true,
          })
          .then((willDelete)=>{
            if (willDelete){
               $("#deleted_form").submit();
            }else{
              swal('Safe Data!')
            }
          });
        });
        //Data passed through here----------
        $("#deleted_form").submit(function(e){
          e.preventDefault();
           var url = $(this).attr('action');
           var request = $(this).serialize();
           $.ajax({
              url:url,
              type:'post',
              async:false,
              data:request,
              success:function(data){
                toastr.warning(data);
                $('#deleted_form')[0].reset();
                table.ajax.reload();
              }

           });
        });
      });
    </script>
@endsection