<template>
    <div>
        <input type="text" placeholder="Zoeken" v-model="query" class="w-full border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm">
    </div>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";

export default {
    data() {
        return {
            query: null,
        };
    },
    watch: {
        query() {
            this.searchProducts();
        }
    },
    methods: {
        searchProducts() {
            Inertia.replace(route('suppliers.index', {filter: {global: this.query} }));
        }
    },
}
</script>
