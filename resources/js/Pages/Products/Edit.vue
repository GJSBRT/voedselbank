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
    products: Object,
});

const { products } = toRefs(props)

const form = useForm({
    _method: 'PATCH',
    name: products.value.name,
    ean_number: products.value.ean_number,
    product_category_id: products.value.product_category_id,
    quantity: products.value.quantity
});

const AddProduct = () => {
    form.post(route('product.EditProduct', products.value.id), {
        preserveScroll: true,
    });
}

</script>

<template>
    <AppLayout title="Customer Overview">
    <FormSection @submitted="updateProfileInformation" class="flex justify-center items-center">

        <template #form>
            <div class="col-span-6 sm:col-span-4 w-full flex-auto">
                <InputLabel for="name" value="Product Naam" />
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
                <InputLabel for="ean_number" value="Ean Nummer" />
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
                <InputLabel for="product_category_id" value="Product Categorie" />
                <TextInput
                    id="product_category_id"
                    v-model="form.product_category_id"
                    type="number"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.product_category_id" class="mt-2" />
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


        <template #actions>
            <PrimaryButton @click="AddProduct">
                Opslaan
            </PrimaryButton>
        </template>
    </FormSection>
        </AppLayout>
</template>