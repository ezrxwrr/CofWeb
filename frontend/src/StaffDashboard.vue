<template>
  <div class="mobile-container">
    <div class="scroll-content">
      <nav class="top-nav">
        <button class="icon-btn">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <div class="logo"><span class="logo-text">Ijoo Staff</span></div>
      </nav>

      <div class="content" v-if="activeTab === 'dashboard'">
        <h1 class="title">Ringkasan Hari Ini</h1>
        <p class="date-display">{{ todayDate }}</p>

        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-top"><span class="stat-number">{{ reservations.length }}</span></div>
            <p class="stat-label">TOTAL RESERVASI</p>
          </div>
          <div class="stat-card">
            <div class="stat-top"><span class="stat-number">{{ pendingCount }}</span></div>
            <p class="stat-label">MENUNGGU KONFIRMASI</p>
          </div>
        </div>

        <div class="section-header">
          <h2>Status Meja Live</h2>
        </div>
        <div class="table-status-scroll">
          <div class="table-card" v-for="table in tables" :key="table.id" :class="getTableClass(table.status)">
            <p class="table-name">{{ table.id }}</p>
            <select v-model="table.status" @change="syncTableToBackend(table.id, table.status)" class="status-dropdown">
              <option value="available">Available</option>
              <option value="occupied">Occupied</option>
              <option value="cleaning">Cleaning</option>
            </select>
          </div>
        </div>
      </div>

      <div class="content" v-if="activeTab === 'reservations'">
        <h1 class="title">Daftar Reservasi</h1>
        <div class="reservation-list" style="margin-top: 24px;">
          <div class="res-card" v-for="res in reservations" :key="res.id">
            <div class="res-info">
              <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <h3>{{ res.name }}</h3>
                <span class="badge" :class="'badge-' + res.status">{{ res.status.toUpperCase() }}</span>
              </div>
              <p>⏱ {{ res.time }} | 👥 {{ res.pax }} Pax | 🪑 Meja {{ res.tables.join(', ') }}</p>
              
              <div class="res-actions" v-if="res.status === 'pending'">
                <button class="btn-sm btn-approve" @click="updateResStatus(res.id, 'approved')">Terima</button>
                <button class="btn-sm btn-reject" @click="updateResStatus(res.id, 'rejected')">Tolak</button>
              </div>
              <div class="res-actions" v-if="res.status === 'approved'">
                <button class="btn-sm btn-outline" @click="updateResStatus(res.id, 'arrived')">Tandai Hadir</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="content" v-if="activeTab === 'menu'">
        <h1 class="title">Manajemen Menu</h1>
        <p class="date-display">Atur ketersediaan dan harga real-time.</p>
        
        <div class="menu-admin-list">
          <div class="menu-admin-card" v-for="item in menuItems" :key="item.id" :class="{'sold-out': !item.isAvailable}">
            <div class="menu-admin-info">
              <h4>{{ item.name }}</h4>
              <div class="price-edit">
                <span>Rp</span>
                <input type="number" v-model="item.price" @blur="syncPriceToBackend(item.id, item.price)" class="price-input" />
              </div>
            </div>
            <div class="menu-admin-toggle">
              <label class="switch">
                <input type="checkbox" v-model="item.isAvailable" @change="syncAvailability(item.id, item.isAvailable)">
                <span class="slider round"></span>
              </label>
              <span class="toggle-label">{{ item.isAvailable ? 'Tersedia' : 'Habis' }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal-overlay" v-if="showMenuForm" @click="showMenuForm = false">
      <div class="modal-content" @click.stop>
        <h3>Tambah Menu Baru</h3>
        <div class="form-group">
          <label>NAMA MENU</label>
          <input type="text" v-model="newMenu.nama_item" placeholder="Nama menu" class="form-input" />
        </div>
        <div class="form-group">
          <label>DESKRIPSI</label>
          <input type="text" v-model="newMenu.deskripsi" placeholder="Deskripsi menu" class="form-input" />
        </div>
        <div class="form-group">
          <label>HARGA (Rp)</label>
          <input type="number" v-model="newMenu.harga" placeholder="0" class="form-input" />
        </div>
        <div class="modal-actions">
          <button class="btn-sm btn-outline" @click="showMenuForm = false">Batal</button>
          <button class="btn-sm btn-approve" @click="submitNewMenu" :disabled="!newMenu.nama_item || !newMenu.harga">Simpan</button>
        </div>
      </div>
    </div>

    <button class="fab-btn" @click="handleFabClick">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    </button>

    <nav class="staff-bottom-nav">
      <a href="#" class="nav-item" :class="{ active: activeTab === 'dashboard' }" @click.prevent="activeTab = 'dashboard'">
        <div class="icon-wrapper"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></div>
        <span>Overview</span>
      </a>
      <a href="#" class="nav-item" :class="{ active: activeTab === 'reservations' }" @click.prevent="activeTab = 'reservations'">
        <div class="icon-wrapper"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
        <span>Reservasi</span>
      </a>
      <a href="#" class="nav-item" :class="{ active: activeTab === 'menu' }" @click.prevent="activeTab = 'menu'">
        <div class="icon-wrapper"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg></div>
        <span>Menu</span>
      </a>
      <a href="#" class="nav-item" @click.prevent="exitToCustomer">
        <div class="icon-wrapper"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></div>
        <span>Keluar</span>
      </a>
    </nav>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { globalStore } from './store'
import {
  getMeja, getMenus, getReservasi, updateReservasi, createMenu,
  occupyMeja, vacateMeja
} from './services/api'

const todayDate = new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })

const activeTab = ref('dashboard')

const exitToCustomer = () => {
  globalStore.isStaff = false
  globalStore.currentView = 'Home'
}

// 1. DATA MEJA
const tables = ref<any[]>([])
const getTableClass = (status: string) => {
  if (status === 'occupied') return 'card-occ'
  if (status === 'cleaning') return 'card-cleaning'
  return ''
}
const syncTableToBackend = async (kode: string, newStatus: string) => {
  const meja = tables.value.find((t: any) => t.id === kode)
  if (!meja) return
  try {
    if (newStatus === 'occupied') {
      await occupyMeja(meja.id_meja)
    } else {
      await vacateMeja(meja.id_meja)
    }
    meja.status = newStatus
  } catch (e) {
    console.error('Gagal update meja', e)
  }
}

const refreshTables = async () => {
  try {
    const res = await getMeja()
    tables.value = res.data.map((m: any) => ({
      id: m.kode_meja,
      id_meja: m.id_meja,
      status: m.status_meja === 'terisi' ? 'occupied' : 'available',
    }))
  } catch (e) {
    console.error('Gagal refresh meja', e)
  }
}

// 2. DATA RESERVASI
const reservations = ref<any[]>([])
const pendingCount = computed(() => reservations.value.filter((r: any) => r.status === 'pending' || r.status === 'menunggu').length)

const statusMapToBackend: Record<string, string> = {
  pending: 'menunggu',
  approved: 'disetujui',
  arrived: 'hadir',
  rejected: 'ditolak',
}
const updateResStatus = async (id: number, newStatus: string) => {
  try {
    await updateReservasi(id, { status_reservasi: statusMapToBackend[newStatus] || newStatus })
    const res = reservations.value.find((r: any) => r.id === id)
    if (res) res.status = newStatus
  } catch (e) {
    console.error('Gagal update reservasi', e)
  }
}

// 3. DATA MENU
const menuItems = ref<any[]>([])

const syncPriceToBackend = (id: number, newPrice: number) => {
  console.log(`Backend Sync: Harga item ${id} jadi Rp${newPrice}`)
}

const syncAvailability = (id: number, isAvail: boolean) => {
  console.log(`Backend Sync: Status item ${id} ketersediaan: ${isAvail}`)
}

// 4. TAMBAH MENU
const showMenuForm = ref(false)
const newMenu = ref({ nama_item: '', harga: 0, deskripsi: '' })

const refreshMenu = async () => {
  try {
    const res = await getMenus()
    menuItems.value = res.data.map((m: any) => ({
      id: m.id_menu,
      name: m.nama_item,
      price: m.harga,
      isAvailable: true,
    }))
  } catch (e) {
    console.error('Gagal refresh menu', e)
  }
}

const submitNewMenu = async () => {
  try {
    await createMenu(newMenu.value)
    showMenuForm.value = false
    newMenu.value = { nama_item: '', harga: 0, deskripsi: '' }
    await refreshMenu()
  } catch (e) {
    console.error('Gagal tambah menu', e)
  }
}

// 5. FLOATING ACTION BUTTON
const handleFabClick = () => {
  if (activeTab.value === 'menu') showMenuForm.value = true
  if (activeTab.value === 'dashboard') alert('TODO: Buka Modal Tambah Meja Fisik Baru')
  if (activeTab.value === 'reservations') alert('TODO: Buka Modal Buat Reservasi Manual (Walk-in)')
}

onMounted(async () => {
  try {
    const [mejaRes, menuRes, reservasiRes] = await Promise.all([
      getMeja(), getMenus(), getReservasi()
    ])

    tables.value = mejaRes.data.map((m: any) => ({
      id: m.kode_meja,
      id_meja: m.id_meja,
      status: m.status_meja === 'terisi' ? 'occupied' : 'available',
    }))

    menuItems.value = menuRes.data.map((m: any) => ({
      id: m.id_menu,
      name: m.nama_item,
      price: m.harga,
      isAvailable: true,
    }))

    const statusMap: Record<string, string> = {
      menunggu: 'pending',
      disetujui: 'approved',
      dibayar: 'approved',
      hadir: 'arrived',
      ditolak: 'rejected',
    }
    reservations.value = reservasiRes.data.map((r: any) => ({
      id: r.id_reservasi,
      name: r.nama_pelanggan,
      time: r.jam,
      pax: r.meja?.kapasitas || '-',
      tables: r.meja ? [r.meja.kode_meja] : [],
      status: statusMap[r.status_reservasi] || r.status_reservasi,
    }))
  } catch (e) {
    console.error('Gagal memuat data dashboard', e)
  }
})
</script>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }

.mobile-container { max-width: 414px; margin: 0 auto; background-color: #F4F7F0; color: #2A3620; min-height: 100vh; position: relative; }
.scroll-content { padding-bottom: 110px; height: 100vh; overflow-y: auto; scrollbar-width: none; }
.scroll-content::-webkit-scrollbar { display: none; }

.top-nav { display: flex; justify-content: space-between; padding: 20px 24px; align-items: center; }
.icon-btn { background: none; border: none; color: #5B6A4B; cursor: pointer; }
.logo-text { font-family: 'Georgia', serif; font-size: 1.5rem; font-weight: bold; }
.content { padding: 0 24px; }
.title { font-family: 'Georgia', serif; font-size: 1.8rem; font-weight: normal; margin-bottom: 8px; }
.date-display { font-size: 0.9rem; color: #4A5837; margin-bottom: 24px; }

/* Dashboard Cards */
.stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 32px; }
.stat-card { background-color: #EAEFE4; padding: 16px; border-radius: 12px; }
.stat-top { margin-bottom: 4px; color: #2A3620; }
.stat-number { font-family: 'Georgia', serif; font-size: 1.8rem; font-weight: bold;}
.stat-label { font-size: 0.65rem; font-weight: 600; color: #5B6A4B; letter-spacing: 0.5px; }

.section-header { margin-bottom: 16px; }
.section-header h2 { font-family: 'Georgia', serif; font-size: 1.3rem; font-weight: normal; }

/* Tables Management */
.table-status-scroll { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 4px; margin-bottom: 32px; scrollbar-width: none; }
.table-card { min-width: 120px; background-color: #EAEFE4; padding: 14px; border-radius: 12px; display: flex; flex-direction: column; align-items: center; gap: 10px; border: 1px solid transparent; }
.card-occ { background-color: #F5F5F5; border-color: #E0E0E0; }
.card-cleaning { background-color: transparent; border: 1px dashed #A4B298; }
.table-name { font-size: 0.95rem; font-weight: 600; }
.status-dropdown { width: 100%; padding: 4px; border-radius: 6px; border: 1px solid #D6DED0; font-size: 0.75rem; font-weight: bold; color: #4A5837; outline: none; background: white;}

/* Reservations Management */
.reservation-list { display: flex; flex-direction: column; gap: 12px; }
.res-card { background: white; border-radius: 16px; padding: 16px; display: flex; flex-direction: column; box-shadow: 0 4px 12px rgba(0,0,0,0.02); border: 1px solid rgba(74, 88, 55, 0.05);}
.res-info h3 { font-size: 1.05rem; font-weight: 600; }
.res-info p { font-size: 0.85rem; color: #5B6A4B; margin-bottom: 12px; }
.badge { font-size: 0.65rem; font-weight: 700; padding: 4px 8px; border-radius: 12px; letter-spacing: 0.5px;}
.badge-pending { background-color: #FFF3E0; color: #E65100; }
.badge-approved { background-color: #E3F2FD; color: #1565C0; }
.badge-arrived { background-color: #EEF2EA; color: #4A5837; }
.badge-rejected { background-color: #FFEBEE; color: #C62828; }
.res-actions { display: flex; gap: 8px; border-top: 1px solid #EAEFE4; padding-top: 12px; }
.btn-sm { flex: 1; padding: 10px; border-radius: 8px; font-size: 0.8rem; font-weight: bold; cursor: pointer; border: none; }
.btn-approve { background: #4A5837; color: white; }
.btn-reject { background: #FFEBEE; color: #C62828; }
.btn-outline { background: transparent; border: 1px solid #4A5837; color: #4A5837; }

/* Menu Management */
.menu-admin-list { display: flex; flex-direction: column; gap: 12px; margin-top: 24px; }
.menu-admin-card { background: white; border-radius: 16px; padding: 16px; display: flex; justify-content: space-between; align-items: center; border: 1px solid rgba(74, 88, 55, 0.05); transition: 0.3s; }
.sold-out { opacity: 0.6; background: #F5F5F5; }
.menu-admin-info h4 { font-size: 0.95rem; margin-bottom: 8px; color: #2A3620; }
.price-edit { display: flex; align-items: center; gap: 4px; font-size: 0.85rem; color: #5B6A4B; font-weight: bold; }
.price-input { width: 80px; padding: 4px 8px; border: 1px solid #D6DED0; border-radius: 6px; font-family: inherit; font-weight: bold; color: #4A5837; outline: none; }
.menu-admin-toggle { display: flex; flex-direction: column; align-items: flex-end; gap: 6px; }
.toggle-label { font-size: 0.7rem; font-weight: bold; color: #8C9C7B; }

/* Toggle Switch CSS */
.switch { position: relative; display: inline-block; width: 44px; height: 24px; }
.switch input { opacity: 0; width: 0; height: 0; }
.slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px; }
.slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
input:checked + .slider { background-color: #4A5837; }
input:checked + .slider:before { transform: translateX(20px); }

/* Modal */
.modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 10000; }
.modal-overlay .modal-content { background: white; padding: 24px; border-radius: 16px; width: 85%; max-width: 340px; }
.modal-overlay .modal-content h3 { font-family: var(--font-serif); margin-bottom: 20px; }
.modal-overlay .form-group { margin-bottom: 16px; }
.modal-overlay .form-group label { display: block; font-size: 0.7rem; font-weight: 600; color: #5B6A4B; margin-bottom: 6px; letter-spacing: 0.5px; }
.modal-overlay .form-input { width: 100%; padding: 12px; border: 1px solid #D6DED0; border-radius: 10px; font-size: 0.9rem; outline: none; }
.modal-overlay .modal-actions { display: flex; gap: 12px; margin-top: 24px; }
.modal-overlay .modal-actions .btn-sm { flex: 1; }
.modal-overlay .btn-sm:disabled { opacity: 0.5; cursor: not-allowed; }

/* FAB */
.fab-btn { position: fixed; bottom: 84px; left: 50%; transform: translateX(130px); width: 52px; height: 52px; background-color: #4A5837; border-radius: 50%; border: none; display: flex; justify-content: center; align-items: center; box-shadow: 0 4px 12px rgba(74, 88, 55, 0.3); cursor: pointer; z-index: 999; }
.fab-btn:active { transform: translateX(130px) scale(0.95); }

/* Bottom Nav */
.staff-bottom-nav { position: fixed; bottom: 0; left: 50%; transform: translateX(-50%); width: 100%; max-width: 414px; background: white; display: flex; justify-content: space-around; padding: 12px 0; border-top-left-radius: 24px; border-top-right-radius: 24px; box-shadow: 0 -4px 20px rgba(0,0,0,0.05); z-index: 9999; }
.staff-bottom-nav .nav-item { display: flex; flex-direction: column; align-items: center; text-decoration: none; color: #A0A0A0; gap: 4px; flex: 1; }
.staff-bottom-nav .nav-item span { font-size: 0.65rem; font-weight: 500; }
.icon-wrapper { padding: 6px 16px; border-radius: 16px; display: flex; justify-content: center; align-items: center; transition: 0.2s;}
.staff-bottom-nav .nav-item.active { color: #4A5837; }
.staff-bottom-nav .nav-item.active .icon-wrapper { background: #EEF2EA; }
</style>