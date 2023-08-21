<template>
	<PageComponent >
		<template v-slot:header>
      Roles
    </template>
    <template v-slot:breadcrumb>
      <breadcrumb></breadcrumb>
    </template>
    <template v-slot:content>
    	<!-- Main content -->
	    <div class="content">
	    	<div v-if="roles.loading" class="d-flex justify-content-center"><span>Loading...</span></div>	
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
				        	<tr v-if="roles.data.length"  v-for="(role, index) in roles.data" :key="role.id" @click="showRole(role)">
										<td>{{ role.display_name }}</td>
										<td>{{ role.description }}</td>
										<td>{{ role.created_at }}</td>
				        	</tr>
				        	<tr v-else><td> No records </td></tr>
				        </tbody>
				      </table>
				    </div>
				    <!-- /.card-body -->
				  </div>
				  <div class="d-flex justify-content-end m-2 mt-4">
			    	<button class="btn btn-primary" data-toggle="modal" data-target="#modal-default" data-backdrop="static" data-keyboard="false" @click="addRole()">Add Role</button>
			    </div>
			  </div>
		    <div class="modal fade" id="modal-default" >
	        <div class="modal-dialog">
	        	<form @submit="saveRole">   
		          <div class="modal-content">
		            <div class="modal-header">
		              <h4 class="modal-title">{{role.id ? 'Update' : 'Add'}} Role</h4>
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
		                    <input type="text" class="form-control" id="display_name" v-model="role.display_name" name="display_name" :disabled="role.id === 1 ? true : false">
		                  </div>
		                </div>
		                <div class="form-group row">
		                  <label for="description" class="col-sm-3 col-form-label">Description</label>
		                  <div class="col-sm-9">
		                    <textarea style="min-height: 70px;" class="form-control" id="description" v-model="role.description" name="description" :disabled="role.id === 1 ? true : false"></textarea>
		                  </div>
		                </div>
		              </div>
		            </div>
		            <div v-if="role.id != 1" class="modal-footer justify-content-between">
		            	<div>
		            		<button v-if="role.id"  type="button" class="btn btn-danger" @click="deleteRole(role.id)" >
		            			<span v-if="errorLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
											  Delete
		            		</button>
		            	</div>
		            	<div >
		            		<button type="button" class="btn btn-outline-info" @click="addRole()" data-dismiss="modal">Cancel</button>
			              <button  class="btn btn-primary ml-2" type="submit">
											<span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
											  {{role.id ? 'Update' : 'Save'}}	
										</button>
									</div>
		            </div>
		            <div v-else class="modal-footer justify-content-end">
									<button type="button" class="btn btn-outline-info" data-dismiss="modal">Cancel</button>
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

	store.dispatch("getRoles");

	const roles = computed(() => store.state.roles);

	const role = ref({
		display_name: '',
		description: ''
	});

	watch(
		() => store.state.currentRole.data,
		(newVal, oldVal) => {
			role.value = {
				...JSON.parse(JSON.stringify(newVal))
			};	
		}
	);

	const loading = ref(false);
	const errorLoading = ref(false);

	let errorMsg = ref('');

	function saveRole(ev) {
		ev.preventDefault();
		if(role.value.id !== 1){
			loading.value = true;
			store
				.dispatch('saveRole', role.value)
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

	function showRole(role) {
		store.dispatch('getRole', role);
		$('#modal-default').modal('show');
	}

	function addRole() {
		const newRole = {
			display_name: '',
			description: 'can add expenses'
		};
		store.dispatch('getRole', newRole);
	}

	function deleteRole(id) {
		errorLoading.value = true;
		store.dispatch("deleteRole", id)
		.then(() => {
			$('#modal-default').modal('hide');
			errorLoading.value = false;
		});
	}


</script>
