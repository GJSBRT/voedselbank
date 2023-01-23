<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, toRefs } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import RoleSearch from '@/Components/Search/RoleSearch.vue';
import DangerButton from '@/Components/DangerButton.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { hasPermission } from '@/utils';
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    user: Object,
    two_factor_enabled: Boolean,
    suspended: Boolean
});

const { user, two_factor_enabled, suspended } = toRefs(props);

const form = useForm({
    _method: 'PATCH',
    user: user.value,
    two_factor_enabled: two_factor_enabled.value,
    suspended: suspended.value
});

const handleSubmit = () => {
    form.post(route('users.update', user.value.id), {
        preserveScroll: true,
    });
}

const setRole = (role) => {
    form.user.role_id = role.id
}

const confirmingUserDeletion = ref(false);
const processingDeletion = ref(false);

const deleteUser = () => {
    processingDeletion.value = true;
    axios.delete(route('users.delete', user.value.id))
        .then(() => {
            confirmingUserDeletion.value = false;
            Inertia.visit(route('users.index'));
        })
        .catch(() => {
            processingDeletion.value = false;
            confirmingUserDeletion.value = false;
        })
    Inertia.visit(route('users.index'));
}
</script>

<template>
    <ConfirmationModal :show="confirmingUserDeletion" @close="confirmingUserDeletion = false">
        <template #title>
            Medewerker Verwijderen
        </template>

        <template #content>
            Weet je zeker dat je deze medewerker wilt verwijderen? Dit kan niet ongedaan worden gemaakt.
        </template>

        <template #footer>
            <SecondaryButton @click.native="confirmingUserDeletion = false">
                Annuleer
            </SecondaryButton>

            <DangerButton class="ml-2" @click="deleteUser" :class="{ 'opacity-25': processingDeletion }" :disabled="processingDeletion">
                Verwijder Medewerker
            </DangerButton>
        </template>
    </ConfirmationModal>


    <AppLayout title="Medewerker bewerken" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Medewerkers Overzicht',
            href: route('users.index'),
        },
        {
            title: 'Medewerkers Bewerken',
            href: '#',
        }
    ]">
        <template #header>
            
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
                <div>
                    <FormSection>
                        <template #title>
                            Medewerker Informatie
                        </template>

                        <template #description>
                            Bewerk hier de informatie van de medewerker.
                        </template>

                        <template #form>
                            <div class="col-span-6 grid grid-cols-2 gap-4">
                                <div>
                                    <InputLabel for="first_name" value="Voornaam" />
                                    <TextInput id="first_name" v-model="form.user.first_name" type="text" class="mt-1 block w-full"/>
                                    <InputError :message="form.errors.first_name" class="mt-2"/>
                                </div>

                                <div>
                                    <InputLabel for="last_name" value="Achternaam" />
                                    <TextInput id="last_name" v-model="form.user.last_name" type="text" class="mt-1 block w-full"/>
                                    <InputError :message="form.errors.last_name" class="mt-2"/>
                                </div>
                            </div>

                            <div class="col-span-6">
                                <InputLabel for="email" value="Email" />
                                <TextInput id="email" v-model="form.user.email" type="text" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.email" class="mt-2"/>
                            </div>

                            <div class="col-span-6">
                                <InputLabel for="role" value="Rol" />
                                <RoleSearch id="role" :callback="setRole" :value="user.role.name"/>
                                <InputError :message="form.errors.role" class="mt-2"/>
                            </div>

                            <div class="grid grid-cols-2 gap-4 col-span-6">
                                <div>
                                    <Checkbox v-model:checked="form.two_factor_enabled" :value="null" :disabled="user.two_factor_confirmed_at == null"/>
                                    <span class="ml-2 text-sm text-gray-600">Twee Factor Authentictie</span>
                                </div>

                                <div>
                                    <Checkbox v-model:checked="form.suspended" :value="form.suspended"/>
                                    <span class="ml-2 text-sm text-gray-600">Geblokkeerd</span>
                                </div>
                            </div>
                        </template>

                        <template #actions>
                            <DangerButton v-if="hasPermission('users:delete')" class="mr-2" @click.native="confirmingUserDeletion = true">
                                Medewerker Verwijderen
                            </DangerButton>

                            <PrimaryButton @click="handleSubmit">
                                Medewerker Opslaan
                            </PrimaryButton>
                        </template>
                    </FormSection>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
