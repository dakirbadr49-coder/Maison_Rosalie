const button = document.querySelector(".menu-toggle");
  const menu = document.querySelector("#main-menu");

  button.addEventListener("click", () => {
    const open = button.getAttribute("aria-expanded") === "true";

    button.setAttribute("aria-expanded", !open);
    button.setAttribute("aria-label", open ? "Open menu" : "Close menu");
    menu.classList.toggle("is-open", !open);
  });