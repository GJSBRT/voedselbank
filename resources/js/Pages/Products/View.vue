<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { toRefs } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';

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

const EditProduct = () => {
    form.post(route('products.update', products.value.id), {
        preserveScroll: true,
    });
}

const confirmingDelete = ref(false);

</script>

<template>
    <AppLayout title="Producten Bewerken" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Producten overzicht',
            href: route('products.index'),
        },
        {
            title: 'Producten Bewerken',
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
                            Op het product informatie pagina kan u alle informatie zien die beschikbaar is over het product
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

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="product_category_id" value="Product Categorie" />
                                <TextInput id="product_category_id" v-model="form.product_category_id" type="number"
                                    class="mt-1 block w-full" />
                                <InputError :message="form.errors.product_category_id" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="quantity" value="Voorraad" />
                                <TextInput id="quantity" v-model="form.quantity" type="number"
                                    class="mt-1 block w-full" />
                                <InputError :message="form.errors.quantity" class="mt-2" />
                            </div>

                        </template>
                        <template #actions>
                            <PrimaryButton @click="EditProduct">
                                Opslaan
                            </PrimaryButton>
                            <DangerButton @click="confirmingDelete = true" class="ml-4">
                                Verwijderen
                            </DangerButton>
                        </template>
                    </FormSection>
                </div>
            </div>
        </div>


        <ConfirmationModal :show="confirmingDelete" @close="confirmingDelete = false">
            <template #title>
                Verwijder Product
            </template>

            <template #content>
                Weet je het zeker dat je dit product wilt verwijderen? Dit product zal permanent verwijderd worden.
            </template>

            <template #footer>
                <SecondaryButton @click.native="confirmingDelete = false">
                    Nee
                </SecondaryButton>
                <!-- Is de variabel null? dan laat je niks zien, Is de variabel niet null dan laat je wel wat zien -->
                <DangerButton class="ml-2"
                    @click.native="Inertia.delete(route('products.delete', products.id)); confirmingDelete = false">
                    Verwijder Product
                </DangerButton>
            </template>
        </ConfirmationModal>

    </AppLayout>
</template>
