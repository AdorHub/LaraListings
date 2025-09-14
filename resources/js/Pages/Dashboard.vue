<script setup>
	import Title from '../Components/Title.vue';
	import Pagination from '../Components/Pagination.vue';
	import SessionMsg from '../Components/SessionMsg.vue';
	import { router } from '@inertiajs/vue3';

	defineProps({
		listings: Object,
		message: String
	});

	const deleteListing = (id) => {
		if (confirm('Are you sure?')) {
			router.delete(route('listing.destroy', id));
		}
	}
</script>

<template>
	<Head title="- Dashboard" />
	<div v-if="listings">
		<div v-if="Object.keys(listings.data).length">
			<div class="flex items-center justify-between mb-4">
				<Title>Your latest listings</Title>
				<div class="flex items-center gap-4 text-xs">
					<p>Approved <i class="fa-solid fa-circle-check text-green-500"></i></p>
					<p>Pending approval <i class="fa-solid fa-circle-xmark text-red-500"></i></p>
				</div>
			</div>
			<SessionMsg :message="message" class="mb-4" />
			<table class="w-full table-fixed border-collapse oveflow-hidden rounded-md text-sm ring-1 ring-slate-300 dark:ring-slate-600 bg-white shadow-lg mb-6">
				<thead class="bg-slate-300 text-xs uppercase text-slate-600 dark:text-slate-400 dark:bg-slate-900">
					<tr>
						<th class="w-3/4 p-3 text-left">Listing Title</th>
						<th class="w-1/4 py-3 pr-3 text-right">View</th>
						<th class="w-1/5 py-3 pr-3 text-right">Edit</th>
						<th class="w-1/5 py-3 pr-3 text-right">Delete</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="listing in listings.data" :key="listing.id" class="border-b border-slate-200 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-600 dark:border-slate-600">
						<td>
							<div class="flex items-center gap-2 p-2">
								<img :src="listing.image ? `/storage/${listing.image}` : '/storage/images/listing/default.jpg'" class="h-20 w-20 rounded-full object-cover object-center">
								<h4>{{ listing.title }} <i :class="`fa-solid fa-${listing.approved ? 'circle-check text-green-500' : 'circle-xmark text-red-500'}`"></i></h4>
							</div>
						</td>

						<td class="w-1/4 py-3 pr-3 text-right text-indigo-500 underline">
							<Link v-if="listing.approved" :href="route('listing.show', listing.id)">View</Link>
						</td>

						<td class="w-1/5 py-3 pr-3 text-right text-blue-500 underline">
							<Link :href="route('listing.edit', listing.id)">Edit</Link>
						</td>

						<td class="w-1/5 py-3 pr-3 text-right text-red-500">
							<button @click="deleteListing(listing.id)" type="button" class="cursor-pointer">Delete</button>
						</td>
					</tr>
				</tbody>
			</table>
			<Pagination :paginator="listings" />
		</div>
		<div v-else>
			You have no listings yet!
		</div>
	</div>
	<div v-else>
		Due to violation of our terms your account has been suspended, please contact us at <span class="text-link">email@admin.com</span>
	</div>
</template>