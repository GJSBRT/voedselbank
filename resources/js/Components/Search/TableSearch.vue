<template>
    <div>
        <input type="text" :placeholder="placeholder" v-model="query" class="w-full border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm">
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
            Inertia.replace(route(this.route, {filter: {global: this.query} }));
        }
    },
    props: {
        route: String,
        placeholder: String
    }
}
</script>
