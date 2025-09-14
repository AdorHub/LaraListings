<script setup>
	import Container from '../../Components/Container.vue';
	import Title from '../../Components/Title.vue';
	import TextLink from '../../Components/TextLink.vue';
	import InputField from '../../Components/InputField.vue';
	import SubmitBtn from '../../Components/SubmitBtn.vue';

	import { useForm } from '@inertiajs/vue3';

	const form = useForm({
		name: '',
		email: '',
		password: '',
		password_confirmation: ''
	});

	const submit = () => {
		form.post(route('register'), {
			onFinish: () => form.reset('password', 'password_confirmation')
		});
	}
</script>

<template>
	<Head title="- Register" />
	<Container class="w-1/2">
		<div class="mb-8 text-center">
			<Title>Registration</Title>
			<p>Already have an account? <TextLink routeName="login">Login</TextLink></p>
		</div>

		<form @submit.prevent="submit" class="space-y-6">
			<InputField label="Name" icon="user" v-model="form.name" :error="form.errors.name" />
			<InputField label="Email" icon="at" type="email" v-model="form.email" :error="form.errors.email" />
			<InputField label="Password" icon="key" type="password" v-model="form.password" :error="form.errors.password"  />
			<InputField label="Confirm Password" icon="key" type="password" v-model="form.password_confirmation"  />
			<SubmitBtn :disabled="form.processing">Register</SubmitBtn>
			<p class="text-center text-slate-500 text-sm dark:text-slate-400">By creating an account, you agree to our Terms of Service and Privacy Policy.</p>
		</form>
	</Container>
</template>