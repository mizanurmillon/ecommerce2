<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard 2</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('public/backend/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('public/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('public/backend') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('public/backend') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('public/backend') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/backend/dist/css/adminlte.min.css') }}">
  <!-- summernote -->
{{-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet"> --}}
  <link rel="stylesheet" href="{{ asset('public/backend/plugins/summernote/summernote-bs4.min.css') }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
  <!-- sweet alerts -->
  <link href="{{ asset('public/backend/plugins/sweet-alert/sweet-alert.min.css') }}" rel="stylesheet">
  <!-- Toastr CSS -->
  <link rel="stylesheet" href="{{ asset('public/backend/plugins/toastr/toastr.min.css') }}">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="{{ URL::to('public/backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
  </div>
  @guest

  @else
  <!-- Navbar -->
  @include('layouts.admin-prtial.navber')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->

  @include('layouts.admin-prtial.sideber')

  <!-- End Sideber  -->

  @endguest

  <!-- Content Wrapper. Contains page content -->
    @yield('admin_content')
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('public/backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('public/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('public/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/backend/dist/js/adminlte.js') }}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('public/backend/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('public/backend/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('public/backend/plugins/chart.js/Chart.min.js') }}"></script>
 <!-- DataTables  & Plugins -->
<script src="{{ asset('public/backend') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('public/backend') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('public/backend') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('public/backend') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('public/backend') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('public/backend') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('public/backend') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('public/backend') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('public/backend') }}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('public/backend') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('public/backend') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('public/backend') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/backend/dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('public/backend/dist/js/pages/dashboard2.js') }}"></script>
<!-- Sweetalert -->
{{-- <script src="{{ asset('public/backend/plugins/sweet-alert/sweet-alert.min.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="{{ asset('public/backend/plugins/toastr/toastr.min.js') }}"></script>
<!-- Summernote -->
<!-- include summernote js -->
{{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script> --}}
<script src="{{ asset('public/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>  
{{-- PrintThis CDN --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
<script type="text/javascript">
   {{-- /* Toastr script */ --}}
    @if(Session::has('message'))
      var type="{{Session::get('alert-type','info')}}"
      switch(type){
      case 'info':
          toastr.info("{{ Session::get('message') }}");
          break;
      case 'success':
          toastr.success("{{ Session::get('message') }}");
          break;
      case 'warning':
          toastr.warning("{{ Session::get('message') }}");
          break;
      case 'error':
          toastr.error("{{ Session::get('message') }}");
          break;
      }
    @endif
    {{-- /*Logout Sweetalert script */ --}}
    $(document).on("click","#logout",function(e){
      e.preventDefault();
      var link = $(this).attr("href");
          swal({
              title: 'Are you Want to logout?',
              text: "",
              icon: 'warning',
              buttons: true,
              dangerMode:true,
          })
          .then((willDelete) => {
              if(willDelete){
                  window.location.href = link;
              }else{
                  swal("Not logout!");
              }
          });
      });
    //  sweetalert script
     $(document).on("click","#delete",function(e){
      e.preventDefault();
      var link = $(this).attr("href");
          swal({
              title: 'Are you went to Delete?',
              text: "Once Delete , This will be Permanently Delete!",
              icon: 'warning',
              buttons: true,
              dangerMode:true,
          })
          .then((willDelete) => {
              if(willDelete){
                  window.location.href = link;
              }else{
                  swal("Safe Data!");
              }
          });
      });
      $(function () {
        // Summernote
        $('#summernote').summernote()

        // // CodeMirror
        // CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        //   mode: "htmlmixed",
        //   theme: "monokai"
        // });
      })
</script>
{{-- Data Table Script --}}
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>

