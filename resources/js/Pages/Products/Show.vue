<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import TableData from '@/Components/TableData.vue';
import Pagination from '@//Components/Pagination.vue';
import { Inertia } from '@inertiajs/inertia';
import TableSearch from "@/Components/Search/TableSearch.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';

// haal de products op
defineProps({
    products: Object,
});

</script>

<template>
    <AppLayout title="Producten" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Producten Overzicht',
            href: route('products.index'),
        }
    ]" >

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Producten
            </h2>
            <div class="ml-auto">
                <PrimaryButton class="flex text-white p-2 rounded" @click="Inertia.visit(route('products.new'))">Toevoegen</PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <TableSearch route="products.index" placeholder="Zoeken op naam of ean nummer" class="my-5" />

                <Table :headers="['ID', 'Naam', 'EAN nummer', 'Product Categorie', 'Voorraad']" >
                    <tr @click="Inertia.visit(route('products.view', productItem.id ))" class="hover:bg-gray-50 cursor-pointer" v-for="productItem in products.data" :key="products.id">
                        <TableData>{{ productItem.id }}</TableData>
                        <TableData>{{ productItem.name }}</TableData>
                        <TableData>{{ productItem.ean_number }}</TableData>
                        <TableData>{{ productItem.category.name }}</TableData>
                        <TableData>{{ productItem.quantity }}</TableData>
                    </tr>
                </Table>
                <Pagination class="mt-6" :links="products.links" />
            </div>
        </div>
    </AppLayout>
</template>

