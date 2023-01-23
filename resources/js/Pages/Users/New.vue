<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    _method: 'POST',
    first_name: '',
    last_name: '',
    email: '',
    password: '',
});

const handleSubmit = () => {
    form.post(route('users.create'), {
        preserveScroll: true,
        onFinish: () => form.reset('password'),
    });
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
                                    <TextInput id="first_name" v-model="form.first_name" type="text" class="mt-1 block w-full"/>
                                </div>

                                <div>
                                    <InputLabel for="last_name" value="Achternaam" />
                                    <TextInput id="last_name" v-model="form.last_name" type="text" class="mt-1 block w-full"/>
                                </div>
                            </div>

                            <div class="col-span-6">
                                <InputLabel for="email" value="Email" />
                                <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full"/>
                            </div>

                            <div class="col-span-6">
                                <InputLabel for="password" value="Wachtwoord" />
                                <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full"/>
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
