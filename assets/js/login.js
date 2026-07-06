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
    var gmlMessageElement = gmlField
      ? gmlField.querySelector(".gml-field-message")
      : null;

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
      gmlSetFieldState(
        gmlInput,
        "error",
        "Password must be at least 6 characters.",
      );
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
      gmlPasswordToggle.setAttribute(
        "aria-label",
        gmlIsHidden ? "Hide password" : "Show password",
      );
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

  document
    .querySelectorAll(".gml-login-btn, .gml-social-btn")
    .forEach(function (gmlButton) {
      gmlButton.addEventListener("click", function (gmlEvent) {
        gmlCreateRipple(gmlButton, gmlEvent);
      });
    });

  if (gmlForm) {
    gmlForm.addEventListener("submit", function (gmlEvent) {
      var gmlInputs = Array.prototype.slice.call(
        gmlForm.querySelectorAll(".gml-input"),
      );
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

  if (
    gmlPage &&
    gmlParallaxTarget &&
    !window.matchMedia("(prefers-reduced-motion: reduce)").matches
  ) {
    gmlPage.addEventListener("pointermove", function (gmlEvent) {
      var gmlRect = gmlPage.getBoundingClientRect();
      var gmlX = (gmlEvent.clientX - gmlRect.width / 2) / gmlRect.width;
      var gmlY = (gmlEvent.clientY - gmlRect.height / 2) / gmlRect.height;

      gmlParallaxTarget.style.transform =
        "translate3d(" + gmlX * 14 + "px, " + gmlY * 14 + "px, 0)";
    });

    gmlPage.addEventListener("pointerleave", function () {
      gmlParallaxTarget.style.transform = "translate3d(0, 0, 0)";
    });
  }

  if ("IntersectionObserver" in window) {
    var gmlObserver = new IntersectionObserver(
      function (gmlEntries) {
        gmlEntries.forEach(function (gmlEntry) {
          if (gmlEntry.isIntersecting) {
            gmlEntry.target.classList.add("gml-is-visible");
            gmlObserver.unobserve(gmlEntry.target);
          }
        });
      },
      { threshold: 0.18 },
    );

    document
      .querySelectorAll(".gml-login-card, .gml-illustration")
      .forEach(function (gmlElement) {
        gmlObserver.observe(gmlElement);
      });
  }
})();
