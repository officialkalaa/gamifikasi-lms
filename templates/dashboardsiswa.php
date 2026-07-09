<?php
/**
 * Template: Dashboard Siswa
 * Route: /dashboard
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ── Enqueue assets ─────────────────────────────────────────────────────────
wp_enqueue_style(
    'gml-dashboard',
    GML_PLUGIN_URL . 'assets/css/dashboardsiswa.css',
    [],
    '1.0.0'
);
wp_enqueue_script(
    'gml-dashboard',
    GML_PLUGIN_URL . 'assets/js/dashboardsiswa.js',
    [],
    '1.0.0',
    true
);

// ── Dynamic data (replace with Firebase/WP user meta in production) ────────
$hour = (int) date( 'G' );
if ( $hour < 11 )       $greeting = 'Selamat Pagi';
elseif ( $hour < 15 )   $greeting = 'Selamat Siang';
else                    $greeting = 'Selamat Sore';

$today         = date_i18n( 'l, j F Y' );
$user_name     = 'Nur Azizah';
$user_initials = 'NA';
$user_level    = 12;
$user_xp       = 3940;
$user_xp_next  = 4500;
$xp_pct        = round( ( $user_xp / $user_xp_next ) * 100 );

$weekly_xp     = 340;
$weekly_target = 500;
$weekly_pct    = round( ( $weekly_xp / $weekly_target ) * 100 );

$missions = [
    [ 'id' => 1, 'label' => 'Login hari ini',          'xp' => 10, 'done' => true  ],
    [ 'id' => 2, 'label' => 'Selesaikan 1 materi',     'xp' => 30, 'done' => false ],
    [ 'id' => 3, 'label' => 'Kerjakan 1 kuis',         'xp' => 50, 'done' => false ],
    [ 'id' => 4, 'label' => 'Dapatkan nilai minimal 80','xp' => 70, 'done' => false ],
];

$tasks = [
    [
        'title'    => 'Tugas Essay: Revolusi Industri',
        'course'   => 'Sejarah Dunia',
        'deadline' => 'Besok, 23:59',
        'priority' => 'mendesak',
    ],
    [
        'title'    => 'Latihan Soal Integral',
        'course'   => 'Matematika Lanjut',
        'deadline' => 'Lusa, 18:00',
        'priority' => 'penting',
    ],
    [
        'title'    => 'Resume Bab 4: Ekosistem',
        'course'   => 'Biologi',
        'deadline' => 'Jum, 12:00',
        'priority' => 'normal',
    ],
];

$leaderboard = [
    [ 'rank' => 1, 'name' => 'Rizky Pratama',  'initials' => 'RP', 'xp' => 4820, 'trend' => 'same', 'is_me' => false ],
    [ 'rank' => 2, 'name' => 'Siti Rahayu',    'initials' => 'SR', 'xp' => 4510, 'trend' => 'up',   'is_me' => false ],
    [ 'rank' => 3, 'name' => 'Ahmad Fauzi',    'initials' => 'AF', 'xp' => 4250, 'trend' => 'down', 'is_me' => false ],
    [ 'rank' => 4, 'name' => 'Kamu',           'initials' => 'NA', 'xp' => 3940, 'trend' => 'up',   'is_me' => true  ],
    [ 'rank' => 5, 'name' => 'Dewi Anggraini', 'initials' => 'DA', 'xp' => 3870, 'trend' => 'same', 'is_me' => false ],
];

$badges = [
    [ 'icon' => '🔥', 'label' => '7 Hari Berturut', 'earned' => true  ],
    [ 'icon' => '⚡', 'label' => 'Quiz Master',      'earned' => true  ],
    [ 'icon' => '📚', 'label' => 'Pelajar Aktif',    'earned' => true  ],
    [ 'icon' => '🏅', 'label' => 'Top 10',           'earned' => false ],
    [ 'icon' => '💎', 'label' => 'Perfect Score',    'earned' => false ],
    [ 'icon' => '🎯', 'label' => 'Misi Lengkap',     'earned' => false ],
];

$notifications = [
    [ 'text' => 'Nilai kuis Matematika kamu: 92/100',        'time' => '5 mnt lalu',  'read' => false ],
    [ 'text' => 'Badge baru: Quiz Master diperoleh!',        'time' => '1 jam lalu',  'read' => false ],
    [ 'text' => 'Pengingat: Tugas Essay deadline besok',     'time' => '3 jam lalu',  'read' => true  ],
    [ 'text' => 'Kursus baru: Data Science Dasar tersedia',  'time' => 'Kemarin',     'read' => true  ],
];

$unread_count     = count( array_filter( $notifications, fn($n) => ! $n['read'] ) );
$missions_done    = count( array_filter( $missions, fn($m) => $m['done'] ) );
$missions_total   = count( $missions );
$mission_xp_earned = array_sum( array_column( array_filter( $missions, fn($m) => $m['done'] ), 'xp' ) );
$mission_pct      = round( ( $missions_done / $missions_total ) * 100 );

$priority_map = [
    'mendesak' => [ 'label' => 'Mendesak', 'class' => 'gml-priority--mendesak' ],
    'penting'  => [ 'label' => 'Penting',  'class' => 'gml-priority--penting'  ],
    'normal'   => [ 'label' => 'Normal',   'class' => 'gml-priority--normal'   ],
];

$trend_icons = [
    'up'   => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="gml-trend-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>',
    'down' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="gml-trend-down"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>',
    'same' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="gml-trend-same"><line x1="5" y1="12" x2="19" y2="12"/></svg>',
];
?>

<div class="gml-dashboard">

    <!-- ── Sidebar ─────────────────────────────────────────────────── -->
    <aside class="gml-sidebar">

        <!-- Logo -->
        <div class="gml-sidebar__logo">
            <div class="gml-sidebar__logo-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            </div>
            <span class="gml-sidebar__logo-text">Gamifikasi LMS</span>
        </div>

        <!-- Navigation -->
        <nav class="gml-sidebar__nav" aria-label="Navigasi utama">
            <p class="gml-sidebar__section-label">Menu</p>
            <ul class="gml-sidebar__nav-list" role="list">
                <li>
                    <a href="/dashboard" class="gml-sidebar__nav-link gml-sidebar__nav-link--active" aria-current="page" data-nav="dashboard">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Dashboard
                        <span class="gml-sidebar__nav-dot" aria-hidden="true"></span>
                    </a>
                </li>
                <li>
                    <a href="/kursus" class="gml-sidebar__nav-link" data-nav="kursus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        Kursus
                    </a>
                </li>
                <li>
                    <a href="/quiz" class="gml-sidebar__nav-link" data-nav="quiz">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="15" y2="17"/><line x1="9" y1="9" x2="11" y2="9"/></svg>
                        Quiz
                    </a>
                </li>
                <li>
                    <a href="/leaderboard" class="gml-sidebar__nav-link" data-nav="leaderboard">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2z"/></svg>
                        Leaderboard
                    </a>
                </li>
                <li>
                    <a href="/profil" class="gml-sidebar__nav-link" data-nav="profil">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Profil
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Quick Access -->
        <div class="gml-sidebar__quick">
            <p class="gml-sidebar__section-label">Akses Cepat</p>
            <ul class="gml-sidebar__quick-list" role="list">
                <li><a href="/kursus" class="gml-sidebar__quick-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    My Courses
                </a></li>
                <li><a href="/tugas" class="gml-sidebar__quick-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="15" y2="17"/></svg>
                    Assignments
                </a></li>
                <li><a href="/diskusi" class="gml-sidebar__quick-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Diskusi
                </a></li>
                <li><a href="/sertifikat" class="gml-sidebar__quick-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                    Sertifikat
                </a></li>
                <li><a href="/kalender" class="gml-sidebar__quick-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Kalender
                </a></li>
            </ul>
        </div>

    </aside>

    <!-- ── Main ────────────────────────────────────────────────────── -->
    <div class="gml-main">

        <!-- Header -->
        <header class="gml-header">
            <div class="gml-header__info">
                <h1 class="gml-header__title">Dashboard</h1>
                <p class="gml-header__date"><?php echo esc_html( $today ); ?></p>
            </div>

            <div class="gml-header__actions">

                <!-- Notification Bell -->
                <div class="gml-notif" id="gml-notif">
                    <button
                        class="gml-notif__btn"
                        id="gml-notif-btn"
                        aria-label="Notifikasi"
                        aria-expanded="false"
                        aria-haspopup="true"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        <?php if ( $unread_count > 0 ) : ?>
                            <span class="gml-notif__badge" aria-label="<?php echo $unread_count; ?> notifikasi belum dibaca"></span>
                        <?php endif; ?>
                    </button>

                    <!-- Dropdown -->
                    <div class="gml-notif__dropdown" id="gml-notif-dropdown" role="dialog" aria-label="Notifikasi" hidden>
                        <div class="gml-notif__dropdown-head">
                            <span class="gml-notif__dropdown-title">Notifikasi</span>
                            <button class="gml-notif__mark-all" id="gml-notif-mark-all">Tandai semua dibaca</button>
                        </div>
                        <ul class="gml-notif__list" id="gml-notif-list">
                            <?php foreach ( $notifications as $index => $notif ) : ?>
                                <li class="gml-notif__item <?php echo $notif['read'] ? '' : 'gml-notif__item--unread'; ?>" data-index="<?php echo $index; ?>">
                                    <p class="gml-notif__text"><?php echo esc_html( $notif['text'] ); ?></p>
                                    <p class="gml-notif__time"><?php echo esc_html( $notif['time'] ); ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- User Info -->
                <div class="gml-user">
                    <div class="gml-user__avatar" aria-hidden="true">
                        <?php echo esc_html( $user_initials ); ?>
                    </div>
                    <div class="gml-user__info">
                        <p class="gml-user__name"><?php echo esc_html( $user_name ); ?></p>
                        <p class="gml-user__meta">Level <?php echo $user_level; ?> · <?php echo number_format( $user_xp, 0, ',', '.' ); ?> XP</p>
                    </div>
                </div>

            </div>
        </header>

        <!-- Scrollable Content -->
        <main class="gml-content" id="gml-content">

            <!-- ── Hero: Welcome + Continue Learning ──────────────── -->
            <section class="gml-hero" aria-label="Selamat datang">
                <div class="gml-hero__grid">

                    <!-- Welcome -->
                    <div class="gml-welcome">
                        <div class="gml-welcome__text">
                            <p class="gml-welcome__greeting"><?php echo esc_html( $greeting ); ?>, 👋</p>
                            <h2 class="gml-welcome__name"><?php echo esc_html( $user_name ); ?></h2>
                            <p class="gml-welcome__summary">
                                Kamu memiliki <strong>2 tugas</strong> yang harus diselesaikan hari ini.
                            </p>
                        </div>
                        <div class="gml-welcome__progress">
                            <div class="gml-welcome__progress-labels">
                                <span>Target mingguan</span>
                                <span><?php echo $weekly_pct; ?>%</span>
                            </div>
                            <div class="gml-progress-bar" role="progressbar" aria-valuenow="<?php echo $weekly_pct; ?>" aria-valuemin="0" aria-valuemax="100">
                                <div class="gml-progress-bar__fill gml-progress-bar__fill--white" style="width: <?php echo $weekly_pct; ?>%"></div>
                            </div>
                            <p class="gml-welcome__progress-sub"><?php echo $weekly_xp; ?> / <?php echo $weekly_target; ?> XP minggu ini</p>
                        </div>
                    </div>

                    <!-- Continue Learning -->
                    <div class="gml-continue">
                        <div class="gml-continue__head">
                            <div class="gml-continue__icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            </div>
                            <span class="gml-continue__label">Lanjutkan Belajar</span>
                        </div>

                        <p class="gml-continue__course">Kalkulus Diferensial</p>
                        <p class="gml-continue__chapter">Bab 7: Turunan Fungsi Trigonometri</p>

                        <div class="gml-progress-bar gml-continue__bar" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" aria-label="Progress kursus 62%">
                            <div class="gml-progress-bar__fill" style="width: 62%"></div>
                        </div>
                        <div class="gml-continue__meta">
                            <span>62% selesai</span>
                            <span class="gml-continue__time">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                ~18 menit
                            </span>
                        </div>

                        <a href="/kursus/kalkulus-diferensial/bab-7" class="gml-btn gml-btn--primary gml-continue__cta">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none" aria-hidden="true"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            Lanjutkan Belajar
                        </a>
                    </div>

                </div>
            </section>

            <!-- ── Row 2: Daily Mission + Statistics ──────────────── -->
            <section class="gml-row" aria-label="Misi harian dan statistik">
                <div class="gml-row__grid">

                    <!-- Daily Mission -->
                    <div class="gml-card" id="gml-missions">
                        <div class="gml-card__head">
                            <div class="gml-card__title-group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <h3 class="gml-card__title">Misi Harian</h3>
                            </div>
                            <span class="gml-mission__summary" id="gml-mission-summary">
                                <?php echo $missions_done; ?>/<?php echo $missions_total; ?> selesai ·
                                <strong>+<?php echo $mission_xp_earned; ?> XP</strong>
                            </span>
                        </div>

                        <div class="gml-progress-bar gml-mission__bar" role="progressbar" aria-valuenow="<?php echo $mission_pct; ?>" aria-valuemin="0" aria-valuemax="100" aria-label="Progress misi harian">
                            <div class="gml-progress-bar__fill gml-progress-bar__fill--accent" id="gml-mission-bar" style="width: <?php echo $mission_pct; ?>%"></div>
                        </div>

                        <ul class="gml-mission__list" id="gml-mission-list" role="list">
                            <?php foreach ( $missions as $mission ) : ?>
                                <li class="gml-mission__item <?php echo $mission['done'] ? 'gml-mission__item--done' : ''; ?>" data-id="<?php echo $mission['id']; ?>" data-xp="<?php echo $mission['xp']; ?>">
                                    <button
                                        class="gml-mission__check"
                                        aria-label="<?php echo $mission['done'] ? 'Tandai belum selesai' : 'Tandai selesai'; ?>: <?php echo esc_attr( $mission['label'] ); ?>"
                                    >
                                        <?php if ( $mission['done'] ) : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        <?php else : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/></svg>
                                        <?php endif; ?>
                                    </button>
                                    <span class="gml-mission__label"><?php echo esc_html( $mission['label'] ); ?></span>
                                    <span class="gml-mission__xp <?php echo $mission['done'] ? 'gml-mission__xp--done' : ''; ?>">
                                        +<?php echo $mission['xp']; ?> XP
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Statistics -->
                    <div class="gml-card">
                        <div class="gml-card__head">
                            <div class="gml-card__title-group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#4F46E5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                                <h3 class="gml-card__title">Statistik</h3>
                            </div>
                        </div>
                        <div class="gml-stats__grid" role="list">
                            <div class="gml-stat" role="listitem">
                                <div class="gml-stat__icon gml-stat__icon--amber">⚡</div>
                                <div><p class="gml-stat__value"><?php echo number_format( $user_xp, 0, ',', '.' ); ?></p><p class="gml-stat__label">Total XP</p></div>
                            </div>
                            <div class="gml-stat" role="listitem">
                                <div class="gml-stat__icon gml-stat__icon--orange">🔥</div>
                                <div><p class="gml-stat__value">7 hari</p><p class="gml-stat__label">Streak</p></div>
                            </div>
                            <div class="gml-stat" role="listitem">
                                <div class="gml-stat__icon gml-stat__icon--blue">🕐</div>
                                <div><p class="gml-stat__value">42 jam</p><p class="gml-stat__label">Waktu Belajar</p></div>
                            </div>
                            <div class="gml-stat" role="listitem">
                                <div class="gml-stat__icon gml-stat__icon--violet">⭐</div>
                                <div><p class="gml-stat__value">86,4</p><p class="gml-stat__label">Nilai Rata-rata</p></div>
                            </div>
                            <div class="gml-stat" role="listitem">
                                <div class="gml-stat__icon gml-stat__icon--green">📋</div>
                                <div><p class="gml-stat__value">18</p><p class="gml-stat__label">Quiz Selesai</p></div>
                            </div>
                            <div class="gml-stat" role="listitem">
                                <div class="gml-stat__icon gml-stat__icon--indigo">📚</div>
                                <div><p class="gml-stat__value">3</p><p class="gml-stat__label">Kursus Selesai</p></div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- ── Row 3: Upcoming Tasks + Achievement + Leaderboard ─ -->
            <section class="gml-row" aria-label="Tugas, pencapaian, dan leaderboard">
                <div class="gml-row__grid">

                    <!-- Upcoming Tasks -->
                    <div class="gml-card">
                        <div class="gml-card__head">
                            <div class="gml-card__title-group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#4F46E5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="15" y2="17"/></svg>
                                <h3 class="gml-card__title">Tugas Mendatang</h3>
                            </div>
                            <a href="/tugas" class="gml-card__link">
                                Lihat semua
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        </div>

                        <?php if ( empty( $tasks ) ) : ?>
                            <div class="gml-empty">
                                <p class="gml-empty__text">Tidak ada tugas mendatang.</p>
                            </div>
                        <?php else : ?>
                            <ul class="gml-tasks__list" role="list">
                                <?php foreach ( $tasks as $task ) : ?>
                                    <li class="gml-task">
                                        <div class="gml-task__body">
                                            <p class="gml-task__title"><?php echo esc_html( $task['title'] ); ?></p>
                                            <p class="gml-task__course"><?php echo esc_html( $task['course'] ); ?></p>
                                        </div>
                                        <div class="gml-task__meta">
                                            <span class="gml-priority <?php echo esc_attr( $priority_map[ $task['priority'] ]['class'] ); ?>">
                                                <?php echo esc_html( $priority_map[ $task['priority'] ]['label'] ); ?>
                                            </span>
                                            <span class="gml-task__deadline">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                <?php echo esc_html( $task['deadline'] ); ?>
                                            </span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <!-- Right column: Achievement + Leaderboard -->
                    <div class="gml-col">

                        <!-- Achievement -->
                        <div class="gml-card">
                            <div class="gml-card__head">
                                <div class="gml-card__title-group">
                                    <span aria-hidden="true">🏆</span>
                                    <h3 class="gml-card__title">Pencapaian</h3>
                                </div>
                                <span class="gml-achievement__level">Lv. <?php echo $user_level; ?></span>
                            </div>

                            <div class="gml-achievement__xp-row">
                                <span><?php echo number_format( $user_xp, 0, ',', '.' ); ?> XP</span>
                                <span>Level <?php echo $user_level + 1; ?> → <?php echo number_format( $user_xp_next, 0, ',', '.' ); ?> XP</span>
                            </div>
                            <div class="gml-progress-bar" role="progressbar" aria-valuenow="<?php echo $xp_pct; ?>" aria-valuemin="0" aria-valuemax="100" aria-label="Progress menuju level berikutnya">
                                <div class="gml-progress-bar__fill gml-progress-bar__fill--accent" style="width: <?php echo $xp_pct; ?>%"></div>
                            </div>

                            <div class="gml-badges" role="list">
                                <?php foreach ( $badges as $badge ) : ?>
                                    <div class="gml-badge <?php echo $badge['earned'] ? '' : 'gml-badge--locked'; ?>" role="listitem" title="<?php echo esc_attr( $badge['label'] ); ?>">
                                        <span class="gml-badge__icon" aria-hidden="true"><?php echo $badge['icon']; ?></span>
                                        <span class="gml-badge__label"><?php echo esc_html( $badge['label'] ); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Mini Leaderboard -->
                        <div class="gml-card">
                            <div class="gml-card__head">
                                <div class="gml-card__title-group">
                                    <span aria-hidden="true">🥇</span>
                                    <h3 class="gml-card__title">Leaderboard</h3>
                                </div>
                                <a href="/leaderboard" class="gml-card__link">
                                    Lihat semua
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
                                </a>
                            </div>

                            <ul class="gml-lb__list" role="list">
                                <?php foreach ( $leaderboard as $entry ) : ?>
                                    <li class="gml-lb__row <?php echo $entry['is_me'] ? 'gml-lb__row--me' : ''; ?>">
                                        <span class="gml-lb__rank gml-lb__rank--<?php echo $entry['rank']; ?>" aria-label="Peringkat <?php echo $entry['rank']; ?>">
                                            <?php echo $entry['rank']; ?>
                                        </span>
                                        <div class="gml-lb__avatar <?php echo $entry['is_me'] ? 'gml-lb__avatar--me' : ''; ?>" aria-hidden="true">
                                            <?php echo esc_html( $entry['initials'] ); ?>
                                        </div>
                                        <span class="gml-lb__name <?php echo $entry['is_me'] ? 'gml-lb__name--me' : ''; ?>">
                                            <?php echo esc_html( $entry['name'] ); ?>
                                        </span>
                                        <div class="gml-lb__xp-group">
                                            <?php echo $trend_icons[ $entry['trend'] ]; ?>
                                            <span class="gml-lb__xp"><?php echo number_format( $entry['xp'], 0, ',', '.' ); ?></span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </div><!-- /.gml-col -->

                </div>
            </section>

        </main><!-- /#gml-content -->

    </div><!-- /.gml-main -->

</div><!-- /.gml-dashboard -->

