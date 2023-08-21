<template>
	<div class="wrapper">
		<NavBar />
		<Sidebar />
		<router-view></router-view>
		<ControlSidebar />
		<Footer />
	</div>
</template>

<script setup>
	import NavBar from "../components/NavBar.vue"
	import Footer from "../components/Footer.vue"
	import Sidebar from "../components/Sidebar.vue"
	import ControlSidebar from "../components/ControlSidebar.vue"

	// import { useStore } from "vuex"

	// const store = useStore();

	// store.dispatch("getAuthUser");
	
</script>