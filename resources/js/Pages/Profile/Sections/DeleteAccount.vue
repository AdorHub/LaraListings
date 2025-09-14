<script setup>
	import Container from '../../../Components/Container.vue';
	import Title from '../../../Components/Title.vue';
	import InputField from '../../../Components/InputField.vue';
	import SubmitBtn from '../../../Components/SubmitBtn.vue';
	import { useForm } from '@inertiajs/vue3';
	import { ref } from 'vue';

	const form = useForm({
		password: ''
	});

	const submit = () => {
		form.delete(route('profile.delete'), {
			preserveScroll: true,
			onFinish: () => form.reset()
		});
	}

	const showDeleteForm = ref(false);
</script>

<template>
	<Container class="mb-6 max-w-1/2">
		<div class="mb-6 text-center">
			<Title>Delete account</Title>
			<p>Once your account is deleted, all of its resources data will be permanently deleted. This action cannot be undone</p>
		</div>
		<div v-if="showDeleteForm">
			<form @submit.prevent="submit" class="space-y-4">
				<InputField label="Confirm Password" icon="key" type="password" v-model="form.password" :error="form.errors.password" />
				<SubmitBtn :disabled="form.processing">Delete forever</SubmitBtn>
				<button @click="showDeleteForm = false" class="text-indigo-500 font-medium underline dark:text-indigo-400 cursor-pointer hover:text-indigo-300 transition-all">Cancel</button>
			</form>
		</div>
		<button v-if="!showDeleteForm" @click="showDeleteForm = true"  class="px-6 py-2 rounded-lg bg-red-600 text-white cursor-pointer hover:bg-red-500 transition-all w-full">
			<i class="fa-solid fa-triangle-exclamation mr-2"></i>
			Delete Account
		</button>
	</Container>
</template>