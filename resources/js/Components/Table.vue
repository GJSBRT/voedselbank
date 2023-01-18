<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 rounded-b-md">
                        <thead class="bg-gray-50">
                        <tr>
                            <th v-for="(header, index) in headers" :key="index" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ header }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <slot v-if="$slots.default(data)[0].children.length > 0"/>
                            <td v-else :colspan="headers.length" class="px-6 py-4 text-center text-sm text-gray-600">
                                <label>No results.</label>
                            </td>
                        </tbody>
                    </table>
                </div>
                <slot name="pagination" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Table",
    data() {
        return {
            items: 3,
        }
    },
    props: {
        headers: {
            type: Array,
            required: true
        },
    }
}
</script>
