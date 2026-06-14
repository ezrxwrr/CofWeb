<template>
  <div class="mobile-container">
    <div class="scroll-content">
      <div class="hero-image">
        <img src="https://images.unsplash.com/photo-1541167760496-1628856ab772?q=80&w=400&auto=format&fit=crop" alt="Success" />
      </div>
      
      <div class="content">
        <h1 class="title">Terima Kasih atas<br>Pesanan Anda!</h1>
        <p class="subtitle">Reservasi Anda telah berhasil kami terima.<br>Tunjukkan kode receipt ini kepada staff kami.</p>
        
        <div class="detail-card">
          <div class="card-header">
            <span class="label">DETAIL RESERVASI</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#8C9C7B" stroke="white" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>
          </div>
          
          <div class="detail-row">
            <span class="row-label">KODE RECEIPT</span>
            <span class="row-value receipt-code">{{ globalStore.currentReceiptCode || 'IJOO-MOCK' }}</span>
          </div>

          <div class="detail-row"><span class="row-label">NAMA PEMESAN</span><span class="row-value">{{ globalStore.reservation.name || 'Budi Siregar' }}</span></div>
          <div class="detail-row"><span class="row-label">MEJA</span><span class="row-value">Meja {{ globalStore.reservation.tables.join(', ') || '4' }}</span></div>
          <div class="detail-row last-row"><span class="row-label">WAKTU</span><span class="row-value">{{ globalStore.reservation.time || '14:00' }}, {{ formattedDate }}</span></div>
        </div>

        <div class="notification-box">
          <div class="notif-text">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <p>Receipt telah dikirim ke <strong>{{ globalStore.reservation.contact || 'nomor Anda' }}</strong>.</p>
          </div>
          <button class="btn-resend" @click="resendMsg">Kirim Ulang</button>
        </div>

        <div class="actions">
          <button class="btn btn-primary" @click="resetFlow">Kembali ke Beranda</button>
          <button class="btn btn-outline" @click="saveProof">Simpan Bukti</button>
        </div>

        <p class="footer-logo">Ijoo Coffee</p>
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

const saveProof = () => { alert('Bukti reservasi berhasil disimpan!') }
const resendMsg = () => { alert('Kode receipt berhasil dikirim ulang!') }

const formattedDate = computed(() => {
  if (!globalStore.reservation.date) return '24 Mei 2026'
  const d = new Date(globalStore.reservation.date)
  return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
})
</script>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { background-color: #F4F7F0; color: #2A3620; min-height: 100vh; width: 100%; overflow-y: auto; }
.scroll-content { padding-bottom: 120px; display: flex; flex-direction: column; }
.hero-image { width: 100%; padding: 24px 24px 0; }
.hero-image img { width: 100%; height: 220px; object-fit: cover; border-radius: 16px; }
.content { padding: 32px 24px 40px; text-align: center; display: flex; flex-direction: column; }
.title { font-family: 'Georgia', serif; font-size: 2rem; font-weight: normal; margin-bottom: 12px; line-height: 1.2; color: #4A5837; }
.subtitle { font-size: 0.9rem; color: #5B6A4B; line-height: 1.5; margin-bottom: 24px; }
.detail-card { background-color: #EAEFE4; border-radius: 16px; padding: 24px; text-align: left; margin-bottom: 24px; border: 1px solid rgba(74, 88, 55, 0.08); }
.card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(74, 88, 55, 0.1); padding-bottom: 16px; }
.label { font-size: 0.75rem; font-weight: 600; color: #5B6A4B; letter-spacing: 1px; }
.detail-row { margin-bottom: 16px; }
.last-row { margin-bottom: 0; }
.row-label { display: block; font-size: 0.65rem; color: #8C9C7B; letter-spacing: 0.5px; margin-bottom: 4px; text-transform: uppercase; }
.row-value { font-size: 1rem; font-weight: 500; color: #2A3620; }
.receipt-code { font-family: monospace; font-size: 1.2rem; font-weight: bold; color: #4A5837; background: rgba(74, 88, 55, 0.1); padding: 4px 8px; border-radius: 6px;}
.notification-box { display: flex; justify-content: space-between; align-items: center; background: white; padding: 16px; border-radius: 12px; margin-bottom: 40px; border: 1px solid rgba(74, 88, 55, 0.1); text-align: left;}
.notif-text { display: flex; align-items: center; gap: 12px; font-size: 0.8rem; color: #5B6A4B; flex: 1;}
.btn-resend { background: transparent; border: none; color: #4A5837; font-weight: 600; font-size: 0.8rem; text-decoration: underline; cursor: pointer; white-space: nowrap;}
.actions { display: flex; flex-direction: column; gap: 12px; margin-bottom: 40px; }
.btn { width: 100%; padding: 16px; border-radius: 30px; font-weight: 600; font-size: 0.95rem; cursor: pointer; text-align: center; }
.btn-primary { background-color: #4A5837 !important; color: white !important; border: none; }
.btn-outline { background-color: transparent !important; color: #4A5837 !important; border: 1px solid #4A5837 !important; }
.footer-logo { font-family: 'Georgia', serif; font-size: 1.1rem; color: #A4B298; letter-spacing: 1px; margin-bottom: 20px;}
</style>