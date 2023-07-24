<template>
    <BarChart
        ref="barChartRef"
        :chart-data="chartData"
        v-bind="barChartProps"
        :options="options"
    />
</template>

<script setup>
import { Chart, registerables } from "chart.js";
import { BarChart, useBarChart } from "vue-chart-3";
import { computed, ref } from "vue";

const props = defineProps({
    data: Object,
});

Chart.register(...registerables);

const chartData = ref({
    labels: props.data.labels,
    datasets: [
        {
            data: props.data.data,
            backgroundColor: [
                "#77CEFF",
                "#0079AF",
                "#123E6B",
                "#97B0C4",
                "#A5C8ED",
            ],
        },
    ],
});

const options = ref({
    legend: {
        position: "top",
    },
    responsive: true,
});

const { barChartProps, barChartRef } = useBarChart({
    chartData,
});
</script>
