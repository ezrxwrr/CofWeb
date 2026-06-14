<template>
  <div class="mobile-container">
    <nav class="top-nav">
      <button class="icon-btn" @click="globalStore.currentView = 'TableReservation'"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg></button>
      <div class="logo"><span class="logo-text">Ijoo</span></div>
    </nav>

    <header class="page-header">
      <h2>Pre-order Menu</h2>
      <p>Pilih menu untuk meja {{ globalStore.reservation.tables.join(', ') }}</p>
    </header>

    <div class="menu-list">
      <div class="menu-card" v-for="item in menuItems" :key="item.id" @click="addToCart(item)">
        <div class="emoji-placeholder">{{ item.emoji }}</div>
        
        <div class="card-content">
          <h3>{{ item.name }}</h3>
          <p class="desc">{{ item.desc }}</p>
          <div class="card-bottom">
            <span class="price">Rp {{ item.price.toLocaleString('id-ID') }}</span>
            
            <div class="qty-controls" v-if="getItemCount(item.id) > 0">
              <button class="qty-btn" @click.stop="removeFromCart(item.id)">-</button>
              <span class="qty-count">{{ getItemCount(item.id) }}</span>
              <button class="qty-btn" @click.stop="addToCart(item)">+</button>
            </div>
            <button class="add-btn" v-else @click.stop="addToCart(item)">+</button>
          </div>
        </div>
      </div>
    </div>

    <div style="height: 120px;"></div>

    <div class="floating-checkout" v-if="globalStore.cart.length > 0" @click="goToPayment">
      <div class="checkout-info">
        <span class="checkout-qty">{{ globalStore.cart.length }} Item</span>
        <span class="checkout-total">Rp {{ globalStore.total.toLocaleString('id-ID') }}</span>
      </div>
      <div class="checkout-action">
        <span>Bayar</span>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { globalStore } from './store'

const menuItems = ref([
  { id: 1, name: 'Iced Ceremonial Matcha', desc: 'Smooth, layered, deeply refreshing.', price: 45000, emoji: '🍵' },
  { id: 2, name: 'Hojicha Latte', desc: 'Roasted green tea with creamy milk.', price: 40000, emoji: '☕' },
  { id: 3, name: 'Chocoberry', desc: 'Dark chocolate blended with pure blueberry.', price: 45000, emoji: '🫐' },
  { id: 4, name: 'Cheese Cake', desc: 'Classic basque burnt cheesecake.', price: 38000, emoji: '🍰' },
  { id: 5, name: 'Chicken Ricebowl', desc: 'Tender chicken with authentic sambal matah.', price: 48000, emoji: '🍱' },
  { id: 6, name: 'Truffle Fries', desc: 'Crispy fries tossed in truffle oil and parmesan.', price: 35000, emoji: '🍟' }
])

const getItemCount = (id: number) => {
  return globalStore.cart.filter(item => item.id === id).length
}

const addToCart = (item: any) => {
  globalStore.cart.push(item)
  calculateTotal()
}

const removeFromCart = (id: number) => {
  const index = globalStore.cart.findIndex(item => item.id === id)
  if (index !== -1) {
    globalStore.cart.splice(index, 1)
    calculateTotal()
  }
}

const calculateTotal = () => {
  globalStore.subtotal = globalStore.cart.reduce((sum, item) => sum + item.price, 0)
  globalStore.tax = globalStore.subtotal * 0.1 
  globalStore.total = globalStore.subtotal + globalStore.tax
}

const goToPayment = () => {
  globalStore.currentView = 'Payment'
}
</script>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { background: var(--bg-main); color: var(--text-main); min-height: 100vh; position: relative;}
.top-nav { display: flex; justify-content: space-between; padding: 20px 24px; }
.icon-btn { background: none; border: none; color: var(--text-main); cursor: pointer; }
.logo-text { font-family: var(--font-serif); font-size: 1.5rem; font-weight: bold; }
.page-header { padding: 0 24px; margin-bottom: 20px; }
.page-header h2 { font-family: var(--font-serif); font-size: 1.8rem; margin-bottom: 8px;}
.page-header p { font-size: 0.9rem; color: #5B6A4B; }

.menu-list { padding: 0 24px; display: flex; flex-direction: column; gap: 16px; }
.menu-card { display: flex; align-items: center; gap: 16px; background: white; border-radius: 16px; padding: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); cursor: pointer; transition: 0.2s; border: 1px solid transparent; }
.menu-card:active { transform: scale(0.98); border-color: var(--primary); }

.emoji-placeholder { font-size: 2.2rem; background-color: var(--card-bg); width: 80px; height: 80px; display: flex; justify-content: center; align-items: center; border-radius: 12px; flex-shrink: 0; }
.card-content { flex: 1; pointer-events: none; }
.card-content h3 { font-family: var(--font-serif); font-size: 1rem; }
.desc { font-size: 0.8rem; color: #666; margin: 4px 0 12px; line-height: 1.3;}
.card-bottom { display: flex; justify-content: space-between; align-items: center; pointer-events: auto;}
.price { font-weight: 600; color: var(--primary); font-size: 0.9rem;}

/* Style Kontrol Plus Minus */
.add-btn { background-color: var(--primary); color: white; border: none; border-radius: 50%; width: 28px; height: 28px; display: flex; justify-content: center; align-items: center; cursor: pointer;}
.qty-controls { display: flex; align-items: center; gap: 12px; background: #EEF2EA; border-radius: 20px; padding: 4px 6px; }
.qty-btn { background: white; color: var(--primary); border: none; width: 24px; height: 24px; border-radius: 50%; font-weight: bold; cursor: pointer; display: flex; justify-content: center; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);}
.qty-count { font-size: 0.9rem; font-weight: bold; color: var(--primary); min-width: 12px; text-align: center;}

.floating-checkout { position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%); width: calc(100% - 48px); max-width: 366px; background-color: #4A5837; color: white; padding: 16px 20px; border-radius: 16px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 10px 25px rgba(74, 88, 55, 0.4); cursor: pointer; z-index: 9999; transition: transform 0.2s; }
.floating-checkout:active { transform: translateX(-50%) scale(0.96); }
.checkout-info { display: flex; flex-direction: column; gap: 4px; }
.checkout-qty { font-size: 0.75rem; background: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 12px; width: fit-content; }
.checkout-total { font-weight: bold; font-family: var(--font-serif); font-size: 1.1rem; }
.checkout-action { display: flex; align-items: center; gap: 8px; font-weight: bold; font-size: 1rem; }
</style>