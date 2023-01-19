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




// haal de products op
defineProps({
    products: Object,
});


const confirmDelete = ref(null);

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
                Products
            </h2>
            <br>
            <Link class="text-white bg-yellow-500 p-2 rounded" :href="route('product.CreateProduct')">Toevoegen</Link>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Table :headers="['ID', 'Naam', 'Ean nummer', 'Product Categorie', 'Voorraad', 'Bewerk', 'Verwijder']" >
                    <tr class="hover:bg-gray-50 cursor-pointer" v-for="productItem in products.data" :key="products.id">
                        <TableData>{{ productItem.id }}</TableData>
                        <TableData>{{ productItem.name }}</TableData>
                        <TableData>{{ productItem.ean_number }}</TableData>
                        <TableData>{{ productItem.category.name }}</TableData>
                        <TableData>{{ productItem.quantity }}</TableData>
                        <Table-data @click="Inertia.visit(route('product.Edit', productItem.id ))"  class="font-bold rounded" >Wijzig </Table-data>
                        <Table-data @click="confirmDelete = productItem.id"  class="font-bold rounded" >Verwijder </Table-data>
                    </tr>
                </Table>
                <Pagination class="mt-6" :links="products.links" />
            </div>
        </div>

        <ConfirmationModal :show="confirmDelete" @close="confirmDelete = null">
            <template #title>
                Verwijder Product
            </template>

            <template #content>
                Weet je het zeker dat je dit product wilt verwijderen? Dit product zal permanent verwijderd worden.
            </template>

            <template #footer>
                <SecondaryButton @click.native="confirmDelete = null">
                    Nee
                </SecondaryButton>
                <!-- Is de variabel null? dan laat je niks zien, Is de variabel niet null dan laat je wel wat zien -->
                <DangerButton class="ml-2" @click.native="Inertia.delete(route('product.DeleteProduct', confirmDelete)); confirmDelete = null">
                    Verwijder Product
                </DangerButton>
            </template>
        </ConfirmationModal>

    </AppLayout>
</template>

