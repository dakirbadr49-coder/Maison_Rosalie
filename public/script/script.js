const button = document.querySelector(".menu-toggle");
  const menu = document.querySelector("#main-menu");

  button.addEventListener("click", () => {
    const open = button.getAttribute("aria-expanded") === "true";

    button.setAttribute("aria-expanded", !open);
    button.setAttribute("aria-label", open ? "Open menu" : "Close menu");
    menu.classList.toggle("is-open", !open);
  });

// Panneau connexion
const loginOpen = document.querySelector(".login-open");
const loginPanel = document.querySelector("#login-panel");
const loginWrap = document.querySelector(".login-wrap");

function toggleLogin(open) {
  loginPanel.classList.toggle("is-open", open);
  loginOpen.setAttribute("aria-expanded", open);
}

loginOpen.addEventListener("click", () => {
  toggleLogin(!loginPanel.classList.contains("is-open"));
});

// Clic en dehors
document.addEventListener("click", (e) => {
  if (!loginWrap.contains(e.target)) toggleLogin(false);
});

// Touche Échap
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") toggleLogin(false);
});

// Vers inscription
const registerOpen = document.querySelector(".register-open");
const registerPanel = document.querySelector("#register-panel");

registerOpen.addEventListener("click", () => {
  toggleLogin(false);
  registerPanel.classList.add("is-open");
  registerOpen.setAttribute("aria-expanded", true);
});
