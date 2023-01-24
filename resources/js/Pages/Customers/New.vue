<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextField from '@/Components/TextField.vue';

const props = defineProps({
    customer: Object,
});

const form = useForm({
    _method: 'POST',
    first_name: '',
    last_name: '',
    email: '',
    address: '',
    phone_number: '',
    child_amount: 0,
    adult_amount: 0,
    baby_amount: 0,
    notes: '',
});

const handleSubmit = () => {
    form.post(route('customers.create'), {
        preserveScroll: true,
    });
}

</script>

<template>

     <AppLayout title="Klanten toevoegen" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Klant overzicht',
            href: route('customers.index'),
        },
        {
            title: 'Klanten Toevoegen',
            href: '#',
        }
    ]">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
        <FormSection>

            <template #title>
                Klant aanmaken
            </template>

            <template #description>
                Maak een klant aan waar je voedselpakketten voor kan maken. Onthoud:
                Er moet altijd één volwassen persoon aanwezig zijn.
            </template>

            <template #form>
                <div class="col-span-6 sm:col-span-4 w-full flex-auto">
                    <InputLabel for="first_name" value="Voornaam"/>
                    <TextInput
                        id="first_name"
                        v-model="form.first_name"
                        type="text"
                        class="mt-1 block w-full"
                        autocomplete="given-name"
                    />
                    <InputError :message="form.errors.first_name" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4 w-full">
                    <InputLabel for="last_name" value="Achternaam"/>
                    <TextInput
                        id="last_name"
                        v-model="form.last_name"
                        type="text"
                        class="mt-1 block w-full"
                        autocomplete="family-name"
                    />
                    <InputError :message="form.errors.last_name" class="mt-2"/>
                </div>

                <!-- Email -->
                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="email" value="Email Adres"/>
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.email" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="address" value="Adres"/>
                    <TextInput
                        id="address"
                        v-model="form.address"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.address" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="phone_number" value="telefoonnummer"/>
                    <TextInput
                        id="phone_number"
                        v-model="form.phone_number"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.phone_number" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="adult_amount" value="Volwassenen"/>
                    <TextInput
                        id="adult_amount"
                        v-model="form.adult_amount"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.adult_amount" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="child_amount" value="Kinderen"/>
                    <TextInput
                        id="child_amount"
                        v-model="form.child_amount"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.child_amount" class="mt-2"/>
                </div>


                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="baby_amount" value="Babies"/>
                    <TextInput
                        id="baby_amount"
                        v-model="form.baby_amount"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.baby_amount" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="notes" value="Notities"/>
                    <TextField
                        id="notes"
                        v-model="form.notes"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.notes" class="mt-2"/>
                </div>
            </template>


            <template #actions>
                <PrimaryButton @click="handleSubmit">
                    Toevoegen
                </PrimaryButton>
            </template>
        </FormSection>
            </div>
        </div>
    </AppLayout>
</template>
