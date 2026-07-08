<section class="gml-register-page" aria-labelledby="gml-register-title">
    <div class="gml-bg-blob gml-bg-blob-one" aria-hidden="true"></div>
    <div class="gml-bg-blob gml-bg-blob-two" aria-hidden="true"></div>
    <div class="gml-bg-blob gml-bg-blob-three" aria-hidden="true"></div>

    <div class="gml-register-layout">

        <main class="gml-register-panel">
            <div class="gml-register-card gml-reveal">
                <div class="gml-brand-lockup" aria-label="Gamifikasi LMS">
                    <span class="gml-brand-mark">G</span>
                    <span class="gml-brand-text">Gamifikasi LMS</span>
                </div>

                <header class="gml-register-header">
                    <h2 id="gml-register-title">Create your account</h2>
                    <p>Begin your journey with missions, XP, badges, and friendly competition.</p>
                </header>

                <form class="gml-register-form" action="#" method="post">
                    <div class="gml-input-group">
                        <label for="gml-register-full-name">Full Name</label>
                        <input class="gml-input" id="gml-register-full-name" name="full_name" type="text" autocomplete="name" placeholder="Your full name" required>
                    </div>

                    <div class="gml-input-group">
                        <label for="gml-register-username">Username</label>
                        <input class="gml-input" id="gml-register-username" name="username" type="text" autocomplete="username" placeholder="Choose a username" required>
                    </div>

                    <div class="gml-input-group">
                        <label for="gml-register-email">Email Address</label>
                        <input class="gml-input" id="gml-register-email" name="email" type="email" autocomplete="email" placeholder="you@example.com" required>
                    </div>

                    <div class="gml-form-grid">
                        <div class="gml-input-group">
                            <label for="gml-register-password">Password</label>
                            <input class="gml-input" id="gml-register-password" name="password" type="password" autocomplete="new-password" placeholder="Create password" required>
                        </div>

                        <div class="gml-input-group">
                            <label for="gml-register-confirm-password">Confirm Password</label>
                            <input class="gml-input" id="gml-register-confirm-password" name="confirm_password" type="password" autocomplete="new-password" placeholder="Repeat password" required>
                        </div>
                    </div>

                    <div class="gml-input-group">
                        <label for="gml-register-role">Role</label>
                        <select class="gml-select" id="gml-register-role" name="role" required>
                            <option value="">Select your role</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="course_creator">Course Creator</option>
                            <option value="corporate_learner">Corporate Learner</option>
                            <option value="administrator">Administrator</option>
                        </select>
                    </div>

                    <label class="gml-checkbox">
                        <input type="checkbox" name="accept_terms" required>
                        <span>I agree to the terms and privacy policy.</span>
                    </label>

                    <button class="gml-btn gml-btn-primary" type="submit">
                        Create Account
                    </button>

                    <div class="gml-divider">
                        <span>or continue with</span>
                    </div>

                    <div class="gml-social-actions">
                        <button class="gml-social-btn" type="button">
                            <span class="gml-social-icon">G</span>
                            Google
                        </button>
                        <button class="gml-social-btn" type="button">
                            <span class="gml-social-icon">M</span>
                            Microsoft
                        </button>
                    </div>

                    <p class="gml-login-prompt">
                        Already have an account?
                     <a href="<?php echo home_url('/login'); ?>" class="...">Login</a>
                    </p>
                </form>
            </div>
        </main>
    </div>
</section>