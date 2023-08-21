<template>
	<PageComponent >
		<template v-slot:header>
      My Expenses
    </template>
    <template v-slot:breadcrumb>
      <breadcrumb></breadcrumb>
    </template>
    <template v-slot:content>
    	<!-- Main content -->
    	<!-- <div v-if="myExpenses.loading" class="d-flex justify-content-center"><span>Loading...</span></div>	 -->
			<!-- <div v-else > -->
		    <div class="content">
		      <div class="container-fluid">
		        <div class="row">
		          <div class="col-lg-12 ">
		            <div class="card">
		              <div class="card-body">
		              	<div class="row ">
		              		<div class="col-6 ">
		              			<div class="container " >
												  <div class="row">
												    <div class="col-sm">
												      <h5 class="text-bold">Expense Categories</h5>
												    </div>
												    <div class="col-sm">
												      <h5 class="text-bold">Total</h5>
												    </div>
												  </div>
												  <div  class="row" v-for="expense in myExpensesData.expenses" :key="expense.category">
												    <div class="col-sm">
												      {{expense.category}}
												    </div>
												    <div class="col-sm">
												      ${{expense.amount}}
												    </div>
												  </div>
												</div>
		              		</div>
		              		<div v-if="myExpensesData.expenses" class="col-6 d-flex justify-content-center">
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
		  <!-- </div> -->
	    <!-- /.content -->
    </template>
	</PageComponent>
</template>

<script setup>
	import Breadcrumb from '../components/Breadcrumb.vue';
	import PageComponent from "../components/PageComponent.vue";
	import { ref, watch, computed, onMounted } from "vue";
	import axiosClient from '../axios.js';
	import { useRouter } from "vue-router";
	import store from "../store.js";

	const router = useRouter();

	const auth_data = JSON.parse(sessionStorage.getItem('AUTH_USER'));

	const myExpensesData = ref({});

	$(function () {

		axiosClient.get('/my-expenses', { params: {user_id: auth_data.id} })
      .then((res) => {
      	var myExpensesChart = res.data;

        myExpensesData.value = myExpensesChart;

        var pieData = {
        labels: myExpensesChart.categories,
        datasets: [
          {
            data: myExpensesChart.amounts,
            backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
          }
        ]
      }

      var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
      var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
      }

      new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
      });

        return null;
      });
	});
</script>