<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '../../Components/Table.vue';
import TableData from '../../Components/TableData.vue';
import Pagination from '../../Components/Pagination.vue';
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    products: Object,
});

const form = useForm({
    _method: 'POST',
    name: products.data.name,
    ean_number: products.data.ean_number,
    category: products.data.category,
    quantity: products.data.quantity,
});

const verificationLinkSent = ref(null);

const Add_Product = () => {
    form.post(route('product.CreateProduct'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

</script>

<template>
    <FormSection @submitted="Add_Product">
        <template #title>
            Voeg nieuw product toe
        </template>

        <template #description>
            Vul hier uw nieuwe product gegevens in
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4 w-full">
                <InputLabel for="name" value="Naam" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="given-name"
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 w-full">
                <InputLabel for="ean_number" value="ea_nummer" />
                <TextInput
                    id="ean_number"
                    v-model="form.ean_number"
                    type="number"
                    class="mt-1 block w-full"
                    autocomplete="family-name"
                />
                <InputError :message="form.errors.ean_number" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="category" value="categorie" />
                <TextInput
                    id="category"
                    v-model="form.category"
                    type="text"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.category" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="quantity" value="Voorraad" />
                <TextInput
                    id="quantity"
                    v-model="form.quantity"
                    type="number"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.quantity" class="mt-2" />
            </div>
        </template>
    </FormSection>
</template>

