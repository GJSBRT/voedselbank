<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import TableData from '@/Components/TableData.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Inertia } from '@inertiajs/inertia';
import { hasPermission } from '@/utils';
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

defineProps({
    packages: Object,
});

function sort(state){
    Inertia.replace(route('food-packages.index', {sort: state? 'created_at' : '-created_at' }));
}

</script>

<template>

    <AppLayout title="Voedsel Pakketten" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Voedselpakketten overzicht',
            href: route('food-packages.index')
        }
    ]">

        <template #header>


            <div class="ml-auto my-auto">
                <PrimaryButton v-if="hasPermission('food-packages:create')" @click="() => Inertia.visit(route('food-packages.new'))">
                    Nieuw Pakket
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Dropdown class="mb-5" align="left" width="48">
                    <template #trigger>
                        <span class="inline-flex rounded-md border shadow-sm">
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                Samengesteld op
                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <DropdownLink @click="sort(true)">
                            Oud naar nieuw
                        </DropdownLink>

                        <DropdownLink @click="sort(false)">
                            Nieuw naar oud
                        </DropdownLink>
                    </template>
                </Dropdown>

                <Table :headers="['#', 'Klant', 'Aantal Producten', 'Opgehaald Op', 'Samengesteld Op']" >
                    <tr @click="Inertia.visit(route('food-packages.view', packageItem.id))" class="hover:bg-gray-50 cursor-pointer" v-for="packageItem in packages.data" :key="packages.id">
                        <TableData>{{ packageItem.id }}</TableData>
                        <TableData>{{ packageItem.customer.first_name }} {{ packageItem.customer.last_name }}</TableData>
                        <TableData>{{ packageItem.items.length }}</TableData>
                        <TableData>
                            <span v-if="packageItem.retrieved_at == null" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-800">
                                Nog niet opgehaald
                            </span>
                            <span v-else>
                                {{ new Date(packageItem.retrieved_at).toLocaleString() }}
                            </span>
                        </TableData>
                        <TableData>{{ new Date(packageItem.created_at).toLocaleString() }}</TableData>
                    </tr>
                </Table>
                <Pagination class="mt-6" :links="packages.links" />
            </div>
        </div>
    </AppLayout>
</template>
