document.addEventListener("DOMContentLoaded", () => {
  // 1. UI Components Initialization
  burgerMenu();
  selectMenu();

  // 2. Dropdown Dependencies Logic
  // Region -> City
  syncDropdowns("regionDropdown", "locationDropdown");
  // Category -> Type
  syncDropdowns("categoryDropdown", "typeDropdown");
  // City -> Neighborhood (with Visibility toggle)
  handleDependentWithVisibility("locationDropdown", "neighborhoodDropdown");

  // 3. Map Initialization (Unified for both ADM1 and ADM2)
  initUnifiedMap(
    "map-container",
    "map/geoBoundaries-BGR-ADM1_simplified.geojson",
    "map/geoBoundaries-BGR-ADM2_simplified.geojson"
  );

  initPaginationUI();

  // 4. Horizontal Scroll for Filter Bar
  const filterBar = document.querySelector(".filter_bar");
  if (filterBar) {
    filterBar.addEventListener(
      "wheel",
      (e) => {
        if (e.deltaY !== 0) {
          e.preventDefault();
          filterBar.scrollLeft += e.deltaY;
          closeAllMenus();
        }
      },
      { passive: false }
    );
  }
});

/**
 * UNIFIED MAP FUNCTION
 * Manages one map instance and handles highlighting for both levels
 */
function initUnifiedMap(containerId, adm1Path, adm2Path) {
  const mapElement = document.getElementById(containerId);
  if (!mapElement) return;

  // Център на България
  const BULGARIA_CENTER = [42.7339, 25.4858];
  const DEFAULT_ZOOM = 7;

  // Инициализация на картата
  const map = L.map(containerId).setView(BULGARIA_CENTER, DEFAULT_ZOOM);
  
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "© OpenStreetMap contributors",
  }).addTo(map);

  let adm1Layer, adm2Layer;

  // Дефиниция на стиловете
  const styles = {
    adm1: { fillColor: "#154073", weight: 1, color: "white", fillOpacity: 0.2 },
    adm2: { fillColor: "#154073", weight: 1, color: "white", fillOpacity: 0.1 },
    highlight: {
      fillColor: "#ff4757",
      weight: 3,
      color: "#ffffff",
      fillOpacity: 0.7,
    },
    hidden: { fillOpacity: 0, weight: 0 }
  };

  // Зареждане на данните
  Promise.all([
    fetch(adm1Path).then((res) => res.json()),
    fetch(adm2Path).then((res) => res.json()),
  ])
    .then(([adm1Data, adm2Data]) => {
      adm1Layer = L.geoJson(adm1Data, { style: styles.adm1 }).addTo(map);
      adm2Layer = L.geoJson(adm2Data, { style: styles.adm2 }).addTo(map);
      
      // Поправка за правилно оразмеряване в контейнери
      setTimeout(() => map.invalidateSize(), 300);
    })
    .catch((err) => console.error("Грешка при зареждане на картата:", err));

  /**
   * Търси и оцветява обект в даден слой
   */
  const applyHighlight = (layerGroup, englishName, isADM2 = false) => {
    if (!layerGroup || !englishName) return;
    
    let targetLayer = null;
    const searchName = englishName.toString().toLowerCase().trim();

    layerGroup.eachLayer((layer) => {
      const props = layer.feature.properties;
      // Проверяваме всички възможни полета за име в GeoJSON
      const layerName = (props.shapeName || props.NAME_1 || props.NAME_2 || "").toString().toLowerCase().trim();

      if (layerName === searchName) {
        layer.setStyle(styles.highlight);
        layer.bringToFront();
        targetLayer = layer;
      } else {
        // Връщаме базовия стил за останалите в същия слой
        layer.setStyle(isADM2 ? styles.adm2 : styles.adm1);
      }
    });

    // Ако сме намерили обекта, фокусираме картата върху него
    if (targetLayer) {
      map.flyToBounds(targetLayer.getBounds(), { 
        padding: [50, 50], 
        duration: 1.5 
      });
    }
  };

  /**
   * Слушател за събития от дропдауните
   */
  document.addEventListener("selectionChanged", (e) => {
    const selectedValue = e.detail.value;
    const btn = e.target.querySelector(".dropdown_toggle");
    const englishName = btn?.getAttribute("data-selected-name");

    // 1. Случай: Избрано е "Всички" или няма име
    if (selectedValue === "any" || !englishName) {
      adm1Layer?.eachLayer(l => l.setStyle(styles.adm1));
      adm2Layer?.eachLayer(l => l.setStyle(styles.adm2));
      map.flyTo(BULGARIA_CENTER, DEFAULT_ZOOM);
      return;
    }

    // 2. Случай: Избор на Област (Region)
    if (e.target.id === "regionDropdown") {
      // Скриваме градовете (ADM2), за да се вижда ясно областта
      adm2Layer?.eachLayer(l => l.setStyle(styles.hidden));
      applyHighlight(adm1Layer, englishName, false);
    } 
    
    // 3. Случай: Избор на Град/Локация (Location)
    else if (e.target.id === "locationDropdown") {
      // Връщаме областите като бекграунд (опционално)
      adm1Layer?.eachLayer(l => l.setStyle(styles.adm1));
      applyHighlight(adm2Layer, englishName, true);
    }
  });
}

/**
 * UI AND DROPDOWN LOGIC
 */
function burgerMenu() {
  const menuToggle = document.getElementById("menuToggle");
  const navContainer = document.querySelector(".nav_container");
  if (!menuToggle) return;

  menuToggle.addEventListener("click", () => {
    navContainer.classList.toggle("active");
    menuToggle.classList.toggle("open");
  });
}

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
        menu.style.display = "block";
        menu.setAttribute("data-parent-id", wrapper.id);
        document.body.appendChild(menu);

        menu.style.position = "fixed";
        menu.style.top = `${rect.bottom + 8}px`;
        menu.style.left = `${Math.max(10, rect.left)}px`;
        menu.style.minWidth = `${rect.width}px`;
        menu.style.zIndex = "10000";

        requestAnimationFrame(() => {
          menu.classList.add("show");
          btn.classList.add("active");
        });
      }
    });

    options.forEach((option) => {
      option.addEventListener("click", (e) => {
        e.stopPropagation();
        const val = option.getAttribute("data-value");
        const nameEn = option.getAttribute("data-name");

        label.innerText = option.innerText;
        btn.setAttribute("data-selected-name", nameEn || "");

        closeAllMenus();

        btn.style.borderColor = val !== "any" ? "var(--tu_blue_primary)" : "";

        wrapper.dispatchEvent(
          new CustomEvent("selectionChanged", {
            detail: { value: val },
            bubbles: true,
          })
        );
      });
    });
  });

  window.addEventListener("click", closeAllMenus);
  window.addEventListener("scroll", closeAllMenus, { passive: true });
}

function closeAllMenus() {
  document.querySelectorAll(".dropdown_content").forEach((m) => {
    m.classList.remove("show");
    setTimeout(() => {
      if (!m.classList.contains("show")) m.style.display = "none";
    }, 200);
  });
  document.querySelectorAll(".dropdown_toggle").forEach((b) => b.classList.remove("active"));
}

function getMenuFromWrapper(wrapperId) {
  return document.querySelector(`.dropdown_content[data-parent-id="${wrapperId}"]`);
}

function syncDropdowns(parentId, childId) {
  const parentWrapper = document.getElementById(parentId);
  const childWrapper = document.getElementById(childId);
  if (!parentWrapper || !childWrapper) return;

  parentWrapper.addEventListener("selectionChanged", (e) => {
    const selectedValue = e.detail.value;
    
    // ТЪРСИМ МЕНЮТО И В BODY (ако е отворено), И ВЪТРЕ В WRAPPER-A (ако не е отваряно)
    let childMenu = getMenuFromWrapper(childId) || childWrapper.querySelector(".dropdown_content");
    
    const childLabel = childWrapper.querySelector(".filter_label");
    const childBtn = childWrapper.querySelector(".dropdown_toggle");

    if (!childMenu) return;
    const childOptions = childMenu.querySelectorAll(".dropdown_option");

    // Reset child state
    childLabel.innerText = childOptions[0].innerText;
    childBtn.style.borderColor = "";
    childBtn.setAttribute("data-selected-name", "");

    childWrapper.dispatchEvent(
      new CustomEvent("selectionChanged", {
        detail: { value: "any" },
        bubbles: true,
      })
    );

    childOptions.forEach((opt) => {
      const dep = opt.getAttribute("data-region");
      const isAny = opt.getAttribute("data-value") === "any";
      
      if (selectedValue === "any" || dep === selectedValue || isAny) {
        opt.style.display = "block";
      } else {
        opt.style.display = "none";
      }
    });
  });
}

function handleDependentWithVisibility(parentId, childId) {
  const childWrapper = document.getElementById(childId);
  const parentWrapper = document.getElementById(parentId);
  if (!childWrapper || !parentWrapper) return;

  syncDropdowns(parentId, childId);

  const checkVisibility = (val) => {
    // If "any" or no value is selected in parent, hide the child
    childWrapper.style.display = (val === "any" || !val) ? "none" : "inline-block";
  };

  parentWrapper.addEventListener("selectionChanged", (e) => {
    checkVisibility(e.detail.value);
  });

  // Run once on load
  checkVisibility("any");
}

// Добави това извикване в твоя съществуващ DOMContentLoaded event
document.addEventListener("DOMContentLoaded", () => {
  // ... другите ти функции (burgerMenu, selectMenu и т.н.)
  initThemeToggle();
});

// --- ФУНКЦИЯ ЗА СМЯНА НА ТЕМАТА ---
function initThemeToggle() {
  const toggleBtn = document.getElementById("theme-toggle");
  if (!toggleBtn) return;

  // 1. Проверяваме дали има запазена тема в LocalStorage ИЛИ дали компютърът на потребителя е в тъмен режим
  const currentTheme = localStorage.getItem("theme");
  const systemPrefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;

  if (currentTheme === "dark" || (!currentTheme && systemPrefersDark)) {
    document.body.classList.add("dark-mode");
    toggleBtn.innerHTML = "☀️"; // Слагаме слънце, защото сме в тъмен режим
  } else {
    toggleBtn.innerHTML = "🌙"; // Слагаме луна, защото сме в светъл режим
  }

  // 2. Добавяме събитие при клик
  toggleBtn.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");
    
    // Проверяваме кой режим е активен в момента
    if (document.body.classList.contains("dark-mode")) {
      localStorage.setItem("theme", "dark");
      toggleBtn.innerHTML = "☀️";
    } else {
      localStorage.setItem("theme", "light");
      toggleBtn.innerHTML = "🌙";
    }
  });
}

function initPaginationUI() {
    const pageLinks = document.querySelectorAll(".page_link");
    
    pageLinks.forEach(link => {
        link.addEventListener("click", () => {
            // Добави анимация за зареждане или скрол догоре
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
}