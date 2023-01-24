<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import TableData from '@/Components/TableData.vue';
import Pagination from '@/Components/Pagination.vue';
import TableSearch from "@/Components/Search/TableSearch.vue";
import {Inertia} from '@inertiajs/inertia';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { hasPermission } from '@/utils';

defineProps({
    customers: Object,
});

</script>

<template>
    <AppLayout title="Klanten overzicht" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Klanten overzicht',
            href: route('customers.index'),
        }
    ]">
        <template #header>


            <div class="ml-auto my-auto">
                <primary-button v-if="hasPermission('customers:create')" @click="() => Inertia.visit(route('customers.new'))">
                    Maak een klant aan
                </primary-button>
            </div>
        </template>
        <div class="mx-auto mt-6 ml-6">
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <TableSearch route="customers.index" placeholder="Zoeken op voornaam, achternaam of telefoonnummer" class="my-5" />

                    <Table
                        :headers="['#','Naam', 'Achternaam', 'Volwassenen', 'Kinderen', 'Babies', 'Telefoonnummer']">
                        <tr @click="Inertia.visit(route('customers.view', customerData.id))" class="hover:bg-gray-50 cursor-pointer" v-for="customerData in customers.data"
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
                <Pagination class="mt-6" :links="customers.links"/>
            </div>
        </div>
    </AppLayout>
</template>
