<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {Inertia} from "@inertiajs/inertia";
import {ref, toRefs} from 'vue';

const props = defineProps({
    customer: Object,
});

const {customer} = toRefs(props)

const form = useForm({
    _method: 'PATCH',
    first_name: customer.value.first_name,
    last_name: customer.value.last_name,
    email: customer.value.email,
    address: customer.value.address,
    phone_number: customer.value.phone_number,
    child_amount: customer.value.child_amount,
    adult_amount: customer.value.adult_amount,
    baby_amount: customer.value.baby_amount,
    notes: customer.value.notes,
});

const handleSubmit = () => {
    form.post(route('customers.update', customer.value.id), {
        preserveScroll: true,
    });
}

const exportPdf = () => {

    axios.get(route('customers.export', customer.value.id),{ responseType: 'blob' })
    .then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'account_gegevens_' + customer.value.first_name + '_' + customer.value.id + '.pdf');
        document.body.appendChild(link);
        link.click();
    });
}

const confirmingDelete = ref(false);

const confirmDelete = () => {
    confirmingDelete.value = true;
}


</script>

<template>
    <AppLayout title="Klanten overzicht">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Details van de klant {{ customer.first_name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
                <div>
                    <FormSection @submitted="updateProfileInformation">
                        <template #title>
                            Klant informatie
                        </template>

                        <template #description>
                            Op de klant informatie pagina kan u alle informatie zien die beschikbaar is over de klant
                        </template>

                        <template #form>
                            <div class="col-span-6 sm:col-span-4 w-full flex-auto">
                                <InputLabel for="first_name" value="Voornaam"/>
                                <TextInput
                                    id="first_name"
                                    v-model="form.first_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autocomplete="given-name"
                                />
                                <InputError :message="form.errors.first_name" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="last_name" value="Achternaam"/>
                                <TextInput
                                    id="last_name"
                                    v-model="form.last_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autocomplete="family-name"
                                />
                                <InputError :message="form.errors.last_name" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="email" value="Email Adres"/>
                                <TextInput
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.email" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="address" value="Adres"/>
                                <TextInput
                                    id="address"
                                    v-model="form.address"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.address" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="phone_number" value="telefoonnummer"/>
                                <TextInput
                                    id="phone_number"
                                    v-model="form.phone_number"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.phone_number" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="adult_amount" value="Volwassenen"/>
                                <TextInput
                                    id="adult_amount"
                                    v-model="form.adult_amount"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.adult_amount" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="child_amount" value="Kinderen"/>
                                <TextInput
                                    id="child_amount"
                                    v-model="form.child_amount"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.child_amount" class="mt-2"/>
                            </div>


                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="baby_amount" value="Babies"/>
                                <TextInput
                                    id="baby_amount"
                                    v-model="form.baby_amount"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.baby_amount" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="notes" value="Notities"/>
                                <TextInput
                                    id="notes"
                                    v-model="form.notes"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.notes" class="mt-2"/>
                            </div>
                        </template>


                        <template #actions>
                            <SecondaryButton class="mr-4" @click="exportPdf">
                                Exporteer als PDF
                            </SecondaryButton>
                            <PrimaryButton @click="handleSubmit">
                                Opslaan
                            </PrimaryButton>
                            <DangerButton @click="confirmDelete" class="ml-4 ">
                                Verwijderen
                            </DangerButton>
                        </template>
                    </FormSection>
                </div>
            </div>
        </div>

        <ConfirmationModal :show="confirmingDelete" @close="confirmingDelete = false">
            <template #title>
                Verwijder klant
            </template>

            <template #content>
                Weet je het zeker dat je deze klant wil verwijderen? De klant zal permanent verwijderd worden.
            </template>

            <template #footer>
                <SecondaryButton @click.native="confirmingDelete = false">
                    Nee
                </SecondaryButton>

                <DangerButton class="ml-2" @click.native="Inertia.delete(route('customers.delete', customer.id));">
                    Verwijder Klant
                </DangerButton>
            </template>
        </ConfirmationModal>
    </AppLayout>
</template>
