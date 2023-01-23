<template>
    <div>
        <input :id="id" type="text" v-model="query" :placeholder="value" class="w-full border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm">
        <ul :id="id + 'List'" v-if="results.length > 0 && query" class="border-gray-300 border rounded-md shadow-sm bg-white w-64 absolute">
            <li v-for="result in results.slice(0,10)" :key="result.id" @click="setRole(result)" class="border-bottom p-2 hover:bg-gray-100 cursor-pointer">
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
            this.searchRoles();
        }
    },
    methods: {
        searchRoles() {
            if (this.query.length < 2) {
                return;
            }

            axios.get('/search/roles', { params: { query: this.query } })
                .then(response => {
                    this.results = response.data
                    document.getElementById(this.id + 'List').style.display = 'block';
                })
                .catch((error) => console.log(error));
        },
        setRole(role) {
            this.callback(role.searchable)
            document.getElementById(this.id).value = role.searchable.name;
            document.getElementById(this.id + 'List').style.display = 'none';
        }
    },
    props: {
        id: {
            type: String,
            default: '',
            required: true,
        },
        value: {
            type: String,
            default: '',
            required: false,
        },
        callback: {
            required: true,
        }
    }
}
</script>