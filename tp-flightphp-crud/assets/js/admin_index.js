document.querySelectorAll(".dropdown-btn").forEach(function (btn) {
  btn.addEventListener("click", function () {
    // Ferme les autres menus ouverts
    document.querySelectorAll(".dropdown-content").forEach(function (el) {
      if (el !== btn.nextElementSibling) el.style.display = "none";
    });

    const content = btn.nextElementSibling;
    if (content) {
      content.style.display = content.style.display === "block" ? "none" : "block";
    }
  });
});
