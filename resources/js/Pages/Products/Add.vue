<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import SecondaryButton from '../../Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';


defineProps({
    products: Object,
});

const form = useForm({
    method: 'POST',
    name: '',
    ean_number: 0,
    product_category_id: '',
    quantity: ''
})

const CreateProduct = () => {
    form.post(route('product.CreateProduct'), {

        preserveScroll: true,
    });
};


</script>

<template>
    <AppLayout title="Food products" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'producten',
            href: route('product.index'),
        },
        {
            title: 'producten toevoegen',
            href: route('product.CreateProduct'),
        }
    ]" >
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Voeg producten toe
            </h2>
        </template>
        <FormSection @submitted="CreateProduct">
        <template #form >

            <div class="col-span-6 sm:col-span-4 w-full flex-auto">
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

            <div class="col-span-6 sm:col-span-4 w-full flex-auto">
                <InputLabel for="ean_number" value="Ean Nummer" />
                <TextInput
                    id="ean_number"
                    v-model="form.ean_number"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="given-name"
                />
                <InputError :message="form.errors.ean_number" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 w-full flex-auto">
                <InputLabel for="product_category_id" value="Product Categorie" />
                <TextInput
                    id="product_category_id"
                    v-model="form.product_category_id"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="given-name"
                />
                <InputError :message="form.errors.product_category_id" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 w-full flex-auto">
                <InputLabel for="quantity" value="Voorraad" />
                <TextInput
                    id="quantity"
                    v-model="form.quantity"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="given-name"
                />
                <InputError :message="form.errors.quantity" class="mt-2" />
            </div>

        </template>
    </FormSection>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                Opgeslagen.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Toevoegen
            </PrimaryButton>
        </template>

    </AppLayout>
</template>

