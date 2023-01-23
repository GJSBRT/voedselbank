<template>
    <div class="bg-white overflow-hidden shadow sm:rounded-lg p-4">
        <h2 class="text-center mb-2">{{ title }}</h2>
        <Line :id="id" :height="height" :options="chartOptions" :data="chartData" />
    </div>
</template>

<script>
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend, Filler } from 'chart.js'

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Filler, Legend)

export default {
    name: 'LineChart',
    components: { Line },
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
