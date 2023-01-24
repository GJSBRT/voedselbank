<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import BarChart from '@/Components/Charts/BarChart.vue';
import { toRefs } from 'vue';
import { hasPermission } from '@/utils';
import LineChart from '../Components/Charts/LineChart.vue';
import Statistic from '../Components/Statistic.vue';

const props = defineProps({
    products: Object,
    packageCount: Object,
    statistics: Object
})

const { products, packageCount } = toRefs(props)

</script>

<template>
    <AppLayout title="Dashboard" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: route('dashboard'),
        }
    ]">
        

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="text-xl text-center" v-if="!hasPermission('suppliers:read') && !hasPermission('deliveries:read') && !hasPermission('food-packages:read') && !hasPermission('products:read')">
                    Er is helaas niks te laten zien.
                </h2>

                <div class="grid grid-rows-4 md:grid-rows-2 lg:grid-rows-1 auto-cols-auto grid-flow-col gap-4 mb-4">
                    <Statistic v-if="hasPermission('suppliers:read')" title="Leveranciers Beschikbaar" :value="statistics.suppliers" />
                    <Statistic v-if="hasPermission('deliveries:read')" title="Aankomende Leveringen" :value="statistics.undeliveredDeliveries" />
                    <Statistic v-if="hasPermission('food-packages:read')" title="Pakketten Niet Opgehaald" :value="statistics.unretreivedPackages" />
                    <Statistic v-if="hasPermission('products:read')" title="Producten Beschikbaar" :value="statistics.productsAvailable" />
                </div>

                <BarChart 
                    v-if="hasPermission('products:read') && hasPermission('food-packages:read')"
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
                        v-if="hasPermission('food-packages:read')"
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
