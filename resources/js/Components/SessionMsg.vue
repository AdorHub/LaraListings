<script setup>
	defineProps({
		message: String
	})
</script>

<template>
	<div v-if="message" class="font-medium text-md text-green-500 w-full text-center">
		{{ message }}
	</div>
</template>