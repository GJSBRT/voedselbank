<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '../../Components/Table.vue';
import TableData from '../../Components/TableData.vue';
import Pagination from '../../Components/Pagination.vue';

defineProps({
    Customers: Object,
});

</script>

<template>
    <AppLayout title="Food Packages">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Food Packages
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                    <Table :headers="['#', 'Klant', 'Aantal Producten', 'Opgehaald op']" >
                        <tr class="hover:bg-gray-50 cursor-pointer" v-for="packageItem in packages.data" :key="packages.id">
                            <TableData>{{ packageItem.id }}</TableData>
                            <TableData>{{ packageItem.customer.first_name }}</TableData>
                            <TableData>{{ packageItem.items.length }}</TableData>
                            <TableData>
                                <span v-if="packageItem.retrieved_at == null" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-800">
                                    Nog niet opgehaald
                                </span>
                                <span v-else class="px-2 inline-flex text-xs leading-5">
                                    {{new Date(packageItem.retrieved_at).toLocaleDateString()}}
                                </span>
                            </TableData>
                        </tr>
                    </Table>
                    <Pagination class="mt-6" :links="packages.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
