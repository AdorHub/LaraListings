<script setup>
	import { switchTheme } from '../theme.js';
	import NavLink from '../Components/NavLink.vue';
	import { computed, ref } from 'vue';
	import { usePage } from '@inertiajs/vue3';

	const page = usePage();
	const user = computed(() => page.props.auth.user);
	const show = ref(false);
</script>

<template>
	<div v-if="show" @click="show = !show" class="fixed inset-0 z-40"></div>
	<header class="bg-slate-800 text-white">
		<nav class="p-6 mx-auto max-w-screen-lg flex items-center justify-between">
			<NavLink routeName="home" componentName="Home">Home</NavLink>

			<div class="flex items-center space-x-6">				
				<div v-if="user" class="relative">
					<div @click="show = !show" class="flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-slate-700 cursor-pointer" :class="{'!bg-slate-700': show}">
						<p>{{ user.name }}</p>
						<i class="fa-solid fa-angle-down"></i>
					</div>
					<div v-if="show" @click="show = !show" class="absolute z-50 top-16 right-0 bg-slate-800 text-white rounded-lg border-slate-300 overflow-hidden w-40 opacity-95">
						<Link class="block w-full px-6 py-3 hover:bg-slate-700 text-left" :href="route('profile.edit')">Profile</Link>
						<Link class="block w-full px-6 py-3 hover:bg-slate-700 text-left" :href="route('listing.create')">New Listing</Link>
						<Link class="block w-full px-6 py-3 hover:bg-slate-700 text-left" :href="route('dashboard')">Dashboard</Link>
						<Link class="block w-full px-6 py-3 hover:bg-slate-700 text-left" as="button" method="post" :href="route('logout')">Logout</Link>
					</div>
				</div>
				<div v-else class="space-x-6">
					<NavLink routeName="login" componentName="Auth/Login">Login</NavLink>
					<NavLink routeName="register" componentName="Auth/Register">Register</NavLink>	
				</div>							
				<button @click="switchTheme" class="hover:bg-slate-700 w-6 h-6 grid place-items-center rounded-full hover-outline hover:outline-1 outline-white cursor-pointer">
					<i class="fa-solid fa-circle-half-stroke"></i>
				</button>
			</div>
		</nav>
	</header>

	<main class="p-6 mx-auto max-w-screen-lg">
		<slot />
	</main>
</template>