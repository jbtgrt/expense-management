<template>
	<PageComponent >
		<template v-slot:header>
      User dashboard
    </template>
    
    <template v-slot:content>
    	<!-- Main content -->
	    <div class="content">
	      <div class="container-fluid">
	        <div class="row">
	          <div class="col-lg-12 ">
	            <div class="card">
	              <div class="card-body">
	              	<div class="row">
	              		<div class="col-6">
	              			<ul>
	              				<li>Expense Categories</li>
	              				<li>Category A</li>
	              				<li>Category B</li>
	              			</ul>
	              			<ul>
	              				<li>Total</li>
	              				<li>$12312</li>
	              				<li>$12321</li>
	              			</ul>

	              		</div>
	              		<div class="col-6">
	              			<canvas id="pieChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
	              		</div>
	              		
	              	</div>
	                
	              </div>
	            </div>



	            
	          </div>
	        </div>
	        <!-- /.row -->
	      </div>
	      <!-- /.container-fluid -->
	    </div>
	    <!-- /.content -->
    </template>
	</PageComponent>
</template>

<script setup>
	import PageComponent from "../../components/PageComponent.vue";

</script>