<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import BarChart from '@/Components/Charts/BarChart.vue';
import { toRefs } from 'vue';
import { HasPermission } from '@/utils';
import LineChart from '../Components/Charts/LineChart.vue';
import Statistic from '../Components/Statistic.vue';

const props = defineProps({
    products: Object,
    packageCount: Object,
    statistics: Object
})

const { products, packageCount } = toRefs(props)

console.log(packageCount.value)

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-rows-1 auto-cols-auto grid-flow-col gap-4 mb-4">
                    <Statistic v-if="HasPermission('suppliers:read')" title="Leveranciers Beschikbaar" :value="statistics.suppliers" />
                    <Statistic v-if="HasPermission('deliveries:read')" title="Aankomende Leveringen" :value="statistics.undeliveredDeliveries" />
                    <Statistic v-if="HasPermission('food-packages:read')" title="Pakketten Niet Opgehaald" :value="statistics.unretreivedPackages" />
                    <Statistic v-if="HasPermission('products:read')" title="Producten Beschikbaar" :value="statistics.productsAvailable" />
                </div>

                <BarChart 
                    v-if="HasPermission('products:read') && HasPermission('food-packages:read')"
                    title="Top 10 Producten (30 dagen)" 
                    id="top-10-products-graph" 
                    height="80" 
                    :chartOptions="{
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }"
                    :chartData="{
                    labels: products.labels,
                    datasets: [{
                        label: 'Top Producten', 
                        backgroundColor: '#f6701b55', 
                        borderColor: '#f6701b', 
                        borderWidth: 1, 
                        data: products.data
                    }]
                }"/>

                <div class="mt-4">
                    <LineChart
                        v-if="HasPermission('food-packages:read')"
                        title="Pakketten Gemaakt (30 dagen)" 
                        id="package-made-graph" 
                        height="80" 
                        :chartOptions="{
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }"
                        :chartData="{
                        labels: packageCount.labels,
                        datasets: [{
                            label: 'Pakketten Gemaakt', 
                            backgroundColor: '#f6701b55', 
                            borderColor: '#f6701b', 
                            fill: true,
                            borderWidth: 1, 
                            data: packageCount.data
                        }]
                    }"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
