function burgerMenu() {
  const menuToggle = document.getElementById("menuToggle");
  const navContainer = document.querySelector(".nav_container");

  menuToggle.addEventListener("click", () => {
    navContainer.classList.toggle("active");

    menuToggle.classList.toggle("open");
  });

  const navLinks = document.querySelectorAll(".nav_link");
  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      navContainer.classList.remove("active");
      menuToggle.classList.remove("open");
    });
  });
}

function getMenuFromWrapper(wrapperId) {
  const wrapper = document.getElementById(wrapperId);
  let menu = wrapper?.querySelector(".dropdown_content");
  if (!menu) {
    menu = document.querySelector(
      `.dropdown_content[data-parent-id="${wrapperId}"]`,
    );
  }
  return menu;
}

/**
 * Основна функция за dropdown функционалност и мобилно позициониране
 */
function selectMenu() {
  const dropdowns = document.querySelectorAll(".dropdown_wrapper");

  dropdowns.forEach((wrapper) => {
    const btn = wrapper.querySelector(".dropdown_toggle");
    const menu = wrapper.querySelector(".dropdown_content");
    const label = wrapper.querySelector(".filter_label");
    const options = wrapper.querySelectorAll(".dropdown_option");

    btn.addEventListener("click", (e) => {
      e.stopPropagation();
      const isOpen = menu.classList.contains("show");
      closeAllMenus();

      if (!isOpen) {
        const rect = btn.getBoundingClientRect();

        // Подготовка за местене (премахване на глича)
        menu.style.visibility = "hidden";
        menu.style.display = "block";
        menu.setAttribute("data-parent-id", wrapper.id);
        document.body.appendChild(menu);

        // Позициониране спрямо екрана (fixed)
        const menuWidth = 220;
        let leftPos = rect.left;
        if (leftPos + menuWidth > window.innerWidth) {
          leftPos = window.innerWidth - 230;
        }

        menu.style.position = "fixed";
        menu.style.top = `${rect.bottom + 8}px`;
        menu.style.left = `${Math.max(10, leftPos)}px`;
        menu.style.minWidth = `${rect.width}px`;
        menu.style.zIndex = "10000";

        requestAnimationFrame(() => {
          menu.style.visibility = "visible";
          menu.classList.add("show");
          btn.classList.add("active");
        });
      }
    });

    options.forEach((option) => {
      option.addEventListener("click", (e) => {
        e.stopPropagation();
        label.innerText = option.innerText;
        closeAllMenus();

        // Стилизиране на активен филтър
        btn.style.borderColor =
          option.getAttribute("data-value") !== "any"
            ? "var(--tu_blue_primary)"
            : "";

        // Ръчно задействаме "click" събитие върху wrapper-а за зависимостите
        wrapper.dispatchEvent(
          new CustomEvent("selectionChanged", {
            detail: { value: option.getAttribute("data-value") },
          }),
        );
      });
    });
  });

  window.addEventListener("click", closeAllMenus);
  window.addEventListener("scroll", closeAllMenus, { passive: true });
}

function closeAllMenus() {
  document.querySelectorAll(".dropdown_content").forEach((m) => {
    if (m.classList.contains("show")) {
      m.classList.remove("show");
      setTimeout(() => {
        if (!m.classList.contains("show")) {
          m.style.display = "none";
          m.style.visibility = "hidden";
        }
      }, 200);
    }
  });
  document
    .querySelectorAll(".filter_pill")
    .forEach((b) => b.classList.remove("active"));
}

/**
 * Синхронизация на два дропдауна (Филтриране на опциите)
 */
function syncDropdowns(parentId, childId) {
  const parentWrapper = document.getElementById(parentId);
  const childWrapper = document.getElementById(childId);

  if (!parentWrapper || !childWrapper) return;

  parentWrapper.addEventListener("selectionChanged", (e) => {
    const selectedValue = e.detail.value;
    const childMenu = getMenuFromWrapper(childId);
    const childLabel = childWrapper.querySelector(".filter_label");
    const childBtn = childWrapper.querySelector(".dropdown_toggle");

    if (!childMenu) return;

    const childOptions = childMenu.querySelectorAll(".dropdown_option");

    // Ресет на детето
    childLabel.innerText = childOptions[0].innerText;
    childBtn.style.borderColor = "";

    // Филтриране
    childOptions.forEach((opt) => {
      const dep = opt.getAttribute("data-region");
      opt.style.display =
        selectedValue === "any" ||
        dep === selectedValue ||
        opt.getAttribute("data-value") === "any"
          ? "block"
          : "none";
    });

    // ВЕРИЖНА РЕАКЦИЯ: Сигнализираме на следващото ниво, че сме се ресетирали
    childWrapper.dispatchEvent(
      new CustomEvent("selectionChanged", {
        detail: { value: "any" },
      }),
    );
  });
}

/**
 * Логика за зависимост + Скриване/Показване на целия бутон
 */
function handleDependentWithVisibility(parentId, childId) {
  const childWrapper = document.getElementById(childId);
  if (!childWrapper) return;

  // Първо пускаме филтрирането
  syncDropdowns(parentId, childId);

  const checkVisibility = (val) => {
    childWrapper.style.display = val === "any" ? "none" : "inline-block";
  };

  document
    .getElementById(parentId)
    .addEventListener("selectionChanged", (e) => {
      checkVisibility(e.detail.value);
    });

  checkVisibility("any");
}

document.addEventListener("DOMContentLoaded", () => {
  burgerMenu();
  selectMenu();
  syncDropdowns("regionDropdown", "locationDropdown");
  handleDependentWithVisibility("locationDropdown", "neighborhoodDropdown");
});
