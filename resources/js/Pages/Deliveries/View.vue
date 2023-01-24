<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {ref, toRefs} from 'vue';
import TextInput from "@/Components/TextInput.vue";
import TextField from '@/Components/TextField.vue';
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import {Inertia} from '@inertiajs/inertia';
import { hasPermission } from '@/utils';

const props = defineProps({
    delivery: Object,
    suppliers: Object,
});

const {delivery} = toRefs(props);

const confirmingCancelDelivery = ref(false);

const confirmCancelDelivery = () => {
    confirmingCancelDelivery.value = true;
};

const form = useForm({
    _method: 'PATCH',
    supplier_id: delivery.value.supplier_id,
    delivered_at: delivery.value.delivered_at ?
        new Date(new Date(delivery.value.delivered_at).setSeconds(0)).toISOString().replace("T", " ").replace("Z", "")
        : null,
    expected_at: new Date(new Date(delivery.value.expected_at).setSeconds(0)).toISOString().replace("T", " ").replace("Z", ""),
    notes: delivery.value.notes,
});

const handleSubmit = () => {
    form.post(route('deliveries.update', delivery.value.id), {
        preserveScroll: true,
    });
}

function destroy(id) {
    Inertia.delete(route("deliveries.delete", id));
}

</script>

<template>
    <AppLayout title="Details van leveringen bewerken" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Leveringen overzicht',
            href: route('deliveries.index'),
        },
        {
            title: `Leveringen #${delivery.id} bewerken`,
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
                            Informatie over de levering
                        </template>

                        <template #description>
                            Je kunt hier de levering wijzigen.
                        </template>

                        <template #form>
                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="supplier_id" value="Leverancier"/>
                                <select id="supplier_id" v-model="form.supplier_id" class="border-gray-300 focus:border-primary-300 focus:ring w-full sfocus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    <option v-for="supplier in suppliers" :value="supplier.id">
                                        {{ supplier.company_name }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="delivered_at" value="Geleverd op"/>
                                <TextInput id="delivered_at" v-model="form.delivered_at" type="datetime-local" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.delivered_at" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="expected_at" value="Verwacht op"/>
                                <TextInput id="expected_at" v-model="form.expected_at" type="datetime-local" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.expected_at" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="notes" value="Notities"/>
                                <TextField id="notes" v-model="form.notes" type="text" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.notes" class="mt-2"/>
                            </div>
                        </template>

                        <template v-if="hasPermission('deliveries:update')" #actions>
                            <div class="col-span-6 sm:col-span-4 w-full">
                                <DangerButton v-if="!delivery.delivered_at" class="mr-4" @click="confirmCancelDelivery">
                                    Levering annuleren
                                </DangerButton>
                                <PrimaryButton @click="handleSubmit">
                                    Gegevens wijzigen
                                </PrimaryButton>
                            </div>
                        </template>
                    </FormSection>
                </div>
            </div>
        </div>

        <ConfirmationModal :show="confirmingCancelDelivery" @close="confirmingCancelDelivery = false">
            <template #title>
                Levering annuleren
            </template>

            <template #content>
                Weet je zeker dat je de levering wil annuleren? Door de levering te annuleren, verdwijnt deze uit het overzicht.
            </template>

            <template #footer>
                <SecondaryButton @click.native="confirmingCancelDelivery = false">
                    Ga terug
                </SecondaryButton>

                <DangerButton class="ml-2" @click.native="destroy(delivery.id)" :class="{ 'opacity-25': form.processing }"
                              :disabled="form.processing">
                    Annuleer levering
                </DangerButton>
            </template>
        </ConfirmationModal>
    </AppLayout>
</template>
