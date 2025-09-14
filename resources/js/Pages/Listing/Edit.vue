<script setup>
	import Container from '../../Components/Container.vue';
	import Title from '../../Components/Title.vue';
	import InputField from '../../Components/InputField.vue';
	import SumbitBtn from '../../Components/SubmitBtn.vue';
	import TextArea from '../../Components/TextArea.vue';
	import { useForm } from '@inertiajs/vue3';
	import ImageUpload from '../../Components/ImageUpload.vue';

	const props = defineProps({
		listing: Object
	});

	const form = useForm({
		title: props.listing.title,
		desc: props.listing.desc,
		tags: props.listing.tags,
		email: props.listing.email,
		link: props.listing.link,
		image: null,

		_method: 'PUT'
	});

	const submit = () => {
		form.post(route('listing.update', props.listing.id));
	}
</script>

<template>
	<Head title="- Edit Listing" />
	<Container>
		<div class="mb-6">
			<Title>Update listing</Title>
		</div>
		<form @submit.prevent="submit" class="grid grid-cols-2 gap-6">
			<div class="space-y-6">
				<InputField label="Title" icon="heading" placeholder="My new listing" v-model="form.title" :error="form.errors.title" />
				<InputField label="Tags (separate with ',')" icon="tags" placeholder="one, two, three" v-model="form.tags" :error="form.errors.tags" />
				<TextArea label="Description" icon="newspaper" placeholder="Listing description" v-model="form.desc" :error="form.errors.desc" />
			</div>
			<div class="space-y-6">
				<InputField label="Email" icon="at" placeholder="example@email.com" v-model="form.email" :error="form.errors.email" />
				<InputField label="External Link" icon="up-right-from-square" placeholder="https://example.com" v-model="form.link" :error="form.errors.link" />
				<ImageUpload @image="(e) => form.image = e" :error="form.errors.image" :image="listing.image" />
			</div>			
			<div>
				<SumbitBtn :disabled="form.processing">Save</SumbitBtn>
			</div>
		</form>
	</Container>
</template>