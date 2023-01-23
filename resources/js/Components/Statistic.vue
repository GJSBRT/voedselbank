<template>
    <div class="bg-white overflow-hidden shadow sm:rounded-lg p-4">
        <h2 class="text-lg">{{ title }}</h2>
        <span class="text-2xl font-semibold">{{ value }}</span>
    </div>
</template>

<script setup>
    defineProps({
        title: {
            type: String,
            default: 'Title'
        },
        value: {
            type: String,
            default: 'Value'
        },
    })
</script>