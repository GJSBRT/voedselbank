<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import RoleSearch from '@/Components/Search/RoleSearch.vue';

const form = useForm({
    _method: 'POST',
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    role_id: null,
});

const handleSubmit = () => {
    // If user has not selected a role, focus on the role search input.
    if (form.role_id === null) {
        document.getElementById('role').focus();
        return;
    }

    form.post(route('users.create'), {
        preserveScroll: true,
        onFinish: () => form.reset('password'),
    });
}

const setRole = (role) => {
    form.role_id = role.id
}
</script>

<template>
    <AppLayout title="Nieuwe Medewerker">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nieuwe Medewerker
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
                <div>
                    <FormSection>
                        <template #title>
                            Medewerker Informatie
                        </template>

                        <template #description>
                            Voer hier de informatie van de medewerker.
                        </template>

                        <template #form>
                            <div class="col-span-6 grid grid-cols-2 gap-4">
                                <div>
                                    <InputLabel for="first_name" value="Voornaam" />
                                    <TextInput id="first_name" v-model="form.first_name" type="text" required autofocus class="mt-1 block w-full"/>
                                </div>

                                <div>
                                    <InputLabel for="last_name" value="Achternaam" />
                                    <TextInput id="last_name" v-model="form.last_name" type="text" required class="mt-1 block w-full"/>
                                </div>
                            </div>

                            <div class="col-span-6 grid grid-cols-2 gap-4">
                                <div>
                                    <InputLabel for="email" value="Email" />
                                    <TextInput id="email" v-model="form.email" type="email" required class="mt-1 block w-full"/>
                                </div>

                                <div>
                                    <InputLabel for="role" value="Rol" class="mb-1"/>
                                    <RoleSearch id="role" :callback="setRole"/>
                                </div>
                            </div>

                            <div class="col-span-6">
                                <InputLabel for="password" value="Wachtwoord" />
                                <TextInput id="password" v-model="form.password" type="password" required class="mt-1 block w-full"/>
                            </div>
                        </template>
                        
                        <template #actions>
                            <PrimaryButton @click="handleSubmit">
                                Medewerker Toevoegen
                            </PrimaryButton>
                        </template>
                    </FormSection>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
