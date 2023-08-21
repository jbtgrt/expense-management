<template>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
  
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto mr-2">
     

      
      <li class="nav-item">
        <span  class="mr-3 nav-link">
          Welcome in Expense Manager
        </span>
      </li>
      <li class="nav-item ">
         <a  href="#" @click="logout" class="nav-link">Log out</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
</template>

<script setup>
  import { useStore } from 'vuex';
  import { useRouter } from 'vue-router';

  const store = useStore();
  const router = useRouter();

  function logout(){
      store.dispatch('logout')
        .then((res) => {
          router.push({
            name: 'Login'
          });
        });
    }
  
</script>