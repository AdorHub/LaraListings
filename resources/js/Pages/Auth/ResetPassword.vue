<script setup>
	import Container from '../../Components/Container.vue';
	import Title from '../../Components/Title.vue';
	import InputField from '../../Components/InputField.vue';
	import SubmitBtn from '../../Components/SubmitBtn.vue';
	import { useForm } from '@inertiajs/vue3';

	const props = defineProps({
		email: String,
		token: String
	});

	const form = useForm({
		token: props.token,
		email: props.email,
		password: '',
		password_confirmation: ''
	});

	const submit = () => {
		form.post(route('password.update'), {
			onFinish: () => form.reset('password', 'password_confirmation')
		});
	}
</script>

<template>
	<Head title="- Reset Password" />
	<Container class="w-1/2">
		<div class="mb-8 text-center">
			<Title>Reset Password</Title>
		</div>

		<form @submit.prevent="submit" class="space-y-6">
			<InputField label="Email" icon="at" type="email" v-model="form.email" :error="form.errors.email" />
			<InputField label="Password" icon="key" type="password" v-model="form.password" :error="form.errors.password"  />
			<InputField label="Confirm Password" icon="key" type="password" v-model="form.password_confirmation"  />
			<SubmitBtn :disabled="form.processing">Apply New Password</SubmitBtn>
		</form>
	</Container>
</template>