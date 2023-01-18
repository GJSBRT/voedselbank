<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';


defineProps({
    products: Object,
});

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
    </AppLayout>
</template>

