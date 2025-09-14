<script setup>
	import Container from '../../Components/Container.vue';
	import Title from '../../Components/Title.vue';
	import InputField from '../../Components/InputField.vue';
	import SubmitBtn from '../../Components/SubmitBtn.vue';

	import { useForm } from '@inertiajs/vue3';

	const form = useForm({
		password: ''
	});

	const submit = () => {
		form.post(route('password.confirm'), {
			onFinish: () => {
				form.reset();
			}
		});
	}
</script>

<template>
	<Head title="- Confirm Password" />
	<Container class="w-1/2">
		<div class="mb-8 text-center">
			<Title>Confirm Your Password</Title>
			<p>Please confirm your password before continuing</p>
		</div>

		<form @submit.prevent="submit" class="space-y-6">
			<InputField label="Password" icon="key" type="password" v-model="form.password" :error="form.errors.password" />
			<SubmitBtn :disabled="form.processing">Confirm</SubmitBtn>
		</form>
	</Container>
</template>