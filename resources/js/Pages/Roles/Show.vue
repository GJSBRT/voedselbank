<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '../../Components/Table.vue';
import TableData from '../../Components/TableData.vue';
import Pagination from '../../Components/Pagination.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import { Inertia } from '@inertiajs/inertia';
import { HasPermission } from '@/utils';

defineProps({
    roles: Object,
});

</script>

<template>
    <AppLayout title="Rollen">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rollen Beheer
            </h2>

            <div class="ml-auto">
                <PrimaryButton v-if="HasPermission('roles:create')" @click="() => Inertia.visit(route('roles.new'))">
                    Nieuwe Rol
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Table :headers="['#', 'Naam', 'Aantal Permissies']" >
                    <tr @click="Inertia.visit(route('roles.view', role.id))" class="hover:bg-gray-50 cursor-pointer" v-for="role in roles.data" :key="role.id">
                        <TableData>{{ role.id }}</TableData>
                        <TableData>{{ role.name }}</TableData>
                        <TableData>{{ JSON.parse(role.permissions).length }}</TableData>
                    </tr>   
                </Table>
                <Pagination class="mt-6" :links="roles.links" />
            </div>
        </div>
    </AppLayout>
</template>
