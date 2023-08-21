<template>
	<PageComponent >
		<template v-slot:header>
      Users
    </template>
    <template v-slot:breadcrumb>
      <breadcrumb></breadcrumb>
    </template>
    <template v-slot:content>
    	<!-- Main content -->
	    <div class="content">
	    	<div v-if="users.loading" class="d-flex justify-content-center"><span>Loading...</span></div>	
				<div v-else >
		      <div class="card m-2">
				    <!-- /.card-header -->
				    <div class="card-body p-0">
				      <table class="table table-sm">
				        <thead>
				          <tr>
				            <th>Name</th>
				            <th>Email Address</th>
				            <th>Role</th>
				            <th>Created At</th>
				          </tr>
				        </thead>
				        <tbody>
				        	<tr v-if="users.data.length" v-for="(user, index) in users.data" :key="user.id" @click="showUser(user)">
										<td>{{ user.name }}</td>
										<td>{{ user.email }}</td>
										<td>{{ user.role }}</td>
										<td>{{ user.created_at }}</td>
				        	</tr>
				        	<tr v-else><td> No records </td></tr>
				        </tbody>
				      </table>
				    </div>
				    <!-- /.card-body -->
				  </div>
				  <div class="d-flex justify-content-end m-2 mt-4">
			    	<button class="btn btn-primary" data-toggle="modal" data-target="#modal-default" data-backdrop="static" data-keyboard="false" @click="addUser()">Add User</button>
			    </div>
			  </div>
		    <div class="modal fade" id="modal-default" >
	        <div class="modal-dialog">
	        	<form @submit="saveUser">   
		          <div class="modal-content">
		            <div class="modal-header">
		              <h4 class="modal-title">{{user.id ? 'Update' : 'Add'}}	 User</h4>
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
		                  <label for="name" class="col-sm-3 col-form-label">Name</label>
		                  <div class="col-sm-9">
		                    <input type="text" class="form-control" id="name" v-model="user.name" name="name" :disabled="user.role_id === 1 ? true : false">
		                  </div>
		                </div>
		                <div class="form-group row">
		                  <label for="email" class="col-sm-3 col-form-label">Email Address</label>
		                  <div class="col-sm-9">
		                    <input type="text" class="form-control" id="email" v-model="user.email" name="email" :disabled="user.role_id === 1 ? true : false">
		                  </div>
		                </div>
		                <div class="form-group row">
		                  <label for="role" class="col-sm-3 col-form-label">Role</label>
		                  <div class="col-sm-9">
									      <select id="role" v-model="user.role_id" class="form-control select2" :disabled="user.role_id === 1 ? true : false">
													<option v-for="type in roleTypes" :key="type.id" :value="type.id">
														{{type.display_name}}
													</option>
												</select>
											</div>
		                </div>
		                
		              </div>
		            </div>
		            <div v-if="user.role_id != 1" class="modal-footer justify-content-between">
		            	<div>
		            		<button v-if="user.id"  type="button" class="btn btn-danger" @click="deleteUser(user.id)" >
		            			<span v-if="errorLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
											  Delete
		            		</button>
		            	</div>
		            	<div >
		            		<button type="button" class="btn btn-outline-info" @click="addUser()" data-dismiss="modal">Cancel</button>
			              <button  class="btn btn-primary ml-2" type="submit">
											<span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
											  {{user.id ? 'Update' : 'Save'}}	
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

	store.dispatch("getUsers");
	store.dispatch("getRoleTypes");

	const users = computed(() => store.state.users);
	const roleTypes = computed(() => store.state.roleTypes);

	const user = ref({
		name: '',
		email: '',
		role_id: ''
	});

	watch(
		() => store.state.currentUser.data,
		(newVal, oldVal) => {
			user.value = {
				...JSON.parse(JSON.stringify(newVal))
			};	
		}
	);

	const loading = ref(false);
	const errorLoading = ref(false);

	let errorMsg = ref('');

	function saveUser(ev) {
		ev.preventDefault();
		if(user.value.id !== 1){
			loading.value = true;
			store
				.dispatch('saveUser', user.value)
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

	function showUser(user) {
		store.dispatch('getUser', user);
		$('#modal-default').modal('show');
	}

	function addUser() {
		const newUser = {
			name: '',
			email: '',
			role: ''
		};
		store.dispatch('getUser', newUser);
	}

	function deleteUser(id) {
		errorLoading.value = true;
		store.dispatch("deleteUser", id)
			.then(() => {
				$('#modal-default').modal('hide');
				errorLoading.value = false;
			});
	}



</script>
