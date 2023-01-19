<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import SecondaryButton from '../../Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { toRefs } from 'vue';

const props = defineProps({
    customer: Object,
});

const { customer } = toRefs(props)

const form = useForm({
    _method: 'PATCH',
    first_name: customer.value.first_name,
    last_name: customer.value.last_name,
    email: customer.value.email,
    address: customer.value.address,
    phone_number: customer.value.phone_number,
    child_amount: customer.value.child_amount,
    adult_amount: customer.value.adult_amount,
    baby_amount: customer.value.baby_amount,
    notes: customer.value.notes,
});

const handleSubmit = () => {
    form.post(route('customer.update', customer.value.id), {
        preserveScroll: true,
    });
}

</script>

<template>
    <AppLayout title="Customer Overview">
        <FormSection @submitted="updateProfileInformation" class="flex justify-center items-center">

            <template #form>
                <div class="col-span-6 sm:col-span-4 w-full flex-auto">
                    <InputLabel for="first_name" value="Voornaam" />
                    <TextInput
                        id="first_name"
                        v-model="form.first_name"
                        type="text"
                        class="mt-1 block w-full"
                        autocomplete="given-name"
                    />
                    <InputError :message="form.errors.first_name" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4 w-full">
                    <InputLabel for="last_name" value="Achternaam" />
                    <TextInput
                        id="last_name"
                        v-model="form.last_name"
                        type="text"
                        class="mt-1 block w-full"
                        autocomplete="family-name"
                    />
                    <InputError :message="form.errors.last_name" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="email" value="Email Adres" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.email" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="address" value="Adres" />
                    <TextInput
                        id="address"
                        v-model="form.address"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.address" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="phone_number" value="telefoonnummer" />
                    <TextInput
                        id="phone_number"
                        v-model="form.phone_number"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.phone_number" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="adult_amount" value="Volwassenen" />
                    <TextInput
                        id="adult_amount"
                        v-model="form.adult_amount"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.adult_amount" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="child_amount" value="Kinderen" />
                    <TextInput
                        id="child_amount"
                        v-model="form.child_amount"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.child_amount" class="mt-2" />
                </div>


                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="baby_amount" value="Babies" />
                    <TextInput
                        id="baby_amount"
                        v-model="form.baby_amount"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.baby_amount" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="notes" value="Notities" />
                    <TextInput
                        id="notes"
                        v-model="form.notes"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.notes" class="mt-2" />
                </div>
            </template>


            <template #actions>
                <PrimaryButton @click="handleSubmit">
                    Opslaan
                </PrimaryButton>
            </template>
        </FormSection>
    </AppLayout>
</template>
