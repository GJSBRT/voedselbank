<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import FormSection from '@/Components/FormSection.vue';
import TableData from '@/Components/TableData.vue';
import Pagination from '@/Components/Pagination.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import {Inertia} from '@inertiajs/inertia';
import {ref, toRefs} from 'vue';
import TextInput from "@/Components/TextInput.vue";
import TextField from '@/Components/TextField.vue';
import { hasPermission } from '@/utils';

const props = defineProps({
    supplier: Object,
    deliveries: Object
});

const { supplier } = toRefs(props);

const confirmingSupplierDeletion = ref(false);

const confirmSupplierDeletion = () => {
    confirmingSupplierDeletion.value = true;
};

const form = useForm({
    _method: 'PATCH',
    company_name: supplier.value.company_name,
    address: supplier.value.address,
    email: supplier.value.email,
    phone_number: supplier.value.phone_number,
    contact_name: supplier.value.contact_name,
    notes: supplier.value.notes,
});

const handleSubmit = () => {
    form.post(route('suppliers.update', supplier.value.id), {
        preserveScroll: true,
    });
}

function destroy(id) {
    Inertia.delete(route("suppliers.delete", id));
}

</script>

<template>
    <AppLayout title="Details van leveranciers bewerken" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Leveranciers overzicht',
            href: route('suppliers.index'),
        },
        {
            title: 'leveranciers Bewerken',
            href: '#',
        }
    ]">
        <template #header>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="sm:mt-10 mt-2">
                    <FormSection>
                        <template #title>
                            Informatie over de leverancier
                        </template>

                        <template #description>
                            Je kunt hier de leverancier wijzigen.
                        </template>

                        <template #form>
                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="company_name" value="Bedrijfsnaam" />
                                <TextInput id="company_name" v-model="form.company_name" type="text" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.company_name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="address" value="Adres" />
                                <TextInput id="address" v-model="form.address" type="text" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.address" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="email" value="E-mailadres" />
                                <TextInput id="email" v-model="form.email" type="text" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.email" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="phone_number" value="Telefoonnummer" />
                                <TextInput id="phone_number" v-model="form.phone_number" type="text" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.phone_number" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="contact_name" value="Contact persoon" />
                                <TextInput id="contact_name" v-model="form.contact_name" type="text" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.contact_name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="notes" value="Notities" />
                                <TextField id="notes" v-model="form.notes" type="text" class="mt-1 block w-full" />
                                <InputError :message="form.errors.notes" class="mt-2" />
                            </div>
                        </template>

                        <template #actions>
                            <div class="col-span-6 sm:col-span-4 w-full">
                                <PrimaryButton v-if="hasPermission('suppliers:update')" class="mr-4" @click="handleSubmit">
                                    Gegevens wijzigen
                                </PrimaryButton>
                                <DangerButton v-if="hasPermission('suppliers:delete')" @click="confirmSupplierDeletion">
                                    Leverancier verwijderen
                                </DangerButton>
                            </div>
                        </template>
                    </FormSection>
                </div>

                <div v-if="hasPermission('deliveries:read')" class="sm:mt-10 mt-2">
                    <FormSection>
                        <template #title>
                            Leveringen
                        </template>

                        <template #form>
                            <div class="col-span-6">
                                <Table :headers="['#', 'Verwacht op', 'Geleverd op', 'Gemaakt op']">
                                    <tr class="hover:bg-gray-50 cursor-pointer" v-for="delivery in deliveries.data"
                                        :key="deliveries.data.id"
                                        @click="$inertia.visit(route('deliveries.view', delivery.id))">
                                        <TableData>{{ delivery.id }}</TableData>
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
                                <Pagination class="mt-6" :links="deliveries.links"/>
                            </div>
                        </template>
                    </FormSection>
                </div>
            </div>
        </div>

        <ConfirmationModal :show="confirmingSupplierDeletion" @close="confirmingSupplierDeletion = false">
            <template #title>
                Leverancier verwijderen
            </template>

            <template #content>
                Weet je zeker dat je de leverancier wil verwijderen? Door de leverancier te verwijderen, worden ook alle leveringen
                van deze leverancier verwijderd!
            </template>

            <template #footer>
                <SecondaryButton @click.native="confirmingSupplierDeletion = false">
                    Ga terug
                </SecondaryButton>

                <DangerButton class="ml-2" @click.native="destroy(supplier.id)" :class="{ 'opacity-25': form.processing }"
                              :disabled="form.processing">
                    Verwijder leverancier
                </DangerButton>
            </template>
        </ConfirmationModal>
    </AppLayout>
</template>
