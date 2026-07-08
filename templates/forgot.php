        <main class="gml-forgot-main">
            <div class="gml-forgot-card gml-reveal">
                <a class="gml-auth-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Gamifikasi LMS Home">
                    <span class="gml-logo-mark" aria-hidden="true">G</span>
                    <span>Gamifikasi LMS</span>
                </a>

                <div class="gml-form-state" data-gml-forgot-form-state>
                    <div class="gml-form-heading">
                        <p class="gml-kicker">Forgot Password</p>
                        <h1 id="gml-forgot-title">Recover your account</h1>
                        <p>Type the email linked to your account. We will help you create a new password securely.</p>
                    </div>

                    <form class="gml-forgot-form" data-gml-forgot-form method="post" novalidate>
                        <div class="gml-input-group">
                            <label class="gml-label" for="gml-forgot-email">Email Address</label>
                            <div class="gml-input-shell">
                                <span class="gml-input-icon" aria-hidden="true">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M4 6.5H20V17.5H4V6.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                        <path d="M4.5 7L12 13L19.5 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <input class="gml-input" id="gml-forgot-email" name="user_email" type="email" autocomplete="email" placeholder="you@example.com" required>
                            </div>
                            <p class="gml-field-message" data-gml-forgot-message aria-live="polite"></p>
                        </div>

                        <button class="gml-btn gml-btn-primary" type="submit" data-gml-ripple>
                            <span>Send Reset Link</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M13 6L19 12L13 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <p class="gml-security-note">
                            <span aria-hidden="true">●</span>
                            A password reset email will be sent only if the address matches an active account.
                        </p>
                    </form>

                    <div class="gml-auth-divider"><span>or</span></div>

                    <div class="gml-auth-links">
                        <a href="/login" class="...">Back to Login</a>
                        <a href="/register" class="...">Create an Account</a>
                    </div>
                </div>

                <div class="gml-success-state" data-gml-forgot-success hidden>
                    <div class="gml-email-illustration" aria-hidden="true">
                        <svg width="132" height="112" viewBox="0 0 132 112" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="18" y="28" width="96" height="62" rx="18" fill="#EEF2FF"/>
                            <path d="M24 38L66 68L108 38" stroke="#6C5CE7" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="105" cy="26" r="17" fill="#22C55E"/>
                            <path d="M97 26.5L102.5 32L113 20" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="gml-kicker">Email Sent</p>
                    <h2>Check your inbox</h2>
                    <p>We have sent a password reset link to your email. Open it to create a new password and return to your LMS dashboard.</p>
                    <a class="gml-btn gml-btn-primary" href="<?php echo esc_url(wp_login_url()); ?>">Return to Login</a>
                </div>
            </div>
        </main>
    </div>
</section>