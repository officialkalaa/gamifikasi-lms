<main class="gml-login-page" aria-labelledby="gml-login-title">
  <div class="gml-bg-blob gml-bg-blob-one"></div>
  <div class="gml-bg-blob gml-bg-blob-two"></div>
  <div class="gml-bg-blob gml-bg-blob-three"></div>

  <div class="gml-particles" aria-hidden="true">
    <span class="gml-particle"></span>
    <span class="gml-particle"></span>
    <span class="gml-particle"></span>
    <span class="gml-particle"></span>
    <span class="gml-particle"></span>
  </div>

  <div class="gml-login-layout">
    <section class="gml-hero-panel" aria-label="Gamifikasi LMS welcome">
      <div class="gml-hero-copy">
        <span class="gml-kicker">Gamifikasi LMS</span>
        <h1 class="gml-hero-title">Continue your learning adventure.</h1>
        <p class="gml-hero-text">
          Earn XP, unlock achievements, climb the leaderboard, and keep every lesson feeling rewarding.
        </p>
      </div>

      <div class="gml-illustration" data-gml-parallax>
        <div class="gml-orbit gml-orbit-one"></div>
        <div class="gml-orbit gml-orbit-two"></div>

        <article class="gml-achievement-card">
          <div class="gml-achievement-icon">★</div>
          <div>
            <strong>Achievement Unlocked</strong>
            <span>7-day learning streak</span>
          </div>
        </article>

        <article class="gml-xp-card">
          <span>+850 XP</span>
          <strong>Level 12</strong>
        </article>

        <article class="gml-leaderboard-widget">
          <div class="gml-leaderboard-header">
            <strong>Leaderboard</strong>
            <span>Today</span>
          </div>
          <ol class="gml-leaderboard-list">
            <li><span>1</span><strong>Nadia</strong><em>9,420 XP</em></li>
            <li><span>2</span><strong>Raka</strong><em>8,880 XP</em></li>
            <li><span>3</span><strong>You</strong><em>8,610 XP</em></li>
          </ol>
        </article>

        <span class="gml-floating-badge gml-floating-badge-one">🏆</span>
        <span class="gml-floating-badge gml-floating-badge-two">⚡</span>
        <span class="gml-floating-badge gml-floating-badge-three">🪙</span>
        <span class="gml-floating-badge gml-floating-badge-four">✓</span>
      </div>
    </section>

    <section class="gml-form-panel" aria-label="Login form">
      <article class="gml-login-card">
        <div class="gml-logo" aria-label="Gamifikasi LMS">
          <span class="gml-logo-mark">G</span>
          <span class="gml-logo-text">Gamifikasi LMS</span>
        </div>

        <div class="gml-card-heading">
          <h2 id="gml-login-title">Welcome back</h2>
          <p>Login to manage courses, track progress, and keep momentum going.</p>
        </div>

        <form class="gml-login-form" action="#" method="post" novalidate>
          <div class="gml-input-group" data-gml-field>
            <span class="gml-input-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" focusable="false">
                <path d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v11a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 17.5v-11Zm2.25-.75 5.23 4.25c.3.24.74.24 1.04 0l5.23-4.25H6.25Zm12 2.22-4.62 3.75a2.6 2.6 0 0 1-3.26 0L5.75 7.97v9.53c0 .41.34.75.75.75h11c.41 0 .75-.34.75-.75V7.97Z"/>
              </svg>
            </span>
            <input class="gml-input" id="gml-email" name="email" type="email" autocomplete="email" required placeholder=" ">
            <label class="gml-input-label" for="gml-email">Email address</label>
            <span class="gml-field-message" aria-live="polite"></span>
          </div>

          <div class="gml-input-group" data-gml-field>
            <span class="gml-input-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" focusable="false">
                <path d="M7 10V8a5 5 0 0 1 10 0v2h.5A2.5 2.5 0 0 1 20 12.5v5A2.5 2.5 0 0 1 17.5 20h-11A2.5 2.5 0 0 1 4 17.5v-5A2.5 2.5 0 0 1 6.5 10H7Zm2 0h6V8a3 3 0 0 0-6 0v2Zm3 3.25a1.25 1.25 0 0 0-.5 2.4V17a.5.5 0 0 0 1 0v-1.35a1.25 1.25 0 0 0-.5-2.4Z"/>
              </svg>
            </span>
            <input class="gml-input" id="gml-password" name="password" type="password" autocomplete="current-password" required placeholder=" ">
            <label class="gml-input-label" for="gml-password">Password</label>
            <button class="gml-password-toggle" type="button" aria-label="Show password" aria-pressed="false">
              <svg class="gml-eye-icon" viewBox="0 0 24 24" focusable="false">
                <path d="M12 5c5 0 8.5 4.4 9.6 5.95a1.8 1.8 0 0 1 0 2.1C20.5 14.6 17 19 12 19s-8.5-4.4-9.6-5.95a1.8 1.8 0 0 1 0-2.1C3.5 9.4 7 5 12 5Zm0 2c-3.7 0-6.5 3.1-7.85 5C5.5 13.9 8.3 17 12 17s6.5-3.1 7.85-5C18.5 10.1 15.7 7 12 7Zm0 2a3 3 0 1 1 0 6 3 3 0 0 1 0-6Z"/>
              </svg>
            </button>
            <span class="gml-field-message" aria-live="polite"></span>
          </div>

          <div class="gml-form-options">
            <label class="gml-remember">
              <input class="gml-checkbox" type="checkbox" name="remember">
              <span class="gml-checkbox-box"></span>
              <span>Remember me</span>
            </label>
            <a class="gml-forgot-link" href="/forgot">Forgot password?</a>
          </div>

          <button class="gml-login-btn" type="submit">
            <span class="gml-btn-text">Login</span>
            <span class="gml-btn-loader" aria-hidden="true"></span>
          </button>

          <div class="gml-divider" role="separator">
            <span>or continue with</span>
          </div>

          <div class="gml-social-actions">
            <button class="gml-social-btn" type="button">
              <span class="gml-social-icon">G</span>
              <span>Google</span>
            </button>
            <button class="gml-social-btn" type="button">
              <span class="gml-social-icon">M</span>
              <span>Microsoft</span>
            </button>
          </div>

          <p class="gml-register-text">
            New to Gamifikasi LMS? <a class="gml-register-link" href="/register">Create an account</a>
          </p>
        </form>

        <footer class="gml-card-footer">
          <p>Secure learning access for students, teachers, creators, and teams.</p>
        </footer>
      </article>
    </section>
  </div>
</main>