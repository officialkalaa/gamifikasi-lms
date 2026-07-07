<main class="gml-page" id="gmlPage">
  

  <section class="gml-workspace" id="gmlPanelArea" aria-label="Dashboard fitur guru">
    <div class="gml-shell">
      <div class="gml-workspace__layout">
        <aside class="gml-sidebar gml-reveal" aria-label="Menu dashboard guru">
          <div class="gml-sidebar__brand">
            <span>🎮</span>
            <div>
              <strong>Gamifikasi LMS</strong>
              <small>Dashboard Guru</small>
            </div>
          </div>

          <nav class="gml-sidebar__nav" aria-label="Daftar bagian dashboard">
            <button class="gml-sidebar__item is-active" type="button" data-gml-panel="summary">Class Summary</button>
            <button class="gml-sidebar__item" type="button" data-gml-panel="statistics">Learning Statistics</button>
            <button class="gml-sidebar__item" type="button" data-gml-panel="activity">Recent Activity</button>
            <button class="gml-sidebar__item" type="button" data-gml-panel="classes">Class List</button>
            <button class="gml-sidebar__item" type="button" data-gml-panel="content">Content Management</button>
            <button class="gml-sidebar__item" type="button" data-gml-panel="assignment">Assignment & Quiz</button>
            <button class="gml-sidebar__item" type="button" data-gml-panel="leaderboard">Student Leaderboard</button>
            <button class="gml-sidebar__item" type="button" data-gml-panel="progress">Learning Progress</button>
            <button class="gml-sidebar__item" type="button" data-gml-panel="missions">Weekly Missions</button>
            <button class="gml-sidebar__item" type="button" data-gml-panel="calendar">Academic Calendar</button>
            <button class="gml-sidebar__item" type="button" data-gml-panel="notifications">Notifications</button>
            <button class="gml-sidebar__item" type="button" data-gml-panel="messages">Messages</button>
            <button class="gml-sidebar__item" type="button" data-gml-panel="analytics">Performance Analytics</button>
            <button class="gml-sidebar__item" type="button" data-gml-panel="ai">AI Recommendations</button>
            <button class="gml-sidebar__item" type="button" data-gml-panel="actions">Quick Actions</button>
          </nav>
        </aside>

        <div class="gml-panel-stage gml-reveal">
          <section class="gml-panel is-active" data-gml-panel-content="summary">
            <div class="gml-panel__head">
              <span>📊</span>
              <div>
                <h2>Class Summary</h2>
                <p>Ringkasan cepat aktivitas kelas hari ini.</p>
              </div>
            </div>
            <div class="gml-metric-grid">
              <article class="gml-metric"><span>👥</span><strong data-gml-counter="248">0</strong><small>Students</small></article>
              <article class="gml-metric"><span>🏫</span><strong data-gml-counter="12">0</strong><small>Active Classes</small></article>
              <article class="gml-metric"><span>📝</span><strong data-gml-counter="34">0</strong><small>Assignments</small></article>
              <article class="gml-metric"><span>📈</span><strong data-gml-counter="82">0</strong><small>Progress %</small></article>
            </div>
          </section>

          <section class="gml-panel" data-gml-panel-content="statistics">
            <div class="gml-panel__head"><span>📈</span><div><h2>Learning Statistics</h2><p>Completion, scores, and attendance trends.</p></div></div>
            <div class="gml-chart-grid">
              <article class="gml-chart-card"><h3>Material Completion</h3><div class="gml-ring" style="--gml-ring:82"><span>82%</span></div></article>
              <article class="gml-chart-card"><h3>Average Scores</h3><div class="gml-bars"><span style="--gml-bar:72%"></span><span style="--gml-bar:88%"></span><span style="--gml-bar:64%"></span><span style="--gml-bar:92%"></span></div></article>
              <article class="gml-chart-card"><h3>Attendance</h3><div class="gml-progress"><span style="--gml-progress:91%"></span></div><strong>91%</strong></article>
            </div>
          </section>

          <section class="gml-panel" data-gml-panel-content="activity">
            <div class="gml-panel__head"><span>🔔</span><div><h2>Recent Activity</h2><p>Submissions, comments, and earned badges.</p></div></div>
            <div class="gml-feed">
              <article><span>✅</span><p><strong>Alya</strong> submitted Quiz Algebra.</p><small>2 min ago</small></article>
              <article><span>💬</span><p><strong>Raka</strong> commented on Science Mission.</p><small>14 min ago</small></article>
              <article><span>🎖️</span><p><strong>Naya</strong> earned Focus Master badge.</p><small>32 min ago</small></article>
            </div>
          </section>

          <section class="gml-panel" data-gml-panel-content="classes">
            <div class="gml-panel__head"><span>🏫</span><div><h2>Class List</h2><p>Kelola kelas aktif dan performanya.</p></div></div>
            <div class="gml-table">
              <div><strong>Matematika 8A</strong><span>92 students</span><em>Active</em></div>
              <div><strong>Biologi Dasar</strong><span>64 students</span><em>Active</em></div>
              <div><strong>Corporate Onboarding</strong><span>120 learners</span><em>Active</em></div>
            </div>
          </section>

          <section class="gml-panel" data-gml-panel-content="content">
            <div class="gml-panel__head"><span>📚</span><div><h2>Content Management</h2><p>Atur materi, modul, video, dan reward pembelajaran.</p></div></div>
            <div class="gml-card-grid">
              <article class="gml-feature-tile">📘<strong>Modules</strong><span>48 published</span></article>
              <article class="gml-feature-tile">🎬<strong>Video Lessons</strong><span>26 active</span></article>
              <article class="gml-feature-tile">🎁<strong>Reward Rules</strong><span>14 configured</span></article>
            </div>
          </section>

          <section class="gml-panel" data-gml-panel-content="assignment">
            <div class="gml-panel__head"><span>🧩</span><div><h2>Assignment & Quiz Management</h2><p>Buat kuis, tugas, rubrik, dan XP otomatis.</p></div></div>
            <div class="gml-task-list">
              <article><strong>Quiz Pemanasan</strong><span>18 submissions</span><button type="button">Review</button></article>
              <article><strong>Essay Mingguan</strong><span>42 submissions</span><button type="button">Grade</button></article>
              <article><strong>Challenge Sprint</strong><span>9 teams</span><button type="button">Open</button></article>
            </div>
          </section>

          <section class="gml-panel" data-gml-panel-content="leaderboard">
            <div class="gml-panel__head"><span>🏆</span><div><h2>Student Leaderboard</h2><p>Peringkat XP, streak, dan badge siswa.</p></div></div>
            <ol class="gml-leaderboard">
              <li><span>🥇</span><strong>Alya Putri</strong><em>9.820 XP</em></li>
              <li><span>🥈</span><strong>Raka Mahendra</strong><em>8.640 XP</em></li>
              <li><span>🥉</span><strong>Naya Kirana</strong><em>7.910 XP</em></li>
            </ol>
          </section>

          <section class="gml-panel" data-gml-panel-content="progress">
            <div class="gml-panel__head"><span>🚀</span><div><h2>Student Learning Progress</h2><p>Pantau perkembangan siswa per materi.</p></div></div>
            <div class="gml-progress-list">
              <article><strong>Alya</strong><div class="gml-progress"><span style="--gml-progress:96%"></span></div><small>96%</small></article>
              <article><strong>Raka</strong><div class="gml-progress"><span style="--gml-progress:84%"></span></div><small>84%</small></article>
              <article><strong>Dimas</strong><div class="gml-progress"><span style="--gml-progress:58%"></span></div><small>58%</small></article>
            </div>
          </section>

          <section class="gml-panel" data-gml-panel-content="missions">
            <div class="gml-panel__head"><span>🎯</span><div><h2>Weekly Missions / Challenges</h2><p>Misi mingguan untuk menjaga motivasi kelas.</p></div></div>
            <div class="gml-mission-grid">
              <article><span>🔥</span><strong>7-Day Streak</strong><small>Complete one lesson daily</small></article>
              <article><span>💡</span><strong>Quiz Hero</strong><small>Score above 85%</small></article>
              <article><span>🤝</span><strong>Team Quest</strong><small>Finish group discussion</small></article>
            </div>
          </section>

          <section class="gml-panel" data-gml-panel-content="calendar">
            <div class="gml-panel__head"><span>🗓️</span><div><h2>Academic Calendar</h2><p>Akses kalender akademik dan PDF untuk guru.</p></div></div>
            <div class="gml-calendar-card">
              <strong>July 2026</strong>
              <p>3 exams, 6 missions, 2 review weeks scheduled.</p>
              <a class="gml-btn gml-btn--primary" href="#" aria-label="Download academic calendar PDF">PDF Accessibility</a>
            </div>
          </section>

          <section class="gml-panel" data-gml-panel-content="notifications">
            <div class="gml-panel__head"><span>📣</span><div><h2>Notifications</h2><p>Pemberitahuan penting kelas dan LMS.</p></div></div>
            <div class="gml-feed">
              <article><span>⚠️</span><p>5 students missed the weekly mission.</p><small>Today</small></article>
              <article><span>🎉</span><p>Class 8A reached 90% completion.</p><small>Yesterday</small></article>
            </div>
          </section>

          <section class="gml-panel" data-gml-panel-content="messages">
            <div class="gml-panel__head"><span>💬</span><div><h2>Messages / Student Discussions</h2><p>Diskusi siswa dan pesan terbaru.</p></div></div>
            <div class="gml-chat-list">
              <article><strong>Alya</strong><p>Bu, apakah badge teamwork bisa didapat dari tugas kelompok?</p></article>
              <article><strong>Group Science A</strong><p>Kami sudah upload hasil eksperimen.</p></article>
            </div>
          </section>

          <section class="gml-panel" data-gml-panel-content="analytics">
            <div class="gml-panel__head"><span>🧠</span><div><h2>Student Performance Analytics</h2><p>Analitik performa siswa berbasis indikator belajar.</p></div></div>
            <div class="gml-insight-grid">
              <article><strong>High Engagement</strong><span>68%</span></article>
              <article><strong>Need Support</strong><span>12 students</span></article>
              <article><strong>Top Material</strong><span>Algebra Quest</span></article>
            </div>
          </section>

          <section class="gml-panel" data-gml-panel-content="ai">
            <div class="gml-panel__head"><span>✨</span><div><h2>AI Recommendations</h2><p>Saran prioritas untuk siswa dan materi.</p></div></div>
            <div class="gml-ai-box">
              <article><strong>Students needing attention</strong><p>Dimas, Fira, and Kevin show declining completion over 7 days.</p></article>
              <article><strong>Material requiring review</strong><p>Fractions Level 2 has the highest retry rate this week.</p></article>
            </div>
          </section>

          <section class="gml-panel" data-gml-panel-content="actions">
            <div class="gml-panel__head"><span>⚡</span><div><h2>Quick Actions</h2><p>Aksi cepat untuk workflow guru.</p></div></div>
            <div class="gml-action-grid">
              <button type="button">📚 Add Material</button>
              <button type="button">🧪 Create Quiz</button>
              <button type="button">🎯 Create Challenge</button>
            </div>
          </section>
        </div>
      </div>
    </div>
  </section>

  <footer class="gml-footer">
    <div class="gml-shell">
      <strong>Gamifikasi LMS</strong>
      <span>Premium teacher dashboard for joyful learning experiences.</span>
    </div>
  </footer>
</main>