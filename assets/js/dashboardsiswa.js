(function () {
  "use strict";

  // Safeguard: Check if Firebase is available
  if (typeof firebase === "undefined" || typeof auth === "undefined" || typeof db === "undefined") {
    console.error("Firebase SDK is not loaded. Gamifikasi LMS will run in offline demo mode.");
    return;
  }

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
          if (userData.role === "teacher") {
            // Teacher shouldn't access Student Dashboard
            window.location.href = "/dashboard";
          } else {
            // Initialize student dashboard with actual Firebase data
            initializeStudentDashboard(user, userData);
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

  /* ── Student Dashboard Initializer ────────────────────────────────────── */
  function initializeStudentDashboard(user, userData) {
    // 1. Setup User Profile & Header Info
    updateUserProfileDOM(userData);

    // 2. Setup Real-time Notifications Listener
    setupNotificationsListener(user.uid);

    // 3. Setup Continue Learning Chapter
    setupContinueLearning(user.uid);

    // 4. Setup Daily Missions Interaction
    setupDailyMissions(user.uid, userData);

    // 5. Setup Live Mini Leaderboard
    setupMiniLeaderboard(user.uid);

    // 6. Setup Academic Stats Card
    setupAcademicStats(user.uid, userData);
  }

  /* ── DOM Update Helpers ────────────────────────────────────────────────── */
  function getInitials(name) {
    if (!name) return "NA";
    var parts = name.trim().split(/\s+/);
    if (parts.length === 1) return parts[0].substring(0, 2).toUpperCase();
    return (parts[0].charAt(0) + parts[1].charAt(0)).toUpperCase();
  }

  function updateUserProfileDOM(data) {
    var fullname = data.fullname || "Nur Azizah";
    var initials = getInitials(fullname);
    var xp = parseInt(data.xp, 10) || 0;
    var level = parseInt(data.level, 10) || 1;
    var streak = parseInt(data.streak, 10) || 0;

    // Header updates
    var avatarEl = document.querySelector(".gml-user__avatar");
    var userNameEl = document.querySelector(".gml-user__name");
    var userMetaEl = document.querySelector(".gml-user__meta");

    if (avatarEl) avatarEl.textContent = initials;
    if (userNameEl) userNameEl.textContent = fullname;
    if (userMetaEl) {
      userMetaEl.textContent = "Level " + level + " · " + xp.toLocaleString("id-ID") + " XP";
    }

    // Hero updates
    var welcomeNameEl = document.querySelector(".gml-welcome__name");
    if (welcomeNameEl) welcomeNameEl.textContent = fullname;

    // Level-up Card updates (Achievement)
    var levelEl = document.querySelector(".gml-achievement__level");
    var xpRowLabelLeft = document.querySelector(".gml-achievement__xp-row span:first-child");
    var xpRowLabelRight = document.querySelector(".gml-achievement__xp-row span:last-child");
    var achievementBarFill = document.querySelector(".gml-achievement__xp-row + .gml-progress-bar .gml-progress-bar__fill");

    var xpInCurrentLevel = xp % 1000;
    var xpForNextLevel = (level + 1) * 1000;
    var xpPct = Math.round((xpInCurrentLevel / 1000) * 100);

    if (levelEl) levelEl.textContent = "Lv. " + level;
    if (xpRowLabelLeft) xpRowLabelLeft.textContent = xp.toLocaleString("id-ID") + " XP";
    if (xpRowLabelRight) {
      xpRowLabelRight.textContent = "Level " + (level + 1) + " → " + xpForNextLevel.toLocaleString("id-ID") + " XP";
    }
    if (achievementBarFill) {
      achievementBarFill.style.width = xpPct + "%";
      var parentBar = achievementBarFill.closest(".gml-progress-bar");
      if (parentBar) parentBar.setAttribute("aria-valuenow", xpPct);
    }

    // Target Mingguan Card updates (Weekly Goal - 500 XP target)
    var weeklyXp = xp % 500;
    var weeklyPct = Math.min(100, Math.round((weeklyXp / 500) * 100));
    var weeklyPctLabel = document.querySelector(".gml-welcome__progress-labels span:last-child");
    var weeklyBarFill = document.querySelector(".gml-welcome__progress .gml-progress-bar__fill");
    var weeklySubText = document.querySelector(".gml-welcome__progress-sub");

    if (weeklyPctLabel) weeklyPctLabel.textContent = weeklyPct + "%";
    if (weeklyBarFill) {
      weeklyBarFill.style.width = weeklyPct + "%";
      var parentWeeklyBar = weeklyBarFill.closest(".gml-progress-bar");
      if (parentWeeklyBar) parentWeeklyBar.setAttribute("aria-valuenow", weeklyPct);
    }
    if (weeklySubText) {
      weeklySubText.textContent = weeklyXp + " / 500 XP minggu ini";
    }
  }

  /* ── Real-time Notifications ─────────────────────────────────────────── */
  function setupNotificationsListener(uid) {
    var notifBadge = document.querySelector(".gml-notif__badge");
    var notifList = document.getElementById("gml-notif-list");

    db.collection("notifications")
      .where("uid", "==", uid)
      .orderBy("createdAt", "desc")
      .limit(6)
      .onSnapshot(function (snapshot) {
        if (snapshot.empty) {
          if (notifBadge) notifBadge.style.display = "none";
          if (notifList) {
            notifList.innerHTML = '<li class="gml-notif__item"><p class="gml-notif__text">Tidak ada notifikasi baru.</p></li>';
          }
          return;
        }

        var unreadCount = 0;
        var html = "";

        snapshot.forEach(function (doc) {
          var data = doc.data();
          if (!data.isRead) unreadCount++;

          var dateStr = "Beberapa saat lalu";
          if (data.createdAt) {
            var date = data.createdAt.toDate();
            var diffMs = new Date() - date;
            var diffMins = Math.floor(diffMs / 60000);
            if (diffMins < 1) dateStr = "Baru saja";
            else if (diffMins < 60) dateStr = diffMins + " mnt lalu";
            else {
              var diffHours = Math.floor(diffMins / 60);
              if (diffHours < 24) dateStr = diffHours + " jam lalu";
              else dateStr = date.toLocaleDateString("id-ID", { day: "numeric", month: "short" });
            }
          }

          html += '<li class="gml-notif__item ' + (data.isRead ? "" : "gml-notif__item--unread") + '" data-id="' + doc.id + '">';
          html += '  <p class="gml-notif__text">' + escapeHTML(data.title || data.message) + '</p>';
          html += '  <p class="gml-notif__time">' + dateStr + '</p>';
          html += '</li>';
        });

        if (notifList) notifList.innerHTML = html;

        // Update badge visibility
        var badge = document.querySelector(".gml-notif__badge");
        if (unreadCount > 0) {
          if (!badge) {
            badge = document.createElement("span");
            badge.className = "gml-notif__badge";
            var btn = document.getElementById("gml-notif-btn");
            if (btn) btn.appendChild(badge);
          }
          badge.style.display = "block";
          badge.setAttribute("aria-label", unreadCount + " notifikasi belum dibaca");
        } else {
          if (badge) badge.style.display = "none";
        }
      }, function (err) {
        console.warn("Notifications real-time sync failed. Using default placeholders.", err);
      });

    // Mark all as read click interaction
    var markAllBtn = document.getElementById("gml-notif-mark-all");
    if (markAllBtn) {
      markAllBtn.addEventListener("click", function () {
        db.collection("notifications")
          .where("uid", "==", uid)
          .where("isRead", "==", false)
          .get()
          .then(function (snapshot) {
            var batch = db.batch();
            snapshot.forEach(function (doc) {
              batch.update(db.collection("notifications").doc(doc.id), { isRead: true });
            });
            return batch.commit();
          })
          .catch(function (error) {
            console.error("Error marking notifications as read:", error);
          });
      });
    }
  }

  /* ── Continue Learning Chapter ──────────────────────────────────────── */
  function setupContinueLearning(uid) {
    db.collection("progress")
      .where("uid", "==", uid)
      .orderBy("updatedAt", "desc")
      .limit(1)
      .get()
      .then(function (snapshot) {
        if (snapshot.empty) return;

        var progressDoc = snapshot.docs[0];
        var progressData = progressDoc.data();

        // Get course title
        db.collection("courses")
          .doc(progressData.courseId)
          .get()
          .then(function (courseDoc) {
            if (!courseDoc.exists) return;
            var courseData = courseDoc.data();

            var courseEl = document.querySelector(".gml-continue__course");
            var chapterEl = document.querySelector(".gml-continue__chapter");
            var barFill = document.querySelector(".gml-continue__bar .gml-progress-bar__fill");
            var completedLabel = document.querySelector(".gml-continue__meta span:first-child");
            var ctaBtn = document.querySelector(".gml-continue__cta");

            var progressPct = parseInt(progressData.progress, 10) || 0;

            if (courseEl) courseEl.textContent = courseData.title;
            if (chapterEl) chapterEl.textContent = progressData.lastMaterial || "Modul Berjalan";
            if (barFill) barFill.style.width = progressPct + "%";
            if (completedLabel) completedLabel.textContent = progressPct + "% selesai";
            if (ctaBtn) {
              ctaBtn.setAttribute("href", "/kursus/" + progressData.courseId);
            }
          });
      })
      .catch(function (err) {
        console.warn("Could not fetch user's last learning course progress:", err);
      });
  }

  /* ── Daily Missions Real-time Sync & XP Transaction ─────────────────── */
  var defaultMissions = [
    { id: 1, label: "Login hari ini", xp: 10, done: true },
    { id: 2, label: "Selesaikan 1 materi", xp: 30, done: false },
    { id: 3, label: "Kerjakan 1 kuis", xp: 50, done: false },
    { id: 4, label: "Dapatkan nilai minimal 80", xp: 70, done: false }
  ];

  function setupDailyMissions(uid, userData) {
    var missionList = document.getElementById("gml-mission-list");
    if (!missionList) return;

    var missions = userData.missions;

    // If user document does not contain missions array, write default ones to Firestore
    if (!missions || missions.length === 0) {
      missions = defaultMissions;
      db.collection("users").doc(uid).update({ missions: defaultMissions })
        .catch(function (err) {
          console.error("Error setting default missions:", err);
        });
    }

    renderMissions(missions);

    // Event listener for mission completion toggle
    missionList.addEventListener("click", function (e) {
      var checkBtn = e.target.closest(".gml-mission__check");
      if (!checkBtn) return;

      var item = checkBtn.closest(".gml-mission__item");
      if (!item) return;

      var missionId = parseInt(item.dataset.id, 10);
      var isAlreadyDone = item.classList.contains("gml-mission__item--done");
      var newDoneState = !isAlreadyDone;

      // Safe Firestore Transaction to prevent XP accumulation race-conditions
      db.collection("users").doc(uid).runTransaction(function (transaction) {
        return transaction.get(db.collection("users").doc(uid)).then(function (sfDoc) {
          if (!sfDoc.exists) return;

          var data = sfDoc.data();
          var currentMissions = data.missions || defaultMissions;
          var targetMission = currentMissions.find(function (m) { return m.id === missionId; });

          if (targetMission && targetMission.done !== newDoneState) {
            targetMission.done = newDoneState;
            var xpDiff = newDoneState ? targetMission.xp : -targetMission.xp;
            var currentXp = parseInt(data.xp, 10) || 0;
            var nextXp = Math.max(0, currentXp + xpDiff);
            var nextLevel = Math.max(1, Math.floor(nextXp / 1000) + 1);

            transaction.update(db.collection("users").doc(uid), {
              missions: currentMissions,
              xp: nextXp,
              level: nextLevel,
              updatedAt: firebase.firestore.FieldValue.serverTimestamp()
            });

            // Return target changes for local DOM update
            return {
              updatedData: {
                xp: nextXp,
                level: nextLevel,
                missions: currentMissions
              }
            };
          }
        });
      })
      .then(function (result) {
        if (result && result.updatedData) {
          // Immediately update DOM dynamically
          updateUserProfileDOM(result.updatedData);
          renderMissions(result.updatedData.missions);
        }
      })
      .catch(function (err) {
        console.error("Missions sync transaction failed:", err);
      });
    });
  }

  function renderMissions(missionsList) {
    var missionList = document.getElementById("gml-mission-list");
    var summaryEl = document.getElementById("gml-mission-summary");
    var barEl = document.getElementById("gml-mission-bar");

    if (!missionList) return;

    var html = "";
    var doneCount = 0;
    var totalCount = missionsList.length;
    var earnedXp = 0;

    missionsList.forEach(function (m) {
      if (m.done) {
        doneCount++;
        earnedXp += m.xp;
      }

      html += '<li class="gml-mission__item ' + (m.done ? "gml-mission__item--done" : "") + '" data-id="' + m.id + '" data-xp="' + m.xp + '">';
      html += '  <button class="gml-mission__check" aria-label="' + (m.done ? "Tandai belum selesai" : "Tandai selesai") + ': ' + escapeHTML(m.label) + '">';
      if (m.done) {
        html += '    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';
      } else {
        html += '    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/></svg>';
      }
      html += '  </button>';
      html += '  <span class="gml-mission__label">' + escapeHTML(m.label) + '</span>';
      html += '  <span class="gml-mission__xp ' + (m.done ? "gml-mission__xp--done" : "") + '">+' + m.xp + ' XP</span>';
      html += '</li>';
    });

    missionList.innerHTML = html;

    // Update statistics summary label
    if (summaryEl) {
      summaryEl.innerHTML = doneCount + "/" + totalCount + " selesai · <strong>+" + earnedXp + " XP</strong>";
    }

    // Update Progress bar width
    var pct = totalCount > 0 ? Math.round((doneCount / totalCount) * 100) : 0;
    if (barEl) {
      barEl.style.width = pct + "%";
      var wrapper = barEl.closest(".gml-progress-bar");
      if (wrapper) wrapper.setAttribute("aria-valuenow", pct);
    }
  }

  /* ── Live Leaderboard ─────────────────────────────────────────────────── */
  var trendIcons = {
    up: '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="gml-trend-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>',
    down: '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="gml-trend-down"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>',
    same: '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="gml-trend-same"><line x1="5" y1="12" x2="19" y2="12"/></svg>'
  };

  function setupMiniLeaderboard(currentUid) {
    var lbList = document.querySelector(".gml-lb__list");
    if (!lbList) return;

    db.collection("users")
      .orderBy("xp", "desc")
      .limit(5)
      .get()
      .then(function (snapshot) {
        if (snapshot.empty) return;

        var html = "";
        var rank = 1;

        snapshot.forEach(function (doc) {
          var data = doc.data();
          var isMe = doc.id === currentUid;
          var trend = data.trend || "same"; // Fallback to same if undefined
          var initials = getInitials(data.fullname);

          html += '<li class="gml-lb__row ' + (isMe ? "gml-lb__row--me" : "") + '">';
          html += '  <span class="gml-lb__rank gml-lb__rank--' + rank + '" aria-label="Peringkat ' + rank + '">' + rank + '</span>';
          html += '  <div class="gml-lb__avatar ' + (isMe ? "gml-lb__avatar--me" : "") + '" aria-hidden="true">' + initials + '</div>';
          html += '  <span class="gml-lb__name ' + (isMe ? "gml-lb__name--me" : "") + '">' + escapeHTML(isMe ? "Kamu" : data.fullname) + '</span>';
          html += '  <div class="gml-lb__xp-group">';
          html += '    ' + (trendIcons[trend] || trendIcons.same);
          html += '    <span class="gml-lb__xp">' + (data.xp || 0).toLocaleString("id-ID") + '</span>';
          html += '  </div>';
          html += '</li>';

          rank++;
        });

        lbList.innerHTML = html;
      })
      .catch(function (err) {
        console.warn("Leaderboard live sync failed. Fallback to mock rankings.", err);
      });
  }

  /* ── Academic Statistics Card ────────────────────────────────────────── */
  function setupAcademicStats(uid, userData) {
    var totalXpEl = document.querySelector(".gml-stat__value"); // Match Total XP
    if (totalXpEl) {
      // Find parent which label is Total XP
      var totalXpCard = totalXpEl.closest(".gml-stat");
      if (totalXpCard && totalXpCard.querySelector(".gml-stat__label").textContent === "Total XP") {
        totalXpEl.textContent = (userData.xp || 0).toLocaleString("id-ID");
      }
    }

    // Query finished quizzes dynamically to compute exact score and quiz completions
    db.collection("quiz_results")
      .where("uid", "==", uid)
      .get()
      .then(function (snapshot) {
        var totalScore = 0;
        var quizCount = snapshot.size;

        snapshot.forEach(function (doc) {
          totalScore += doc.data().score || 0;
        });

        var avgScore = quizCount > 0 ? Math.round((totalScore / quizCount) * 10) / 10 : 0;

        // Render values in DOM
        document.querySelectorAll(".gml-stat").forEach(function (card) {
          var label = card.querySelector(".gml-stat__label");
          var val = card.querySelector(".gml-stat__value");

          if (label && val) {
            var labelText = label.textContent.trim();
            if (labelText === "Quiz Selesai") {
              val.textContent = quizCount;
            } else if (labelText === "Nilai Rata-rata") {
              val.textContent = avgScore.toLocaleString("id-ID");
            }
          }
        });
      })
      .catch(function (err) {
        console.warn("Error loading quiz statistics:", err);
      });
  }

  /* ── Interactive Notification Dropdown Toggle ───────────────────────── */
  var notifBtn = document.getElementById("gml-notif-btn");
  var notifDropdown = document.getElementById("gml-notif-dropdown");

  if (notifBtn && notifDropdown) {
    notifBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      var isHidden = notifDropdown.hidden;
      notifDropdown.hidden = !isHidden;
      notifBtn.setAttribute("aria-expanded", String(isHidden));
    });

    document.addEventListener("click", function (e) {
      if (!notifDropdown.hidden && !notifDropdown.contains(e.target)) {
        notifDropdown.hidden = true;
        notifBtn.setAttribute("aria-expanded", "false");
      }
    });

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && !notifDropdown.hidden) {
        notifDropdown.hidden = true;
        notifBtn.setAttribute("aria-expanded", "false");
        notifBtn.focus();
      }
    });
  }

  /* ── Escape HTML utility for Security ──────────────────────────────── */
  function escapeHTML(str) {
    if (!str) return "";
    return str
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  /* ── Sidebar Path Highlight ─────────────────────────────────────────── */
  var currentPath = window.location.pathname;
  document.querySelectorAll(".gml-sidebar__nav-link").forEach(function (link) {
    var href = link.getAttribute("href");
    link.classList.remove("gml-sidebar__nav-link--active");
    link.removeAttribute("aria-current");

    var dot = link.querySelector(".gml-sidebar__nav-dot");
    if (dot) dot.remove();

    if (href && href === currentPath) {
      link.classList.add("gml-sidebar__nav-link--active");
      link.setAttribute("aria-current", "page");

      var indicator = document.createElement("span");
      indicator.className = "gml-sidebar__nav-dot";
      indicator.setAttribute("aria-hidden", "true");
      link.appendChild(indicator);
    }
  });

  /* ── Keyboard Support ────────────────────────────────────────────────── */
  document.querySelectorAll(".gml-task").forEach(function (task) {
    task.setAttribute("role", "button");
    task.setAttribute("tabindex", "0");
    task.addEventListener("keydown", function (e) {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        task.click();
      }
    });
  });

})();
