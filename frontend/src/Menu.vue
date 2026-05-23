<template>
  <div class="mobile-container">
    <nav class="top-nav">
      <button class="icon-btn"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg></button>
      <div class="logo"><span class="logo-text">Ijoo</span></div>
    </nav>

    <header class="page-header">
      <h2>Curated Menu</h2>
      <p>Select your respite for today.</p>
    </header>

    <div class="categories">
      <button class="pill active">Matcha Series</button>
      <button class="pill">Coffee</button>
      <button class="pill">Pastries</button>
    </div>

    <div class="menu-list">
      <div class="menu-card" v-for="item in menuItems" :key="item.id">
        <div class="card-image-placeholder"></div>
        <div class="card-content">
          <h3>{{ item.name }}</h3>
          <p class="desc">{{ item.desc }}</p>
          <div class="card-bottom">
            <span class="price">{{ item.price }}</span>
            <button class="add-btn">+</button>
          </div>
        </div>
      </div>
    </div>

    <div class="cart-sheet">
      <div class="drag-handle"></div>
      <div class="cart-header">
        <h3>Pesanan Anda</h3>
        <span class="badge">2 Items</span>
      </div>
      <div class="cart-items">
        <div class="cart-item"><span>1x Chocoberry</span><span>Rp 45.000</span></div>
        <div class="cart-item"><span>1x Cheese Cake</span><span>Rp 38.000</span></div>
      </div>
      <hr class="divider" />
      <div class="cart-summary">
        <div class="summary-row"><span>Subtotal</span><span>Rp 83.000</span></div>
        <div class="summary-row"><span>Tax (10%)</span><span>Rp 8.300</span></div>
        <div class="summary-row total-row">
          <span class="summary-label bold">Total</span>
          <span class="summary-value total-price">Rp 91.300</span>
        </div>
      </div>
      <button class="checkout-btn">Lanjut ke Pembayaran</button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
const menuItems = ref([
  { id: 1, name: 'Chocoberry', desc: 'Dark chocolate blended with pure blueberry and creamy milk.', price: 'Rp 45.000' },
  { id: 2, name: 'Chicken Ricebowl', desc: 'A comforting bowl of tender chicken served with authentic sambal matah.', price: 'Rp 48.000' }
])
</script>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { max-width: 414px; margin: 0 auto; background-color: var(--bg-main); color: var(--text-main); min-height: 100vh; position: relative; padding-bottom: 340px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
.top-nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; }
.icon-btn { background: none; border: none; color: var(--text-main); cursor: pointer; }
.logo-text { font-family: var(--font-serif); font-size: 1.5rem; font-weight: bold; }
.page-header { padding: 0 24px; margin-bottom: 20px; }
.page-header h2 { font-family: var(--font-serif); font-size: 1.8rem; font-weight: normal; margin-bottom: 6px; }
.page-header p { color: #5B6A4B; font-size: 0.9rem; }
.categories { display: flex; gap: 10px; padding: 0 24px; margin-bottom: 24px; overflow-x: auto; scrollbar-width: none; }
.categories::-webkit-scrollbar { display: none; }
.pill { padding: 8px 16px; border-radius: 20px; border: 1px solid #D6DED0; background: white; color: var(--text-main); font-size: 0.85rem; white-space: nowrap; cursor: pointer; }
.pill.active { background-color: var(--primary); color: white; border-color: var(--primary); }
.menu-list { padding: 0 24px; display: flex; flex-direction: column; gap: 20px; }
.menu-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
.card-image-placeholder { height: 200px; background-color: var(--card-bg); }
.card-content { padding: 20px; }
.card-content h3 { font-family: var(--font-serif); font-size: 1.2rem; font-weight: normal; margin-bottom: 8px; }
.card-content .desc { font-size: 0.85rem; color: #666; line-height: 1.4; margin-bottom: 16px; }
.card-bottom { display: flex; justify-content: space-between; align-items: center; }
.price { font-weight: 600; font-size: 0.95rem; color: var(--primary); }
.add-btn { background-color: var(--primary); border: none; border-radius: 50%; width: 30px; height: 30px; color: white; cursor: pointer; }
.cart-sheet { position: absolute; bottom: 0; left: 0; width: 100%; background: white; border-radius: 24px 24px 0 0; padding: 16px 24px 32px; box-shadow: 0 -10px 25px rgba(0,0,0,0.06); z-index: 10; }
.drag-handle { width: 40px; height: 4px; background-color: #E0E0E0; border-radius: 2px; margin: 0 auto 20px; }
.cart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
.cart-header h3 { font-family: var(--font-serif); font-size: 1.3rem; font-weight: normal; }
.badge { background-color: #A3B18A; color: white; padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;}
.cart-items { display: flex; flex-direction: column; gap: 10px; margin-bottom: 16px; }
.cart-item { display: flex; justify-content: space-between; font-size: 0.85rem; color: #555; }
.divider { border: 0; height: 1px; background-color: #EAEAEA; margin: 16px 0; }
.cart-summary { display: flex; flex-direction: column; gap: 8px; margin-bottom: 24px; }
.summary-row { display: flex; justify-content: space-between; font-size: 0.85rem; color: #555; }
.total-row { margin-top: 8px; color: var(--text-main); }
.summary-label.bold { font-weight: bold; font-size: 1.1rem; }
.total-price { font-family: var(--font-serif); font-size: 1.2rem; font-weight: bold; }
.checkout-btn { width: 100%; background-color: var(--primary); color: white; border: none; padding: 16px; border-radius: 12px; font-weight: 600; font-size: 0.95rem; cursor: pointer; }
</style>