<template>
    <div>
        <input :id="id" type="text" placeholder="Search" v-model="query" class="w-full mt-1 border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm">
        <ul :id="id + 'List'" v-if="results.length > 0 && query" class="border-gray-300 border rounded-md shadow-sm bg-white w-64 absolute">
            <li v-for="result in results.slice(0,10)" :key="result.id" @click="setCustomer(result)" class="border-bottom p-2 hover:bg-gray-100 cursor-pointer">
                <div v-text="result.title"></div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            query: null,
            results: []
        };
    },
    watch: {
        query(after, before) {
            this.searchCustomers();
        }
    },
    methods: {
        searchCustomers() {
            if (this.query.length < 2) {
                return;
            }

            axios.get('/search/customers', { params: { query: this.query } })
                .then(response => {
                    this.results = response.data
                    document.getElementById(this.id + 'List').style.display = 'block';
                })
                .catch((error) => console.log(error));
        },
        setCustomer(customer) {
            this.callback(customer.searchable)
            document.getElementById(this.id).value = (customer.searchable.first_name + ' ' + customer.searchable.last_name);
            document.getElementById(this.id + 'List').style.display = 'none';
        }
    },
    props: {
        id: {
            type: String,
            default: '',
            required: true,
        },
        callback: {
            required: true,
        }
    }
}
</script>