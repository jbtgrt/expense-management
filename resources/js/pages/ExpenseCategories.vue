<template>
	<PageComponent >
		<template v-slot:header>
      Expense Categories
    </template>
    <template v-slot:breadcrumb>
      <breadcrumb></breadcrumb>
    </template>
    <template v-slot:content>
    	<!-- Main content -->
	    <div class="content">
	    	<div v-if="expenseCategories.loading" class="d-flex justify-content-center"><span>Loading...</span></div>	
				<div v-else >
		      <div class="card m-2">
				    <!-- /.card-header -->
				    <div class="card-body p-0">
				      <table class="table table-sm">
				        <thead>
				          <tr>
				            <th>Display Name</th>
				            <th>Description</th>
				            <th>Created At</th>
				          </tr>
				        </thead>
				        <tbody>
				        	<tr v-if="expenseCategories.data.length" v-for="(expCategory, index) in expenseCategories.data" :key="expCategory.id" @click="showExpenseCategory(expCategory)">
										<td>{{ expCategory.display_name }}</td>
										<td>{{ expCategory.description }}</td>
										<td>{{ expCategory.created_at }}</td>
				        	</tr>
				        	<tr v-else><td> No records </td></tr>
				        </tbody>
				      </table>
				    </div>
				    <!-- /.card-body -->
				  </div>
				  <div class="d-flex justify-content-end m-2 mt-4">
			    	<button class="btn btn-primary" data-toggle="modal" data-target="#modal-default" data-backdrop="static" data-keyboard="false" @click="addExpenseCategory()">Add Category</button>
			    </div>
			  </div>
		    <div class="modal fade" id="modal-default" >
	        <div class="modal-dialog">
	        	<form @submit="saveExpenseCategory">   
		          <div class="modal-content">
		            <div class="modal-header">
		              <h4 class="modal-title">{{expenseCategory.id ? 'Update' : 'Add'}}	 Category</h4>
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
		                  <label for="display_name" class="col-sm-3 col-form-label">Display Name</label>
		                  <div class="col-sm-9">
		                    <input type="text" class="form-control" id="display_name" v-model="expenseCategory.display_name" name="display_name" >
		                  </div>
		                </div>
		                <div class="form-group row">
		                  <label for="description" class="col-sm-3 col-form-label">Description</label>
		                  <div class="col-sm-9">
		                    <textarea style="min-height: 70px;" class="form-control" id="description" v-model="expenseCategory.description" name="description" ></textarea>
		                  </div>
		                </div>
		              </div>
		            </div>
		            <div class="modal-footer justify-content-between">
		            	<div>
		            		<button v-if="expenseCategory.id"  type="button" class="btn btn-danger" @click="deleteExpenseCategory(expenseCategory.id)" >
		            			<span v-if="errorLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
											  Delete
		            		</button>
		            	</div>
		            	<div >
		            		<button type="button" class="btn btn-outline-info" @click="addExpenseCategory()" data-dismiss="modal">Cancel</button>
			              <button  class="btn btn-primary ml-2" type="submit">
											<span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
											  Save	
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

	store.dispatch("getExpenseCategories");

	const expenseCategories = computed(() => store.state.expenseCategories);

	const expenseCategory = ref({
		display_name: '',
		description: ''
	});

	watch(
		() => store.state.currentExpenseCategory.data,
		(newVal, oldVal) => {
			expenseCategory.value = {
				...JSON.parse(JSON.stringify(newVal))
			};	
		}
	);

	const loading = ref(false);
	const errorLoading = ref(false);

	let errorMsg = ref('');

	function saveExpenseCategory(ev) {
		ev.preventDefault();
		if(expenseCategory.value.id !== 1){
			loading.value = true;
			store
				.dispatch('saveExpenseCategory', expenseCategory.value)
				.then((res) => {
					loading.value = false;
					$('#modal-default').modal('hide');
				})
				.catch(err => {
					loading.value = false;
					errorMsg.value = err.response.data.errors;
				});
		}
	}

	function showExpenseCategory(expenseCategory) {
		store.dispatch('getExpenseCategory', expenseCategory);
		$('#modal-default').modal('show');
	}

	function addExpenseCategory() {
		const newExpenseCategory = {
			display_name: '',
			description: ''
		};
		store.dispatch('getExpenseCategory', newExpenseCategory);
	}

	function deleteExpenseCategory(id) {
		errorLoading.value = true;
		store.dispatch("deleteExpenseCategory", id)
		.then(() => {
			$('#modal-default').modal('hide');
			errorLoading.value = false;
		});
	}


</script>
