<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import TableData from '@/Components/TableData.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Inertia } from '@inertiajs/inertia';
import { hasPermission } from '@/utils';
import TableSearch from "@/Components/Search/TableSearch.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

defineProps({
    users: Object,
});

function sort(state){
    Inertia.replace(route('users.index', {sort: state? 'created_at' : '-created_at' }));
}
</script>

<template>
    <AppLayout title="Mederwerkers Overzicht" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Medewerkers overzicht',
            href: route('users.index'),
        }
    ]">
        <template #header>
            <PrimaryButton v-if="hasPermission('users:create')" @click="() => Inertia.visit(route('users.new'))">
                Nieuwe Medewerker
            </PrimaryButton>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-5 flex">
                    <Dropdown align="left" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md border shadow-sm">
                                <button type="button" class="inline-flex items-center w-44 px-4 py-3 my-auto border border-transparent leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                    Aangemaakt Op
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
                    
                    <TableSearch route="users.index" placeholder="Zoeken op voornaam of email" class="w-full ml-4" />
                </div>

                <Table :headers="['Naam', 'Email', '2FA Ingeschakeld Op', 'Geblokkeerd op', 'Aangemaakt Op']" >
                    <tr @click="Inertia.visit(route('users.view', user.id))" class="hover:bg-gray-50 cursor-pointer" v-for="user in users.data" :key="user.id">
                        <TableData>{{ user.first_name }} {{ user.last_name }}</TableData>
                        <TableData>{{ user.email }}</TableData>
                        <TableData>
                            <span v-if="user.two_factor_confirmed_at == null" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-800">
                                Niet geactiveerd
                            </span>
                            <span v-else>
                                {{ new Date(user.two_factor_confirmed_at).toLocaleString() }}
                            </span>
                        </TableData>
                        <TableData>
                            <span v-if="user.suspended_at == null" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-green-100 text-green-800">
                                Niet geblokkeerd
                            </span>
                            <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-800">
                                Geblokkeerd
                            </span>
                        </TableData>
                        <TableData>{{ new Date(user.created_at).toLocaleString() }}</TableData>
                    </tr>
                </Table>
                <Pagination class="mt-6" :links="users.links" />
            </div>
        </div>
    </AppLayout>
</template>
