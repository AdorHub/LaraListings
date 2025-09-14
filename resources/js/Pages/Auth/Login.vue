<script setup>
	import Container from '../../Components/Container.vue';
	import Title from '../../Components/Title.vue';
	import TextLink from '../../Components/TextLink.vue';
	import InputField from '../../Components/InputField.vue';
	import SubmitBtn from '../../Components/SubmitBtn.vue';
	import Checkbox from '../../Components/Checkbox.vue';

	import { useForm } from '@inertiajs/vue3';

	const form = useForm({
		email: '',
		password: '',
		remember: null
	});

	const submit = () => {
		form.post(route('login'));
	}
</script>

<template>
	<Head title="- Login" />
	<Container class="w-1/2">
		<div class="mb-8 text-center">
			<Title>Login</Title>
			<p>Don't have an account? <TextLink routeName="register">Register</TextLink></p>
		</div>

		<form @submit.prevent="submit" class="space-y-6">
			<InputField label="Email" icon="at" type="email" v-model="form.email" :error="form.errors.email" />
			<InputField label="Password" icon="key" type="password" v-model="form.password" :error="form.errors.password" />
			<div class="flex items-center justify-between">
				<Checkbox name="remember" v-model="form.remember">Remember me</Checkbox>
				<TextLink routeName="password.request">Forgot password?</TextLink>
			</div>
			<SubmitBtn :disabled="form.processing">Login</SubmitBtn>
		</form>
	</Container>
</template>