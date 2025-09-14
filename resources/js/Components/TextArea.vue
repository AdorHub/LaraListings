<script setup>
	import { ref } from 'vue';

	const model = defineModel();

	defineProps({
		label: String,
		icon: String,
		placeholder: {
			type: String,
			default: ''
		},
		error: Object
	});

	const isActive = ref(false);
</script>

<template>
	<div>
		<label :for="label" class="block text-sm font-medium text-slate-700 dark:text-slate-300">{{ label }}</label>
		<div class="relative mt-1 rounded-md">
			<div class="pointer-events-none absolute top-3 left-0 flex items-center pl-3">
				<span class="grid place-content-center text-sm text-slate-400">
					<i :class="[`fa-solid fa-${icon}`, {'text-indigo-400' : isActive}]"></i>
				</span>
			</div>
			<textarea rows="12" @focus="isActive = true" @blur="isActive = false" :name="label" :placeholder="placeholder" v-model="model" class="block w-full rounded-md pr-3 pl-9 py-3 text-sm dark:text-slate-200 ring-slate-400 outline-0 ring-1 focus:ring-inset focus:ring-indigo-400 focus:border-indigo-400 placeholder:text-slate-400"></textarea>
		</div>
		<span v-if="error" class="block text-red-500 text-center w-full outline-1 rounded-lg mt-2">{{ error }}</span>
	</div>
</template>