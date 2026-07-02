<!-- =========================================================
     LEARNIO — Halaman Login / Daftar / Lupa Password
     Fragment HTML saja (tanpa <head>, <link>, <script src>).
     Pasang login.css & login.js secara manual di template kamu.
     ========================================================= -->

<div class="lrn-auth">

  <!-- ================= SISI KIRI: BRANDING & KOMUNITAS ================= -->
  <section class="lrn-auth-side">
    <div class="lrn-auth-side__bg"></div>

    <div class="lrn-auth-side__content">
      <div class="lrn-logo lrn-logo--light">
        <span class="lrn-logo__dot lrn-logo__dot--1"></span>
        <span class="lrn-logo__dot lrn-logo__dot--2"></span>
        <span class="lrn-logo__dot lrn-logo__dot--3"></span>
        <span class="lrn-logo__text">Learnio</span>
      </div>

      <blockquote class="lrn-auth-quote">
        <p>“Setiap poin yang kamu kumpulkan hari ini adalah langkah menuju versi terbaik dirimu.”</p>
        <cite>— Komunitas Learnio</cite>
      </blockquote>

      <div class="lrn-auth-highlight">
        <div class="lrn-auth-highlight__icon">🔥</div>
        <div>
          <strong>2.400+ siswa</strong>
          <span>menyelesaikan tantangan mingguan bersama</span>
        </div>
      </div>

      <div class="lrn-auth-leaderboard">
        <div class="lrn-auth-leaderboard__head">
          <span>🏆 Leaderboard Komunitas</span>
          <span class="lrn-auth-leaderboard__period">Minggu ini</span>
        </div>

        <ol class="lrn-auth-leaderboard__list">
          <li>
            <span class="lrn-auth-rank lrn-auth-rank--gold">1</span>
            <span class="lrn-auth-avatar" aria-hidden="true">🦊</span>
            <span class="lrn-auth-name">Daffa R.</span>
            <span class="lrn-auth-points">15.200 pt</span>
          </li>
          <li>
            <span class="lrn-auth-rank lrn-auth-rank--silver">2</span>
            <span class="lrn-auth-avatar" aria-hidden="true">🐼</span>
            <span class="lrn-auth-name">Aisyah P.</span>
            <span class="lrn-auth-points">12.560 pt</span>
          </li>
          <li>
            <span class="lrn-auth-rank lrn-auth-rank--bronze">3</span>
            <span class="lrn-auth-avatar" aria-hidden="true">🐯</span>
            <span class="lrn-auth-name">Raka S.</span>
            <span class="lrn-auth-points">11.300 pt</span>
          </li>
        </ol>
      </div>
    </div>
  </section>

  <!-- ================= SISI KANAN: FORM AUTENTIKASI ================= -->
  <section class="lrn-auth-form-panel">
    <div class="lrn-auth-card">

      <div class="lrn-auth-card__mobile-logo">
        <span class="lrn-logo__dot lrn-logo__dot--1"></span>
        <span class="lrn-logo__dot lrn-logo__dot--2"></span>
        <span class="lrn-logo__dot lrn-logo__dot--3"></span>
        <span class="lrn-logo__text">Learnio</span>
      </div>

      <!-- Tabs -->
      <div class="lrn-auth-tabs" role="tablist" aria-label="Autentikasi">
        <button class="lrn-auth-tab lrn-auth-tab--active" data-target="login" role="tab" aria-selected="true">Masuk</button>
        <button class="lrn-auth-tab" data-target="register" role="tab" aria-selected="false">Daftar</button>
        <button class="lrn-auth-tab" data-target="forgot" role="tab" aria-selected="false">Lupa Password</button>
      </div>

      <!-- ============ FORM: LOGIN ============ -->
      <form class="lrn-auth-form lrn-auth-form--active" id="form-login" data-form="login">
        <h2 class="lrn-auth-title">Selamat Datang Kembali 👋</h2>
        <p class="lrn-auth-desc">Masuk untuk melanjutkan progress belajarmu.</p>

        <label class="lrn-field">
          <span class="lrn-field__label">Email atau Username</span>
          <input type="text" name="login-identity" placeholder="nama@email.com" autocomplete="username" required>
        </label>

        <label class="lrn-field">
          <span class="lrn-field__label">Password</span>
          <div class="lrn-field__password">
            <input type="password" name="login-password" placeholder="Masukkan password" autocomplete="current-password" required>
            <button type="button" class="lrn-field__toggle" data-toggle-password aria-label="Tampilkan password">👁️</button>
          </div>
        </label>

        <div class="lrn-auth-row">
          <label class="lrn-checkbox">
            <input type="checkbox" name="remember-me">
            <span>Ingat saya</span>
          </label>
          <button type="button" class="lrn-auth-link" data-target="forgot">Lupa password?</button>
        </div>

        <button type="submit" class="lrn-btn lrn-btn--primary lrn-btn--block">Masuk ke Learnio</button>

        <div class="lrn-auth-divider"><span>atau lanjutkan dengan</span></div>

        <div class="lrn-auth-social">
          <button type="button" class="lrn-social-btn">
            <span class="lrn-social-btn__icon">G</span> Google
          </button>
          <button type="button" class="lrn-social-btn">
            <span class="lrn-social-btn__icon">f</span> Facebook
          </button>
        </div>

        <p class="lrn-auth-switch">Belum punya akun? <button type="button" class="lrn-auth-link" data-target="register">Daftar sekarang</button></p>

        <div class="lrn-security-badge">
          <span>🔒</span> Koneksi kamu terenkripsi &amp; aman
        </div>
      </form>

      <!-- ============ FORM: DAFTAR ============ -->
      <form class="lrn-auth-form" id="form-register" data-form="register">
        <h2 class="lrn-auth-title">Mulai Petualangan Belajarmu 🚀</h2>
        <p class="lrn-auth-desc">Buat akun dan pilih karakter untuk profilmu.</p>

        <div class="lrn-avatar-picker">
          <span class="lrn-field__label">Pilih Avatar</span>
          <div class="lrn-avatar-picker__list" role="radiogroup" aria-label="Pilih avatar">
            <button type="button" class="lrn-avatar-option lrn-avatar-option--active" data-avatar="fox" role="radio" aria-checked="true">🦊</button>
            <button type="button" class="lrn-avatar-option" data-avatar="panda" role="radio" aria-checked="false">🐼</button>
            <button type="button" class="lrn-avatar-option" data-avatar="tiger" role="radio" aria-checked="false">🐯</button>
            <button type="button" class="lrn-avatar-option" data-avatar="owl" role="radio" aria-checked="false">🦉</button>
            <button type="button" class="lrn-avatar-option" data-avatar="cat" role="radio" aria-checked="false">🐱</button>
          </div>
        </div>

        <label class="lrn-field">
          <span class="lrn-field__label">Nama Lengkap</span>
          <input type="text" name="register-name" placeholder="Nama kamu" autocomplete="name" required>
        </label>

        <label class="lrn-field">
          <span class="lrn-field__label">Email</span>
          <input type="email" name="register-email" placeholder="nama@email.com" autocomplete="email" required>
        </label>

        <label class="lrn-field">
          <span class="lrn-field__label">Password</span>
          <div class="lrn-field__password">
            <input type="password" name="register-password" id="register-password" placeholder="Buat password" autocomplete="new-password" required>
            <button type="button" class="lrn-field__toggle" data-toggle-password aria-label="Tampilkan password">👁️</button>
          </div>
          <div class="lrn-password-strength" aria-hidden="true">
            <div class="lrn-password-strength__bar" id="password-strength-bar"></div>
          </div>
          <span class="lrn-password-strength__label" id="password-strength-label">Minimal 8 karakter</span>
        </label>

        <label class="lrn-checkbox">
          <input type="checkbox" name="agree-terms" required>
          <span>Saya setuju dengan Syarat &amp; Ketentuan Learnio</span>
        </label>

        <button type="submit" class="lrn-btn lrn-btn--primary lrn-btn--block">Buat Akun</button>

        <div class="lrn-auth-divider"><span>atau daftar dengan</span></div>

        <div class="lrn-auth-social">
          <button type="button" class="lrn-social-btn">
            <span class="lrn-social-btn__icon">G</span> Google
          </button>
          <button type="button" class="lrn-social-btn">
            <span class="lrn-social-btn__icon">f</span> Facebook
          </button>
        </div>

        <p class="lrn-auth-switch">Sudah punya akun? <button type="button" class="lrn-auth-link" data-target="login">Masuk di sini</button></p>
      </form>

      <!-- ============ FORM: LUPA PASSWORD ============ -->
      <form class="lrn-auth-form" id="form-forgot" data-form="forgot">
        <h2 class="lrn-auth-title">Lupa Password? 🔑</h2>
        <p class="lrn-auth-desc">Masukkan email akunmu, kami akan kirimkan tautan reset password.</p>

        <label class="lrn-field">
          <span class="lrn-field__label">Email Terdaftar</span>
          <input type="email" name="forgot-email" placeholder="nama@email.com" autocomplete="email" required>
        </label>

        <button type="submit" class="lrn-btn lrn-btn--primary lrn-btn--block">Kirim Tautan Reset</button>

        <p class="lrn-auth-switch">
          <button type="button" class="lrn-auth-link" data-target="login">← Kembali ke halaman masuk</button>
        </p>

        <div class="lrn-security-badge">
          <span>🔒</span> Tautan reset berlaku 15 menit demi keamananmu
        </div>
      </form>

      <!-- Notifikasi status (dummy, dikendalikan JS) -->
      <p class="lrn-auth-feedback" id="auth-feedback" aria-live="polite"></p>
    </div>
  </section>

</div>