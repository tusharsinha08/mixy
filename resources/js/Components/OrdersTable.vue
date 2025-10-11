<template>
  <div>
    <h2 class="font-semibold mb-4">Recent Orders</h2>
    <table class="w-full text-left border">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-2 border">Order ID</th>
          <th class="p-2 border">Customer</th>
          <th class="p-2 border">Total</th>
          <th class="p-2 border">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders" :key="order.id" class="border-b hover:bg-gray-50">
          <td class="p-2 border">{{ order.id }}</td>
          <td class="p-2 border">{{ order.customer }}</td>
          <td class="p-2 border">${{ order.total }}</td>
          <td class="p-2 border">
            <span
              :class="[
                'px-2 py-1 rounded text-xs',
                order.status === 'Delivered' ? 'bg-green-100 text-green-700' :
                order.status === 'Pending' ? 'bg-yellow-100 text-yellow-700' :
                'bg-red-100 text-red-700'
              ]"
            >
              {{ order.status }}
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
const orders = [
  { id: '#001', customer: 'John Doe', total: 120.5, status: 'Delivered' },
  { id: '#002', customer: 'Jane Smith', total: 80.0, status: 'Pending' },
  { id: '#003', customer: 'Mark Lee', total: 230.0, status: 'Cancelled' },
  { id: '#004', customer: 'Lisa Ray', total: 150.0, status: 'Delivered' }
]
</script>
