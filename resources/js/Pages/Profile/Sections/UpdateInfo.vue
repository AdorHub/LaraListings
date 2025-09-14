<script setup>
	import Container from '../../../Components/Container.vue';
	import Title from '../../../Components/Title.vue';
	import InputField from '../../../Components/InputField.vue';
	import SubmitBtn from '../../../Components/SubmitBtn.vue';
	import SessionMsg from '../../../Components/SessionMsg.vue';
	import { useForm, router } from '@inertiajs/vue3';

	const props = defineProps({
		user: Object,
		status: String
	});

	const form = useForm({
		name: props.user.name,
		email: props.user.email
	});

	const submit = () => {
		form.patch(route('profile.info'));
	}

	const sendEmail = (e) => {
		router.post(route('verification.send')), {},
		{
			onStart: () => e.target.disabled = true,
			onFinish: () => e.target.disabled = false
		}
	}
</script>

<template>
	<Container class="mb-6 max-w-1/2">
		<div class="mb-6 text-center">
			<Title>Update Information</Title>
			<p>Update your account info and email address</p>
		</div>
		<form @submit.prevent="submit" class="space-y-6">
			<InputField label="Name" icon="id-badge" v-model="form.name" :error="form.errors.name" />
			<InputField label="Email" icon="at" type="email" v-model="form.email" :error="form.errors.email" />
			<div v-if="user.email_verified_at === null">
				<p class="text-center text-purple-500 border-1 border-purple-500 rounded-md">
					Your email address is unverified 
					<button @click.prevent="sendEmail" class="text-purple-500 hover:text-purple-600 font-medium underline dark:text-purple-400 dark:hover:text-purple-500 cursor-pointer w-full disabled:text-slate-400 disabled:cursor-wait">Send Verification Email</button>
				</p>
			</div>
			<SubmitBtn :disabled="form.processing">Save</SubmitBtn>
			<SessionMsg :message="status" />
		</form>
	</Container>
</template>