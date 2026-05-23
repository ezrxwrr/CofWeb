<template>
  <div class="mobile-container">
    <nav class="top-nav">
      <button class="icon-btn"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg></button>
      <h1 class="page-title">Pembayaran</h1>
      <button class="icon-btn" style="opacity: 0"><svg width="24" height="24"></svg></button>
    </nav>

    <div class="content">
      <p class="section-label">RINGKASAN PESANAN</p>
      <div class="summary-card">
        <div class="summary-row"><span>1x Chocoberry</span><span>Rp 45.000</span></div>
        <div class="summary-row"><span>1x Cheese Cake</span><span>Rp 38.000</span></div>
        <div class="summary-row"><span>Pajak (10%)</span><span>Rp 8.300</span></div>
        <div class="card-divider"></div>
        <div class="summary-row total-row">
          <span class="total-label">Total</span>
          <span class="total-value">Rp 91.300</span>
        </div>
      </div>

      <div class="page-divider"></div>

      <p class="section-label">SCAN UNTUK MEMBAYAR</p>
      <p class="sub-label">Gunakan aplikasi e-wallet atau m-banking Anda.</p>

      <div class="qr-wrapper">
        <div class="qris-badge">QRIS</div>
        <div class="qr-container">
          <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMDAiIGhlaWdodD0iMjAwIiB2aWV3Qm94PSIwIDAgMjAwIDIwMCI+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0iI2ZmZiIvPjxwYXRoIGQ9Ik0yMCAyMGg1MHY1MEgyMHptMTAgMTBoMzB2MzBIMzB6TTEzMCAyMGg1MHY1MGgtNTB6bTEwIDEwaDMwdjMwaC0zMHpNMjAgMTMwaDUwdjUwSDIwem0xMCAxMGgzMHYzMEgzMHpNODAgMjBoMzB2MzBIODB6TTEwMCA4MGg1MHY1MGgtNTB6TTgwIDEzMGgzMHYzMEg4MHpNMTMwIDEzMGgzMHYzMGgtMzB6IiBmaWxsPSIjMkEzNjIwIi8+PC9zdmc+" alt="QR Code" class="qr-image" />
        </div>
      </div>

      <div class="timer-info">
        <span>⏱ Menunggu pembayaran... (04:59)</span>
      </div>

      <div class="page-divider"></div>

      <p class="section-label">LANGKAH TERAKHIR</p>
      <p class="sub-label">Setelah scan, kirim bukti ke admin kami.</p>

      <button class="btn-wa">Konfirmasi via WhatsApp</button>
    </div>
  </div>
</template>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { max-width: 414px; margin: 0 auto; background-color: var(--bg-main); color: var(--text-main); min-height: 100vh; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
.top-nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; }
.icon-btn { background: none; border: none; color: #5B6A4B; cursor: pointer; }
.page-title { font-family: var(--font-serif); font-size: 1.3rem; font-weight: normal; }
.content { padding: 12px 24px 40px; text-align: center; }
.section-label { font-size: 0.7rem; font-weight: 600; color: #5B6A4B; letter-spacing: 1px; margin-bottom: 16px; }
.sub-label { font-size: 0.9rem; margin-bottom: 24px; line-height: 1.4; }
.summary-card { background-color: var(--card-bg); border-radius: 12px; padding: 20px 24px; text-align: left; }
.summary-row { display: flex; justify-content: space-between; font-size: 0.95rem; color: var(--primary); margin-bottom: 16px; }
.card-divider { border-top: 1px solid rgba(74, 88, 55, 0.15); margin: 20px 0; }
.total-row { align-items: center; margin-top: 20px; }
.total-label, .total-value { font-family: var(--font-serif); font-size: 1.25rem; font-weight: bold; color: var(--primary); }
.page-divider { border-top: 1px solid rgba(74, 88, 55, 0.1); margin: 32px 0; }
.qr-wrapper { position: relative; width: 200px; margin: 0 auto 20px; }
.qris-badge { position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--primary); color: white; font-size: 0.7rem; font-weight: 600; padding: 4px 16px; border-radius: 20px; z-index: 2; }
.qr-container { background: white; padding: 16px; border-radius: 16px; }
.qr-image { width: 100%; height: auto; display: block; border: 4px solid var(--primary); border-radius: 8px; }
.timer-info { font-size: 0.85rem; color: #5B6A4B; }
.btn-wa { width: 100%; background-color: var(--primary); color: white; border: none; padding: 16px; border-radius: 12px; font-weight: 500; font-size: 0.95rem; cursor: pointer; margin-top: 16px; }
</style>