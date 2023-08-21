<template>
	<PageComponent >
		<template v-slot:header>
      Expenses
    </template>
    <template v-slot:breadcrumb>
      <breadcrumb></breadcrumb>
    </template>
    <template v-slot:content>
    	<!-- Main content -->
	    <div class="content">
	    	<div v-if="expenses.loading" class="d-flex justify-content-center"><span>Loading...</span></div>	
				<div v-else >
		      <div class="card m-2">
				    <!-- /.card-header -->
				    <div class="card-body p-0">
				      <table class="table table-sm">
				        <thead>
				          <tr>
				            <th>Expense Category</th>
				            <th>Amount</th>
				            <th>Entry Date</th>
				            <th>Created At</th>
				          </tr>
				        </thead>
				        <tbody>

				        	<tr  v-if="expenses.data.length" v-for="(expense, index) in expenses.data" :key="expense.id" @click="showExpense(expense)">
										<td>{{ expense.expense_category }}</td>
										<td>${{ expense.amount }}</td>
										<td>{{ expense.entry_date }}</td>
										<td>{{ expense.created_at }}</td>
				        	</tr>
				        	<tr v-else><td> No records </td></tr>
				        </tbody>
				      </table>
				    </div>
				    <!-- /.card-body -->
				  </div>
				  <div class="d-flex justify-content-end m-2 mt-4">
			    	<button class="btn btn-primary" data-toggle="modal" data-target="#modal-default" data-backdrop="static" data-keyboard="false" @click="addExpense()">Add Expense</button>
			    </div>
			  </div>
		    <div class="modal fade" id="modal-default" >
	        <div class="modal-dialog">
	        	<form @submit="saveExpense">   
		          <div class="modal-content">
		            <div class="modal-header">
		              <h4 class="modal-title">{{expense.id ? 'Update' : 'Add'}}	 Expense</h4>
		            </div>
		            <div class="modal-body">
		              <div class="card-body">
		        				<Alert v-if="Object.keys(errorMsg).length">
		        					<button type="button" class="close" @click="errorMsg = ''">&times;</button>
					      			<div v-for="(field, i) of Object.keys(errorMsg)" :key="i">
					      				<div v-for="(error, ind) of errorMsg[field] || []" :key="ind">
					      					* {{error}}
					      				</div>
					      			</div>
						      	</Alert>
						      	<div class="form-group row">
		                  <label for="expense_category" class="col-sm-3 col-form-label">Expense Category</label>
		                  <div class="col-sm-9">
									      <select v-model="expense.expense_category_id" class="form-control">
													<option v-for="type in expenseCategoryTypes" :key="type.id" :value="type.id">
														{{type.display_name}}
													</option>
												</select>
											</div>
		                </div>
		                <div class="form-group row">
		                  <label for="amount" class="col-sm-3 col-form-label">Amount</label>
		                  <div class="col-sm-9">
		                    <input type="text"  @input="onInputAmount" class="form-control" id="amount" v-model="expense.amount" name="amount">
		                  </div>
		                </div>
								    <div class=" row">
								    	<label for="datemask2" class="col-sm-3 col-form-label">Entry Date</label>
								    	<div class="col-sm-9 form-group">
			                  <div class="input-group" id="datemask2">
			                    <input v-model="expense.entry_date" type="text" class="form-control" placeholder="mm/dd/yyyy">
			                    <div class="input-group-append">
			                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
			                    </div>
			                  </div>
			                </div>
		                  <!-- /.input group -->
		                </div>
		              </div>
		            </div>
		            <div class="modal-footer justify-content-between">
		            	<div>
		            		<button v-if="expense.id"  type="button" class="btn btn-danger" @click="deleteExpense(expense.id)" >
		            			<span v-if="errorLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
											  Delete
		            		</button>
		            	</div>
		            	<div >
		            		<button type="button" class="btn btn-outline-info" @click="addExpense()" data-dismiss="modal">Cancel</button>
			              <button  class="btn btn-primary ml-2" type="submit">
											<span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
											  {{expense.id ? 'Update' : 'Save'}}	
										</button>
									</div>
		            </div>
		          </div>
	        	</form>
	        </div>
	      </div>
	    </div>
    </template>
	</PageComponent>
</template>

<script setup>

	import Breadcrumb from '../components/Breadcrumb.vue';
	import PageComponent from "../components/PageComponent.vue";
	import Alert from "../components/AlertComponent.vue";

	import store from "../store.js";
	import { useRouter } from "vue-router";
	import { ref, watch, computed } from "vue";
	const router = useRouter();

	const auth_data = JSON.parse(sessionStorage.getItem('AUTH_USER'));

	store.dispatch("getExpenses", auth_data.id);
	store.dispatch("getExpenseCategoryTypes");

	const expenses = computed(() => store.state.expenses);
	const expenseCategoryTypes = computed(() => store.state.expenseCategoryTypes);
	

	const expense = ref({
		expense_category_id: '',
		amount: '',
		entry_date: ''
	});

	watch(
		() => store.state.currentExpense.data,
		(newVal, oldVal) => {
			expense.value = {
				...JSON.parse(JSON.stringify(newVal))
			};	
		}
	);

	const loading = ref(false);
	const errorLoading = ref(false);

	let errorMsg = ref('');

	function saveExpense(ev) {
		ev.preventDefault();

		expense.value.user_id = auth_data.id;
		loading.value = true;
		store
			.dispatch('saveExpense', expense.value)
			.then((res) => {
				loading.value = false;
				$('#modal-default').modal('hide');
			})
			.catch(err => {
				loading.value = false;
				errorMsg.value = err.response.data.errors;
			});
	}

	function showExpense(expense) {
		store.dispatch('getExpense', expense);
		$('#modal-default').modal('show');
	}

	function addExpense() {
		const newExpense = {
			expense_category_id: '',
			amount: '',
			entry_date: ''
		};
		store.dispatch('getExpense', newExpense);
	}

	function deleteExpense(id) {
		const data = {
			id: id,
			user_id: auth_data.id
		};
		errorLoading.value = true;
		store.dispatch("deleteExpense", data)
			.then(() => {
				$('#modal-default').modal('hide');
				errorLoading.value = false;
			});
	}

	const onInputAmount = () => {
	  // Remove non-numeric characters except periods and numbers
	  expense.value.amount = expense.value.amount.replace(/[^0-9.]/g, '');
	};


</script>
