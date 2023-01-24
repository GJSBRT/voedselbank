<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import TableData from '@/Components/TableData.vue';
import Pagination from '@/Components/Pagination.vue';
import {Inertia} from '@inertiajs/inertia';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref} from "vue";
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { hasPermission } from '@/utils';

defineProps({
    category: Object,
});

const confirmDelete = ref(null);

</script>

<template>
    <AppLayout title="Categorie overzicht" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Categorieën overzicht',
            href: route('categories.index')
        }
    ]">

        <template #header>
            <div class="ml-auto my-auto">
                <primary-button v-if="hasPermission('categories:create')" @click="() => Inertia.visit(route('categories.new'))">
                    Maak een nieuw product categorie aan
                </primary-button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow sm:rounded-lg ">
                    <Table
                        :headers="['Naam']">
                        <tr @click="Inertia.visit(route('categories.view', categoryData.id))"
                            class="hover:bg-gray-50 cursor-pointer" v-for="categoryData in category.data"
                            :key="categoryData.id">
                            <TableData>{{ categoryData.name }}</TableData>
                        </tr>
                    </Table>
                </div>
                <Pagination class="mt-6" :links="category.links"/>
            </div>
        </div>
    </AppLayout>
</template>
