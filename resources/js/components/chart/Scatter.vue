<script setup>
import { ref } from 'vue';
const props = defineProps(['series', 'height']);

const chartOptions = ref({
    chart: {
        type: 'scatter',
        toolbar: { show: false },
        stacked: true,
        fontFamily: "Poppins, sans-serif",
        zoom: {
            enabled: true,
            type: 'xy'
        }
    },
    fill: {
        type: "gradient",
        gradient: {
            shade: "dark",
            gradientToColors: ["#3494FF"],
            shadeIntensity: 1,
            type: "horizontal",
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100],
        },
    },

    //  '#F3CA81', '#9656FF',
    colors: ['#22c55e', '#f59e0b', '#ef4444'],
    grid: {
        show: false,
        borderColor: '#E4E4E7',
    },
    tooltip: {
        enabled: true,
        fillSeriesColor: false,
        theme: 'dark',
        x: { show: false }
    },
    dataLabels: {
        enabled: false,
    },
    xaxis: {
        tickAmount: 10,
        labels: {
            formatter: function(val) {
                return parseFloat(val).toFixed(1)
            },
            style: {
                colors: ['red'],
                fontSize: '12px',
                fontFamily: 'Roboto, sans-serif',
            }
        }
    },
    yaxis: {
        tickAmount: 7,
        style: {
            colors: ['#FFFFFF'],
            fontSize: '12px',
            fontFamily: 'Roboto, sans-serif',
        }
    },
    legend: {
        show: true,
        position: 'bottom',
        fontSize: '14px',
        fontWeight: 400,
        labels: {
            colors: 'white',
            useSeriesColors: false
        },
    }
})
</script>


<template>
    <div class="w-full box-border">
        <apexchart type="scatter" :height="props.height" :options="chartOptions" :series="props.series"></apexchart>
    </div>
</template>