<script setup>
import { toRefs } from 'vue';

const props = defineProps({
    links: Array,
});

const { links } = toRefs(props)
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-2 text-sm leading-4 text-gray-500 hover:text-gray-700 font-medium capitalize"
                    v-html="link.label.replace('pagination.','')" />
                <inertia-link v-else
                    class="mr-1 mb-1 px-4 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 capitalize tracking-widest hover:text-gray-700 active:text-gray-700"
                    :class="{ 'text-gray-700': link.active }" :href="link.url" v-html="link.label.replace('pagination.','')" />
            </template>
        </div>
    </div>
</template>