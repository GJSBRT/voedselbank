<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import TableData from '@/Components/TableData.vue';
import Pagination from '@//Components/Pagination.vue';
import { Inertia } from '@inertiajs/inertia';
import TableSearch from "@/Components/Search/TableSearch.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { hasPermission } from '@/utils';

defineProps({
    products: Object,
});

function sort(state){
    Inertia.replace(route('products.index', {sort: state? '-quantity' : 'quantity' }));
}
</script>

<template>
    <AppLayout title="Producten" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Producten overzicht',
            href: route('products.index'),
        }
    ]" >

        <template #header>
            <PrimaryButton v-if="hasPermission('products:create')" class="flex text-white p-2 rounded" @click="Inertia.visit(route('products.new'))">
                Toevoegen
            </PrimaryButton>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="my-5 flex">
                    <Dropdown align="left" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md border border-gray-300 shadow-sm">
                                <button type="button" class="inline-flex items-center px-4 py-3 my-auto border border-transparent leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                    Voorraad
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/></svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink @click="sort(true)">
                                Sorteer op de meeste
                            </DropdownLink>

                            <DropdownLink @click="sort(false)">
                                Sorteer op de minste
                            </DropdownLink>
                        </template>
                    </Dropdown>

                    <TableSearch route="products.index" placeholder="Zoeken op naam of ean nummer" class="ml-4 w-full my-auto" />
                </div>

                <Table :headers="['#', 'Naam', 'EAN nummer', 'Product Categorie', 'Voorraad']" >
                    <tr @click="Inertia.visit(route('products.view', productItem.id ))" class="hover:bg-gray-50 cursor-pointer" v-for="productItem in products.data" :key="products.id">
                        <TableData>{{ productItem.id }}</TableData>
                        <TableData>{{ productItem.name }}</TableData>
                        <TableData>{{ productItem.ean_number }}</TableData>
                        <TableData>
                            <span v-if="productItem.category.name === 'deleted'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-800">
                                Verwijderd
                            </span>
                            <span v-else>
                            {{ productItem.category.name }}
                            </span>
                        </TableData>
                        <TableData>{{ productItem.quantity }}</TableData>
                    </tr>
                </Table>
                <Pagination class="mt-6" :links="products.links" />
            </div>
        </div>
    </AppLayout>
</template>

