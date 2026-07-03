(function () {
  "use strict";

  const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
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

        if (entry.target.classList.contains("gml-counter") && !entry.target.dataset.gmlAnimated) {
          entry.target.dataset.gmlAnimated = "true";
          animateCounter(entry.target);
        }

        observer.unobserve(entry.target);
      });
    },
    {
      threshold: 0.18,
      rootMargin: "0px 0px -40px 0px"
    }
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
        block: "start"
      });
    });
  });

  if (parallaxTarget && !prefersReducedMotion) {
    window.addEventListener(
      "pointermove",
      function (event) {
        const x = (event.clientX / window.innerWidth - 0.5) * 18;
        const y = (event.clientY / window.innerHeight - 0.5) * 18;

        parallaxTarget.style.transform = "translate3d(" + x + "px, " + y + "px, 0)";
      },
      { passive: true }
    );
  }
})();


//*js login*//
(function () {
  "use strict";

  var gmlPage = document.querySelector(".gml-login-page");
  var gmlForm = document.querySelector(".gml-login-form");
  var gmlPasswordInput = document.querySelector("#gml-password");
  var gmlPasswordToggle = document.querySelector(".gml-password-toggle");
  var gmlParallaxTarget = document.querySelector("[data-gml-parallax]");

  function gmlSetFieldState(gmlInput, gmlState, gmlMessage) {
    var gmlField = gmlInput.closest("[data-gml-field]");
    var gmlMessageElement = gmlField ? gmlField.querySelector(".gml-field-message") : null;

    if (!gmlField) {
      return;
    }

    gmlField.classList.remove("gml-field-error", "gml-field-success");

    if (gmlState) {
      gmlField.classList.add("gml-field-" + gmlState);
    }

    if (gmlMessageElement) {
      gmlMessageElement.textContent = gmlMessage || "";
    }
  }

  function gmlValidateEmail(gmlValue) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(gmlValue);
  }

  function gmlValidateField(gmlInput) {
    var gmlValue = gmlInput.value.trim();

    if (!gmlValue) {
      gmlSetFieldState(gmlInput, "error", "This field is required.");
      return false;
    }

    if (gmlInput.type === "email" && !gmlValidateEmail(gmlValue)) {
      gmlSetFieldState(gmlInput, "error", "Enter a valid email address.");
      return false;
    }

    if (gmlInput.name === "password" && gmlValue.length < 6) {
      gmlSetFieldState(gmlInput, "error", "Password must be at least 6 characters.");
      return false;
    }

    gmlSetFieldState(gmlInput, "success", "Looks good.");
    return true;
  }

  function gmlCreateRipple(gmlButton, gmlEvent) {
    var gmlRipple = document.createElement("span");
    var gmlRect = gmlButton.getBoundingClientRect();
    var gmlSize = Math.max(gmlRect.width, gmlRect.height);
    var gmlX = gmlEvent.clientX - gmlRect.left - gmlSize / 2;
    var gmlY = gmlEvent.clientY - gmlRect.top - gmlSize / 2;

    gmlRipple.className = "gml-ripple";
    gmlRipple.style.width = gmlSize + "px";
    gmlRipple.style.height = gmlSize + "px";
    gmlRipple.style.left = gmlX + "px";
    gmlRipple.style.top = gmlY + "px";

    gmlButton.appendChild(gmlRipple);

    window.setTimeout(function () {
      gmlRipple.remove();
    }, 650);
  }

  if (gmlPasswordToggle && gmlPasswordInput) {
    gmlPasswordToggle.addEventListener("click", function () {
      var gmlIsHidden = gmlPasswordInput.type === "password";

      gmlPasswordInput.type = gmlIsHidden ? "text" : "password";
      gmlPasswordToggle.setAttribute("aria-pressed", String(gmlIsHidden));
      gmlPasswordToggle.setAttribute("aria-label", gmlIsHidden ? "Hide password" : "Show password");
      gmlPasswordInput.focus();
    });
  }

  document.querySelectorAll(".gml-input").forEach(function (gmlInput) {
    gmlInput.addEventListener("blur", function () {
      gmlValidateField(gmlInput);
    });

    gmlInput.addEventListener("input", function () {
      if (gmlInput.closest(".gml-field-error")) {
        gmlValidateField(gmlInput);
      }
    });
  });

  document.querySelectorAll(".gml-login-btn, .gml-social-btn").forEach(function (gmlButton) {
    gmlButton.addEventListener("click", function (gmlEvent) {
      gmlCreateRipple(gmlButton, gmlEvent);
    });
  });

  if (gmlForm) {
    gmlForm.addEventListener("submit", function (gmlEvent) {
      var gmlInputs = Array.prototype.slice.call(gmlForm.querySelectorAll(".gml-input"));
      var gmlIsValid = gmlInputs.every(gmlValidateField);
      var gmlLoginButton = gmlForm.querySelector(".gml-login-btn");

      gmlEvent.preventDefault();

      if (!gmlIsValid || !gmlLoginButton) {
        return;
      }

      gmlLoginButton.classList.add("gml-btn-loading");
      gmlLoginButton.disabled = true;

      window.setTimeout(function () {
        gmlLoginButton.classList.remove("gml-btn-loading");
        gmlLoginButton.disabled = false;
      }, 1300);
    });
  }

  if (gmlPage && gmlParallaxTarget && !window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    gmlPage.addEventListener("pointermove", function (gmlEvent) {
      var gmlRect = gmlPage.getBoundingClientRect();
      var gmlX = (gmlEvent.clientX - gmlRect.width / 2) / gmlRect.width;
      var gmlY = (gmlEvent.clientY - gmlRect.height / 2) / gmlRect.height;

      gmlParallaxTarget.style.transform = "translate3d(" + gmlX * 14 + "px, " + gmlY * 14 + "px, 0)";
    });

    gmlPage.addEventListener("pointerleave", function () {
      gmlParallaxTarget.style.transform = "translate3d(0, 0, 0)";
    });
  }

  if ("IntersectionObserver" in window) {
    var gmlObserver = new IntersectionObserver(function (gmlEntries) {
      gmlEntries.forEach(function (gmlEntry) {
        if (gmlEntry.isIntersecting) {
          gmlEntry.target.classList.add("gml-is-visible");
          gmlObserver.unobserve(gmlEntry.target);
        }
      });
    }, { threshold: 0.18 });

    document.querySelectorAll(".gml-login-card, .gml-illustration").forEach(function (gmlElement) {
      gmlObserver.observe(gmlElement);
    });
  }
})();