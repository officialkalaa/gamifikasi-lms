(function () {
  "use strict";

  /* ── Notification Dropdown ───────────────────────────────────────────── */

  var notifBtn = document.getElementById("gml-notif-btn");
  var notifDropdown = document.getElementById("gml-notif-dropdown");
  var markAllBtn = document.getElementById("gml-notif-mark-all");

  if (notifBtn && notifDropdown) {
    notifBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      toggleNotifDropdown(notifDropdown.hidden);
    });

    document.addEventListener("click", function (e) {
      if (!notifDropdown.hidden && !notifDropdown.contains(e.target)) {
        toggleNotifDropdown(false);
      }
    });

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && !notifDropdown.hidden) {
        toggleNotifDropdown(false);
        notifBtn.focus();
      }
    });
  }

  function toggleNotifDropdown(open) {
    if (!notifDropdown || !notifBtn) return;
    notifDropdown.hidden = !open;
    notifBtn.setAttribute("aria-expanded", String(open));
  }

  if (markAllBtn) {
    markAllBtn.addEventListener("click", function () {
      document
        .querySelectorAll(".gml-notif__item--unread")
        .forEach(function (item) {
          item.classList.remove("gml-notif__item--unread");
        });
      var badge = document.querySelector(".gml-notif__badge");
      if (badge) badge.remove();
    });
  }

  /* ── Daily Mission Toggle ────────────────────────────────────────────── */

  var missionList = document.getElementById("gml-mission-list");

  if (missionList) {
    missionList.addEventListener("click", function (e) {
      var checkBtn = e.target.closest(".gml-mission__check");
      if (!checkBtn) return;

      var item = checkBtn.closest(".gml-mission__item");
      if (!item) return;

      var isDone = item.classList.toggle("gml-mission__item--done");
      var xpEl = item.querySelector(".gml-mission__xp");
      var labelEl = item.querySelector(".gml-mission__label");

      checkBtn.innerHTML = isDone
        ? '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>'
        : '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>';

      checkBtn.setAttribute(
        "aria-label",
        (isDone ? "Tandai belum selesai: " : "Tandai selesai: ") +
          (labelEl ? labelEl.textContent.trim() : ""),
      );

      if (xpEl) {
        xpEl.classList.toggle("gml-mission__xp--done", isDone);
      }

      updateMissionSummary();
    });
  }

  function updateMissionSummary() {
    var allItems = document.querySelectorAll(".gml-mission__item");
    var doneItems = document.querySelectorAll(".gml-mission__item--done");

    var total = allItems.length;
    var done = doneItems.length;
    var pct = total > 0 ? Math.round((done / total) * 100) : 0;

    var earnedXp = 0;

    doneItems.forEach(function (item) {
      earnedXp += parseInt(item.dataset.xp, 10) || 0;
    });

    var summaryEl = document.getElementById("gml-mission-summary");

    if (summaryEl) {
      summaryEl.innerHTML =
        done + "/" + total + " selesai · <strong>+" + earnedXp + " XP</strong>";
    }

    var barEl = document.getElementById("gml-mission-bar");

    if (barEl) {
      barEl.style.width = pct + "%";

      var wrapper = barEl.closest(".gml-progress-bar");

      if (wrapper) {
        wrapper.setAttribute("aria-valuenow", pct);
      }
    }
  }

  /* ── Sidebar Active ───────────────────────────────────────────── */

  var currentPath = window.location.pathname;

  document.querySelectorAll(".gml-sidebar__nav-link").forEach(function (link) {
    var href = link.getAttribute("href");

    link.classList.remove("gml-sidebar__nav-link--active");
    link.removeAttribute("aria-current");

    var dot = link.querySelector(".gml-sidebar__nav-dot");

    if (dot) {
      dot.remove();
    }

    if (href && href === currentPath) {
      link.classList.add("gml-sidebar__nav-link--active");
      link.setAttribute("aria-current", "page");

      var indicator = document.createElement("span");
      indicator.className = "gml-sidebar__nav-dot";
      indicator.setAttribute("aria-hidden", "true");

      link.appendChild(indicator);
    }
  });

  /* ── Keyboard Support Task ───────────────────────────────────── */

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
