<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import RoleSearch from '@/Components/Search/RoleSearch.vue';
import InputError from '@/Components/InputError.vue';

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
    <AppLayout title="Nieuwe Medewerker" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Medewerkers overzicht',
            href: route('users.index'),
        },
        {
            title: 'Medewerkers toevoegen',
            href: '#',
        }
    ]">
        <template #header>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
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
                                <InputError :message="form.errors.first_name" class="mt-2"/>
                            </div>

                            <div>
                                <InputLabel for="last_name" value="Achternaam" />
                                <TextInput id="last_name" v-model="form.last_name" type="text" required class="mt-1 block w-full"/>
                                <InputError :message="form.errors.last_name" class="mt-2"/>
                            </div>
                        </div>

                        <div class="col-span-6 grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="email" value="Email" />
                                <TextInput id="email" v-model="form.email" type="email" required class="mt-1 block w-full"/>
                                <InputError :message="form.errors.email" class="mt-2"/>
                            </div>

                            <div>
                                <InputLabel for="role" value="Rol" class="mb-1"/>
                                <RoleSearch id="role" :callback="setRole"/>
                                <InputError :message="form.errors.role_id" class="mt-2"/>
                            </div>
                        </div>

                        <div class="col-span-6">
                            <InputLabel for="password" value="Wachtwoord" />
                            <TextInput id="password" v-model="form.password" type="password" required class="mt-1 block w-full"/>
                            <InputError :message="form.errors.password" class="mt-2"/>
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
    </AppLayout>
</template>
