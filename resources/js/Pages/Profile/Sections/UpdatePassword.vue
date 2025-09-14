<script setup>
	import Container from '../../../Components/Container.vue';
	import Title from '../../../Components/Title.vue';
	import InputField from '../../../Components/InputField.vue';
	import SubmitBtn from '../../../Components/SubmitBtn.vue';
	import { useForm } from '@inertiajs/vue3';

	const form = useForm({
		current_password: '',
		password: '',
		password_confirmation: ''
	});

	const submit = () => {
		form.put(route('profile.password'), {
			preserveScroll: true,
			onFinish: () => form.reset()
		});
	}
</script>

<template>
	<Container class="mb-6 max-w-1/2">
		<div class="mb-6 text-center">
			<Title>Update Password</Title>
			<p>Update your password</p>
		</div>
		<form @submit.prevent="submit" class="space-y-6">
			<InputField label="Current Password" icon="key" v-model="form.current_password" :error="form.errors.current_password" type="password" />
			<InputField label="New Password" icon="key" v-model="form.password" :error="form.errors.password" type="password" />
			<InputField label="Confirm Password" icon="key" v-model="form.password_confirmation" :error="form.errors.password_confirmation" type="password" />
			<SubmitBtn :disabled="form.processing">Save</SubmitBtn>
			<p v-if="form.recentlySuccessful" class="text-green-500 font-medium text-center">Saved</p>
		</form>
	</Container>
</template>