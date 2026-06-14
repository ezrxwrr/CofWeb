<template>
  <div class="main-layout">
    <div class="mobile-app-container">
      <div class="app-wrapper">
        <component :is="activeComponent" />
      </div>

      <nav class="bottom-nav" v-if="showBottomNav">
        <a href="#" class="nav-item" :class="{ active: globalStore.currentView === 'Home' }" @click.prevent="globalStore.currentView = 'Home'">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
          <span>Home</span>
        </a>
        <a href="#" class="nav-item" :class="{ active: globalStore.currentView === 'TableReservation' }" @click.prevent="globalStore.currentView = 'TableReservation'">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          <span>Reserve</span>
        </a>
        <a href="#" class="nav-item" :class="{ active: globalStore.currentView === 'Menu' }" @click.prevent="globalStore.currentView = 'Menu'">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
          <span>Menu</span>
        </a>
      </nav>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { globalStore } from './store'

import Home from './Home.vue'
import Menu from './Menu.vue'
import TableReservation from './TableReservation.vue'
import Payment from './Payment.vue'
import PaymentSuccess from './PaymentSuccess.vue'
import PaymentCancelled from './PaymentCancelled.vue'
import StaffDashboard from './StaffDashboard.vue'
import OrderHistory from './OrderHistory.vue'

const components: Record<string, any> = {
  Home, Menu, TableReservation, Payment, PaymentSuccess, PaymentCancelled, StaffDashboard, OrderHistory
}

const activeComponent = computed(() => components[globalStore.currentView])

// Navbar bawah bawaan App.vue hanya muncul di halaman utama pelanggan
const showBottomNav = computed(() => {
  return ['Home', 'OrderHistory'].includes(globalStore.currentView)
})
</script>

<style scoped>
.main-layout { display: flex; flex-direction: column; align-items: center; background-color: #E0E5DF; min-height: 100vh; }
.mobile-app-container { max-width: 414px; width: 100%; position: relative; min-height: 100vh; background-color: #F4F7F0; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow-x: hidden; }
.app-wrapper { height: 100%; }

.bottom-nav { 
  position: fixed; 
  bottom: 0; 
  left: 50%;
  transform: translateX(-50%);
  width: 100%; 
  max-width: 414px;
  background: white; 
  display: flex; 
  justify-content: space-around; 
  padding: 16px 0; 
  border-top-left-radius: 24px; 
  border-top-right-radius: 24px; 
  box-shadow: 0 -4px 20px rgba(0,0,0,0.05); 
  z-index: 9999; 
}
.nav-item { display: flex; flex-direction: column; align-items: center; text-decoration: none; color: #A0A0A0; gap: 4px; }
.nav-item span { font-size: 0.7rem; }
.nav-item.active { color: #4A5837; }
</style>