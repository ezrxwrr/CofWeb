<template>
  <div class="mobile-container">
    <div class="sidebar-overlay" v-if="isSidebarOpen" @click="isSidebarOpen = false"></div>
    <div class="sidebar" :class="{ 'open': isSidebarOpen }">
      <div class="sidebar-header">
        <span class="logo-text">Ijoo Coffee</span>
        <button class="close-btn" @click="isSidebarOpen = false">✕</button>
      </div>
      <div class="sidebar-content">
        <p class="sidebar-label">PILIH PERAN</p>
        <button 
          class="role-btn" 
          :class="{ 'active': !globalStore.isStaff }" 
          @click="selectCustomer"
        >
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Pelanggan
        </button>
        <button 
          class="role-btn" 
          :class="{ 'active': globalStore.isStaff }" 
          @click="selectStaff"
        >
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          Staff / Admin
        </button>
      </div>
    </div>

    <div class="login-modal" v-if="showLoginModal">
      <div class="modal-content">
        <button class="close-modal-btn" @click="showLoginModal = false">✕</button>
        <h3 class="modal-title">Akses Staff</h3>
        <p class="modal-desc">Masukkan kredensial Anda.</p>
        
        <div class="form-group">
          <input type="text" v-model="loginForm.username" placeholder="Username" class="form-input" />
        </div>
        <div class="form-group">
          <input type="password" v-model="loginForm.password" placeholder="Password" class="form-input" />
        </div>
        
        <p class="error-msg" v-if="loginError">Username atau Password salah!</p>
        
        <button class="btn btn-primary" style="margin-top: 16px;" @click="handleLogin">Masuk</button>
      </div>
    </div>

    <nav class="top-nav">
      <button class="icon-btn hamburger-btn" @click="isSidebarOpen = true">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      <div class="logo"><span class="logo-text">Ijoo</span></div>
    </nav>

    <header class="hero">
      <div class="hero-image-placeholder">
        <div class="hero-overlay">
          <h2>The Art of<br>Respite</h2>
          <p>A moment of calm in your busy day.</p>
        </div>
      </div>
    </header>

    <div class="cta-group">
      <button class="btn btn-history" @click="goToOrderHistory">Riwayat Pesanan</button>
    </div>

    <section class="philosophy-card">
      <h3>Filosofi Kami</h3>
      <p>We believe in the slow pour. In a world that demands speed, we offer a sanctuary where time is measured in steeps and sips. Every cup is an invitation to pause, breathe, and find clarity.</p>
    </section>

    <section class="menu-section">
      <h3>Signature Matcha</h3>
      <div class="horizontal-scroll">
        <div class="product-card" v-for="item in signatureItems" :key="item.id">
          <div class="product-image-placeholder"></div>
          <div class="product-info">
            <h4>{{ item.name }}</h4>
            <p>{{ item.desc }}</p>
            <div class="product-bottom">
              <span class="price">{{ item.price }}</span>
              <button class="add-btn" @click="goToMenu">+</button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { globalStore } from './store'
import { staffLogin } from './services/api'

const signatureItems = ref([
  { id: 1, name: 'Iced Ceremonial Matcha', desc: 'Smooth, layered, deeply refreshing.', price: 'IDR 45K' },
  { id: 2, name: 'Hojicha Latte', desc: 'Roasted green tea with creamy milk.', price: 'IDR 40K' }
])

const goToMenu = () => { globalStore.currentView = 'Menu' }
const goToOrderHistory = () => { globalStore.currentView = 'OrderHistory' }

// Logika Sidebar & Login
const isSidebarOpen = ref(false)
const showLoginModal = ref(false)
const loginError = ref(false)

const loginForm = reactive({
  username: '',
  password: ''
})

const selectCustomer = () => {
  globalStore.isStaff = false
  isSidebarOpen.value = false
  globalStore.currentView = 'Home'
}

const selectStaff = () => {
  if (globalStore.isStaff) {
    // Kalau sudah login, langsung lempar ke dashboard
    isSidebarOpen.value = false
    globalStore.currentView = 'StaffDashboard'
  } else {
    // Kalau belum login, buka pop up login
    showLoginModal.value = true
    isSidebarOpen.value = false
  }
}

const handleLogin = async () => {
  try {
    const res = await staffLogin(loginForm.username, loginForm.password)
    globalStore.isStaff = true
    globalStore.staffName = res.data.staff.nama_staff
    showLoginModal.value = false
    loginError.value = false
    loginForm.username = ''
    loginForm.password = ''
    globalStore.currentView = 'StaffDashboard'
  } catch {
    loginError.value = true
  }
}
</script>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { max-width: 414px; margin: 0 auto; background-color: var(--bg-main); color: var(--text-main); min-height: 100vh; position: relative; padding-bottom: 100px; overflow-x: hidden; }

/* Sidebar Styles */
.sidebar-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 10000; }
.sidebar { position: fixed; top: 0; left: -280px; width: 280px; height: 100%; background: white; z-index: 10001; transition: 0.3s ease-in-out; box-shadow: 4px 0 20px rgba(0,0,0,0.1); display: flex; flex-direction: column; }
.sidebar.open { left: 0; }
.sidebar-header { display: flex; justify-content: space-between; align-items: center; padding: 24px; border-bottom: 1px solid rgba(74, 88, 55, 0.1); }
.close-btn { background: none; border: none; font-size: 1.2rem; color: #5B6A4B; cursor: pointer; }
.sidebar-content { padding: 24px; }
.sidebar-label { font-size: 0.7rem; font-weight: 600; color: #8C9C7B; letter-spacing: 1px; margin-bottom: 16px; }
.role-btn { width: 100%; display: flex; align-items: center; gap: 12px; padding: 16px; background: transparent; border: 1px solid transparent; border-radius: 12px; font-weight: 600; color: #5B6A4B; cursor: pointer; margin-bottom: 12px; transition: 0.2s; }
.role-btn.active { background: #EEF2EA; border-color: var(--primary); color: var(--primary); }

/* Login Modal Styles */
.login-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 10002; }
.modal-content { background: white; padding: 32px 24px; border-radius: 20px; width: 85%; max-width: 320px; position: relative; text-align: center; }
.close-modal-btn { position: absolute; top: 16px; right: 16px; background: none; border: none; font-size: 1.2rem; color: #5B6A4B; cursor: pointer; }
.modal-title { font-family: var(--font-serif); font-size: 1.5rem; margin-bottom: 8px; color: var(--text-main); }
.modal-desc { font-size: 0.85rem; color: #5B6A4B; margin-bottom: 24px; }
.form-group { margin-bottom: 16px; }
.form-input { width: 100%; padding: 14px 16px; border: 1px solid #D6DED0; border-radius: 12px; font-size: 0.95rem; outline: none; }
.error-msg { color: #D32F2F; font-size: 0.8rem; margin-top: -8px; margin-bottom: 8px; text-align: left; }

/* Original Home Styles */
.top-nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; }

.hamburger-btn { background: none; border: none; color: var(--text-main); cursor: pointer; transition: transform 0.3s ease; }
.hamburger-btn:active { transform: scale(0.95); }

/* Hamburger animation */
.hamburger-btn svg {
  animation: hamburgerSlideInRight 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes hamburgerSlideInRight {
  from {
    transform: translateX(-15px);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

.logo-text { font-family: var(--font-serif); font-size: 1.5rem; font-weight: bold; letter-spacing: -1px; }
.hero { padding: 0 20px; margin-bottom: 24px; }
.hero-image-placeholder { background: #334; border-radius: 24px; height: 300px; display: flex; align-items: flex-end; overflow: hidden; }
.hero-overlay { padding: 24px; color: #fff; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); width: 100%; }
.hero-overlay h2 { font-family: var(--font-serif); font-size: 2rem; margin-bottom: 8px; font-weight: normal; }
.hero-overlay p { font-size: 0.9rem; color: #ddd; }

/* Updated CTA Group - Single Button */
.cta-group { 
  display: flex; 
  flex-direction: column; 
  gap: 12px; 
  padding: 0 20px; 
  margin-bottom: 32px; 
}

.btn { 
  padding: 16px; 
  border-radius: 30px; 
  font-weight: 600; 
  font-size: 0.95rem; 
  cursor: pointer; 
  text-align: center; 
  transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
  border: none;
  position: relative;
  overflow: hidden;
}

.btn:active { 
  transform: scale(0.97);
}

/* Riwayat Pesanan Button - Enhanced Styling */
.btn-history {
  background: linear-gradient(135deg, #4A5837 0%, #5B6A4B 100%);
  color: white;
  box-shadow: 0 8px 20px rgba(74, 88, 55, 0.3);
  animation: slideDownFadeIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.btn-history:hover {
  box-shadow: 0 12px 28px rgba(74, 88, 55, 0.4);
}

.btn-history:active {
  transform: scale(0.97) translateY(2px);
  box-shadow: 0 4px 12px rgba(74, 88, 55, 0.3);
}

@keyframes slideDownFadeIn {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.btn-primary { background-color: var(--primary); color: rgb(69, 68, 68); border: none; }
.btn-outline { background-color: transparent; color: var(--primary); border: 1px solid var(--primary); }

.philosophy-card { background-color: var(--card-bg); margin: 0 20px 40px; padding: 32px 24px; border-radius: 20px; }
.philosophy-card h3 { font-family: var(--font-serif); font-size: 1.3rem; margin-bottom: 16px; color: var(--primary); font-weight: normal; }
.philosophy-card p { line-height: 1.6; font-size: 0.95rem; }
.menu-section { padding-left: 20px; margin-bottom: 40px; }
.menu-section h3 { font-family: var(--font-serif); font-size: 1.3rem; margin-bottom: 16px; color: var(--primary); font-weight: normal; }
.horizontal-scroll { display: flex; gap: 16px; overflow-x: auto; padding-bottom: 10px; scrollbar-width: none; }
.horizontal-scroll::-webkit-scrollbar { display: none; }
.product-card { min-width: 260px; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
.product-image-placeholder { height: 160px; background-color: var(--card-bg); }
.product-info { padding: 16px; }
.product-info h4 { margin-bottom: 6px; font-size: 1.05rem; font-family: var(--font-serif); font-weight: normal; }
.product-info p { margin-bottom: 16px; font-size: 0.85rem; color: #666; line-height: 1.4; }
.product-bottom { display: flex; justify-content: space-between; align-items: center; }
.price { font-weight: bold; font-size: 0.9rem; color: var(--primary); }
.add-btn { background-color: var(--primary); border: none; border-radius: 50%; width: 28px; height: 28px; color: white; cursor: pointer; transition: transform 0.2s; }
.add-btn:active { transform: scale(0.9); }
</style>