(function () {
  "use strict";

  const prefersReducedMotion = window.matchMedia(
    "(prefers-reduced-motion: reduce)",
  ).matches;
  const revealItems = document.querySelectorAll(".gml-reveal");
  const counters = document.querySelectorAll(".gml-counter");
  const navToggle = document.querySelector(".gml-nav-toggle");
  const navMenu = document.querySelector(".gml-nav-menu");
  const parallaxTarget = document.querySelector(".gml-parallax");

  function animateCounter(element) {
    const target = Number(element.dataset.gmlTarget || 0);
    const duration = 1200;
    const start = performance.now();

    function update(time) {
      const progress = Math.min((time - start) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);

      element.textContent = Math.round(target * eased).toString();

      if (progress < 1) {
        requestAnimationFrame(update);
      }
    }

    requestAnimationFrame(update);
  }

  const observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) {
          return;
        }

        entry.target.classList.add("gml-visible");

        if (
          entry.target.classList.contains("gml-counter") &&
          !entry.target.dataset.gmlAnimated
        ) {
          entry.target.dataset.gmlAnimated = "true";
          animateCounter(entry.target);
        }

        observer.unobserve(entry.target);
      });
    },
    {
      threshold: 0.18,
      rootMargin: "0px 0px -40px 0px",
    },
  );

  revealItems.forEach(function (item) {
    observer.observe(item);
  });

  counters.forEach(function (counter) {
    observer.observe(counter);
  });

  if (navToggle && navMenu) {
    navToggle.addEventListener("click", function () {
      const isOpen = navMenu.classList.toggle("gml-nav-open");
      navToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });

    navMenu.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        navMenu.classList.remove("gml-nav-open");
        navToggle.setAttribute("aria-expanded", "false");
      });
    });
  }

  document.querySelectorAll(".gml-faq-item button").forEach(function (button) {
    button.addEventListener("click", function () {
      const item = button.closest(".gml-faq-item");
      const isOpen = item.classList.toggle("gml-faq-open");
      const indicator = button.querySelector("span");

      if (indicator) {
        indicator.textContent = isOpen ? "−" : "+";
      }
    });
  });

  document.querySelectorAll(".gml-btn").forEach(function (button) {
    button.addEventListener("click", function (event) {
      const ripple = document.createElement("span");
      const rect = button.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);

      ripple.className = "gml-ripple";
      ripple.style.width = size + "px";
      ripple.style.height = size + "px";
      ripple.style.left = event.clientX - rect.left - size / 2 + "px";
      ripple.style.top = event.clientY - rect.top - size / 2 + "px";

      button.appendChild(ripple);

      window.setTimeout(function () {
        ripple.remove();
      }, 600);
    });
  });

  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener("click", function (event) {
      const targetId = anchor.getAttribute("href");

      if (!targetId || targetId === "#") {
        return;
      }

      const target = document.querySelector(targetId);

      if (!target) {
        return;
      }

      event.preventDefault();
      target.scrollIntoView({
        behavior: prefersReducedMotion ? "auto" : "smooth",
        block: "start",
      });
    });
  });

  if (parallaxTarget && !prefersReducedMotion) {
    window.addEventListener(
      "pointermove",
      function (event) {
        const x = (event.clientX / window.innerWidth - 0.5) * 18;
        const y = (event.clientY / window.innerHeight - 0.5) * 18;

        parallaxTarget.style.transform =
          "translate3d(" + x + "px, " + y + "px, 0)";
      },
      { passive: true },
    );
  }
  document.addEventListener("DOMContentLoaded", function () {
    const animation = document.querySelector(".gml-hero-animation");

    if (!animation) return;

    lottie.loadAnimation({
      container: animation,
      renderer: "svg",
      loop: true,
      autoplay: true,
      path: "/wp-content/plugins/gamifikasi-lms/assets/lottie/learning.json",
    });
  });
})();
