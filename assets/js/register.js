//*java script register*//
(function () {
  const gmlRevealItems = document.querySelectorAll(".gml-reveal");

  if ("IntersectionObserver" in window && gmlRevealItems.length) {
    const gmlRevealObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("gml-is-visible");
            gmlRevealObserver.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.16,
      },
    );

    gmlRevealItems.forEach(function (item) {
      gmlRevealObserver.observe(item);
    });
  } else {
    gmlRevealItems.forEach(function (item) {
      item.classList.add("gml-is-visible");
    });
  }

  document
    .querySelectorAll(".gml-btn, .gml-social-btn")
    .forEach(function (button) {
      button.addEventListener("click", function (event) {
        const existingRipple = button.querySelector(".gml-ripple");

        if (existingRipple) {
          existingRipple.remove();
        }

        const ripple = document.createElement("span");
        const rect = button.getBoundingClientRect();

        ripple.className = "gml-ripple";
        ripple.style.left = `${event.clientX - rect.left}px`;
        ripple.style.top = `${event.clientY - rect.top}px`;

        button.appendChild(ripple);

        window.setTimeout(function () {
          ripple.remove();
        }, 650);
      });
    });
})();
