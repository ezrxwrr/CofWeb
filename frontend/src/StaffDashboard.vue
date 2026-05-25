<template>
  <div class="mobile-container">
    <nav class="top-nav">
      <button class="icon-btn"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
      <div class="logo"><span class="logo-text">Ijoo</span></div>
    </nav>

    <div class="content">
      <h1 class="title">Dashboard Staff</h1>
      <p class="date-display">Kamis, 24 Oktober 2024</p>

      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-top"><span class="stat-number">24</span></div>
          <p class="stat-label">TOTAL RESERVASI</p>
        </div>
        <div class="stat-card">
          <div class="stat-top"><span class="stat-number">5</span></div>
          <p class="stat-label">TAMU MENUNGGU</p>
        </div>
        <div class="stat-card full-width">
          <div class="stat-top"><span class="stat-number">8/15</span></div>
          <p class="stat-label">MEJA TERSEDIA</p>
        </div>
      </div>

      <div class="section-header">
        <h2>Status Meja</h2>
      </div>
      <div class="table-status-scroll">
        <div class="table-card">
          <p class="table-name">Meja 1</p>
          <span class="badge badge-avail">AVAILABLE</span>
        </div>
        <div class="table-card card-occ">
          <p class="table-name">Meja 2</p>
          <span class="badge badge-occ-text">OCCUPIED</span>
        </div>
        <div class="table-card card-cleaning">
          <p class="table-name">Meja 3</p>
          <span class="badge badge-clean">CLEANING</span>
        </div>
      </div>

      <h2 class="section-title">Reservasi Hari Ini</h2>
      <div class="reservation-list">
        <div class="res-card">
          <div class="res-avatar avatar-waiting"></div>
          <div class="res-info">
            <h3>Andreana</h3>
            <p>14:00 • 2 Pax</p>
            <span class="badge badge-waiting">WAITING</span>
          </div>
        </div>
        <div class="res-card">
          <div class="res-avatar avatar-arrived"></div>
          <div class="res-info">
            <h3>Budi</h3>
            <p>13:30 • 4 Pax</p>
            <span class="badge badge-arrived">ARRIVED</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { max-width: 414px; margin: 0 auto; background-color: var(--bg-main); color: var(--text-main); min-height: 100vh; padding-bottom: 100px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
.top-nav { display: flex; justify-content: space-between; padding: 20px 24px; }
.icon-btn { background: none; border: none; color: #5B6A4B; cursor: pointer; }
.logo-text { font-family: var(--font-serif); font-size: 1.5rem; font-weight: bold; }
.content { padding: 0 24px; }
.title { font-family: var(--font-serif); font-size: 1.8rem; font-weight: normal; margin-bottom: 8px; }
.date-display { font-size: 0.9rem; color: var(--primary); margin-bottom: 24px; }
.stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 40px; }
.stat-card { background-color: var(--card-bg); padding: 16px; border-radius: 12px; }
.full-width { grid-column: span 2; }
.stat-top { margin-bottom: 12px; color: var(--text-main); }
.stat-number { font-family: var(--font-serif); font-size: 1.8rem; }
.stat-label { font-size: 0.65rem; font-weight: 600; color: #5B6A4B; }
.section-header h2, .section-title { font-family: var(--font-serif); font-size: 1.4rem; font-weight: normal; margin-bottom: 16px;}
.table-status-scroll { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 10px; margin-bottom: 32px; scrollbar-width: none; }
.table-status-scroll::-webkit-scrollbar { display: none; }
.table-card { min-width: 100px; background-color: var(--card-bg); padding: 16px; border-radius: 12px; display: flex; flex-direction: column; align-items: center; gap: 12px; }
.card-occ { opacity: 0.7; }
.card-cleaning { border: 1px dashed #A4B298; background-color: transparent; }
.table-name { font-size: 0.9rem; font-weight: 500; }
.badge { font-size: 0.6rem; font-weight: 600; padding: 4px 10px; border-radius: 12px; }
.badge-avail, .badge-arrived { background-color: #DDE2D3; color: var(--text-main); }
.badge-occ-text { color: #8C9C7B; }
.badge-clean { background-color: #A4B298; color: white; }
.badge-waiting { background-color: white; color: var(--text-main); border: 1px solid #DDE2D3; }
.reservation-list { display: flex; flex-direction: column; gap: 12px; }
.res-card { background: white; border-radius: 16px; padding: 16px; display: flex; gap: 16px; align-items: center; }
.res-avatar { width: 40px; height: 40px; border-radius: 50%; }
.avatar-waiting { background-color: var(--card-bg); }
.avatar-arrived { background-color: #DDE2D3; }
.res-info h3 { font-size: 1.05rem; margin-bottom: 4px; font-weight: 600; }
.res-info p { font-size: 0.8rem; color: #8C9C7B; margin-bottom: 8px; }
</style>