<template>
	<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
  	<router-link to="/dashboard"  class="brand-link">
      <span class="brand-text font-weight-light">Expense Manager</span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->            
      <router-link to="/profile" class="user-panel mt-3 pb-2 d-flex ">
        <div class="image">
        	<img :src="userData.image" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
         	<a href="#" class="d-block">{{userData.name}}</a>
         	<span class="d-block text-white"> ( {{userData.role}} )</span>
        </div>
      </router-link>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li v-for="(item, index) in navigation" :key="item.name" :to="item.to"  :class="item.active ? 'nav-item menu-open' : 'nav-item'" >
          	<a v-if="item.navtree.length" href="#" :class="item.active ? 'nav-link active' : 'nav-link'">
            	<i :class="item.icon"></i>
              <p>
                {{ item.name }} 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <router-link v-else class="nav-link" :to="item.to">
       				<i :class="item.icon"></i>
              <p>
                {{ item.name }}
              </p>
            </router-link>
            
            <ul v-if="item.navtree.length" class="nav nav-treeview">
	            <li class="nav-item" v-for="subItem in item.navtree" :key="subItem.name">
	              <router-link class="nav-link " :to="subItem.to">
	              	<i class="far fa-circle nav-icon"></i>
	              	<p>{{ subItem.name }}</p>
	              </router-link>
	            </li>
	          </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>

<script setup>

	import { ref, watch, computed } from "vue"
	import { useStore } from "vuex"
	const store = useStore();

	const user = computed(() => store.state.user.data);
	const auth_data = JSON.parse(sessionStorage.getItem('AUTH_USER'));

  if(auth_data.role == 'Administrator'){
     store.commit("setAdminData", auth_data);
  }
 
	const userData = user === null ? user : auth_data;

	watch(
		() => store.state.sidebar,
		(newVal, oldVal) => {
		  navigation.value.forEach(item => {
		  	const active = item.name === newVal[0].to.name ? true : false;
		  	item.active = active; 
		  });
		}
	);


  const navigation = ref({});

	const adminNavigation = ref([
	  { 
        name: 'Dashboard', 
        icon: 'nav-icon fas fa-solid fa-chart-pie',
        active: false,
        to: { name: 'Dashboard' }, 
        navtree: []
      },
      { 
        name: 'User Management', 
        icon: 'nav-icon fas fa-solid fa-users',
        active: false,
        to: {}, 
        navtree: [
            {
              name: 'Roles', 
              to: { name: 'Roles' }, 
            },
            {
              name: 'Users', 
              to: { name: 'Users' }, 
            }
          ]
      },
      { 
        name: 'Expense Management', 
        icon: 'nav-icon fas fa-solid fa-database',
        active: false,
        to: {}, 
        navtree: [
            {
              name: 'Expense Categories', 
              to: { name: 'Expense Categories' }, 
            },
            {
              name: 'Expenses', 
              to: { name: 'Expenses' }, 
            }
          ]
      }
	]);

  const userNavigation = ref([
    { 
        name: 'Dashboard', 
        icon: 'nav-icon fas fa-solid fa-chart-pie',
        active: false,
        to: { name: 'Dashboard' }, 
        navtree: []
      },
      { 
        name: 'Expense Management', 
        icon: 'nav-icon fas fa-solid fa-database',
        active: false,
        to: {}, 
        navtree: [
            {
              name: 'Expenses', 
              to: { name: 'Expenses' }, 
            }
          ]
      }
  ]);

  navigation.value = userData.role == 'Administrator' ? adminNavigation.value : userNavigation.value;

	
</script>