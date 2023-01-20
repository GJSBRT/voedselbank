<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import TableData from '@/Components/TableData.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Inertia } from '@inertiajs/inertia';

defineProps({
    packages: Object,
});

</script>

<template>
    <AppLayout title="Voedsel Pakketten">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Voedsel Pakketten
            </h2>

            <div class="ml-auto">
                <PrimaryButton @click="() => Inertia.visit(route('food-packages.new'))">
                    Nieuw Pakket
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Table :headers="['#', 'Klant', 'Aantal Producten', 'Opgehaald Op', 'Samengesteld Op']" >
                    <tr @click="Inertia.visit(route('food-packages.view', packageItem.id))" class="hover:bg-gray-50 cursor-pointer" v-for="packageItem in packages.data" :key="packages.id">
                        <TableData>{{ packageItem.id }}</TableData>
                        <TableData>{{ packageItem.customer.first_name }}</TableData>
                        <TableData>{{ packageItem.items.length }}</TableData>
                        <TableData>
                            <span v-if="packageItem.retrieved_at == null" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-800">
                                Nog niet opgehaald
                            </span>
                            <span v-else>
                                {{ new Date(packageItem.retrieved_at).toLocaleDateString() }}
                            </span>
                        </TableData>
                        <TableData>{{ new Date(packageItem.created_at).toLocaleDateString() }}</TableData>
                    </tr>
                </Table>
                <Pagination class="mt-6" :links="packages.links" />
            </div>
        </div>
    </AppLayout>
</template>
