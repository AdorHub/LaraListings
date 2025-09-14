<script setup>
	import Card from '../Components/Card.vue';
	import Pagination from '../Components/Pagination.vue';
	import InputField from '../Components/InputField.vue';
	import { router, useForm } from '@inertiajs/vue3';

	const props = defineProps({
		listings: Object,
		searchTerm: String
	});

	const params = route().params;

	const form = useForm({
		search: props.searchTerm
	});

	const search = () => {
		router.get(route('home'), {
			search: form.search,
			userId: params.userId,
			tag: params.tag
		});
	}

	const username = params.userId 
						? props.listings.data.find(e => e.user_id === Number(params.userId)).user.name 
						: null;
</script>

<template>
	<Head title="- Latest Listings" />

	<div class="flex items-center justify-between mb-4">
		<div class="flex items-center gap-2">
			<Link v-if="params.tag" :href="route('home', {...params, tag: null, page: null})" class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2">{{ params.tag }} <i class="fa-solid fa-xmark"></i></Link>

			<Link v-if="params.search" :href="route('home', {...params, search: null, page: null})" class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2">{{ params.search }} <i class="fa-solid fa-xmark"></i></Link>

			<Link v-if="params.userId" :href="route('home', {...params, userId: null, page: null})" class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2">{{ username }} <i class="fa-solid fa-xmark"></i></Link>
		</div>
		<div class="w-1/4">
			<form @submit.prevent="search">
				<InputField type="search" label="" icon="magnifying-glass" placeholder="Search.." v-model="form.search" />
			</form>
		</div>
	</div>

	<div v-if="Object.keys(listings.data).length">
		<div class="grid grid-cols-3 gap-4">
			<div v-for="listing in listings.data" :key="listing.id">
				<Card :listing="listing" />
			</div>
		</div>
	</div>
	<div v-else>
		There are no listings
	</div>

	<Pagination :paginator="listings" class="mt-8" />
</template>