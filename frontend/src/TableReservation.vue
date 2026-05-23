<template>
  <div class="mobile-container">
    <nav class="top-nav">
      <button class="icon-btn"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg></button>
      <div class="logo"><span class="logo-text">Ijoo</span></div>
    </nav>

    <div class="content-padding">
      <section class="step-section">
        <div class="step-header">
          <div class="step-number">1</div>
          <h2>Detail Pengunjung</h2>
        </div>
        <div class="form-group">
          <label>NAMA LENGKAP</label>
          <input type="text" placeholder="Masukkan nama Anda" class="form-input" />
        </div>
        <div class="form-row">
          <div class="form-group half">
            <label>JUMLAH ORANG</label>
            <div class="select-wrapper">
              <select class="form-input"><option>2 Orang</option></select>
            </div>
          </div>
          <div class="form-group half">
            <label>WAKTU</label>
            <div class="select-wrapper">
              <input type="text" value="11:00" class="form-input" readonly />
            </div>
          </div>
        </div>
      </section>

      <div class="divider"></div>

      <section class="step-section">
        <div class="step-header">
          <div class="step-number">2</div>
          <h2>Pilih Tanggal</h2>
        </div>
        <div class="calendar-card">
          <div class="calendar-header">
            <button class="cal-nav">&lt;</button>
            <span>Oktober 2024</span>
            <button class="cal-nav">&gt;</button>
          </div>
          <div class="calendar-grid">
            <div class="cal-day-header">MIN</div><div class="cal-day-header">SEN</div><div class="cal-day-header">SEL</div><div class="cal-day-header">RAB</div><div class="cal-day-header">KAM</div><div class="cal-day-header">JUM</div><div class="cal-day-header">SAB</div>
            <div class="cal-day disabled">29</div><div class="cal-day disabled">30</div><div class="cal-day">1</div><div class="cal-day">2</div><div class="cal-day">3</div><div class="cal-day">4</div><div class="cal-day">5</div>
            <div class="cal-day">6</div><div class="cal-day">7</div><div class="cal-day">8</div><div class="cal-day">9</div><div class="cal-day">10</div><div class="cal-day">11</div><div class="cal-day">12</div>
            <div class="cal-day">13</div><div class="cal-day">14</div><div class="cal-day active">15</div><div class="cal-day">16</div><div class="cal-day">17</div><div class="cal-day">18</div><div class="cal-day">19</div>
            <div class="cal-day">20</div><div class="cal-day">21</div><div class="cal-day">22</div><div class="cal-day">23</div><div class="cal-day">24</div><div class="cal-day">25</div><div class="cal-day">26</div>
          </div>
        </div>
      </section>

      <section class="step-section">
        <div class="step-header">
          <div class="step-number">3</div>
          <h2>Pilih Meja</h2>
        </div>
        <div class="table-map">
          <div class="area-label">AREA LUAR</div>
          <div class="table-row">
            <div class="table-btn available">T-01</div>
            <div class="table-btn occupied">T-02</div>
            <div class="table-btn selected">T-03</div>
          </div>
        </div>
        <div class="info-box">
          <p class="info-text">Meja <strong>T-03</strong> dipilih.<br><span class="info-desc">Kapasitas maksimal 2 orang.</span></p>
        </div>
      </section>
    </div>

    <div class="bottom-actions">
      <button class="btn btn-outline">Pre-order Menu</button>
      <button class="btn btn-primary">Selesaikan</button>
    </div>
  </div>
</template>

<style scoped>
:root { --bg-main: #F4F7F0; --text-main: #2A3620; --card-bg: #EAEFE4; --primary: #4A5837; --border-color: #D6DED0; --font-serif: 'Georgia', serif; }
* { box-sizing: border-box; margin: 0; padding: 0; font-family: system-ui, sans-serif; }
.mobile-container { max-width: 414px; margin: 0 auto; background-color: var(--bg-main); color: var(--text-main); min-height: 100vh; position: relative; padding-bottom: 100px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
.top-nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; }
.icon-btn { background: none; border: none; color: var(--primary); cursor: pointer; }
.logo-text { font-family: var(--font-serif); font-size: 1.5rem; font-weight: bold; }
.content-padding { padding: 0 24px; }
.step-section { margin-bottom: 32px; }
.step-header { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; }
.step-number { background-color: var(--primary); color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
.step-header h2 { font-family: var(--font-serif); font-size: 1.5rem; font-weight: normal; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; font-size: 0.7rem; font-weight: 600; color: #5B6A4B; margin-bottom: 8px; letter-spacing: 0.5px; }
.form-input { width: 100%; padding: 16px; border: 1px solid var(--border-color); border-radius: 12px; background: white; font-size: 0.95rem; color: var(--text-main); outline: none; }
.form-row { display: flex; gap: 16px; }
.half { flex: 1; }
.divider { height: 1px; background-color: var(--border-color); margin: 32px 0; opacity: 0.6; }
.calendar-card { background: white; border-radius: 20px; padding: 24px; }
.calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-family: var(--font-serif); font-weight: 600; font-size: 1.15rem; }
.cal-nav { background: none; border: none; cursor: pointer; font-size: 1.2rem; color: var(--text-main); }
.calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 12px 8px; text-align: center; }
.cal-day-header { font-size: 0.7rem; color: #5B6A4B; font-weight: 600; margin-bottom: 8px; }
.cal-day { font-size: 0.95rem; display: flex; align-items: center; justify-content: center; height: 32px; width: 32px; margin: 0 auto; cursor: pointer; }
.cal-day.disabled { color: #C5CEC0; }
.cal-day.active { background-color: var(--primary); color: white; border-radius: 50%; font-weight: 600; }
.table-map { background: white; border-radius: 20px; padding: 24px 20px; margin-bottom: 16px; }
.area-label { text-align: center; font-size: 0.7rem; color: #8C9C7B; letter-spacing: 1px; margin-bottom: 20px; font-weight: 600; }
.table-row { display: flex; justify-content: center; gap: 16px; }
.table-btn { padding: 16px 0; border-radius: 12px; border: 1px solid var(--border-color); background: white; font-size: 0.8rem; font-weight: 600; width: 76px; text-align: center; }
.table-btn.occupied { background: var(--card-bg); border-color: var(--card-bg); color: #8C9C7B; }
.table-btn.selected { background: #EEF2EA; border: 2px solid var(--primary); color: var(--primary); }
.info-box { background-color: var(--card-bg); padding: 16px 20px; border-radius: 12px; border: 1px solid rgba(74, 88, 55, 0.1); }
.info-text { font-size: 0.95rem; }
.info-desc { font-size: 0.8rem; color: #5B6A4B; }
.bottom-actions { position: absolute; bottom: 0; left: 0; width: 100%; background: white; padding: 16px 24px; display: flex; gap: 12px; box-shadow: 0 -4px 24px rgba(0,0,0,0.04); border-radius: 20px 20px 0 0; }
.btn { border-radius: 12px; font-weight: 500; font-size: 0.95rem; cursor: pointer; text-align: center; }
.btn-outline { flex: 1; padding: 16px 10px; background: white; border: 1px solid var(--primary); color: var(--primary); }
.btn-primary { flex: 2; padding: 16px; background: var(--primary); border: none; color: white; }
</style>