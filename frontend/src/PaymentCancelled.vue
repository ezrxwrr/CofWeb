<template>
  <div class="mobile-container">
    <nav class="top-nav">
      <button class="icon-btn"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
      <div class="logo"><span class="logo-text">Ijoo</span></div>
    </nav>

    <div class="content">
      <div class="icon-circle">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 15 15"/><line x1="4" y1="4" x2="20" y2="20"/></svg>
      </div>
      <h1 class="title">Waktu Pembayaran<br>Habis</h1>
      <p class="desc">Mohon maaf, sesi pembayaran Anda telah berakhir. Reservasi telah otomatis dibatalkan untuk memberikan kesempatan bagi pelanggan lain yang sedang menunggu.</p>

      <div class="note-card">
        <div class="note-content">
          <p class="note-title">CATATAN</p>
          <p class="note-text">Meja Anda telah dikembalikan seperti semula. Jangan khawatir, Anda dapat memulai proses reservasi kapan saja.</p>
        </div>
      </div>
    </div>

    <div class="bottom-area">
      <button class="btn-outline">KEMBALI KE BERANDA</button>
    </div>
  </div>
</template>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --primary: #4A5837; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { max-width: 414px; margin: 0 auto; background-color: var(--bg-main); color: var(--text-main); min-height: 100vh; display: flex; flex-direction: column; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
.top-nav { display: flex; justify-content: space-between; padding: 20px 24px; }
.icon-btn { background: none; border: none; color: #5B6A4B; cursor: pointer; }
.logo-text { font-family: var(--font-serif); font-size: 1.5rem; font-weight: bold; }
.content { padding: 20px 24px 40px; text-align: center; flex: 1; }
.icon-circle { width: 100px; height: 100px; background-color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 32px; }
.title { font-family: var(--font-serif); font-size: 2rem; font-weight: normal; margin-bottom: 24px; line-height: 1.2; }
.desc { font-size: 0.95rem; color: var(--primary); line-height: 1.6; margin-bottom: 40px; }
.note-card { background-color: rgba(246, 248, 240, 0.8); border-radius: 16px; padding: 20px; text-align: left; border: 1px solid rgba(74, 88, 55, 0.1); }
.note-title { font-size: 0.7rem; font-weight: 600; color: #5B6A4B; margin-bottom: 6px; }
.note-text { font-size: 0.9rem; line-height: 1.5; }
.bottom-area { padding: 0 24px 32px; }
.btn-outline { width: 100%; padding: 16px; border-radius: 30px; border: 1px solid var(--text-main); background-color: transparent; color: var(--text-main); font-weight: 500; font-size: 0.85rem; cursor: pointer; }
</style>