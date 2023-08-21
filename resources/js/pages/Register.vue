<template >
	<div class="login-box">
	  <!-- /.login-logo -->
	  <div class="card card-outline card-primary">
	    <div class="card-header text-center">
	      <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
	    </div>
	    <div class="card-body">
	        <div class="text-center">
			    <h2 class="text-md ">Register For Free</h2>
			      	<p class="mt-2 text-center text-sm text-gray-600">
			        Or
			        {{ ' ' }}
			        <router-link :to="{name: 'Login'}" class="font-medium text-indigo-600 hover:text-indigo-500">Login To Your Account</router-link>
			    </p>
		    </div>

		    <Alert v-if="Object.keys(errorMsg).length" class="flex-col items-stretch text-sm">
      			<div v-for="(field, i) of Object.keys(errorMsg)" :key="i">
      				<div v-for="(error, ind) of errorMsg[field] || []" :key="ind">
      					* {{error}}
      				</div>
      			</div>
	      	</Alert>

	      	<form @submit="register">
		        <div class="input-group mb-3">
		          <input type="text" class="form-control" placeholder="Full name" v-model="user.name" name="name">
		          <div class="input-group-append"  >
		            <div class="input-group-text">
		              <span class="fas fa-user"></span>
		            </div>
		          </div>
		        </div>
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
		          <input type="password" class="form-control" placeholder="Retype password" v-model="user.password_confirmation" name="password_confirmation">
		          <div class="input-group-append">
		            <div class="input-group-text">
		              <span class="fas fa-lock"></span>
		            </div>
		          </div>
		        </div>
		        <div class="row justify-content-end">
		   
		          <!-- /.col -->
		          <div class="col-4">
		            <button type="submit" class="btn btn-primary btn-block">Register</button>
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
	import {useRouter} from "vue-router";
	import {ref} from "vue";
	import Alert from "../components/AlertComponent.vue";

	const router = useRouter();
	const user = {
		role: 'user',
		name: '',
		email: '',
		password: '',
		password_confirmation: ''
	};

	const loading = ref(false);

	const errorMsg = ref({});

	function register(ev) {
		ev.preventDefault();
		loading.value = true;
		store
			.dispatch('register', user)
			.then((res) => {
				loading.value = false;
				router.push({
					name: 'Dashboard'
				})
			})
			.catch((err) => {
				loading.value = false;
				if(err.response.status == 422) {
					errorMsg.value = err.response.data.errors;
				}
			});
	}


</script>