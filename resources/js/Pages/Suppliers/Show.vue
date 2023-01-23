<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
// import Table from '@/Components/Table.vue';
import TableData from '@/Components/TableData.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Inertia } from '@inertiajs/inertia';
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";

defineProps({
    suppliers: Object,
});

</script>

<template>
    <AppLayout title="Leveranciers">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Leveranciers
            </h2>

            <div class="ml-auto">
                <PrimaryButton @click="() => Inertia.visit(route('suppliers.new'))">
                    Nieuwe leverancier
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

<!--                <Table :meta="suppliers">-->
<!--                    <template #head>-->
<!--                        <tr>-->
<!--                            <th>#</th>-->
<!--                            <th>Bedrijfsnaam</th>-->
<!--                            <th>Telefoonnummer</th>-->
<!--                            <th>Contactpersoon</th>-->
<!--                            <th>Volgende levering</th>-->
<!--                        </tr>-->
<!--                    </template>-->

<!--                    <template #body>-->
<!--                        <tr class="hover:bg-gray-50 cursor-pointer" @click="Inertia.visit(route('suppliers.view', supplier.id))"-->
<!--                            v-for="(supplier, key) in suppliers.data"-->
<!--                            :key="key">-->
<!--                            <td>{{ supplier.id }}</td>-->
<!--                            <td>{{ supplier.company_name }}</td>-->
<!--                            <td>{{ supplier.phone_number }}</td>-->
<!--                            <td>{{ supplier.contact_name }}</td>-->
<!--                            <td>{{ supplier.id }}</td>-->
<!--                            <td>-->
<!--                                <span v-if="!supplier.next_deliveries[0] || !supplier.next_deliveries[0].expected_at" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-800">-->
<!--                                    Geen verwachte levering-->
<!--                                </span>-->
<!--                                <span v-else>-->
<!--                                    {{ new Date(supplier.next_deliveries[0].expected_at).toLocaleString() }}-->
<!--                                </span>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                    </template>-->
<!--                </Table>-->

                <Table
                    :meta="suppliers"
                    :resource="suppliers"
                    :striped="true"
                    :prevent-overlapping-requests="false"
                    :input-debounce-ms="1000"
                    :preserve-scroll="true"
                />

                <!--                <Table :headers="['#', 'Bedrijfsnaam', 'Telefoonnummer', 'Contact persoon', 'Volgende levering']">-->
<!--                    <tr class="hover:bg-gray-50 cursor-pointer" v-for="supplier in suppliers.data" :key="suppliers.id"-->
<!--                        @click="Inertia.visit(route('suppliers.view', supplier.id))">-->
<!--                        <TableData>{{ supplier.id }}</TableData>-->
<!--                        <TableData>{{ supplier.company_name }}</TableData>-->
<!--                        <TableData>{{ supplier.phone_number }}</TableData>-->
<!--                        <TableData>{{ supplier.contact_name }}</TableData>-->
<!--                        <TableData>-->
<!--                            <span v-if="!supplier.next_deliveries[0] || !supplier.next_deliveries[0].expected_at" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-800">-->
<!--                                Geen verwachte levering-->
<!--                            </span>-->
<!--                            <span v-else>-->
<!--                                {{ new Date(supplier.next_deliveries[0].expected_at).toLocaleString() }}-->
<!--                            </span>-->
<!--                        </TableData>-->
<!--                    </tr>-->
<!--                </Table>-->
<!--                <Pagination class="mt-6" :links="suppliers.links"/>-->
            </div>
        </div>
    </AppLayout>
</template>
