<template>
  <div class="mobile-container">
    <nav class="top-nav">
      <button class="icon-btn" @click="globalStore.currentView = 'Home'"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg></button>
      <h1 class="page-title">Riwayat Pesanan</h1>
      <div style="width: 24px;"></div>
    </nav>

    <div class="content">
      <div v-if="globalStore.history.length === 0" class="empty-state">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#A4B298" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <p>Belum ada riwayat pesanan.</p>
      </div>

      <div v-else class="history-list">
        <div class="history-card" v-for="(order, index) in globalStore.history" :key="index">
          <div class="card-header">
            <span class="order-id">{{ order.code }}</span>
            <span class="order-status">{{ order.status }}</span>
          </div>
          <div class="card-body">
            <p class="order-date">{{ order.date }}</p>
            <p class="order-total">Total: <strong>Rp {{ order.total.toLocaleString('id-ID') }}</strong></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { globalStore } from './store'
</script>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { background-color: var(--bg-main); color: var(--text-main); min-height: 100vh; }
.top-nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; }
.icon-btn { background: none; border: none; color: #5B6A4B; cursor: pointer; }
.page-title { font-family: var(--font-serif); font-size: 1.3rem; }
.content { padding: 20px 24px; }

.empty-state { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 50vh; color: #8C9C7B; gap: 16px; }
.history-list { display: flex; flex-direction: column; gap: 16px; }
.history-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); border: 1px solid rgba(74, 88, 55, 0.08); }
.card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid rgba(74, 88, 55, 0.1); padding-bottom: 12px;}
.order-id { font-family: monospace; font-size: 1.1rem; font-weight: bold; color: var(--primary); }
.order-status { background: #EEF2EA; color: var(--primary); font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 12px; }
.order-date { font-size: 0.85rem; color: #5B6A4B; margin-bottom: 8px;}
.order-total { font-size: 0.95rem; }
</style>