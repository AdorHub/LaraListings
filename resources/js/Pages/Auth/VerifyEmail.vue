<script setup>
	import Container from '../../Components/Container.vue';
	import SubmitBtn from '../../Components/SubmitBtn.vue';
	import { useForm } from '@inertiajs/vue3';
	import SessionMsg from '../../Components/SessionMsg.vue';

	defineProps({
		status: String
	});

	const form = useForm({});
	const submit = () => {
		form.post(route('verification.send'));
	}

</script>

<template>
	<div>
		<Head title="- Email Verification" />
		<Container class="w-1/2">
			<div class="mb-6">
				<p>Thanks for signing up! Before getting started you need to verify that email address is yours. Just click the link we just emailed to you. If you didn't recieve email yet we can resend you new one</p>				
			</div>
			<form @submit.prevent="submit">
				<SubmitBtn :disabled="form.processing" class="mb-4">Resend Verification Email</SubmitBtn>
			</form>
			<SessionMsg :message="status" />
		</Container>
	</div>
</template>