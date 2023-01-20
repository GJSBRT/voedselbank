<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import TableData from '@/Components/TableData.vue';
import Pagination from '@/Components/Pagination.vue';
import {Link} from "@inertiajs/inertia-vue3";
import {Inertia} from '@inertiajs/inertia';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref} from "vue";


defineProps({
    customers: Object,
});

const confirmDelete = ref(null);

</script>

<template>
    <AppLayout title="Klanten overzicht">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Klanten overzicht
            </h2>

            <div class="ml-auto">
                <primary-button @click="() => Inertia.visit(route('customer.new'))">
                    Maak een klant aan
                </primary-button>
            </div>
        </template>
        <div class="mx-auto mt-6 ml-6">
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow sm:rounded-lg ">
                    <Table
                        :headers="['#','Naam', 'Achternaam', 'Volwassenen', 'Kinderen', 'Babies', 'Telefoonnummer']">
                        <tr @click="Inertia.visit(route('customer.view', customerData.id))" class="hover:bg-gray-50 cursor-pointer" v-for="customerData in customers.data"
                            :key="customerData.id">
                            <TableData>{{ customerData.id }}</TableData>
                            <TableData>{{ customerData.first_name }}</TableData>
                            <TableData>{{ customerData.last_name }}</TableData>
                            <TableData>{{ customerData.adult_amount }}</TableData>
                            <TableData>{{ customerData.child_amount }}</TableData>
                            <TableData>{{ customerData.baby_amount }}</TableData>
                            <TableData>{{ customerData.phone_number }}</TableData>
                        </tr>
                    </Table>
                </div>
                <Pagination class="mt-6" :links="customers.links"/>
            </div>
        </div>
    </AppLayout>
</template>
