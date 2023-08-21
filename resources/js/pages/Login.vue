<template >
	<div class="login-box">
	  <!-- /.login-logo -->
	  <div class="card card-outline card-primary">
	    <div class="card-header text-center">
	      <a href="#" class="h1"><b>Expense</b>Manager</a>
	    </div>
	    <div class="card-body">
		    <div class="text-center mb-4">
			    <h2 class="text-md ">Login To Your Account</h2>
			      	<!-- <p class="mt-2 text-center text-sm text-gray-600">
			        Or
			        {{ ' ' }}
			        <router-link :to="{name: 'Register'}" class="font-medium text-indigo-600 hover:text-indigo-500">Register For Free</router-link>
			    </p> -->
		    </div>

		    <Alert v-if="Object.keys(errorMsg).length">
					<button type="button" class="close" @click="errorMsg = ''">&times;</button>
    			<div v-for="(field, i) of Object.keys(errorMsg)" :key="i">
    				<div v-for="(error, ind) of errorMsg[field] || []" :key="ind">
    					* {{error}}
    				</div>
    			</div>
      	</Alert> 

      	<form @submit="login">
	        <div class="input-group mb-3">
	          <input type="email" class="form-control" placeholder="Email" v-model="user.email" name="email">
	          <div class="input-group-append">
	            <div class="input-group-text">
	              <span class="fas fa-envelope"></span>
	            </div>
	          </div>
	        </div>
	        <div class="input-group mb-3">
	          <input type="password" class="form-control" placeholder="Password" v-model="user.password" name="password" autocomplete="off">
	          <div class="input-group-append">
	            <div class="input-group-text">
	              <span class="fas fa-lock"></span>
	            </div>
	          </div>
	        </div>
	        <div class="input-group mb-3">
	          <select id="role" v-model="user.role_id" class="form-control" >
	          	<option value="">Select Role</option>
							<option v-for="type in roleTypes" :key="type.id" :value="type.id">
								{{type.display_name}}
							</option>
						</select>
	        </div>
	        <div class="row ">
	        	<div class="col-8">
	            <div hidden class="icheck-primary">
	              <input type="checkbox" id="remember" v-model="user.remember">
	              <label for="remember" class="ml-2">
	                Remember Me
	              </label>
	            </div>
		        </div>
	          <!-- /.col -->
	          <div class="col-4">
	            <button type="submit" class="btn btn-primary btn-block">
	            	<span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
	            Log In</button>
	          </div>
	          <!-- /.col -->
	        </div>
		    </form>	     
	    </div>
	    <!-- /.card-body -->
	  </div>
	  <!-- /.card -->
	</div>
</template>

<script setup>
	import store from "../store.js";
	import {useRouter, useRoute} from "vue-router";
	import { ref, watch, computed } from "vue";
	import Alert from "../components/AlertComponent.vue";

	const router = useRouter();
	const route = useRoute();

	store.dispatch("getRoleTypes");

	const roleTypes = computed(() => store.state.roleTypes);

	const user = ref({
		role_id: '',
		email: '',
		password: '',
		remember: false
	});

	const loading = ref(false);

	let errorMsg = ref('');

	function login(ev) {
		ev.preventDefault();
			loading.value = true;
		store
			.dispatch('login', user.value)
			.then((res) => {
				loading.value = false;
				router.push({
					name: 'Dashboard'
				});
			})
			.catch(err => {
				loading.value = false;
				errorMsg.value = err.response.data.errors;
			});
	}


</script>