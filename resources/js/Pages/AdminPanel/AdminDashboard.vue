<template>
  <div class="grid gap-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <StatsCard title="Total Sales" value="$12,340" icon="💰" />
      <StatsCard title="Orders" value="320" icon="📦" />
      <StatsCard title="Customers" value="210" icon="👥" />
      <StatsCard title="Products" value="145" icon="🛒" />
    </div>

    <div class="bg-white rounded-lg shadow p-4">
      <SalesChart />
    </div>

    <div class="bg-white rounded-lg shadow p-4">
      <OrdersTable />
    </div>
  </div>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import StatsCard from '@/Components/StatsCard.vue'
import SalesChart from '@/Components/SalesChart.vue'
import OrdersTable from '@/Components/OrdersTable.vue'

export default {
  name: 'Dashboard',
  components: {
    StatsCard,
    SalesChart,
    OrdersTable,
  },
  layout: AdminLayout, // 👈 this automatically wraps your page with AdminLayout
}
</script>
