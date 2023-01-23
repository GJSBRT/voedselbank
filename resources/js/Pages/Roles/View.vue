<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { toRefs } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';

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
</script>

<template>
    <AppLayout title="Rol Bewerken" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Rollen Overzicht',
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
                                <InputLabel for="permissions" value="Permissions" />

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
                            <PrimaryButton @click="handleSubmit">
                                Rol Opslaan
                            </PrimaryButton>
                        </template>
                    </FormSection>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
