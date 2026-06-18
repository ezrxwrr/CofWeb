<template>
  <div class="mobile-container">
    <nav class="top-nav">
      <button class="icon-btn" @click="globalStore.currentView = 'Home'"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg></button>
      <div class="logo"><span class="logo-text">Ijoo</span></div>
    </nav>

    <div class="content-padding">
      <section class="step-section">
        <div class="step-header"><div class="step-number">1</div><h2>Detail Pengunjung</h2></div>
        <div class="form-group">
          <label>NAMA LENGKAP</label>
          <input type="text" v-model="globalStore.reservation.name" placeholder="Masukkan nama Anda" class="form-input" />
        </div>
        <div class="form-group">
          <label>NOMOR HP / EMAIL</label>
          <input type="text" v-model="globalStore.reservation.contact" placeholder="0812xxx / email@x.com" class="form-input" />
        </div>
        <div class="form-row">
          <div class="form-group half">
            <label>JUMLAH ORANG</label>
            <input 
              type="number" 
              v-model.number="globalStore.reservation.pax" 
              :max="totalAvailableCapacity" 
              min="1" 
              class="form-input" 
              placeholder="Jml"
            />
          </div>
          <div class="form-group half">
            <label>WAKTU</label>
            <input 
              type="time" 
              v-model="globalStore.reservation.time" 
              class="form-input" 
            />
          </div>
        </div>
      </section>

      <div class="divider"></div>

      <section class="step-section">
        <div class="step-header"><div class="step-number">2</div><h2>Pilih Tanggal</h2></div>
        <div class="calendar-card">
          <div class="calendar-header">
            <span>Bulan Ini</span>
          </div>
          <div class="calendar-grid">
            <div class="cal-day-header" v-for="day in ['MIN','SEN','SEL','RAB','KAM','JUM','SAB']" :key="day">{{ day }}</div>
            <div class="cal-day disabled" v-for="blank in startBlankDays" :key="'b'+blank"></div>
            <div 
              class="cal-day" 
              v-for="day in daysInMonth" 
              :key="day"
              :class="{ active: globalStore.reservation.date === `${currentYear}-${currentMonth}-${day}` }"
              @click="globalStore.reservation.date = `${currentYear}-${currentMonth}-${day}`"
            >
              {{ day }}
            </div>
          </div>
        </div>
      </section>

      <section class="step-section">
        <div class="step-header"><div class="step-number">3</div><h2>Pilih Meja</h2></div>
        <div class="table-map">
          <div class="area-label">AREA LUAR & DALAM</div>
          <div class="table-grid-custom">
            <button 
              v-for="table in tables" :key="table.id"
              class="table-btn"
              :class="{ 
                occupied: table.status === 'occupied', 
                selected: globalStore.reservation.tables.includes(table.id) 
              }"
              :disabled="table.status === 'occupied'"
              @click="toggleTable(table.id)"
            >
              {{ table.id }}<br><small>({{ table.capacity }} pax)</small>
            </button>
          </div>
        </div>
        
        <div class="info-box" :class="{ 'warning-box': !isCapacityEnough }">
          <p class="info-text">
            Kapasitas Dipilih: <strong>{{ currentCapacity }} / {{ globalStore.reservation.pax }} Orang</strong>
            <br>
            <span class="info-desc" v-if="!isCapacityEnough" style="color: #D32F2F;">Kapasitas meja kurang! Silakan pilih meja tambahan.</span>
            <span class="info-desc" v-else style="color: #4A5837; font-weight: 600;">Kapasitas meja mencukupi.</span>
          </p>
        </div>
      </section>
    </div>

    <div class="bottom-actions">
      <button class="btn btn-primary" :disabled="!isFormValid" @click="goToMenu">Pre-order Menu & Selesaikan</button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { globalStore } from './store'
import { getMeja, createReservasi } from './services/api'

const today = new Date()
const currentYear = today.getFullYear()
const currentMonth = today.getMonth() + 1
const daysInMonth = new Date(currentYear, currentMonth, 0).getDate()
const startBlankDays = new Date(currentYear, currentMonth - 1, 1).getDay()

if (!globalStore.reservation.date) {
  globalStore.reservation.date = `${currentYear}-${currentMonth}-${today.getDate()}`
}

const tables = ref<any[]>([])

onMounted(async () => {
  try {
    const res = await getMeja()
    tables.value = res.data.map((m: any) => ({
      id: m.kode_meja,
      capacity: m.kapasitas,
      status: m.status_meja === 'terisi' ? 'occupied' : 'available',
      id_meja: m.id_meja,
    }))
  } catch (e) {
    console.error('Gagal memuat data meja', e)
  }
})

const totalAvailableCapacity = computed(() => {
  return tables.value.filter((t: any) => t.status === 'available').reduce((sum: number, t: any) => sum + t.capacity, 0)
})

const toggleTable = (id: string) => {
  const idx = globalStore.reservation.tables.indexOf(id)
  if (idx > -1) {
    globalStore.reservation.tables.splice(idx, 1)
  } else {
    globalStore.reservation.tables.push(id)
  }
}

const currentCapacity = computed(() => {
  return globalStore.reservation.tables.reduce((total, tableId) => {
    const t = tables.value.find((x: any) => x.id === tableId)
    return total + (t ? t.capacity : 0)
  }, 0)
})

const isCapacityEnough = computed(() => currentCapacity.value >= globalStore.reservation.pax)

const isFormValid = computed(() => {
  return globalStore.reservation.name.trim() !== '' && 
         globalStore.reservation.contact.trim() !== '' && 
         globalStore.reservation.pax > 0 &&
         isCapacityEnough.value &&
         globalStore.reservation.tables.length > 0
})

const goToMenu = async () => {
  try {
    const selectedMeja = tables.value.find((t: any) => t.id === globalStore.reservation.tables[0])
    const contact = globalStore.reservation.contact
    const isEmail = contact.includes('@')
    const res = await createReservasi({
      id_meja: selectedMeja?.id_meja,
      nama_pelanggan: globalStore.reservation.name,
      no_telp: isEmail ? '-' : contact,
      email: isEmail ? contact : '-',
      tanggal: globalStore.reservation.date,
      jam: globalStore.reservation.time,
    })
    globalStore.reservation.id_reservasi = res.data.reservasi.id_reservasi
    globalStore.currentView = 'Menu'
  } catch (e: any) {
    console.error('Gagal membuat reservasi', e)
    alert(e.response?.data?.message || 'Gagal membuat reservasi. Silakan coba lagi.')
  }
}
</script>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --border-color: #D6DED0; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { padding-bottom: 120px; background: var(--bg-main); color: var(--text-main); min-height: 100vh; position: relative;}
.top-nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; }
.icon-btn { background: none; border: none; color: var(--primary); cursor: pointer; }
.logo-text { font-family: var(--font-serif); font-size: 1.5rem; font-weight: bold; }
.content-padding { padding: 0 24px; }
.step-section { margin-bottom: 32px; }
.step-header { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; }
.step-number { background-color: var(--primary); color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
.step-header h2 { font-family: var(--font-serif); font-size: 1.5rem; font-weight: normal; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; font-size: 0.7rem; font-weight: 600; color: #5B6A4B; margin-bottom: 8px; letter-spacing: 0.5px; }
.form-input { width: 100%; padding: 16px; border: 1px solid var(--border-color); border-radius: 12px; background: white; font-size: 0.95rem; color: var(--text-main); outline: none; }
.form-row { display: flex; gap: 16px; }
.half { flex: 1; }
.divider { height: 1px; background-color: var(--border-color); margin: 32px 0; opacity: 0.6; }
.calendar-card { background: white; border-radius: 20px; padding: 24px; }
.calendar-header { display: flex; justify-content: center; margin-bottom: 24px; font-family: var(--font-serif); font-weight: 600; font-size: 1.15rem; }
.calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 12px 8px; text-align: center; }
.cal-day-header { font-size: 0.7rem; color: #5B6A4B; font-weight: 600; margin-bottom: 8px; }

/* PERBAIKAN KALENDER: Warna dipertegas pakai hex mutlak biar nggak nyaru */
.cal-day { font-size: 0.95rem; display: flex; align-items: center; justify-content: center; height: 36px; width: 36px; margin: 0 auto; cursor: pointer; border-radius: 50%; transition: 0.2s;}
.cal-day.active { background-color: #4A5837 !important; color: #FFFFFF !important; font-weight: bold; box-shadow: 0 4px 10px rgba(74, 88, 55, 0.4); }

.table-map { background: white; border-radius: 20px; padding: 24px 20px; margin-bottom: 16px; }
.area-label { text-align: center; font-size: 0.7rem; color: #8C9C7B; letter-spacing: 1px; margin-bottom: 20px; font-weight: 600; }
.table-grid-custom { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
.table-btn { padding: 12px 0; border-radius: 12px; border: 1px solid var(--border-color); background: white; font-size: 0.8rem; font-weight: 600; text-align: center; cursor: pointer;}
.table-btn small { font-weight: normal; font-size: 0.65rem; color: #666; }
.table-btn.occupied { background: var(--card-bg); border-color: var(--card-bg); color: #8C9C7B; cursor: not-allowed; }
.table-btn.selected { background: #EEF2EA; border: 2px solid var(--primary); color: var(--primary); }
.info-box { background-color: var(--card-bg); padding: 16px 20px; border-radius: 12px; border: 1px solid rgba(74, 88, 55, 0.1); }
.warning-box { border-color: #D32F2F; background-color: #FFEBEE; }
.info-text { font-size: 0.95rem; }

.bottom-actions { 
  position: fixed; 
  bottom: 0; 
  left: 50%;
  transform: translateX(-50%);
  width: 100%; 
  max-width: 414px;
  background: white; 
  padding: 16px 24px; 
  box-shadow: 0 -4px 24px rgba(0,0,0,0.04); 
  border-radius: 20px 20px 0 0; 
  z-index: 9999;
}
/* PERBAIKAN TOMBOL: Kunci warna background dan teks pakai !important biar nggak ilang */
.btn-primary { width: 100%; padding: 16px; background-color: #4A5837 !important; border: none; color: #FFFFFF !important; border-radius: 12px; font-weight: bold; font-size: 1rem; cursor: pointer; display: block; }
.btn-primary:disabled { background-color: #A4B298 !important; cursor: not-allowed; opacity: 1; }
</style>