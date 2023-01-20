<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '../../Components/Table.vue';
import TableData from '../../Components/TableData.vue';
import Pagination from '../../Components/Pagination.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';
import ConfirmationModal from '../../Components/ConfirmationModal.vue';
import DangerButton from '../../Components/DangerButton.vue';
import SecondaryButton from '../../Components/SecondaryButton.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';

// haal de products op
defineProps({
    products: Object,
});



</script>

<template>
    <!-- Breadcrumbs voor dit pagina -->
    <AppLayout title="Producten" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'producten',
            href: route('product.index'),
        }
    ]" >
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Producten
            </h2>
            
            <PrimaryButton class="flex text-white p-2 rounded" @click="Inertia.visit(route('product.createProduct'))">Toevoegen</PrimaryButton>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Table :headers="['ID', 'Naam', 'EAN nummer', 'Product Categorie', 'Voorraad']" >
                    <tr @click="Inertia.visit(route('product.edit', productItem.id ))" class="hover:bg-gray-50 cursor-pointer" v-for="productItem in products.data" :key="products.id">
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

