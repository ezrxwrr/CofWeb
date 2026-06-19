<template>
  <div class="mobile-container">
    <div class="scroll-content">
      <nav class="top-nav">
        <button class="icon-btn anim-subtle">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <div class="logo"><span class="logo-text">Ijoo Staff</span></div>
      </nav>

      <transition name="tab-fade" mode="out-in">
        <div class="content" v-if="activeTab === 'dashboard'" key="dashboard">
          <h1 class="title">Ringkasan Hari Ini</h1>
          <p class="date-display">{{ todayDate }}</p>
          <div class="stats-grid">
            <div class="stat-card"><div class="stat-top"><span class="stat-number">{{ totalReservasi }}</span></div><p class="stat-label">TOTAL RESERVASI</p></div>
            <div class="stat-card"><div class="stat-top"><span class="stat-number">{{ pendingCount }}</span></div><p class="stat-label">MENUNGGU</p></div>
          </div>
          <div class="section-header"><h2>Status Meja Live</h2></div>
          <div class="table-status-scroll">
            <div class="table-card" v-for="table in tables" :key="table.id" :class="table.status === 'Occupied' ? 'card-occ' : ''">
              <p class="table-name">{{ table.id }}</p>
              <span class="status-dropdown">{{ table.status }}</span>
            </div>
          </div>
        </div>

        <div class="content" v-else-if="activeTab === 'reservations'" key="reservations">
          <h1 class="title">Daftar Reservasi</h1>
          <div class="reservation-list" style="margin-top: 24px;">
            <div class="res-card" v-for="res in reservations" :key="res.id">
              <div class="res-info">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                  <h3>{{ res.name }}</h3><span class="badge" :class="'badge-' + res.status">{{ res.status.toUpperCase() }}</span>
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

        <div class="content" v-else-if="activeTab === 'menu'" key="menu">
          <h1 class="title">Manajemen Menu</h1>
          <p class="date-display">Atur ketersediaan dan harga real-time.</p>
          <div class="menu-admin-list">
            <div class="menu-admin-card" v-for="item in menuItems" :key="item.id">
              <div class="menu-admin-image-section">
                <div class="menu-image-preview" v-if="item.imagePreview">
                  <img :src="item.imagePreview" :alt="item.name" class="menu-image">
                </div>
                <div class="menu-image-placeholder" v-else>
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A4B298" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
                <label class="upload-label">
                  <input 
                    type="file" 
                    class="file-input" 
                    accept="image/png,image/jpeg,image/webp,.png,.jpg,.jpeg,.webp"
                    @change="handleImageUpload($event, item.id)"
                  />
                  <span class="upload-btn">{{ item.imageFile ? '✓ Terpilih' : 'Unggah' }}</span>
                </label>
              </div>
              <div class="menu-admin-info">
                <h4>{{ item.name }}</h4>
                <p class="price-display">Rp{{ item.price.toLocaleString('id-ID') }}</p>
              </div>
            </div>
          </div>
          
          <div class="upload-status" v-if="uploadMessage">
            <p :class="uploadSuccess ? 'success-msg' : 'error-msg'">{{ uploadMessage }}</p>
          </div>
        </div>
      </transition>
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
          <input type="number" v-model.number="newMenu.harga" placeholder="Contoh: 35000" class="form-input" min="1" />
        </div>
        <div class="form-group">
          <label>GAMBAR (opsional)</label>
          <input type="file" accept="image/*" @change="onNewMenuImageSelected" class="form-input" />
          <span v-if="newMenuImageName" style="font-size:0.75rem;color:#5B6A4B;">{{ newMenuImageName }}</span>
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
      <a href="#" class="nav-item" :class="{ active: activeTab === 'dashboard' }" @click.prevent="changeTab('dashboard')">
        <div class="icon-wrapper"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></div>
        <span>Overview</span>
      </a>
      <a href="#" class="nav-item" :class="{ active: activeTab === 'reservations' }" @click.prevent="changeTab('reservations')">
        <div class="icon-wrapper"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
        <span>Reservasi</span>
      </a>
      <a href="#" class="nav-item" :class="{ active: activeTab === 'menu' }" @click.prevent="changeTab('menu')">
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
  occupyMeja, vacateMeja, uploadMenuImage
} from './services/api'

const todayDate = new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })

const activeTab = ref('dashboard')
const uploadMessage = ref('')
const uploadSuccess = ref(false)

const changeTab = (tab: string) => {
  activeTab.value = tab
  uploadMessage.value = ''
}

const exitToCustomer = () => {
  globalStore.isStaff = false
  globalStore.currentView = 'Home'
}

// 1. MEJA
const tables = ref<any[]>([])
const fetchMeja = async () => {
  try {
    const res = await getMeja()
    tables.value = res.data.map((m: any) => ({
      id: m.kode_meja,
      id_meja: m.id_meja,
      status: m.status_meja === 'terisi' ? 'Occupied' : 'Available',
    }))
  } catch (e) {
    console.error('Gagal memuat meja', e)
  }
}

// 2. RESERVASI
const reservations = ref<any[]>([])
const totalReservasi = computed(() => reservations.value.length)
const pendingCount = computed(() =>
  reservations.value.filter((r: any) => r.status === 'pending' || r.status === 'menunggu').length
)

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

const fetchReservasi = async () => {
  try {
    const res = await getReservasi()
    const statusMap: Record<string, string> = {
      menunggu: 'pending',
      disetujui: 'approved',
      dibayar: 'approved',
      hadir: 'arrived',
      ditolak: 'rejected',
    }
    reservations.value = res.data.map((r: any) => ({
      id: r.id_reservasi,
      name: r.nama_pelanggan,
      time: r.jam,
      pax: r.meja?.kapasitas || '-',
      tables: r.meja ? [r.meja.kode_meja] : [],
      status: statusMap[r.status_reservasi] || r.status_reservasi,
    }))
  } catch (e) {
    console.error('Gagal memuat reservasi', e)
  }
}

// 3. MENU
const menuItems = ref<any[]>([])

const handleImageUpload = async (event: Event, itemId: number) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  if (!file) return
  try {
    const bitmap = await createImageBitmap(file)
    const canvas = document.createElement('canvas')
    canvas.width = bitmap.width
    canvas.height = bitmap.height
    const ctx = canvas.getContext('2d')
    if (!ctx) throw new Error('Canvas not supported')
    ctx.drawImage(bitmap, 0, 0)
    const blob = await new Promise<Blob | null>((resolve) => canvas.toBlob(resolve, 'image/webp', 0.8))
    if (!blob) { uploadMessage.value = "Gagal memproses blob gambar."; uploadSuccess.value = false; return }
    const webpFile = new File([blob], `menu-${itemId}-${Date.now()}.webp`, { type: 'image/webp' })
    uploadMessage.value = "Mengunggah gambar..."
    const res = await uploadMenuImage(itemId, webpFile)
    const item = menuItems.value.find(m => m.id === itemId)
    if (item) {
      item.imagePreview = res.data.gambar
      item.imageFile = webpFile
    }
    uploadMessage.value = "Gambar berhasil diupload!"
    uploadSuccess.value = true
  } catch {
    uploadMessage.value = "Gagal mengupload gambar."
    uploadSuccess.value = false
  }
}

const fetchMenu = async () => {
  try {
    const res = await getMenus()
    menuItems.value = res.data.map((m: any) => ({
      id: m.id_menu,
      name: m.nama_item,
      price: m.harga,
      isAvailable: true,
      imagePreview: m.gambar || null,
      imageFile: null as File | null,
    }))
  } catch (e) {
    console.error('Gagal memuat menu', e)
  }
}

// 4. TAMBAH MENU
const showMenuForm = ref(false)
const newMenu = ref({ nama_item: '', harga: null as number | null, deskripsi: '' })
const newMenuImage = ref<File | null>(null)
const newMenuImageName = ref('')

const onNewMenuImageSelected = (e: Event) => {
  const input = e.target as HTMLInputElement
  const file = input.files?.[0]
  if (file) {
    newMenuImage.value = file
    newMenuImageName.value = file.name
  }
}

const submitNewMenu = async () => {
  if (!newMenu.value.nama_item || !newMenu.value.harga) return
  try {
    const res = await createMenu({
      nama_item: newMenu.value.nama_item,
      harga: Number(newMenu.value.harga),
      deskripsi: newMenu.value.deskripsi,
    })
    const createdId = res.data.menu.id_menu
    if (newMenuImage.value) {
      await uploadMenuImage(createdId, newMenuImage.value)
    }
    showMenuForm.value = false
    newMenu.value = { nama_item: '', harga: null, deskripsi: '' }
    newMenuImage.value = null
    newMenuImageName.value = ''
    await fetchMenu()
    uploadMessage.value = 'Menu berhasil ditambahkan!'
    uploadSuccess.value = true
  } catch (e: any) {
    uploadMessage.value = e?.response?.data?.message || 'Gagal menambahkan menu'
    uploadSuccess.value = false
  }
}

// 5. FAB
const handleFabClick = () => {
  if (activeTab.value === 'menu') showMenuForm.value = true
  else alert('Fitur sedang dalam pengembangan')
}

// INIT
onMounted(async () => {
  await Promise.all([fetchMeja(), fetchMenu(), fetchReservasi()])
})
</script>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { max-width: 414px; margin: 0 auto; background-color: #F4F7F0; color: #2A3620; min-height: 100vh; position: relative; }
.scroll-content { padding-bottom: 110px; height: 100vh; overflow-y: auto; scrollbar-width: none; }
.scroll-content::-webkit-scrollbar { display: none; }

/* TAB TRANSITION CLASSES */
.tab-fade-enter-active, .tab-fade-leave-active { transition: opacity 0.2s ease, transform 0.2s ease; }
.tab-fade-enter-from { opacity: 0; transform: translateX(10px); }
.tab-fade-leave-to { opacity: 0; transform: translateX(-10px); }

/* Standard Dashboard CSS */
.top-nav { display: flex; justify-content: space-between; padding: 20px 24px; align-items: center; }
.icon-btn { background: none; border: none; color: #5B6A4B; cursor: pointer; transition: transform 0.2s; }
.icon-btn:active { transform: scale(0.95); }
.logo-text { font-family: 'Georgia', serif; font-size: 1.5rem; font-weight: bold; }
.content { padding: 0 24px; }
.title { font-family: 'Georgia', serif; font-size: 1.8rem; font-weight: normal; margin-bottom: 8px; }
.date-display { font-size: 0.9rem; color: #4A5837; margin-bottom: 24px; }
.stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 32px; }
.stat-card { background-color: #EAEFE4; padding: 16px; border-radius: 12px; }
.stat-top { margin-bottom: 4px; color: #2A3620; }
.stat-number { font-family: 'Georgia', serif; font-size: 1.8rem; font-weight: bold;}
.stat-label { font-size: 0.65rem; font-weight: 600; color: #5B6A4B; letter-spacing: 0.5px; }

/* Reservation Styles */
.section-header { margin-bottom: 16px; }
.section-header h2 { font-family: 'Georgia', serif; font-size: 1.3rem; font-weight: normal; }
.table-status-scroll { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 10px; }
.table-card { background: white; border-radius: 12px; padding: 16px; min-width: 140px; text-align: center; }
.table-name { font-weight: 600; margin-bottom: 8px; }
.status-dropdown { font-size: 0.75rem; background: #EEF2EA; padding: 4px 8px; border-radius: 8px; display: inline-block; }
.card-occ { border: 1px solid #FFE0E0; background: #FFF5F5; }

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
.menu-admin-card { background: white; border-radius: 16px; padding: 16px; display: flex; gap: 16px; align-items: center; border: 1px solid rgba(74, 88, 55, 0.05); }

/* Image Upload CSS */
.menu-admin-image-section { display: flex; flex-direction: column; align-items: center; gap: 8px; }
.menu-image-placeholder { width: 56px; height: 56px; background: #EEF2EA; border-radius: 12px; display: flex; justify-content: center; align-items: center; }
.menu-image-preview { width: 56px; height: 56px; border-radius: 12px; overflow: hidden; border: 1px solid #D6DED0; }
.menu-image { width: 100%; height: 100%; object-fit: cover; }
.file-input { display: none; }
.upload-label { cursor: pointer; }
.upload-btn { font-size: 0.65rem; font-weight: 600; color: #4A5837; background: #EAEFE4; padding: 4px 8px; border-radius: 6px; transition: transform 0.2s; display: inline-block; }
.upload-label:active .upload-btn { transform: scale(0.95); }
.upload-status { margin-top: 24px; text-align: center; font-size: 0.85rem; font-weight: bold; }
.success-msg { color: #4A5837; }
.error-msg { color: #D32F2F; }

.menu-admin-info { flex: 1; }
.menu-admin-info h4 { font-size: 0.95rem; margin-bottom: 4px; color: #2A3620; }
.price-display { font-size: 0.85rem; color: #5B6A4B; font-weight: bold; }

/* Modal */
.modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 10000; }
.modal-overlay .modal-content { background: white; padding: 24px; border-radius: 16px; width: 85%; max-width: 340px; }
.modal-overlay .modal-content h3 { font-family: 'Georgia', serif; margin-bottom: 20px; }
.modal-overlay .form-group { margin-bottom: 16px; }
.modal-overlay .form-group label { display: block; font-size: 0.7rem; font-weight: 600; color: #5B6A4B; margin-bottom: 6px; letter-spacing: 0.5px; }
.modal-overlay .form-input { width: 100%; padding: 12px; border: 1px solid #D6DED0; border-radius: 10px; font-size: 0.9rem; outline: none; }
.modal-overlay .modal-actions { display: flex; gap: 12px; margin-top: 24px; }
.modal-overlay .modal-actions .btn-sm { flex: 1; }
.modal-overlay .btn-sm:disabled { opacity: 0.5; cursor: not-allowed; }

/* FAB */
.fab-btn { position: fixed; bottom: 84px; left: 50%; transform: translateX(130px); width: 52px; height: 52px; background-color: #4A5837; border-radius: 50%; border: none; display: flex; justify-content: center; align-items: center; box-shadow: 0 4px 12px rgba(74, 88, 55, 0.3); cursor: pointer; z-index: 999; transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
.fab-btn:active { transform: translateX(130px) scale(0.92); }

/* Bottom Nav */
.staff-bottom-nav { position: fixed; bottom: 0; left: 50%; transform: translateX(-50%); width: 100%; max-width: 414px; background: white; display: flex; justify-content: space-around; padding: 12px 0; border-top-left-radius: 24px; border-top-right-radius: 24px; box-shadow: 0 -4px 20px rgba(0,0,0,0.05); z-index: 9999; }
.staff-bottom-nav .nav-item { display: flex; flex-direction: column; align-items: center; text-decoration: none; color: #A0A0A0; gap: 4px; flex: 1; transition: color 0.3s ease; }
.staff-bottom-nav .nav-item span { font-size: 0.65rem; font-weight: 500; }
.icon-wrapper { padding: 6px 16px; border-radius: 16px; display: flex; justify-content: center; align-items: center; transition: background-color 0.3s ease, transform 0.2s;}
.staff-bottom-nav .nav-item:active .icon-wrapper { transform: scale(0.9); }
.staff-bottom-nav .nav-item.active { color: #4A5837; }
.staff-bottom-nav .nav-item.active .icon-wrapper { background: #EEF2EA; }
</style>