<script setup>
	import { router } from '@inertiajs/vue3';

	defineProps({
		listing: Object
	});

	const params = route().params;

	const selectUser = (id) => {
		router.get(route('home'), {
			userId: id,
			search: params.search,
			tag: params.tag
		});
	}

	const selectTag = (tag) => {
		router.get(route('home'), {
			userId: params.userId,
			search: params.search,
			tag: tag
		});
	}
</script>

<template>
	<div class="bg-white rounded-lg shadow-lg overflow-hidden dark:bg-slate-800 h-full flex-col justify-between">
		<div>
			<Link :href="route('listing.show', listing.id)">
				<img :src="listing.image ? `/storage/${listing.image}` : '/storage/images/listing/default.jpg'" class="w-full h-48 object-center object-cover">
			</Link>
			<div class="p-4">
				<h3 class="font-bold text-xl mb-2">{{ listing.title.substring(0, 35) }}...</h3>
				<p>Listed on {{ new Date(listing.created_at).toLocaleDateString() }} by <button @click="selectUser(listing.user.id)" class="text-link">{{ listing.user.name }}</button></p>
			</div>
		</div>
		<div v-if="listing.tags" class="flex items-center gap-3 px-4 pb-4">
			<div v-for="tag in listing.tags.split(',')" :key="tag">
				<button @click="selectTag(tag)" class="bg-slate-500 text-white px-2 py-px rounded-full hover:bg-slate-700 dark:hover:bg-slate-900 cursor-pointer">{{ tag }}</button>
			</div>
		</div>
	</div>
</template>