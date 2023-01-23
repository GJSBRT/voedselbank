<template>
    <div class="bg-white overflow-hidden shadow sm:rounded-lg p-4">
        <h2 class="text-center mb-2">{{ title }}</h2>
        <Bar :id="id" :height="height" :options="chartOptions" :data="chartData" />
    </div>
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: 'BarChart',
    components: { Bar },
    data() {
        return {
            chartData: this.chartData,
            chartOptions: this.chartOptions
        }
    },
    props: {
        height: {
            type: Number,
            default: 100
        },
        title: {
            type: String,
            default: 'My Chart'
        },
        id: {
            type: String,
            default: 'my-chart-id'
        },
        chartData: {
            type: Object,
            default: null
        },
        chartOptions: {
            type: Object,
            default: {
                responsive: true
            }
        }
    },
}
</script>
