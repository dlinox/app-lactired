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
import { ref } from "vue";

Chart.register(...registerables);

const props = defineProps({
  data: Object, // ya no mezclamos con Array
  label: {
    type: String,
    default: "Acopio",
  },
});

// Labels fijas de 12 meses
const monthLabels = [
  "Enero", "Febrero", "Marzo", "Abril",
  "Mayo", "Junio", "Julio", "Agosto",
  "Septiembre", "Octubre", "Noviembre", "Diciembre"
];

const backgroundColor = [
  "#77CEFF", "#0079AF", "#123E6B", "#97B0C4",
  "#A5C8ED", "#D9E6F2", "#F0F4F8", "#F7FAFC",
  "#E0E7EC", "#C1D3E0", "#A2B9D6", "#83A0CC",
];

const chartData = ref({
  labels: monthLabels,
  datasets: [],
});

const options = ref({
  responsive: true,
  plugins: {
    legend: {
      position: "top",
    },
    tooltip: {
      mode: "index",
      intersect: false,
    },
  },
});

const { barChartProps, barChartRef } = useBarChart({ chartData });

// Inicializar datasets desde props.data
const initChart = () => {

  
  const datasets = Object.keys(props.data.data).map((key, index) => {
    return {
      label: key,
      data: props.data.data[key],
      backgroundColor: backgroundColor[index % backgroundColor.length],
    };
  });

  chartData.value.datasets = datasets;
};

initChart();
</script>
