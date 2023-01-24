<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextField from '@/Components/TextField.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from "@/Components/TextInput.vue";

defineProps({
    suppliers: Object,
});

const form = useForm({
    _method: 'POST',
    supplier_id: null,
    delivered_at: null,
    expected_at: null,
    notes: null,
});

const handleSubmit = () => {
    form.post(route('deliveries.create'), {
        preserveScroll: true,
    });
}

</script>

<template>
    <AppLayout title="Details van leveringen" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
        {
            title: 'Leveringen overzicht',
            href: route('deliveries.index'),
        },
        {
            title: 'Leveringen Toevoegen',
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
                            Plan een nieuwe levering in
                        </template>

                        <template #description>
                            Je kunt hier een nieuwe levering inplannen.
                        </template>

                        <template #form>
                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="supplier_id" value="Leverancier"/>
                                <select id="supplier_id" v-model="form.supplier_id" class="border-gray-300 focus:border-primary-300 focus:ring w-full sfocus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    <option v-for="supplier in suppliers" :value="supplier.id">{{ supplier.company_name }}</option>
                                </select>
                                <InputError :message="form.errors.supplier_id" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="delivered_at" value="Geleverd op"/>
                                <TextInput id="delivered_at" v-model="form.delivered_at" type="datetime-local" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.delivered_at" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="expected_at" value="Verwacht op"/>
                                <TextInput id="expected_at" v-model="form.expected_at" type="datetime-local" class="mt-1 block w-full"/>
                                <InputError :message="form.errors.expected_at" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <InputLabel for="notes" value="Notities"/>
                                <TextField id="notes" v-model="form.notes" type="text" class="mt-1 block w-full" />
                                <InputError :message="form.errors.notes" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4 w-full">
                                <PrimaryButton @click="handleSubmit">
                                    Inplannen
                                </PrimaryButton>
                            </div>
                        </template>
                    </FormSection>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
