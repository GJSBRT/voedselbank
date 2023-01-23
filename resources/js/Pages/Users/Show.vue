<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import TableData from '@/Components/TableData.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Inertia } from '@inertiajs/inertia';
import { hasPermission } from '@/utils';

defineProps({
    users: Object,
});

</script>

<template>
    <AppLayout title="Voedsel Pakketten">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Medewerker Beheer
            </h2>

            <div class="ml-auto">
                <PrimaryButton v-if="hasPermission('users:create')" @click="() => Inertia.visit(route('users.new'))">
                    Nieuwe Medewerker
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Table :headers="['#', 'Naam', 'Email', '2FA Ingeschakeld Op', 'Aangemaakt Op']" >
                    <tr @click="Inertia.visit(route('users.view', user.id))" class="hover:bg-gray-50 cursor-pointer" v-for="user in users.data" :key="user.id">
                        <TableData>{{ user.id }}</TableData>
                        <TableData>{{ user.first_name }} {{ user.last_name }}</TableData>
                        <TableData>{{ user.email }}</TableData>
                        <TableData>
                            <span v-if="user.two_factor_confirmed_at == null" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-800">
                                Niet Geactiveerd
                            </span>
                            <span v-else>
                                {{ new Date(user.two_factor_confirmed_at).toLocaleString() }}
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