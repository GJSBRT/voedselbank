<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from "@/Components/TextInput.vue";
import TextField from '@/Components/TextField.vue';

const form = useForm({
    _method: 'POST',
    company_name: '',
    address: '',
    email: '',
    phone_number: '',
    contact_name: '',
    notes: '',
});

const handleSubmit = () => {
    form.post(route('suppliers.create'), {
        preserveScroll: true,
    });
}

</script>

<template>
    <AppLayout title="Details van leveranciers" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Leveranciers overzicht',
            href: route('suppliers.index'),
        },
        {
            title: 'leveranciers Toevoegen',
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
                            Voeg een nieuwe leverancier toe
                        </template>

                        <template #description>
                            Je kunt hier een leverancier toevoegen.
                        </template>

                        <template #form>
                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="company_name" value="Bedrijfsnaam" />
                                <TextInput id="company_name" v-model="form.company_name" type="text" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.company_name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="address" value="Adres" />
                                <TextInput id="address" v-model="form.address" type="text" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.address" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="email" value="E-mailadres" />
                                <TextInput id="email" v-model="form.email" type="text" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.email" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="phone_number" value="Telefoonnummer" />
                                <TextInput id="phone_number" v-model="form.phone_number" type="text" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.phone_number" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="contact_name" value="Contact persoon" />
                                <TextInput id="contact_name" v-model="form.contact_name" type="text" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.contact_name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="notes" value="Notities" />
                                <TextField id="notes" v-model="form.notes" type="text" class="mt-1 block w-full" />
                                <InputError :message="form.errors.notes" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <PrimaryButton @click="handleSubmit">
                                    Leverancier toevoegen
                                </PrimaryButton>
                            </div>
                        </template>
                    </FormSection>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
