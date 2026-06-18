<template>
  <div class="mobile-container">
    <nav class="top-nav">
      <button class="icon-btn" @click="globalStore.currentView = 'Menu'"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg></button>
      <h1 class="page-title">Pembayaran</h1>
      <div style="width: 24px;"></div>
    </nav>

    <div class="content">
      <p class="section-label">RINGKASAN PESANAN</p>
      <div class="summary-card">
        <div class="summary-row" v-for="(item, index) in groupedCart" :key="index">
          <span>{{ item.qty }}x {{ item.name }}</span>
          <span>Rp {{ (item.price * item.qty).toLocaleString('id-ID') }}</span>
        </div>
        <div class="summary-row" style="color: #666;"><span>Pajak (10%)</span><span>Rp {{ globalStore.tax.toLocaleString('id-ID') }}</span></div>
        <div class="card-divider"></div>
        <div class="summary-row total-row">
          <span class="total-label">Total</span>
          <span class="total-value">Rp {{ globalStore.total.toLocaleString('id-ID') }}</span>
        </div>
      </div>

      <div class="page-divider"></div>

      <p class="section-label">SCAN UNTUK MEMBAYAR</p>
      <div class="qr-wrapper">
        <div class="qris-badge">QRIS</div>
        <div class="qr-container">
          <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://www.youtube.com/watch?v=dQw4w9WgXcQ" alt="QR Rickroll" class="qr-image" />
        </div>
      </div>

      <div class="timer-info">
        <span>⏱ Menunggu pembayaran... ({{ formattedTime }})</span>
      </div>

      <div class="page-divider"></div>

      <button class="btn-refresh" @click="processPayment">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6"></path><path d="M1 20v-6h6"></path><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
        Cek Status Pembayaran
      </button>

      <button class="btn-cancel-text" @click="showCancelForm = true">Batalkan Pesanan</button>

      <div class="cancel-modal" v-if="showCancelForm">
        <div class="modal-content">
          <h3>Alasan Pembatalan</h3>
          <textarea v-model="cancelInput" placeholder="Ketik alasan pembatalan..."></textarea>
          <div class="modal-actions">
            <button class="btn-back" @click="showCancelForm = false">Kembali</button>
            <button class="btn-danger" @click="submitCancel">Konfirmasi Batal</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { globalStore } from './store'

const groupedCart = computed(() => {
  const groups: Record<number, any> = {}
  globalStore.cart.forEach(item => {
    if (!groups[item.id]) groups[item.id] = { ...item, qty: 0 }
    groups[item.id].qty++
  })
  return Object.values(groups)
})

const timeLeft = ref(300)
let timerInterval: any = null

const formattedTime = computed(() => {
  const m = Math.floor(timeLeft.value / 60).toString().padStart(2, '0')
  const s = (timeLeft.value % 60).toString().padStart(2, '0')
  return `${m}:${s}`
})

const startTimer = () => {
  timerInterval = setInterval(() => {
    if (timeLeft.value > 0) {
      timeLeft.value--
    } else {
      clearInterval(timerInterval)
      globalStore.payment.status = 'CANCELLED'
      globalStore.payment.cancelReason = 'Waktu pembayaran habis (Timeout)'
      globalStore.currentView = 'PaymentCancelled'
    }
  }, 1000)
}

onMounted(() => { startTimer() })
onUnmounted(() => { clearInterval(timerInterval) })

const processPayment = () => {
  clearInterval(timerInterval)
  globalStore.payment.status = 'SUCCESS'
  
  // Generate Kode Receipt
  globalStore.currentReceiptCode = 'IJOO-' + Math.random().toString(36).substr(2, 5).toUpperCase()
  
  globalStore.history.push({
    code: globalStore.currentReceiptCode,
    date: new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }),
    total: globalStore.total,
    status: 'Selesai'
  })

  globalStore.currentView = 'PaymentSuccess'
}

const showCancelForm = ref(false)
const cancelInput = ref('')

const submitCancel = () => {
  clearInterval(timerInterval)
  globalStore.payment.status = 'CANCELLED'
  globalStore.payment.cancelReason = cancelInput.value || 'Dibatalkan manual oleh pengguna'
  globalStore.currentView = 'PaymentCancelled'
}
</script>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { background-color: var(--bg-main); color: var(--text-main); min-height: 100vh; }
.top-nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; }
.icon-btn { background: none; border: none; color: #5B6A4B; cursor: pointer; }
.page-title { font-family: var(--font-serif); font-size: 1.3rem; }
.content { padding: 12px 24px 40px; text-align: center; }
.section-label { font-size: 0.7rem; font-weight: 600; color: #5B6A4B; letter-spacing: 1px; margin-bottom: 16px; }
.summary-card { background-color: var(--card-bg); border-radius: 12px; padding: 20px 24px; text-align: left; }
.summary-row { display: flex; justify-content: space-between; font-size: 0.95rem; color: var(--primary); margin-bottom: 16px; }
.card-divider { border-top: 1px solid rgba(74, 88, 55, 0.15); margin: 20px 0; }
.total-row { align-items: center; margin-top: 20px; }
.total-label, .total-value { font-family: var(--font-serif); font-size: 1.25rem; font-weight: bold; color: var(--primary); }
.page-divider { border-top: 1px solid rgba(74, 88, 55, 0.1); margin: 32px 0; }
.qr-wrapper { position: relative; width: 200px; margin: 0 auto 20px; }
.qris-badge { position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--primary); color: white; font-size: 0.7rem; font-weight: 600; padding: 4px 16px; border-radius: 20px; z-index: 2; }
.qr-container { background: white; padding: 16px; border-radius: 16px; }
.qr-image { width: 100%; display: block; border-radius: 8px; }
.timer-info { font-size: 0.85rem; color: #5B6A4B; margin-bottom: 24px;}

.btn-refresh { width: 100%; display: flex; justify-content: center; align-items: center; gap: 12px; background-color: var(--primary); color: rgb(100, 86, 86); border: none; padding: 16px; border-radius: 12px; font-weight: 600; font-size: 0.95rem; cursor: pointer; margin-bottom: 16px; transition: 0.2s;}
.btn-refresh:active { transform: scale(0.98); }

.btn-cancel-text { background: transparent; border: none; color: #D32F2F; font-weight: 600; cursor: pointer; text-decoration: underline; font-size: 0.9rem;}
.cancel-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 50; }
.modal-content { background: white; padding: 24px; border-radius: 16px; width: 80%; text-align: left; }
.modal-content h3 { font-family: var(--font-serif); margin-bottom: 12px; }
.modal-content textarea { width: 100%; height: 80px; padding: 12px; border: 1px solid #ccc; border-radius: 8px; margin-bottom: 16px; font-family: inherit; resize: none;}
.modal-actions { display: flex; gap: 12px; }
.btn-back { flex: 1; padding: 12px; border: 1px solid #ccc; background: white; border-radius: 8px; cursor: pointer; }
.btn-danger { flex: 1; padding: 12px; border: none; background: #D32F2F; color: white; border-radius: 8px; cursor: pointer; }
</style>