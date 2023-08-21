<template>
  <div>
    <pie-chart :data="chartData" :options="chartOptions" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Pie } from 'vue3-chart-v2';

const auth_data = JSON.parse(sessionStorage.getItem('AUTH_USER'));

const chartData = ref({});
const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
});

const fetchData = async () => {
  try {
    const response = await fetch('/my-expenses', { params: {user_id: auth_data.id} });
    const data = await response.json();

    chartData.value = {
      labels: data.categories,
      datasets: [
        {
          data: data.amounts,
          backgroundColor: [
            '#FF6384',
            '#36A2EB',
            '#FFCE56',
            // Add more colors as needed
          ],
        },
      ],
    };
  } catch (error) {
    console.error('Error fetching data:', error);
  }
};

onMounted(() => {
  fetchData();
});
</script>

<style scoped>
/* Add any necessary styles */
</style>
