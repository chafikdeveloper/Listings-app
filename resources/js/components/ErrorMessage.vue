<script setup>
defineProps({
    errors: Object
})
</script>

<template>
    <div class="mt-4" v-if="Object.keys(errors).length">
        <ul class="ml-4 list-disc list-inside">
            <li v-for="(error, i) in errors" :key="i" class="text-sm text-red-500">{{ error }}</li>
        </ul>
    </div>
</template>