<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import { ref, toRefs } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { hasPermission } from '@/utils';
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    role: Object,
    available_permissions: Array,
});

const { role, available_permissions } = toRefs(props);

const form = useForm({
    _method: 'PATCH',
    name: role.value.name,
    permissions: JSON.parse(role.value.permissions),
});

const handleSubmit = () => {
    form.post(route('roles.update', role.value.id), {
        preserveScroll: true,
    });
}

const processingRoleDeletion = ref(false);
const confirmingRoleDeletion = ref(false);

const deleteRole = () => {
    processingRoleDeletion.value = true;
    axios.delete(route('roles.delete', role.value.id))
        .then(() => {
            processingRoleDeletion.value = false;
            Inertia.visit(route('roles.index'))
            Inertia.visit(route('roles.index'));
        }).catch((error) => {
            processingRoleDeletion.value = false;
            console.log(error);
            Inertia.visit(route('roles.index'));
        });
}
</script>

<template>
    <AppLayout title="Rol Bewerken" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Rollen overzicht',
            href: route('roles.index'),
        },
        {
            title: 'Rollen bewerken',
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
                            Rol
                        </template>

                        <template #description>
                            Beheer hier de rol.
                        </template>

                        <template #form>
                            <div class="col-span-6">
                                <InputLabel for="name" value="Naam" />
                                <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" />
                            </div>

                            <div v-if="available_permissions.length > 0" class="col-span-6">
                                <InputLabel for="permissions" value="Permissies" />

                                <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div v-for="permission in available_permissions" :key="permission">
                                        <label class="flex items-center">
                                            <Checkbox v-model:checked="form.permissions" :value="permission" />
                                            <span class="ml-2 text-sm text-gray-600">{{ permission }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <template #actions>
                            <DangerButton v-if="hasPermission('roles:delete')" @click="confirmingRoleDeletion = true" class="mr-2">
                                Verwijder
                            </DangerButton>

                            <PrimaryButton v-if="hasPermission('roles:update')" @click="handleSubmit">
                                Rol Opslaan
                            </PrimaryButton>
                        </template>
                    </FormSection>
                </div>
            </div>
        </div>

        <ConfirmationModal :show="confirmingRoleDeletion" @close="confirmingRoleDeletion = false">
            <template #title>
                Rol Verwijderen
            </template>

            <template #content>
                Weet je zeker dat je deze rol wilt verwijderen?
            </template>

            <template #footer>
                <SecondaryButton @click.native="confirmingRoleDeletion = false" :class="{ 'opacity-25': processingRoleDeletion }" :disabled="processingRoleDeletion">
                    Annuleer
                </SecondaryButton>

                <DangerButton class="ml-2" @click.native="deleteRole" :class="{ 'opacity-25': processingRoleDeletion }" :disabled="processingRoleDeletion">
                    Verwijder Rol
                </DangerButton>
            </template>
        </ConfirmationModal>
    </AppLayout>
</template>
