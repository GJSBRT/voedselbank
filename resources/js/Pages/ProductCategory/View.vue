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
import { hasPermission } from '@/utils';

const props = defineProps({
    category: Object,
});
const {category} = toRefs(props)
const form = useForm({
    _method: 'PATCH',
    name: category.value.name,
});
const handleSubmit = () => {
    form.post(route('categories.update', category.value.id), {
        preserveScroll: true,
    });
}
const confirmingDelete = ref(false);
const confirmDelete = () => {
    confirmingDelete.value = true;
}
</script>

<template>
    <AppLayout title="Categorieën overzicht" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Categorieën overzicht',
            href: route('categories.index'),
        },
        {
            title: 'Details van categorie',
            href: '#',
        }
    ]">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
                <div>
                    <FormSection>
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
                            <PrimaryButton v-if="hasPermission('categories:update')" @click="handleSubmit">
                                Opslaan
                            </PrimaryButton>
                            <DangerButton v-if="hasPermission('categories:delete')" @click="confirmDelete" class="ml-4 ">
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
                              @click.native="Inertia.delete(route('categories.delete', category.id));">
                    Verwijder categorie
                </DangerButton>
                </template>
        </ConfirmationModal>
    </AppLayout>
</template>
