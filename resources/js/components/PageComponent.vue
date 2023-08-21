<template>
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">
            	<slot name="header"></slot>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <slot name="breadcrumb"></slot>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <slot name="content"></slot>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</template>

<script setup>

</script>
