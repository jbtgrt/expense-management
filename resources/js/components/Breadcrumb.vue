<template>
  <ol  class="breadcrumb float-sm-right">
    <li v-for="(crumb, index) in crumbs" :key="index" class="breadcrumb-item active">
      <router-link v-if="this.$route.name != crumb.to.name" :to="crumb.to">
          {{ crumb.to.name }}
      </router-link>
      <a v-else>{{ crumb.to.name }}</a>
    </li>
  </ol>
</template>

<script setup>
  import { ref, watch, computed } from "vue"
  import { useRoute } from 'vue-router';
  import { useStore } from "vuex"
  const route = useRoute();
  const store = useStore();

  const matched = route.matched;

  const crumbs = computed(() => {
    return matched.map(route => ({
      to: { name: route.name }
    })).slice(1);
  });

  store.commit('setSidebar', crumbs );
</script>

<style>
/* Add your breadcrumb styling here */
</style>
