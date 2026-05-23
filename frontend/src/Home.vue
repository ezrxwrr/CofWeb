<template>
  <div class="mobile-container">
    <nav class="top-nav">
      <button class="icon-btn"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg></button>
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
      <button class="btn btn-primary">Reservasi Sekarang</button>
      <button class="btn btn-outline">Lihat Menu</button>
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
              <button class="add-btn">+</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <nav class="bottom-nav">
      <a href="#" class="nav-item active">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
        <span>Home</span>
      </a>
      <a href="#" class="nav-item">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <span>Reserve</span>
      </a>
      <a href="#" class="nav-item">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
        <span>Menu</span>
      </a>
      <a href="#" class="nav-item">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        <span>Dashboard</span>
      </a>
    </nav>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const signatureItems = ref([
  { id: 1, name: 'Iced Ceremonial Matcha', desc: 'Smooth, layered, deeply refreshing.', price: 'IDR 45K' },
  { id: 2, name: 'Hojicha Latte', desc: 'Roasted green tea with creamy milk.', price: 'IDR 40K' }
])
</script>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { max-width: 414px; margin: 0 auto; background-color: var(--bg-main); color: var(--text-main); min-height: 100vh; position: relative; padding-bottom: 80px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow-x: hidden; }
.top-nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; }
.icon-btn { background: none; border: none; color: var(--text-main); cursor: pointer; }
.logo-text { font-family: var(--font-serif); font-size: 1.5rem; font-weight: bold; letter-spacing: -1px; }
.hero { padding: 0 20px; margin-bottom: 24px; }
.hero-image-placeholder { background: #334; border-radius: 24px; height: 300px; display: flex; align-items: flex-end; overflow: hidden; }
.hero-overlay { padding: 24px; color: #fff; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); width: 100%; }
.hero-overlay h2 { font-family: var(--font-serif); font-size: 2rem; margin-bottom: 8px; font-weight: normal; }
.hero-overlay p { font-size: 0.9rem; color: #ddd; }
.cta-group { display: flex; flex-direction: column; gap: 12px; padding: 0 20px; margin-bottom: 32px; }
.btn { padding: 16px; border-radius: 30px; font-weight: 600; font-size: 0.95rem; cursor: pointer; text-align: center; }
.btn-primary { background-color: var(--primary); color: white; border: none; }
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
.add-btn { background-color: var(--primary); border: none; border-radius: 50%; width: 28px; height: 28px; color: white; cursor: pointer; }
.bottom-nav { position: absolute; bottom: 0; left: 0; width: 100%; background: white; display: flex; justify-content: space-around; padding: 16px 0; border-top-left-radius: 24px; border-top-right-radius: 24px; box-shadow: 0 -4px 20px rgba(0,0,0,0.05); }
.nav-item { display: flex; flex-direction: column; align-items: center; text-decoration: none; color: #A0A0A0; gap: 4px; }
.nav-item span { font-size: 0.7rem; }
.nav-item.active { color: var(--primary); }
</style>