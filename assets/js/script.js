console.log("Gamifikasi LMS Loaded");
/* =========================================================
   LEARNIO — Landing Page Interactions
   Catatan: Semua state di sini HANYA simulasi tampilan (dummy).
   Tidak ada pemanggilan API/Backend/Firebase di file ini.
   ========================================================= */

document.addEventListener("DOMContentLoaded", () => {
  /* ---------- Hero: animasi angka poin & progress saat pertama muncul ---------- */
  const pointCounterEl = document.getElementById("lrn-point-counter");
  const heroFillEl = document.getElementById("lrn-progress-fill");
  const heroPctEl = document.getElementById("lrn-progress-pct");

  const animateCountUp = (el, target, duration = 900) => {
    if (!el) return;
    const start = 0;
    const startTime = performance.now();
    const format = (n) => Math.round(n).toLocaleString("id-ID");

    const step = (now) => {
      const progress = Math.min((now - startTime) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
      el.textContent = format(start + (target - start) * eased);
      if (progress < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  };

  const heroObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCountUp(pointCounterEl, 12560);
          if (heroFillEl) heroFillEl.style.width = "72%";
          if (heroPctEl) heroPctEl.textContent = "72%";
          heroObserver.disconnect();
        }
      });
    },
    { threshold: 0.4 },
  );

  const heroPanel = document.querySelector(".lrn-panel");
  if (heroPanel) heroObserver.observe(heroPanel);

  /* ---------- Demo widget: simulasi poin, XP, level, dan badge ---------- */
  const demoBtn = document.getElementById("demo-btn");
  const demoPointsEl = document.getElementById("demo-points");
  const demoXpEl = document.getElementById("demo-xp");
  const demoXpMaxEl = document.getElementById("demo-xp-max");
  const demoLevelEl = document.getElementById("demo-level");
  const demoFillEl = document.getElementById("demo-progress-fill");
  const demoFeedbackEl = document.getElementById("demo-feedback");
  const demoBadges = document.querySelectorAll(".lrn-demo-badge");

  const demoState = {
    points: 320,
    xp: 40,
    xpMax: 100,
    level: 3,
    clicks: 0,
  };

  const feedbackMessages = [
    "Mantap! Poin bertambah 🎉",
    "Terus lanjutkan, kamu on fire 🔥",
    "Konsisten itu kunci! 💪",
    "Selangkah lagi menuju badge baru ✨",
  ];

  function unlockBadge(key) {
    const badgeEl = document.querySelector(
      `.lrn-demo-badge[data-badge="${key}"]`,
    );
    if (badgeEl && badgeEl.classList.contains("lrn-demo-badge--locked")) {
      badgeEl.classList.remove("lrn-demo-badge--locked");
      badgeEl.classList.add("lrn-demo-badge--unlocked");
      return true;
    }
    return false;
  }

  function updateDemoUI() {
    if (demoPointsEl)
      demoPointsEl.textContent = demoState.points.toLocaleString("id-ID");
    if (demoXpEl) demoXpEl.textContent = demoState.xp;
    if (demoXpMaxEl) demoXpMaxEl.textContent = demoState.xpMax;
    if (demoLevelEl) demoLevelEl.textContent = demoState.level;
    if (demoFillEl)
      demoFillEl.style.width = `${(demoState.xp / demoState.xpMax) * 100}%`;
  }

  if (demoBtn) {
    demoBtn.addEventListener("click", () => {
      demoState.clicks += 1;
      demoState.points += 20;
      demoState.xp += 20;

      let message =
        feedbackMessages[(demoState.clicks - 1) % feedbackMessages.length];

      // Naik level jika XP penuh
      if (demoState.xp >= demoState.xpMax) {
        demoState.xp = demoState.xp - demoState.xpMax;
        demoState.level += 1;
        message = `Level Up! Sekarang Level ${demoState.level} 🚀`;
      }

      // Unlock badge berdasarkan progres (simulasi milestone)
      if (demoState.clicks === 1) {
        // badge "Pemula" sudah terbuka dari awal
      } else if (demoState.clicks === 3) {
        if (unlockBadge("streak")) message = 'Badge "Konsisten" terbuka! 🥈';
      } else if (demoState.clicks === 5) {
        if (unlockBadge("master")) message = 'Badge "Master" terbuka! 🥇';
      }

      updateDemoUI();

      if (demoFeedbackEl) {
        demoFeedbackEl.textContent = message;
      }

      // Micro-interaction: tombol "denyut" sebentar
      demoBtn.style.transform = "scale(0.97)";
      setTimeout(() => {
        demoBtn.style.transform = "";
      }, 120);

      if (demoState.clicks >= 5) {
        demoBtn.disabled = true;
        demoBtn.textContent = "Semua Tantangan Demo Selesai 🎉";
        demoBtn.style.opacity = "0.7";
        demoBtn.style.cursor = "default";
      }
    });
  }

  /* ---------- Smooth scroll offset untuk navbar sticky (opsional, sudah dibantu CSS scroll-behavior) ---------- */
  document.querySelectorAll('a[href^="#"]').forEach((link) => {
    link.addEventListener("click", (e) => {
      const targetId = link.getAttribute("href");
      if (targetId.length > 1) {
        const targetEl = document.querySelector(targetId);
        if (targetEl) {
          e.preventDefault();
          targetEl.scrollIntoView({ behavior: "smooth", block: "start" });
        }
      }
    });
  });
});
