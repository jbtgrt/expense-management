<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Expense Manager</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{ url('admin/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- daterange picker -->
        <link rel="stylesheet" href="{{ url('admin/plugins/daterangepicker/daterangepicker.css') }}">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="{{ url('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- Bootstrap Color Picker -->
        <link rel="stylesheet" href="{{ url('admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href="{{ url('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ url('admin/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ url('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <!-- Bootstrap4 Duallistbox -->
        <link rel="stylesheet" href="{{ url('admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
        <!-- BS Stepper -->
        <link rel="stylesheet" href="{{ url('admin/plugins/bs-stepper/css/bs-stepper.min.css') }}">
        <!-- dropzonejs -->
        <link rel="stylesheet" href="{{ url('admin/plugins/dropzone/min/dropzone.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ url('admin/dist/css/adminlte.min.css') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head> 
    <body class="antialiased hold-transition sidebar-mini">
        <div id="app"></div>

        <!-- REQUIRED SCRIPTS -->

        <!-- jQuery -->
        <script src="{{ url('admin/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ url('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Select2 -->
        <script src="{{ url('admin/plugins/select2/js/select2.full.min.js') }}"></script>
        <!-- Bootstrap4 Duallistbox -->
        <script src="{{ url('admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
        <!-- InputMask -->
        <script src="{{ url('admin/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ url('admin/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
        <!-- ChartJS -->
        <script src="{{ url('admin/plugins/chart.js/Chart.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ url('admin/dist/js/adminlte.min.js') }}"></script>

    </body>
</html>
