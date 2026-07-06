//*java script forgot*//
(function () {
  "use strict";

  function gmlInitForgotPasswordPage() {
    var page = document.querySelector(".gml-forgot-page");

    if (!page) {
      return;
    }

    var form = page.querySelector("[data-gml-forgot-form]");
    var formState = page.querySelector("[data-gml-forgot-form-state]");
    var successState = page.querySelector("[data-gml-forgot-success]");
    var emailInput = page.querySelector("#gml-forgot-email");
    var message = page.querySelector("[data-gml-forgot-message]");

    if ("IntersectionObserver" in window) {
      var observer = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              entry.target.classList.add("gml-is-visible");
              observer.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.18 },
      );

      page.querySelectorAll(".gml-reveal").forEach(function (element) {
        observer.observe(element);
      });
    } else {
      page.querySelectorAll(".gml-reveal").forEach(function (element) {
        element.classList.add("gml-is-visible");
      });
    }

    page.querySelectorAll("[data-gml-ripple]").forEach(function (button) {
      button.addEventListener("click", function (event) {
        var ripple = document.createElement("span");
        var rect = button.getBoundingClientRect();
        var size = Math.max(rect.width, rect.height);
        var left = event.clientX - rect.left - size / 2;
        var top = event.clientY - rect.top - size / 2;

        ripple.className = "gml-btn-ripple";
        ripple.style.width = size + "px";
        ripple.style.height = size + "px";
        ripple.style.left = left + "px";
        ripple.style.top = top + "px";

        button.appendChild(ripple);

        window.setTimeout(function () {
          ripple.remove();
        }, 600);
      });
    });

    if (!form || !formState || !successState || !emailInput) {
      return;
    }

    form.addEventListener("submit", function (event) {
      event.preventDefault();

      if (message) {
        message.textContent = "";
      }

      if (!emailInput.validity.valid) {
        if (message) {
          message.textContent = "Please enter a valid email address.";
        }

        emailInput.focus();
        return;
      }

      formState.hidden = true;
      successState.hidden = false;
      successState.setAttribute("tabindex", "-1");
      successState.focus();
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", gmlInitForgotPasswordPage);
  } else {
    gmlInitForgotPasswordPage();
  }
})();
