<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import Banner from '../../assets/images/banner-transparent.png';
</script>

<template>
    <Link :href="'/'">
        <img :src="Banner" class="h-20 w-auto"/>
    </Link>
</template>
