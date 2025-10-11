<template>
  <div>
    <h2 class="font-semibold mb-4">Monthly Sales</h2>
    <canvas id="salesChart"></canvas>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import Chart from 'chart.js/auto'

onMounted(() => {
  const ctx = document.getElementById('salesChart')
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'Sales ($)',
        data: [1200, 1900, 3000, 2500, 4000, 4700],
        borderColor: '#4f46e5',
        backgroundColor: 'rgba(79, 70, 229, 0.2)',
        fill: true,
        tension: 0.4
      }]
    }
  })
})
</script>
