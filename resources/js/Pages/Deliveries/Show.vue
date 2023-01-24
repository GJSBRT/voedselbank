<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import TableData from '@/Components/TableData.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Inertia } from '@inertiajs/inertia';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {ref} from "vue";
import { hasPermission } from '@/utils';

let props = defineProps({
    deliveries: Array,
    page: Number,
    show_delivered: Boolean
});

let show_delivered = ref(props.show_delivered);

function setShowDelivered(){
    show_delivered = !show_delivered;
    Inertia.get(route('deliveries.index'), { 'page': !props.page? '1' : props.page, 'show-delivered': show_delivered }, {
        preserveState: true,
        replace: true
    });
}
</script>

<template>
    <AppLayout title="Leveringen">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Leveringen
            </h2>

            <div class="ml-auto">
                <PrimaryButton v-if="hasPermission('deliveries:create')" @click="() => Inertia.visit(route('deliveries.new'))">
                    Plan een nieuwe levering in
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="sm:mb-10 mb-2">
                    <div class="ml-auto">
                        <SecondaryButton v-if="!show_delivered" @click="setShowDelivered">
                            Toon geleverde leveringen
                        </SecondaryButton>

                        <SecondaryButton v-if="show_delivered" @click="setShowDelivered">
                            Toon aankomende leveringen
                        </SecondaryButton>
                    </div>
                </div>

                <div v-if="show_delivered">
                    <Table :headers="['#', 'Bedrijfsnaam', 'Verwacht op', 'Geleverd op', 'Gemaakt op']">
                        <tr class="hover:bg-gray-50 cursor-pointer" v-for="delivery in deliveries.delivered.data" :key="deliveries.delivered.id"
                            @click="$inertia.visit(route('deliveries.view', delivery.id))">
                            <TableData>{{ delivery.id }}</TableData>
                            <TableData>{{ delivery.supplier.company_name }}</TableData>
                            <TableData>{{ new Date(delivery.expected_at).toLocaleString() }}</TableData>
                            <TableData>
                                <span v-if="delivery.delivered_at == null"
                                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-800">
                                    Nog niet geleverd
                                </span>
                                <span v-else>
                                    {{ new Date(delivery.delivered_at).toLocaleString() }}
                                </span>
                            </TableData>
                            <TableData>{{ new Date(delivery.created_at).toLocaleString() }}</TableData>
                        </tr>
                    </Table>
                    <Pagination class="mt-6" :links="deliveries.delivered.links" :extraQueries="'show-delivered='+show_delivered"/>
                </div>
                <div v-else>
                    <Table :headers="['#', 'Bedrijfsnaam', 'Verwacht op', 'Geleverd op', 'Gemaakt op']">
                        <tr class="hover:bg-gray-50 cursor-pointer" v-for="delivery in deliveries.not_delivered.data" :key="deliveries.not_delivered.id"
                            @click="$inertia.visit(route('deliveries.view', delivery.id))">
                            <TableData>{{ delivery.id }}</TableData>
                            <TableData>{{ delivery.supplier.company_name }}</TableData>
                            <TableData>{{ new Date(delivery.expected_at).toLocaleString() }}</TableData>
                            <TableData>
                                <span v-if="delivery.delivered_at == null"
                                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-800">
                                    Nog niet geleverd
                                </span>
                                <span v-else>
                                    {{ new Date(delivery.delivered_at).toLocaleString() }}
                                </span>
                            </TableData>
                            <TableData>{{ new Date(delivery.created_at).toLocaleString() }}</TableData>
                        </tr>
                    </Table>
                    <Pagination class="mt-6" :links="deliveries.not_delivered.links" :extraQueries="'show-delivered='+show_delivered"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
