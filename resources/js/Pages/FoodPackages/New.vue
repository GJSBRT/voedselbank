<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import TextField from '@/Components/TextField.vue';
import CustomerSearch from '@/Components/Search/CustomerSearch.vue';
import ProductSearch from '@/Components/Search/ProductSearch.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import BarcodeScanner from '@/Components/BarcodeScanner.vue'
import { ref } from 'vue';

defineProps({
    packages: Object,
});

const form = useForm({
    _method: 'POST',
    notes: '',
    customer: null,
    products: [],
});

const setCustomerId = (customer) => {
    form.customer = customer
}

const addProduct = (product) => {
    form.products.push(product)
}

const removeProduct = (index) => {
    form.products.splice(index, 1)
}

const handleSubmit = () => {
    form.post(route('food-packages.create'), {
        preserveScroll: true,
    });
}

const showScanner = ref(false);
const scanResult = ref(null);

const toggleScanner = () => {
    showScanner.value = !showScanner.value;
}

// Gets the scan result, lookup the product and add it to the form
async function onScan(scan) {
    if (scanResult.value != scan.text) {
        axios.get('/search/products', { params: { query: scan.text } })
            .then(response => {
                scanResult.value = scan.text + ' - ' + response.data[0].searchable.name;
                addProduct(response.data[0].searchable);
            })
            .catch(() => {
                scanResult.value = scan.text + ' - ' + 'Product niet gevonden';
            });

        setTimeout(() => {
            scanResult.value = null;
        }, 5000);
    }
}

</script>

<template>
    <AppLayout title="Voedselpakketten" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Voedselpakketten Overzicht',
            href: route('food-packages.index'),
        },
        {
            title: 'Voedselpakketten Toevoegen',
            href: '#',
        }
    ]">
        <template #header>
            
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
                <div>
                    <FormSection>
                        <template #title>
                            Pakket Informatie
                        </template>

                        <template #description>
                            Voer hier de gegevens in over het voedselpakket.
                        </template>

                        <template #form>
                            <div class="col-span-6">
                                <InputLabel for="customerId" value="Customer" />
                                <CustomerSearch id="customerId" :callback="setCustomerId" class="my-auto" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="notes" value="Notities" />
                                <TextField id="notes" v-model="form.notes" type="text" class="mt-1 block w-full" />
                                <InputError :message="form.errors.notes" class="mt-2" />
                            </div>
                        </template>
                    </FormSection>
                </div>

                <div class="sm:mt-10 mt-2">
                    <FormSection>
                        <template #title>
                            Producten
                        </template>

                        <template #description>
                            Voer hier alle producten in van dit pakket
                        </template>

                        <template #form>
                            <div class="col-span-6">
                                <InputLabel for="productId" value="Add product" />
                                <div class="flex">
                                    <div class="w-full my-auto">
                                        <ProductSearch id="productId" :callback="addProduct" />
                                    </div>
                                    <PrimaryButton class="ml-2 w-12" style="padding: 0px" @click="toggleScanner">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="m-2" fill="currentColor"
                                             viewBox="0 0 16 16">
                                            <path
                                                d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5zM3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-7zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7z" />
                                        </svg>
                                    </PrimaryButton>
                                </div>
                            </div>

                            <div class="col-span-6">
                                <div v-if="scanResult" class="p-2 rounded-md shadow bg-blue-300 border-2 border-blue-500 text-blue-500 mb-2">{{ scanResult }}</div>
                                <BarcodeScanner v-if="showScanner" :callback="onScan" />
                            </div>

                            <div class="col-span-6">
                                <InputLabel for="products" value="Product List" />
                                <div id="products">
                                    <div v-if="form.products.length == 0"
                                         class="w-full mt-1 border-gray-300 text-gray-500 border rounded-md shadow-sm p-2">
                                        Nog geen producten toegevoegd
                                    </div>

                                    <div v-else class="flex flex-col">
                                        <div v-for="(product, index) in form.products" :key="index" class="flex mb-1">
                                            <div
                                                class="w-full mt-1 border-gray-300 text-gray-500 border rounded-md shadow-sm p-2">
                                                {{ product.name }}
                                            </div>

                                            <SecondaryButton @click="() => removeProduct(index)"
                                                             class="ml-2 w-12 bg-red-500" style="padding: 0px">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="m-2" fill="white"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                    <path fill-rule="evenodd"
                                                          d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                </svg>
                                            </SecondaryButton>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </template>
                    </FormSection>
                </div>

                <div class="sm:mt-10 mt-2">
                    <FormSection>
                        <template #title>
                            Overzicht
                        </template>

                        <template #description>
                            Een kort overzicht over je voedsel pakket
                        </template>

                        <template #form>
                            <div class="col-span-6">
                                <div class="flex">
                                    <label class="text-md font-semibold">Klant:</label>
                                    <label class="ml-auto">{{
                                            form.customer ? (form.customer.first_name + ' ' +
                                                form.customer.last_name) : 'Geen klant gekozen'
                                        }}</label>
                                </div>

                                <div class="flex">
                                    <label class="text-md font-semibold">Aantal Producten:</label>
                                    <label class="ml-auto">{{ form.products.length }}</label>
                                </div>

                                <div class="flex flex-col">
                                    <label class="text-md font-semibold">Extra Notities:</label>
                                    <span>{{ form.notes ? form.notes : 'Geen extra notities' }}</span>
                                </div>
                            </div>
                        </template>

                        <template #actions>
                            <PrimaryButton @click="handleSubmit">
                                Pakket Opslaan
                            </PrimaryButton>
                        </template>
                    </FormSection>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
