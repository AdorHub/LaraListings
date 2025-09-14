<script setup>
	import Container from '../../Components/Container.vue';
	import InputField from '../../Components/InputField.vue';
	import SubmitBtn from '../../Components/SubmitBtn.vue';
	import { useForm } from '@inertiajs/vue3';
	import SessionMsg from '../../Components/SessionMsg.vue';

	defineProps({
		status: String
	});

	const form = useForm({
		email: ''
	});

	const submit = () => {
		form.post(route('password.email'));
	}
</script>

<template>
	<Head title="- Reset Password" />
	<Container class="w-1/2">
		<div class="mb-8 text-center">
			<p>Let us know your email address and we will send you a password reset link that will allow you to choose a new one.</p>
		</div>

		<form @submit.prevent="submit" class="space-y-6">
			<InputField label="Email" icon="at" type="email" v-model="form.email" :error="form.errors.email" />
			<SubmitBtn :disabled="form.processing">Send Reset Link</SubmitBtn>
			<SessionMsg :message="status" />
		</form>
	</Container>
</template>