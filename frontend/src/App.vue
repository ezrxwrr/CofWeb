<template>
  <div>
    <div class="dev-nav">
      <button :class="{ active: currentView === Home }" @click="currentView = Home">Landing Page</button>
      <button :class="{ active: currentView === Menu }" @click="currentView = Menu">Menu</button>
      <button :class="{ active: currentView === TableReservation }" @click="currentView = TableReservation">Reservasi</button>
      <button :class="{ active: currentView === Payment }" @click="currentView = Payment">Bayar</button>
      <button :class="{ active: currentView === PaymentSuccess }" @click="currentView = PaymentSuccess">Sukses</button>
      <button :class="{ active: currentView === PaymentCancelled }" @click="currentView = PaymentCancelled">Batal</button>
      <button :class="{ active: currentView === StaffDashboard }" @click="currentView = StaffDashboard">Staff</button>
    </div>

    <div class="app-wrapper">
      <component :is="currentView" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { shallowRef } from 'vue'

import Home from './Home.vue'
import Menu from './Menu.vue'
import TableReservation from './TableReservation.vue'
import Payment from './Payment.vue'
import PaymentSuccess from './PaymentSuccess.vue'
import PaymentCancelled from './PaymentCancelled.vue'
import StaffDashboard from './StaffDashboard.vue'

const currentView = shallowRef(Home)
</script>

<style>
/* GLOBAL STYLES */
body {
  margin: 0;
  padding: 0;
  background-color: #E0E5DF; /* Light gray background for testing */
  font-family: system-ui, -apple-system, sans-serif;
}
.dev-nav {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 8px;
  padding: 12px;
  background-color: #2A3620;
  position: sticky;
  top: 0;
  z-index: 999;
}
.dev-nav button {
  padding: 8px 16px;
  background: #4A5837;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  font-size: 0.8rem;
}
.dev-nav button.active {
  background: #A3B18A;
  color: #111;
}
.app-wrapper {
  padding-top: 20px;
  padding-bottom: 40px;
}
</style>