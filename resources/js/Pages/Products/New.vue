<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { hasPermission } from '@/utils';


const props = defineProps({
    products: Object,
    product_categories: Object,
});

const form = useForm({
    _method: 'POST',
    name: '',
    ean_number: '',
    product_category_id: null,
    quantity: null
});

const AddProduct = () => {
    form.post(route('products.create'), {
        preserveScroll: true,
    });
}

</script>

<template>
    <AppLayout title="Producten Toevoegen" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Producten overzicht',
            href: route('products.index'),
        },
        {
            title: 'Producten toevoegen',
            href: '#',
        }
    ]" >

        <template #header>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
                <div>
                    <FormSection>
                        <template #title>
                            Product informatie
                        </template>

                        <template #description>
                            Vul alle invulvakken in over de producten
                        </template>

                        <template #form>
                            <div class="col-span-6 sm:col-span-4 w-full flex-auto">
                                <InputLabel for="name" value="Product Naam" />
                                <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="ean_number" value="EAN Nummer" />
                                <TextInput id="ean_number" v-model="form.ean_number" type="number"
                                    class="mt-1 block w-full"/>
                                <InputError :message="form.errors.ean_number" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="product_category_id" value="Categorie"/>
                                <select id="product_category_id" v-model="form.product_category_id" class="border-gray-300 focus:border-primary-300 focus:ring w-full sfocus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    <option v-for="product_category in product_categories" :value="product_category.id">
                                        {{ product_category.name }}
                                    </option>
                                </select>
                                <InputError :message="form.errors.product_category_id" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="quantity" value="Voorraad" />
                                <TextInput id="quantity" v-model="form.quantity" type="number"
                                    class="mt-1 block w-full" />
                                <InputError :message="form.errors.quantity" class="mt-2" />
                            </div>

                        </template>
                        <template #actions >
                            <div class="col-span-6 sm:col-span-4 w-full">
                                <PrimaryButton @click="AddProduct" class="col-span-6 sm:col-span-4 float-left">
                                  Opslaan
                                </PrimaryButton>
                            </div>
                        </template>
                    </FormSection>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
