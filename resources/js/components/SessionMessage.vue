<script setup>
defineProps({
  message: String,
})
</script>

<template>
    <p
        v-if="message"
        class="bg-green-200 text-green-600 px-3 py-1 rounded-lg text-sm mb-4"
    >
        {{ message }}
    </p>
</template>
