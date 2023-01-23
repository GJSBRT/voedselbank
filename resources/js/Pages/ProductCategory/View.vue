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
    category: Object,
});
const {category} = toRefs(props)
const form = useForm({
    _method: 'PATCH',
    name: category.value.name,
});
const handleSubmit = () => {
    form.post(route('category.update', category.value.id), {
        preserveScroll: true,
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
                Details van de categorie {{ category.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
                <div>
                    <FormSection @submitted="updateProfileInformation">
                        <template #title>
                            Categorie informatie
                        </template>

                        <template #description>
                            Pas hier de naam van de categorie aan of verwijder de categorie
                        </template>

                        <template #form>
                            <div class="col-span-6 sm:col-span-4 w-full flex-auto">
                                <InputLabel for="name" value="naam"/>
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.name" class="mt-2"/>
                            </div>
                        </template>


                        <template #actions>
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
                Verwijder een categorie
            </template>

            <template #content>
                Weet je het zeker dat je deze categorie wil verwijderen?
            </template>

            <template #footer>
                <SecondaryButton @click.native="confirmingDelete = false">
                    Nee
                </SecondaryButton>
                <DangerButton class="ml-2"
                              @click.native="Inertia.delete(route('category.delete', category.id));">
                    Verwijder categorie
                </DangerButton>
            </template>
        </ConfirmationModal>
    </AppLayout>
</template>
