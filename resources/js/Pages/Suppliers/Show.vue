<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import TableData from '@/Components/TableData.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Inertia } from '@inertiajs/inertia';

defineProps({
    suppliers: Object,
});

</script>

<template>
    <AppLayout title="Leveranciers" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Leveranciers overzicht',
            href: route('suppliers.index'),
        }
    ]">
        <template #header>


            <div class="ml-auto my-auto">
                <PrimaryButton @click="() => Inertia.visit(route('suppliers.new'))">
                    Nieuwe leverancier
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Table :headers="['#', 'Bedrijfsnaam', 'Telefoonnummer', 'Contact persoon', 'Volgende levering']">
                    <tr class="hover:bg-gray-50 cursor-pointer" v-for="supplier in suppliers.data" :key="suppliers.id"
                        @click="Inertia.visit(route('suppliers.view', supplier.id))">
                        <TableData>{{ supplier.id }}</TableData>
                        <TableData>{{ supplier.company_name }}</TableData>
                        <TableData>{{ supplier.phone_number }}</TableData>
                        <TableData>{{ supplier.contact_name }}</TableData>
                        <TableData>
                            <span v-if="!supplier.next_deliveries[0] || !supplier.next_deliveries[0].expected_at" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-800">
                                Geen verwachte levering
                            </span>
                            <span v-else>
                                {{ new Date(supplier.next_deliveries[0].expected_at).toLocaleString() }}
                            </span>
                        </TableData>
                    </tr>
                </Table>
                <Pagination class="mt-6" :links="suppliers.links"/>
            </div>
        </div>
    </AppLayout>
</template>
