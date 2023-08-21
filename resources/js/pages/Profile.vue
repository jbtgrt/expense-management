<template>
	<PageComponent >
		<template v-slot:header>
      Profile
    </template>
    <template v-slot:breadcrumb>
      <breadcrumb></breadcrumb>
    </template>
    <template v-slot:content>
    	<!-- Main content -->
	    <div class="content">
		      <div class="container-fluid">
		        <div class="row">
		          <div class="col-md-12">
		          	<!-- Profile Image -->
		            <div class="card card-primary card-outline">
		              <div class="card-body box-profile ">
		                <div class="text-center">
		                  <img class="profile-user-img img-fluid img-circle" :src="userData.image" alt="User profile picture">
		                </div>
		                <h3 class="profile-username text-center">{{userData.name}}</h3>

		                <p class="text-muted text-center">{{userData.role}}</p>
		                <div class="d-flex justify-content-end m-2 mt-4">
								    	<button class="btn btn-primary" data-toggle="modal" data-target="#modal-default" data-backdrop="static" data-keyboard="false" @click="editInfo()">Change Password</button>
								    </div>
		              </div>
		              <!-- /.card-body -->
		            </div>
		            <!-- /.card -->

		            <!-- modal -->
		            <div class="modal fade" id="modal-default" >
					        <div class="modal-dialog">
					        	<form @submit="saveInfo">   
						          <div class="modal-content">
						            <div class="modal-header">
						              <h4 class="modal-title">Update Password</h4>
						            </div>
						            <div class="modal-body">
						              <div class="card-body">
						              	<!-- alert	 -->
						        				<Alert v-if="Object.keys(errorMsg).length">
						        					<button type="button" class="close" @click="errorMsg = ''">&times;</button>
									      			<div v-for="(field, i) of Object.keys(errorMsg)" :key="i">
									      				<div v-for="(error, ind) of errorMsg[field] || []" :key="ind">
									      					* {{error}}
									      				</div>
									      			</div>
										      	</Alert>
										      	<!-- modal content -->
										      	<div class="input-group mb-3">
										          <input type="password" class="form-control" placeholder="Current Password" v-model="user.current_password" name="current_password" autocomplete="off">
										          <div class="input-group-append">
										            <div class="input-group-text">
										              <span class="fas fa-lock"></span>
										            </div>
										          </div>
										        </div>
										      	<!-- modal content -->
										      	<div class="input-group mb-3">
										          <input type="password" class="form-control" placeholder="New Password" v-model="user.password" name="password" autocomplete="off">
										          <div class="input-group-append">
										            <div class="input-group-text">
										              <span class="fas fa-lock"></span>
										            </div>
										          </div>
										        </div>
										        <div class="input-group mb-3">
										          <input type="password" class="form-control" placeholder="Retype password" v-model="user.password_confirmation" name="password_confirmation" autocomplete="off">
										          <div class="input-group-append">
										            <div class="input-group-text">
										              <span class="fas fa-lock"></span>
										            </div>
										          </div>
										        </div>
						                
						                
						              </div>
						            </div>
						            <div class="modal-footer justify-content-end">
						            	
						            	<div >
						            		<button type="button" class="btn btn-outline-info" @click="user = ''" data-dismiss="modal">Cancel</button>
							              <button  class="btn btn-primary ml-2" type="submit">
															<span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
															  Update
														</button>
													</div>
						            </div>
						          </div>
					        	</form>
					        </div>
					      </div>
		          </div>
		        </div>
		      </div>
				<!-- </div> -->
	    </div>
    </template>
	</PageComponent>
</template>

<script setup>
	import Breadcrumb from '../components/Breadcrumb.vue';
	import PageComponent from "../components/PageComponent.vue";
	import Alert from "../components/AlertComponent.vue";

	import { ref, watch, computed } from "vue"
	import {useRouter} from "vue-router";
	import { useStore } from "vuex"
	const store = useStore();


	const userData = JSON.parse(sessionStorage.getItem('AUTH_USER'));

	const router = useRouter();
	const user = {
		current_password: '',
		password: '',
		password_confirmation: ''
	};

	const loading = ref(false);

	const errorMsg = ref({});

	function saveInfo(ev) {
		ev.preventDefault();
		loading.value = true;
		const data = {
			data: user,
			user_id: userData.id
		};
		store
			.dispatch('saveProfile', data)
			.then((res) => {
				loading.value = false;
				$('#modal-default').modal('hide');
			})
			.catch((err) => {
				loading.value = false;
				if(err.response.status == 422) {
					errorMsg.value = err.response.data.errors;
				}
			});
	}



	
	



</script>
