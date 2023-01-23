<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '../../Components/Table.vue';
import TableData from '../../Components/TableData.vue';
import Pagination from '../../Components/Pagination.vue';
import {Link} from "@inertiajs/inertia-vue3";
import {Inertia} from '@inertiajs/inertia';
import PrimaryButton from "../../Components/PrimaryButton.vue";
import {ref} from "vue";
import ConfirmationModal from '../../Components/ConfirmationModal.vue';
import DangerButton from '../../Components/DangerButton.vue';
import SecondaryButton from '../../Components/SecondaryButton.vue';


defineProps({
    category: Object,
});

const confirmDelete = ref(null);

</script>

<template>
    <AppLayout title="Customer Overview">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categorieën overzicht
            </h2>

            <div class="ml-auto">
                <primary-button @click="() => Inertia.visit(route('category.new'))">
                    Maak een nieuw product categorie aan
                </primary-button>
            </div>
        </template>
        <div class="mx-auto mt-6 ml-6">
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow sm:rounded-lg ">
                    <Table
                        :headers="['Naam']">
                        <tr @click="Inertia.visit(route('category.view', categoryData.id))"
                            class="hover:bg-gray-50 cursor-pointer" v-for="categoryData in category.data"
                            :key="categoryData.id">
                            <TableData>{{ categoryData.name }}</TableData>
                        </tr>
                    </Table>
                </div>
                <Pagination class="mt-6" :links="category.links"/>
            </div>
        </div>

        <ConfirmationModal :show="confirmDelete" @close="confirmDelete = null">
            <template #title>
                Verwijder Product
            </template>

            <template #content>
                Weet je het zeker dat je deze klant wil verwijderen? De klant zal permanent verwijderd worden.
            </template>

            <template #footer>
                <SecondaryButton @click.native="confirmDelete = null">
                    Nee
                </SecondaryButton>
                <!-- Is de variabel null? dan laat je niks zien, Is de variabel niet null dan laat je wel wat zien -->
                <DangerButton class="ml-2"
                              @click.native="Inertia.delete(route('customer.delete', confirmDelete)); confirmDelete = null">
                    Verwijder Klant
                </DangerButton>
            </template>
        </ConfirmationModal>
    </AppLayout>
</template>
