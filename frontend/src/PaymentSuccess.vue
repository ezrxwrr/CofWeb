<template>
  <div class="mobile-container">
    <div class="hero-image">
      <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiB2aWV3Qm94PSIwIDAgNDAwIDMwMCI+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0iIzMzNCIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBkb21pbmFudC1iYXNlbGluZT0ibWlkZGxlIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjYWFhIiBmb250LWZhbWlseT0ic2Fucy1zZXJpZiIgZm9udC1zaXplPSIyMCI+U3VjY2VzcyBJbWFnZTwvdGV4dD48L3N2Zz4=" alt="Success" />
    </div>
    <div class="content">
      <h1 class="title">Terima Kasih atas<br>Pesanan Anda!</h1>
      <p class="subtitle">Reservasi Anda telah berhasil kami terima. Silakan temukan detail kunjungan Anda di bawah ini.</p>
      
      <div class="detail-card">
        <div class="card-header">
          <span class="label">DETAIL RESERVASI</span>
        </div>
        <div class="detail-row"><span class="row-label">NAMA PEMESAN</span><span class="row-value">Anyone</span></div>
        <div class="detail-row"><span class="row-label">MEJA</span><span class="row-value">Meja 4 - Luar Ruangan</span></div>
        <div class="detail-row"><span class="row-label">WAKTU</span><span class="row-value">14:00, 24 Mei 2026</span></div>
        <div class="detail-row"><span class="row-label">JUMLAH TAMU</span><span class="row-value">2 Orang</span></div>
      </div>

      <div class="actions">
        <button class="btn btn-primary">Kembali ke Beranda</button>
        <button class="btn btn-outline">Simpan Bukti</button>
      </div>
      <p class="watermark">Ijoo Coffee</p>
    </div>
  </div>
</template>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { max-width: 414px; margin: 0 auto; background-color: var(--bg-main); color: var(--text-main); min-height: 100vh; display: flex; flex-direction: column; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
.hero-image { width: 100%; height: 280px; padding: 24px 24px 0; }
.hero-image img { width: 100%; height: 100%; object-fit: cover; border-radius: 12px; }
.content { padding: 32px 24px; text-align: center; flex: 1; display: flex; flex-direction: column; }
.title { font-family: var(--font-serif); font-size: 1.8rem; font-weight: normal; margin-bottom: 16px; line-height: 1.3; }
.subtitle { font-size: 0.9rem; color: var(--primary); line-height: 1.5; margin-bottom: 32px; }
.detail-card { background-color: var(--card-bg); border-radius: 16px; padding: 24px; text-align: left; margin-bottom: 40px; }
.card-header { margin-bottom: 24px; border-bottom: 1px solid rgba(74, 88, 55, 0.1); padding-bottom: 16px; }
.label { font-size: 0.7rem; font-weight: 600; color: #5B6A4B; letter-spacing: 1px; }
.detail-row { margin-bottom: 20px; }
.row-label { display: block; font-size: 0.65rem; color: #8C9C7B; margin-bottom: 4px; }
.row-value { font-size: 0.95rem; font-weight: 500; }
.actions { display: flex; flex-direction: column; gap: 12px; margin-bottom: 32px; }
.btn { width: 100%; padding: 16px; border-radius: 30px; font-weight: 500; font-size: 0.95rem; cursor: pointer; }
.btn-primary { background-color: var(--primary); color: white; border: none; }
.btn-outline { background-color: transparent; border: 1px solid var(--primary); color: var(--primary); }
.watermark { font-family: var(--font-serif); font-size: 1rem; color: #A4B298; font-style: italic; margin-top: auto; }
</style>