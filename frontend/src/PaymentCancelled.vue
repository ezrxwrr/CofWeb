<template>
  <div class="mobile-container">
    <div class="scroll-content">
      <nav class="top-nav">
        <button class="icon-btn" @click="resetFlow">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <div class="logo"><span class="logo-text">Ijoo</span></div>
      </nav>

      <div class="content">
        <div class="icon-circle">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
        </div>
        
        <h1 class="title">{{ pageTitle }}</h1>
        <p class="description">{{ pageDescription }}</p>
        
        <div class="note-card">
          <div class="note-header">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            <span>CATATAN</span>
          </div>
          <p class="note-text">
            Meja Anda telah dikembalikan seperti semula. Jangan khawatir, Anda dapat memulai proses reservasi kapan saja.
          </p>
          <p class="note-text manual-reason" v-if="!isTimeout && globalStore.payment.cancelReason">
            <strong>Alasan Anda:</strong> "{{ globalStore.payment.cancelReason }}"
          </p>
        </div>
      </div>

      <div class="bottom-area">
        <button class="btn-outline" @click="resetFlow">KEMBALI KE BERANDA</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { globalStore } from './store'

const resetFlow = () => {
  globalStore.cart = []
  globalStore.reservation = { name: '', contact: '', pax: 2, time: '11:00', date: '', tables: [] }
  globalStore.currentView = 'Home'
}

const isTimeout = computed(() => {
  const reason = globalStore.payment.cancelReason.toLowerCase()
  return reason.includes('waktu') || reason.includes('timeout')
})

const pageTitle = computed(() => {
  return isTimeout.value ? 'Waktu Pembayaran Habis' : 'Pembayaran Dibatalkan'
})

const pageDescription = computed(() => {
  return isTimeout.value 
    ? 'Mohon maaf, sesi pembayaran Anda telah berakhir. Reservasi telah otomatis dibatalkan untuk memberikan kesempatan bagi pelanggan lain yang sedang menunggu.'
    : 'Sesi pembayaran Anda telah dibatalkan. Reservasi yang belum dibayar telah dihapus dari sistem kami.'
})
</script>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { background-color: #F4F7F0; color: #2A3620; min-height: 100vh; width: 100%; overflow-y: auto; }
.scroll-content { display: flex; flex-direction: column; padding-bottom: 120px; }
.top-nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; }
.icon-btn { background: none; border: none; color: #5B6A4B; cursor: pointer; }
.logo-text { font-family: 'Georgia', serif; font-size: 1.5rem; font-weight: bold; }
.content { padding: 40px 24px; text-align: center; }
.icon-circle { width: 100px; height: 100px; background-color: white; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin: 0 auto 32px; color: #5B6A4B; box-shadow: 0 8px 20px rgba(0,0,0,0.04); }
.title { font-family: 'Georgia', serif; font-size: 2.2rem; font-weight: normal; margin-bottom: 20px; line-height: 1.2; color: #2A3620; }
.description { font-size: 0.95rem; color: #5B6A4B; line-height: 1.6; margin-bottom: 40px; }
.note-card { background-color: transparent; border: 1px solid rgba(74, 88, 55, 0.2); border-radius: 16px; padding: 24px; text-align: left; }
.note-header { display: flex; align-items: center; gap: 8px; color: #5B6A4B; font-size: 0.75rem; font-weight: 600; letter-spacing: 1px; margin-bottom: 12px; }
.note-text { font-size: 0.9rem; color: #2A3620; line-height: 1.5; }
.manual-reason { margin-top: 12px; font-style: italic; color: #D32F2F; }
.bottom-area { padding: 0 24px; margin-top: 20px; }
.btn-outline { width: 100%; padding: 16px; border: 1px solid #2A3620 !important; background: transparent !important; color: #2A3620 !important; border-radius: 30px; font-weight: 600; font-size: 0.9rem; letter-spacing: 1px; cursor: pointer; display: block; text-align: center; }
</style>