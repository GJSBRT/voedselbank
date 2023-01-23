<script setup xmlns="http://www.w3.org/1999/html">
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    category: Object,
});

const form = useForm({
    _method: 'POST',
    name: '',
});
const handleSubmit = () => {
    form.post(route('categories.create'), {
        preserveScroll: true,
    });
}
</script>

<template>
    <AppLayout title="Customer Overview">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categorie toevoegen
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
                <FormSection @submitted="updateProfileInformation" class="flex justify-center items-center">

                    <template #form>
                        <div class="col-span-6 sm:col-span-4 w-full flex-auto">
                            <InputLabel for="name" value="naam"/>
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.name" class="mt-2"/>
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
