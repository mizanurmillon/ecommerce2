@extends('layouts.admin')

@section('admin_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">TICKET</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card">
       <div class="card-header">
          <h3 class="card-title">All Ticket list </h3>
        </div>
        <br>
        <div class="row p-2">
          <div class="form-group col-4">
            <label>Type</label>
            <select class="form-control submitable" name="type" id="type">
              <option value="">All</option>
              <option value="Technicel">Technicel</option>
              <option value="Payment">Payment</option>
              <option value="Affiliate">Affiliate</option>
              <option value="Return">Return</option>
              <option value="Refund">Refund</option>
            </select>
          </div>
          
          <div class="form-group col-4">
            <label>Status</label>
            <select class="form-control submitable" name="status" id="status">
              <option value="0">All</option>
              <option value="0">Pending</option>
              <option value="1">Running</option>
              <option value="2">Close</option>
            </select>
          </div>
          <div class="form-group col-4">
            <label>Date</label>
            <input type="date" name="date" class="form-control submitable_input" id="date">
          </div>
      <div class="card-body">
        <table id="" class="table table-bordered table-striped table-sm ytable">
          <thead>
          <tr>
            <th>Sl</th>
            <th>User</th>
            <th>Subject</th>
            <th>Service</th>
            <th>Prortity</th>
            <th>Date</th>
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
    

      $(function ticket(){
          table=$('.ytable').DataTable({
            "processing":true,
            "serverSide":true,
            "searching":true,
            "ajax":{
                "url":"{{ route('ticket.index') }}",
                "data":function(e){
                  e.type=$("#type").val();
                  e.date=$("#date").val();
                  e.status=$("#status").val();
                }
           },
            columns:[
              {data:'DT_RowIndex' , name:'DT_RowIndex'},
              {data:'name' , name:'name'},
              {data:'subject' , name:'subject'},
              {data:'service' , name:'service'},
              {data:'prortity' , name:'prortity'},
              {data:'date' , name:'date'},
              {data:'status' , name:'status'},
              {data:'action' , name:'action', orderable:true, searchable:true},
            ]
          });
        });
     //submitable class call for every change
     $(document).on('change','.submitable',function(){
        $('.ytable').DataTable().ajax.reload();
     });
      $(document).on('blur','.submitable_input',function(){
        $('.ytable').DataTable().ajax.reload();
     });

    </script>
@endsection