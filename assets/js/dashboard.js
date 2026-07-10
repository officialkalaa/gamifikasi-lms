(() => {
  "use strict";

  // Safeguard: Check if Firebase is available
  if (typeof firebase === "undefined" || typeof auth === "undefined" || typeof db === "undefined") {
    console.error("Firebase SDK is not loaded. Teacher Dashboard will run in offline mode.");
    return;
  }

  const page = document.querySelector(".gml-page");
  if (!page) return;

  /* ── Authentication & Route Protection ────────────────────────────────── */
  auth.onAuthStateChanged(function (user) {
    if (!user) {
      window.location.href = "/login";
      return;
    }

    // Fetch user profile from Firestore
    db.collection("users")
      .doc(user.uid)
      .get()
      .then(function (doc) {
        if (doc.exists) {
          var userData = doc.data();
          if (userData.role === "student") {
            // Student shouldn't access Teacher Dashboard, redirect them
            window.location.href = "/dashboardsiswa";
          } else {
            // Initialize teacher dashboard metrics & views
            initializeTeacherDashboard(user, userData);
          }
        } else {
          console.warn("User document not found in Firestore. Redirecting to login...");
          window.location.href = "/login";
        }
      })
      .catch(function (error) {
        console.error("Error checking user profile:", error);
        window.location.href = "/login";
      });
  });

  /* ── Teacher Dashboard Initializer ────────────────────────────────────── */
  function initializeTeacherDashboard(user, userData) {
    // 1. Fetch Class Summary counters
    fetchClassSummary();

    // 2. Fetch Live Leaderboard
    fetchStudentLeaderboard();

    // 3. Fetch Learning Progress list
    fetchLearningProgress();

    // 4. Fetch Course List
    fetchCourseList();

    // 5. Fetch Recent Activity Feed
    fetchRecentActivity();
  }

  /* ── Fetch & Animate Counters ─────────────────────────────────────────── */
  function fetchClassSummary() {
    // Count active students (role == 'student')
    db.collection("users")
      .where("role", "==", "student")
      .get()
      .then((snapshot) => {
        updateAndAnimateCounter('Students', snapshot.size);
      });

    // Count courses
    db.collection("courses")
      .get()
      .then((snapshot) => {
        updateAndAnimateCounter('Active Classes', snapshot.size);
      });

    // Count quizzes
    db.collection("quizzes")
      .get()
      .then((snapshot) => {
        updateAndAnimateCounter('Assignments', snapshot.size);
      });

    // Compute progress average
    db.collection("progress")
      .get()
      .then((snapshot) => {
        let totalProgress = 0;
        snapshot.forEach((doc) => {
          totalProgress += doc.data().progress || 0;
        });
        const avgProgress = snapshot.size > 0 ? Math.round(totalProgress / snapshot.size) : 82;
        updateAndAnimateCounter('Progress %', avgProgress);
      });
  }

  function updateAndAnimateCounter(labelName, targetValue) {
    document.querySelectorAll(".gml-metric").forEach((metric) => {
      const label = metric.querySelector("small");
      const counter = metric.querySelector("[data-gml-counter]");
      if (label && label.textContent.trim() === labelName && counter) {
        counter.dataset.gmlCounter = targetValue;
        animateCounter(counter);
      }
    });
  }

  /* ── Fetch Leaderboard ────────────────────────────────────────────────── */
  function fetchStudentLeaderboard() {
    const leaderboardOl = document.querySelector(".gml-leaderboard");
    if (!leaderboardOl) return;

    db.collection("users")
      .where("role", "==", "student")
      .orderBy("xp", "desc")
      .limit(10)
      .get()
      .then((snapshot) => {
        if (snapshot.empty) return;

        let html = "";
        let rank = 1;

        snapshot.forEach((doc) => {
          const data = doc.data();
          let medal = rank === 1 ? "🥇" : rank === 2 ? "🥈" : rank === 3 ? "🥉" : "🏅";

          html += `<li>`;
          html += `  <span>${medal}</span>`;
          html += `  <strong>${escapeHTML(data.fullname)}</strong>`;
          html += `  <em>${(data.xp || 0).toLocaleString("id-ID")} XP</em>`;
          html += `</li>`;

          rank++;
        });

        leaderboardOl.innerHTML = html;
      })
      .catch((err) => {
        console.warn("Could not fetch Firestore leaderboard, using offline fallback.", err);
      });
  }

  /* ── Fetch Learning Progress ─────────────────────────────────────────── */
  function fetchLearningProgress() {
    const progressList = document.querySelector(".gml-progress-list");
    if (!progressList) return;

    db.collection("progress")
      .limit(12)
      .get()
      .then((snapshot) => {
        if (snapshot.empty) return;

        let html = "";
        snapshot.forEach((doc) => {
          const progressData = doc.data();
          const progressVal = parseInt(progressData.progress, 10) || 0;

          // Fetch student name
          db.collection("users")
            .doc(progressData.uid)
            .get()
            .then((userDoc) => {
              const name = userDoc.exists ? userDoc.data().fullname : "Siswa LMS";
              
              const itemHtml = `
                <article>
                  <strong>${escapeHTML(name)}</strong>
                  <div class="gml-progress">
                    <span style="--gml-progress: ${progressVal}%"></span>
                  </div>
                  <small>${progressVal}%</small>
                </article>
              `;
              
              // Append to list dynamically
              const tempDiv = document.createElement("div");
              tempDiv.innerHTML = itemHtml;
              progressList.appendChild(tempDiv.firstElementChild);
            });
        });

        // Clear existing mock entries
        progressList.innerHTML = "";
      })
      .catch((err) => {
        console.warn("Could not load dynamic progress list, using fallback.", err);
      });
  }

  /* ── Fetch Course Class List ─────────────────────────────────────────── */
  function fetchCourseList() {
    const tableDiv = document.querySelector(".gml-table");
    if (!tableDiv) return;

    db.collection("courses")
      .limit(6)
      .get()
      .then((snapshot) => {
        if (snapshot.empty) return;

        let html = "";
        snapshot.forEach((doc) => {
          const data = doc.data();
          const difficulty = data.difficulty || "Umum";

          html += `<div>`;
          html += `  <strong>${escapeHTML(data.title)}</strong>`;
          html += `  <span>${escapeHTML(data.description || "Kelas Gamifikasi")}</span>`;
          html += `  <em>${escapeHTML(difficulty)}</em>`;
          html += `</div>`;
        });

        tableDiv.innerHTML = html;
      })
      .catch((err) => {
        console.warn("Failed to load active courses, using default table.", err);
      });
  }

  /* ── Fetch Recent Activity ───────────────────────────────────────────── */
  function fetchRecentActivity() {
    const feedDiv = document.querySelector(".gml-feed");
    if (!feedDiv) return;

    db.collection("quiz_results")
      .orderBy("finishedAt", "desc")
      .limit(5)
      .get()
      .then((snapshot) => {
        if (snapshot.empty) return;

        let html = "";
        snapshot.forEach((doc) => {
          const data = doc.data();
          const score = data.score || 0;

          db.collection("users")
            .doc(data.uid)
            .get()
            .then((userDoc) => {
              const name = userDoc.exists ? userDoc.data().fullname : "Siswa";
              
              const actHtml = `
                <article>
                  <span>✅</span>
                  <p><strong>${escapeHTML(name)}</strong> menyelesaikan kuis dengan skor ${score}/100.</p>
                  <small>Baru saja</small>
                </article>
              `;

              const tempDiv = document.createElement("div");
              tempDiv.innerHTML = actHtml;
              feedDiv.appendChild(tempDiv.firstElementChild);
            });
        });

        // Empty existing static list
        feedDiv.innerHTML = "";
      })
      .catch((err) => {
        console.warn("Could not fetch live activity logs.", err);
      });
  }

  /* ── Safe HTML Escape utility ───────────────────────────────────────── */
  function escapeHTML(str) {
    if (!str) return "";
    return str
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  /* ── Panel Switching Logic (Original) ─────────────────────────────────── */
  const sidebarButtons = Array.from(page.querySelectorAll("[data-gml-panel]"));
  const panels = Array.from(page.querySelectorAll("[data-gml-panel-content]"));

  const activatePanel = (panelId) => {
    sidebarButtons.forEach((button) => {
      const isActive = button.dataset.gmlPanel === panelId;
      button.classList.toggle("is-active", isActive);
      button.setAttribute("aria-pressed", String(isActive));
    });

    panels.forEach((panel) => {
      const isActive = panel.dataset.gmlPanelContent === panelId;
      panel.classList.toggle("is-active", isActive);
      panel.hidden = !isActive;
    });
  };

  sidebarButtons.forEach((button) => {
    button.setAttribute("aria-pressed", button.classList.contains("is-active") ? "true" : "false");

    button.addEventListener("click", () => {
      activatePanel(button.dataset.gmlPanel);
    });
  });

  panels.forEach((panel) => {
    panel.hidden = !panel.classList.contains("is-active");
  });

  /* ── Scroll Animations Observer ──────────────────────────────────────── */
  const revealItems = Array.from(page.querySelectorAll(".gml-reveal"));
  const counterItems = Array.from(page.querySelectorAll("[data-gml-counter]"));
  const counted = new WeakSet();

  const animateCounter = (element) => {
    if (counted.has(element)) return;

    counted.add(element);

    const target = Number(element.dataset.gmlCounter || 0);
    const duration = 1100;
    const startTime = performance.now();

    const tick = (now) => {
      const progress = Math.min((now - startTime) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      element.textContent = Math.round(target * eased).toLocaleString("id-ID");

      if (progress < 1) {
        requestAnimationFrame(tick);
      }
    };

    requestAnimationFrame(tick);
  };

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;

        entry.target.classList.add("is-visible");

        if (entry.target.matches("[data-gml-counter]")) {
          animateCounter(entry.target);
        }

        entry.target.querySelectorAll("[data-gml-counter]").forEach(animateCounter);
      });
    },
    {
      threshold: 0.18,
      rootMargin: "0px 0px -40px 0px"
    }
  );

  revealItems.forEach((item) => observer.observe(item));
  counterItems.forEach((item) => observer.observe(item));

  /* ── Interactive Parallax Visuals (Original) ────────────────────────── */
  page.addEventListener("pointermove", (event) => {
    const hero = page.querySelector(".gml-hero__visual");

    if (!hero || window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
      return;
    }

    const rect = hero.getBoundingClientRect();
    const x = ((event.clientX - rect.left) / rect.width - 0.5) * 14;
    const y = ((event.clientY - rect.top) / rect.height - 0.5) * 14;

    hero.style.setProperty("--gml-parallax-x", `${x}px`);
    hero.style.setProperty("--gml-parallax-y", `${y}px`);

    const preview = hero.querySelector(".gml-dashboard-preview");
    if (preview && window.innerWidth > 980) {
      preview.style.transform = `perspective(1000px) rotateY(${(-5 + x / 8).toFixed(2)}deg) rotateX(${(4 - y / 8).toFixed(2)}deg)`;
    }
  });

  /* ── Button Ripples support ─────────────────────────────────────────── */
  page.querySelectorAll(".gml-btn, .gml-action-grid button, .gml-task-list button").forEach((button) => {
    button.addEventListener("click", (event) => {
      const ripple = document.createElement("span");
      const rect = button.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);

      ripple.className = "gml-ripple";
      ripple.style.width = `${size}px`;
      ripple.style.height = `${size}px`;
      ripple.style.left = `${event.clientX - rect.left - size / 2}px`;
      ripple.style.top = `${event.clientY - rect.top - size / 2}px`;

      button.appendChild(ripple);

      window.setTimeout(() => {
        ripple.remove();
      }, 520);
    });
  });

  const style = document.createElement("style");
  style.textContent = `
    .gml-ripple {
      position: absolute;
      border-radius: 999px;
      pointer-events: none;
      background: rgba(255, 255, 255, 0.42);
      transform: scale(0);
      animation: gmlRipple 520ms ease-out forwards;
    }

    @keyframes gmlRipple {
      to {
        opacity: 0;
        transform: scale(2.4);
      }
    }
  `;
  document.head.appendChild(style);
})();
