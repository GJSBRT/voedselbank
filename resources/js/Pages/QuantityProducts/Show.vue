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
    <AppLayout title="Quantity Products" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Producten Voorraad Overzicht',
            href: route('deliveries.index'),
        },
    ]">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Voorraad Producten
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Table :headers="['ID', 'Naam', 'Voorraad']" >
                    <tr class="hover:bg-gray-50 cursor-pointer" v-for="productItem in products.data" :key="products.id">
                        <TableData>{{ productItem.id }}</TableData>
                        <TableData>{{ productItem.name }}</TableData>
                        <TableData>{{ productItem.quantity }}</TableData>
                    </tr>   
                </Table>
                <Pagination class="mt-6" :links="products.links" />
            </div>
        </div>
    </AppLayout>
</template>
