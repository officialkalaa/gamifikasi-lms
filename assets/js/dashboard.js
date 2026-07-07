(() => {
  const page = document.querySelector(".gml-page");

  if (!page) {
    return;
  }

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

  const revealItems = Array.from(page.querySelectorAll(".gml-reveal"));
  const counterItems = Array.from(page.querySelectorAll("[data-gml-counter]"));
  const counted = new WeakSet();

  const animateCounter = (element) => {
    if (counted.has(element)) {
      return;
    }

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
        if (!entry.isIntersecting) {
          return;
        }

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