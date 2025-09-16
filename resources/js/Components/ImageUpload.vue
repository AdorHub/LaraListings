<script setup>
	import { ref } from 'vue';

	const props = defineProps({
		error: String,
		image: String
	});

	const currentImage = props.image ? `/storage/${props.image}` : null;
	const preview = ref(currentImage);
	const oversizedImage = ref(false);
	const showUnselectBtn = ref(false);

	const emit = defineEmits(['image']);
	const imageSelected = (e) => {
		preview.value = URL.createObjectURL(e.target.files[0]);
		oversizedImage.value = e.target.files[0].size > 3145728;
		showUnselectBtn.value = true;
		emit('image', e.target.files[0]);
	}
	const unselectImage = () => {
		showUnselectBtn.value = false;
		preview.value = currentImage;
		oversizedImage.value = false;
		emit('image', null);
	}
</script>

<template>
	<div>
		<span class="block text-sm font-medium text-slate-700 dark:text-slate-300">Image (max size: 3mb)</span>
		<label for="image" class="block rounded-md mt-1 bg-red-300 h-[264px] overflow-hidden cursor-pointer border-slate-300 border relative" :class="{'!border-red-500' : oversizedImage}">
			<img :src="preview ?? '/storage/images/listing/default.jpg'" class="object-cover object-center h-full w-full">
			<button @click.prevent="unselectImage" v-if="showUnselectBtn" type="button" class="absolute top-2 right-2 bg-white/75 w-8 h-8 rounded-full grid place-items-center text-slate-700 cursor-pointer hover:bg-white/85">
				<i class="fa-solid fa-rotate-left"></i>
			</button>
		</label>
		<input @input="imageSelected" type="file" id="image" hidden>
		<span v-if="error" class="block text-red-500 text-center w-full outline-1 rounded-lg mt-2">{{ error }}</span>
	</div>
</template>