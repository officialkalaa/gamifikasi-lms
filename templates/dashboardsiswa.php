<?php
/**
 * Dashboard Siswa - Gamifikasi LMS
 * Halaman utama siswa
 */

// Pastikan user sudah login
// if (!is_user_logged_in()) {
//     wp_redirect(home_url('/login'));
//     exit;
// }

// Get current user data (nanti dari Firebase)
$user_name = 'Ahmad Fauzan';
$user_avatar = '';
$user_email = 'ahmad@example.com';

// Data mock untuk development
$mock_data = [
    'greeting' => 'Selamat Pagi',
    'quote' => 'Belajar hari ini, sukses esok hari!',
    'tasks_today' => 3,
    'overall_progress' => 67,
    'courses_active' => 4,
    'courses_completed' => 7,
    'materials_learned' => 42,
    'weekly_target' => 80,
    'weekly_progress' => 65,
    'continue_learning' => [
        'course' => 'UI/UX Design Fundamentals',
        'material' => 'Prinsip Dasar Typography',
        'progress' => 45,
        'time_remaining' => 15,
    ],
    'daily_missions' => [
        ['id' => 1, 'title' => 'Login hari ini', 'completed' => true, 'xp' => 10],
        ['id' => 2, 'title' => 'Selesaikan 1 materi', 'completed' => false, 'xp' => 25, 'progress' => '1/3'],
        ['id' => 3, 'title' => 'Kerjakan 1 kuis', 'completed' => false, 'xp' => 30],
        ['id' => 4, 'title' => 'Dapatkan nilai minimal 80', 'completed' => false, 'xp' => 40],
    ],
    'upcoming_tasks' => [
        ['id' => 1, 'title' => 'Membuat Wireframe Aplikasi', 'subject' => 'UI/UX Design', 'deadline' => '2024-01-20', 'priority' => 'high'],
        ['id' => 2, 'title' => 'Quiz JavaScript Dasar', 'subject' => 'Web Development', 'deadline' => '2024-01-18', 'priority' => 'urgent'],
        ['id' => 3, 'title' => 'Membaca Jurnal UX Research', 'subject' => 'UI/UX Design', 'deadline' => '2024-01-25', 'priority' => 'normal'],
        ['id' => 4, 'title' => 'Submit Project Akhir', 'subject' => 'Web Development', 'deadline' => '2024-01-28', 'priority' => 'medium'],
    ],
    'achievements' => [
        ['id' => 1, 'name' => 'First Step', 'icon' => '🎯', 'unlocked' => true, 'description' => 'Menyelesaikan course pertama'],
        ['id' => 2, 'name' => 'Fast Learner', 'icon' => '⚡', 'unlocked' => true, 'description' => 'Selesaikan 5 materi dalam sehari'],
        ['id' => 3, 'name' => 'Quiz Master', 'icon' => '🏆', 'unlocked' => false, 'description' => 'Dapatkan nilai 90+ di 3 quiz'],
        ['id' => 4, 'name' => 'Streak Champion', 'icon' => '🔥', 'unlocked' => false, 'description' => 'Belajar 7 hari berturut-turut'],
        ['id' => 5, 'name' => 'Course Master', 'icon' => '👑', 'unlocked' => false, 'description' => 'Selesaikan 10 course'],
    ],
    'level' => 12,
    'total_xp' => 2840,
    'xp_to_next_level' => 160,
    'leaderboard' => [
        ['rank' => 1, 'name' => 'Budi Santoso', 'xp' => 4250, 'trend' => 'up'],
        ['rank' => 2, 'name' => 'Siti Rahayu', 'xp' => 3980, 'trend' => 'up'],
        ['rank' => 3, 'name' => 'Agus Wijaya', 'xp' => 3650, 'trend' => 'down'],
        ['rank' => 4, 'name' => 'Dewi Lestari', 'xp' => 3420, 'trend' => 'up'],
        ['rank' => 5, 'name' => 'Rizky Pratama', 'xp' => 3100, 'trend' => 'down'],
    ],
    'user_rank' => 8,
    'user_xp' => 2840,
    'statistics' => [
        'total_xp' => 2840,
        'streak' => 12,
        'total_time' => 48,
        'quizzes_completed' => 24,
        'avg_score' => 85,
        'courses_completed' => 7,
    ],
    'notifications' => [
        ['id' => 1, 'message' => '🎉 Selamat! Kamu mendapatkan badge "Fast Learner"', 'time' => '5 menit lalu', 'read' => false],
        ['id' => 2, 'message' => '📝 Nilai quiz JavaScript: 85', 'time' => '1 jam lalu', 'read' => false],
        ['id' => 3, 'message' => '📢 Course baru: "Advanced CSS" telah tersedia', 'time' => '3 jam lalu', 'read' => true],
    ]
];

// Get current time for greeting
$current_hour = date('H');
if ($current_hour < 12) {
    $greeting = 'Selamat Pagi';
} elseif ($current_hour < 15) {
    $greeting = 'Selamat Siang';
} elseif ($current_hour < 18) {
    $greeting = 'Selamat Sore';
} else {
    $greeting = 'Selamat Malam';
}

// Sembunyikan notifikasi default
$show_notifications = false;
?>

<div class="gml-dashboard">
    <!-- Notification Container -->
    <div id="gml-notification-container" class="gml-notification-container"></div>

    <!-- Header sudah di handle oleh layout/fullwidth.php -->

    <div class="gml-dashboard-content">
        <!-- 1. WELCOME SECTION -->
        <section class="gml-welcome-section" aria-label="Welcome">
            <div class="gml-welcome-wrapper">
                <div class="gml-welcome-text">
                    <h1 class="gml-welcome-greeting">
                        <?php echo esc_html($greeting); ?>, 
                        <span class="gml-welcome-name"><?php echo esc_html($user_name); ?></span>
                        <span class="gml-welcome-emoji">👋</span>
                    </h1>
                    <p class="gml-welcome-quote">"<?php echo esc_html($mock_data['quote']); ?>"</p>
                    <div class="gml-welcome-reminder">
                        <span class="gml-welcome-reminder-icon">📋</span>
                        <p class="gml-welcome-reminder-text">
                            Kamu memiliki <strong><?php echo esc_html($mock_data['tasks_today']); ?> tugas</strong> yang harus diselesaikan hari ini.
                        </p>
                    </div>
                    <button class="gml-btn gml-btn-primary gml-btn-lg gml-welcome-cta" id="gml-continue-learning-btn">
                        <span class="gml-btn-icon">▶</span>
                        Lanjutkan Belajar
                    </button>
                </div>
                <div class="gml-welcome-avatar">
                    <?php if ($user_avatar): ?>
                        <img src="<?php echo esc_url($user_avatar); ?>" alt="<?php echo esc_attr($user_name); ?>" class="gml-avatar gml-avatar-lg">
                    <?php else: ?>
                        <div class="gml-avatar gml-avatar-lg gml-avatar-fallback">
                            <?php echo esc_html(substr($user_name, 0, 2)); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- 2. LEARNING PROGRESS & DAILY MISSION (2 Column) -->
        <div class="gml-grid-2">
            <!-- Learning Progress -->
            <section class="gml-card gml-progress-section" aria-label="Learning Progress">
                <div class="gml-card-header">
                    <h2 class="gml-card-title">Progress Belajar</h2>
                    <span class="gml-card-badge"><?php echo esc_html($mock_data['overall_progress']); ?>%</span>
                </div>
                <div class="gml-progress-content">
                    <div class="gml-progress-ring-wrapper">
                        <div class="gml-progress-ring" role="progressbar" aria-valuenow="<?php echo esc_attr($mock_data['overall_progress']); ?>" aria-valuemin="0" aria-valuemax="100">
                            <svg viewBox="0 0 120 120" class="gml-progress-ring-svg">
                                <circle cx="60" cy="60" r="54" fill="none" stroke="#E2E8F0" stroke-width="8" />
                                <circle cx="60" cy="60" r="54" fill="none" stroke="#6C5CE7" stroke-width="8" 
                                        stroke-linecap="round"
                                        stroke-dasharray="<?php echo esc_attr(339.292 * $mock_data['overall_progress'] / 100); ?> 339.292"
                                        transform="rotate(-90 60 60)" />
                            </svg>
                            <div class="gml-progress-ring-center">
                                <span class="gml-progress-ring-number"><?php echo esc_html($mock_data['overall_progress']); ?>%</span>
                                <span class="gml-progress-ring-label">Selesai</span>
                            </div>
                        </div>
                    </div>
                    <div class="gml-progress-stats">
                        <div class="gml-stat-item">
                            <span class="gml-stat-number"><?php echo esc_html($mock_data['courses_active']); ?></span>
                            <span class="gml-stat-label">Course Aktif</span>
                        </div>
                        <div class="gml-stat-divider"></div>
                        <div class="gml-stat-item">
                            <span class="gml-stat-number"><?php echo esc_html($mock_data['courses_completed']); ?></span>
                            <span class="gml-stat-label">Course Selesai</span>
                        </div>
                        <div class="gml-stat-divider"></div>
                        <div class="gml-stat-item">
                            <span class="gml-stat-number"><?php echo esc_html($mock_data['materials_learned']); ?></span>
                            <span class="gml-stat-label">Materi Dipelajari</span>
                        </div>
                    </div>
                </div>
                <div class="gml-progress-footer">
                    <div class="gml-progress-weekly">
                        <div class="gml-progress-weekly-header">
                            <span class="gml-progress-weekly-label">Target Mingguan</span>
                            <span class="gml-progress-weekly-value"><?php echo esc_html($mock_data['weekly_progress']); ?>%</span>
                        </div>
                        <div class="gml-progress-bar">
                            <div class="gml-progress-bar-fill" style="width: <?php echo esc_attr($mock_data['weekly_progress']); ?>%; background: #4F46E5;"></div>
                        </div>
                        <span class="gml-progress-weekly-target">Target: <?php echo esc_html($mock_data['weekly_target']); ?>%</span>
                    </div>
                </div>
            </section>

            <!-- Daily Mission -->
            <section class="gml-card gml-mission-section" aria-label="Daily Mission">
                <div class="gml-card-header">
                    <h2 class="gml-card-title">Misi Hari Ini</h2>
                    <span class="gml-card-badge gml-card-badge-accent">+XP</span>
                </div>
                <div class="gml-mission-list">
                    <?php foreach ($mock_data['daily_missions'] as $mission): ?>
                        <div class="gml-mission-item <?php echo $mission['completed'] ? 'gml-mission-completed' : ''; ?>" data-mission-id="<?php echo esc_attr($mission['id']); ?>">
                            <div class="gml-mission-checkbox">
                                <input type="checkbox" id="mission-<?php echo esc_attr($mission['id']); ?>" <?php echo $mission['completed'] ? 'checked' : ''; ?>>
                                <label for="mission-<?php echo esc_attr($mission['id']); ?>" class="gml-mission-checkbox-label"></label>
                            </div>
                            <div class="gml-mission-content">
                                <span class="gml-mission-title"><?php echo esc_html($mission['title']); ?></span>
                                <?php if (isset($mission['progress'])): ?>
                                    <span class="gml-mission-progress"><?php echo esc_html($mission['progress']); ?></span>
                                <?php endif; ?>
                            </div>
                            <span class="gml-mission-xp">+<?php echo esc_html($mission['xp']); ?> XP</span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="gml-mission-footer">
                    <span class="gml-mission-total">Total XP hari ini: <strong>+<?php echo esc_html(array_sum(array_column($mock_data['daily_missions'], 'xp'))); ?></strong></span>
                </div>
            </section>
        </div>

        <!-- 3. CONTINUE LEARNING (Full Width) -->
        <section class="gml-card gml-continue-section" aria-label="Continue Learning">
            <div class="gml-continue-wrapper">
                <div class="gml-continue-content">
                    <div class="gml-continue-header">
                        <span class="gml-continue-badge">Terakhir Dipelajari</span>
                        <h2 class="gml-card-title"><?php echo esc_html($mock_data['continue_learning']['course']); ?></h2>
                    </div>
                    <div class="gml-continue-material">
                        <span class="gml-continue-material-icon">📖</span>
                        <span class="gml-continue-material-title"><?php echo esc_html($mock_data['continue_learning']['material']); ?></span>
                    </div>
                    <div class="gml-continue-progress">
                        <div class="gml-progress-bar">
                            <div class="gml-progress-bar-fill" style="width: <?php echo esc_attr($mock_data['continue_learning']['progress']); ?>%; background: #6C5CE7;"></div>
                        </div>
                        <span class="gml-continue-progress-text"><?php echo esc_html($mock_data['continue_learning']['progress']); ?>% selesai</span>
                    </div>
                    <div class="gml-continue-footer">
                        <div class="gml-continue-time">
                            <span class="gml-continue-time-icon">⏱️</span>
                            <span class="gml-continue-time-text">Estimasi selesai: <?php echo esc_html($mock_data['continue_learning']['time_remaining']); ?> menit</span>
                        </div>
                        <button class="gml-btn gml-btn-primary gml-continue-btn" id="gml-continue-btn">
                            <span class="gml-btn-icon">▶</span>
                            Lanjutkan Belajar
                        </button>
                    </div>
                </div>
                <div class="gml-continue-illustration">
                    <div class="gml-continue-progress-ring">
                        <svg viewBox="0 0 100 100" width="120" height="120">
                            <circle cx="50" cy="50" r="42" fill="none" stroke="#E2E8F0" stroke-width="6" />
                            <circle cx="50" cy="50" r="42" fill="none" stroke="#6C5CE7" stroke-width="6" 
                                    stroke-linecap="round"
                                    stroke-dasharray="<?php echo esc_attr(263.89 * $mock_data['continue_learning']['progress'] / 100); ?> 263.89"
                                    transform="rotate(-90 50 50)" />
                            <text x="50" y="50" text-anchor="middle" dominant-baseline="central" 
                                  fill="#1E293B" font-size="16" font-weight="700">
                                <?php echo esc_html($mock_data['continue_learning']['progress']); ?>%
                            </text>
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. THREE COLUMN: Upcoming Tasks | Achievement | Leaderboard -->
        <div class="gml-grid-3">
            <!-- Upcoming Tasks -->
            <section class="gml-card gml-tasks-section" aria-label="Upcoming Tasks">
                <div class="gml-card-header">
                    <h2 class="gml-card-title">Tugas Mendatang</h2>
                    <a href="#" class="gml-link gml-link-sm">Lihat Semua</a>
                </div>
                <div class="gml-tasks-list">
                    <?php foreach ($mock_data['upcoming_tasks'] as $task): ?>
                        <div class="gml-task-item" data-task-id="<?php echo esc_attr($task['id']); ?>">
                            <div class="gml-task-content">
                                <span class="gml-task-title"><?php echo esc_html($task['title']); ?></span>
                                <span class="gml-task-subject"><?php echo esc_html($task['subject']); ?></span>
                            </div>
                            <div class="gml-task-meta">
                                <span class="gml-task-deadline">
                                    <span class="gml-task-deadline-icon">📅</span>
                                    <?php echo esc_html(date('d M Y', strtotime($task['deadline']))); ?>
                                </span>
                                <span class="gml-task-priority gml-task-priority-<?php echo esc_attr($task['priority']); ?>">
                                    <?php 
                                        $priority_labels = [
                                            'urgent' => 'Mendesak',
                                            'high' => 'Penting',
                                            'medium' => 'Sedang',
                                            'normal' => 'Normal'
                                        ];
                                        echo esc_html($priority_labels[$task['priority']] ?? 'Normal');
                                    ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Achievement -->
            <section class="gml-card gml-achievement-section" aria-label="Achievement">
                <div class="gml-card-header">
                    <h2 class="gml-card-title">Pencapaian</h2>
                    <span class="gml-card-badge">Level <?php echo esc_html($mock_data['level']); ?></span>
                </div>
                <div class="gml-achievement-level">
                    <div class="gml-achievement-xp">
                        <span class="gml-achievement-xp-icon">⭐</span>
                        <span class="gml-achievement-xp-text"><?php echo number_format($mock_data['total_xp']); ?> XP</span>
                    </div>
                    <div class="gml-achievement-progress">
                        <div class="gml-progress-bar">
                            <div class="gml-progress-bar-fill" style="width: <?php echo esc_attr(100 - ($mock_data['xp_to_next_level'] / 1000 * 100)); ?>%; background: #F59E0B;"></div>
                        </div>
                        <span class="gml-achievement-next"><?php echo number_format($mock_data['xp_to_next_level']); ?> XP menuju level selanjutnya</span>
                    </div>
                </div>
                <div class="gml-badge-grid">
                    <?php foreach ($mock_data['achievements'] as $badge): ?>
                        <div class="gml-badge-item <?php echo $badge['unlocked'] ? 'gml-badge-unlocked' : 'gml-badge-locked'; ?>">
                            <div class="gml-badge-icon"><?php echo esc_html($badge['icon']); ?></div>
                            <span class="gml-badge-name"><?php echo esc_html($badge['name']); ?></span>
                            <?php if (!$badge['unlocked']): ?>
                                <span class="gml-badge-lock">🔒</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Leaderboard -->
            <section class="gml-card gml-leaderboard-section" aria-label="Leaderboard">
                <div class="gml-card-header">
                    <h2 class="gml-card-title">Papan Peringkat</h2>
                    <a href="#" class="gml-link gml-link-sm">Lihat Semua</a>
                </div>
                <div class="gml-leaderboard-list">
                    <?php foreach ($mock_data['leaderboard'] as $user): ?>
                        <div class="gml-leaderboard-item <?php echo $user['rank'] <= 3 ? 'gml-leaderboard-top' : ''; ?>">
                            <span class="gml-leaderboard-rank">
                                <?php if ($user['rank'] === 1): ?>
                                    🥇
                                <?php elseif ($user['rank'] === 2): ?>
                                    🥈
                                <?php elseif ($user['rank'] === 3): ?>
                                    🥉
                                <?php else: ?>
                                    #<?php echo esc_html($user['rank']); ?>
                                <?php endif; ?>
                            </span>
                            <span class="gml-leaderboard-name"><?php echo esc_html($user['name']); ?></span>
                            <span class="gml-leaderboard-xp"><?php echo number_format($user['xp']); ?> XP</span>
                            <span class="gml-leaderboard-trend gml-leaderboard-trend-<?php echo esc_attr($user['trend']); ?>">
                                <?php echo $user['trend'] === 'up' ? '↑' : '↓'; ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="gml-leaderboard-user">
                    <span class="gml-leaderboard-user-rank">#<?php echo esc_html($mock_data['user_rank']); ?></span>
                    <span class="gml-leaderboard-user-name"><?php echo esc_html($user_name); ?></span>
                    <span class="gml-leaderboard-user-xp"><?php echo number_format($mock_data['user_xp']); ?> XP</span>
                </div>
            </section>
        </div>

        <!-- 5. STATISTICS (6 Column Grid) -->
        <section class="gml-card gml-stats-section" aria-label="Statistics">
            <div class="gml-card-header">
                <h2 class="gml-card-title">Statistik Belajar</h2>
            </div>
            <div class="gml-stats-grid">
                <div class="gml-stat-card">
                    <span class="gml-stat-card-icon">⭐</span>
                    <span class="gml-stat-card-number"><?php echo number_format($mock_data['statistics']['total_xp']); ?></span>
                    <span class="gml-stat-card-label">Total XP</span>
                </div>
                <div class="gml-stat-card">
                    <span class="gml-stat-card-icon">🔥</span>
                    <span class="gml-stat-card-number"><?php echo esc_html($mock_data['statistics']['streak']); ?></span>
                    <span class="gml-stat-card-label">Hari Belajar</span>
                </div>
                <div class="gml-stat-card">
                    <span class="gml-stat-card-icon">⏱️</span>
                    <span class="gml-stat-card-number"><?php echo esc_html($mock_data['statistics']['total_time']); ?>h</span>
                    <span class="gml-stat-card-label">Total Belajar</span>
                </div>
                <div class="gml-stat-card">
                    <span class="gml-stat-card-icon">📝</span>
                    <span class="gml-stat-card-number"><?php echo esc_html($mock_data['statistics']['quizzes_completed']); ?></span>
                    <span class="gml-stat-card-label">Kuis Selesai</span>
                </div>
                <div class="gml-stat-card">
                    <span class="gml-stat-card-icon">📊</span>
                    <span class="gml-stat-card-number"><?php echo esc_html($mock_data['statistics']['avg_score']); ?>%</span>
                    <span class="gml-stat-card-label">Nilai Rata-rata</span>
                </div>
                <div class="gml-stat-card">
                    <span class="gml-stat-card-icon">🎓</span>
                    <span class="gml-stat-card-number"><?php echo esc_html($mock_data['statistics']['courses_completed']); ?></span>
                    <span class="gml-stat-card-label">Course Selesai</span>
                </div>
            </div>
        </section>

        <!-- 6. QUICK ACCESS (Horizontal Scroll) -->
        <section class="gml-quick-access-section" aria-label="Quick Access">
            <div class="gml-quick-access-wrapper">
                <div class="gml-quick-access-item" data-route="/my-courses">
                    <span class="gml-quick-access-icon">📚</span>
                    <span class="gml-quick-access-label">My Courses</span>
                </div>
                <div class="gml-quick-access-item" data-route="/quiz">
                    <span class="gml-quick-access-icon">🧪</span>
                    <span class="gml-quick-access-label">Quiz</span>
                </div>
                <div class="gml-quick-access-item" data-route="/assignments">
                    <span class="gml-quick-access-icon">📋</span>
                    <span class="gml-quick-access-label">Assignments</span>
                </div>
                <div class="gml-quick-access-item" data-route="/forum">
                    <span class="gml-quick-access-icon">💬</span>
                    <span class="gml-quick-access-label">Forum</span>
                </div>
                <div class="gml-quick-access-item" data-route="/certificates">
                    <span class="gml-quick-access-icon">📜</span>
                    <span class="gml-quick-access-label">Certificates</span>
                </div>
                <div class="gml-quick-access-item" data-route="/profile">
                    <span class="gml-quick-access-icon">👤</span>
                    <span class="gml-quick-access-label">Profile</span>
                </div>
                <div class="gml-quick-access-item" data-route="/calendar">
                    <span class="gml-quick-access-icon">📅</span>
                    <span class="gml-quick-access-label">Calendar</span>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    // Pass PHP data to JavaScript for dynamic rendering
    window.gmlDashboardData = <?php echo json_encode($mock_data); ?>;
    window.gmlUserData = {
        name: '<?php echo esc_js($user_name); ?>',
        avatar: '<?php echo esc_js($user_avatar); ?>',
        email: '<?php echo esc_js($user_email); ?>'
    };
</script>