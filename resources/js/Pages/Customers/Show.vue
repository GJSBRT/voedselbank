<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '../../Components/Table.vue';
import TableData from '../../Components/TableData.vue';
import Pagination from '../../Components/Pagination.vue';
import {Link} from "@inertiajs/inertia-vue3";
import { Inertia } from '@inertiajs/inertia';


defineProps({
    customers: Object,
});

</script>

<template>
    <AppLayout title="Customer Overview">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Klanten overzicht
            </h2>
            <br>
            <div class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow w-44">
                <Link :href="route('customer.add')">
                Maak een klant aan
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow sm:rounded-lg ">
                    <Table :headers="['Naam', 'Achternaam', 'Volwassenen', 'Kinderen', 'Babies', 'Telefoonnummer', '', '']" >
                        <tr class="hover:bg-gray-50 cursor-pointer" v-for="customerData in customers.data" :key="customerData.id">
                            <TableData>{{ customerData.first_name }}</TableData>
                            <TableData>{{ customerData.last_name }}</TableData>
                            <TableData>{{ customerData.adult_amount }}</TableData>
                            <TableData>{{ customerData.child_amount }}</TableData>
                            <TableData>{{ customerData.baby_amount }}</TableData>
                            <TableData>{{ customerData.phone_number }}</TableData>
                            <table-data @click="Inertia.visit(route('customer.view', customerData.id))"  class="font-bold" >Wijzig </table-data>
                            <table-data  @click="Inertia.visit(route('customer.confirmation', customerData.id))" class="font-bold"> Verwijderen</table-data>
                        </tr>
                    </Table>
                    <Pagination class="mt-6" :links="customers.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
