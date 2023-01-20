<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import { toRefs } from 'vue';
import TextInput from '../../Components/TextInput.vue';
import Checkbox from '../../Components/Checkbox.vue';
import RoleSearch from '../../Components/Search/RoleSearch.vue';

const props = defineProps({
    user: Object,
    two_factor_enabled: Boolean,
});

const { user, two_factor_enabled } = toRefs(props);

const form = useForm({
    _method: 'PATCH',
    user: user.value,
    two_factor_enabled: two_factor_enabled.value,
});

const handleSubmit = () => {
    form.post(route('users.update', user.value.id), {
        preserveScroll: true,
    });
}

const setRole = (role) => {
    form.user.role_id = role.id
}
</script>

<template>
    <AppLayout title="Medewerker Beheer">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ form.user.first_name }} {{ form.user.last_name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
                <div>
                    <FormSection>
                        <template #title>
                            Medewerker Informatie
                        </template>

                        <template #description>
                            Bewerk hier de informatie van de medewerker.
                        </template>

                        <template #form>
                            <div class="col-span-6 grid grid-cols-2 gap-4">
                                <div>
                                    <InputLabel for="first_name" value="Voornaam" />
                                    <TextInput id="first_name" v-model="form.user.first_name" type="text" class="mt-1 block w-full"/>
                                </div>

                                <div>
                                    <InputLabel for="last_name" value="Achternaam" />
                                    <TextInput id="last_name" v-model="form.user.last_name" type="text" class="mt-1 block w-full"/>
                                </div>
                            </div>

                            <div class="col-span-6">
                                <InputLabel for="email" value="Email" />
                                <TextInput id="email" v-model="form.user.email" type="text" class="mt-1 block w-full"/>
                            </div>
                            
                            <div class="col-span-6">
                                <InputLabel for="role" value="Rol" />
                                <RoleSearch id="role" :callback="setRole" :value="user.role.name"/>
                            </div>

                            <div class="col-span-6">
                                <Checkbox v-model:checked="form.two_factor_enabled" :value="null" :disabled="user.two_factor_confirmed_at == null"/>
                                <span class="ml-2 text-sm text-gray-600">Twee Factor Authentictie</span>
                            </div>
                        </template>
                        
                        <template #actions>
                            <PrimaryButton @click="handleSubmit">
                                Medewerker Opslaan
                            </PrimaryButton>
                        </template>
                    </FormSection>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
