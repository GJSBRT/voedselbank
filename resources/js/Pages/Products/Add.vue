<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '../../Components/Table.vue';
import TableData from '../../Components/TableData.vue';
import Pagination from '../../Components/Pagination.vue';

defineProps({
    products: Object,
});

</script>

<template>
    <AppLayout title="Food products">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Voeg producten toe
            </h2>
        </template>
    </AppLayout>
</template>

