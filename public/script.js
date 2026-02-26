document.addEventListener("DOMContentLoaded", () => {
  // 1. UI Components Initialization
  burgerMenu();
  selectMenu();

  // 2. Dropdown Dependencies Logic
  syncDropdowns("regionDropdown", "locationDropdown");
  syncDropdowns("categoryDropdown", "typeDropdown");
  handleDependentWithVisibility("locationDropdown", "neighborhoodDropdown");

  // 3. Map Initialization (Point to your ADM1 simplified file)
  initUnifiedMap(
    "map-container",
    "map/geoBoundaries-BGR-ADM1_simplified.geojson",
    "map/geoBoundaries-BGR-ADM2_simplified.geojson",
  );

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
      { passive: false },
    );
  }
});

/**
 * UNIFIED MAP FUNCTION
 * Handles both Regions (ADM1) and Municipalities (ADM2) highlighting
 */
function initUnifiedMap(containerId, adm1Path, adm2Path) {
  const mapElement = document.getElementById(containerId);
  if (!mapElement) return;

  // 1. Initialize Map ONCE
  const map = L.map(containerId).setView([42.7339, 25.4858], 7);
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "© OpenStreetMap contributors",
  }).addTo(map);

  let adm1Layer, adm2Layer;

  const styles = {
    adm1: { fillColor: "#154073", weight: 1, color: "white", fillOpacity: 0.2 },
    adm2: { fillColor: "#154073", weight: 1, color: "white", fillOpacity: 0.1 },
    highlight: {
      fillColor: "#ff4757",
      weight: 3,
      color: "#ffffff",
      fillOpacity: 0.7,
    },
  };

  // 2. Load Both Data Sets using Promise.all
  Promise.all([
    fetch(adm1Path).then((res) => res.json()),
    fetch(adm2Path).then((res) => res.json()),
  ])
    .then(([adm1Data, adm2Data]) => {
      // Add both layers to the map
      adm1Layer = L.geoJson(adm1Data, { style: styles.adm1 }).addTo(map);
      adm2Layer = L.geoJson(adm2Data, { style: styles.adm2 }).addTo(map);

      setTimeout(() => map.invalidateSize(), 300);
    })
    .catch((err) => console.error("Map Loading Error:", err));

  // 3. Helper function to apply style and zoom
  const applyHighlight = (layerGroup, englishName, isADM2 = false) => {
    if (!layerGroup) return;
    let targetLayer = null;

    layerGroup.eachLayer((layer) => {
      const props = layer.feature.properties;
      // Match against common GeoJSON property keys
      const match =
        props.shapeName === englishName ||
        props.NAME_1 === englishName ||
        props.NAME_2 === englishName;

      if (match) {
        layer.setStyle(styles.highlight);
        layer.bringToFront();
        targetLayer = layer;
      } else {
        layer.setStyle(isADM2 ? styles.adm2 : styles.adm1);
      }
    });

    if (targetLayer) {
      map.fitBounds(targetLayer.getBounds(), {
        padding: [50, 50],
        animate: true,
      });
    }
  };

  // 4. Single Event Listener
  document.addEventListener("selectionChanged", (e) => {
    const selectedValue = e.detail.value;
    const btn = e.target.querySelector(".dropdown_toggle");
    const englishName = btn?.getAttribute("data-selected-name");

    // Reset view if "Any" is selected
    if (selectedValue === "any") {
      adm1Layer?.eachLayer((l) => l.setStyle(styles.adm1));
      adm2Layer?.eachLayer((l) => l.setStyle(styles.adm2));
      map.setView([42.7339, 25.4858], 7);
      return;
    }

    if (e.target.id === "regionDropdown") {
      // Highlight Region (ADM1)
      applyHighlight(adm1Layer, englishName, false);
      // Optional: Dim ADM2 layers to make Region selection clearer
      adm2Layer?.eachLayer((l) => l.setStyle({ fillOpacity: 0, weight: 0 }));
    } else if (e.target.id === "locationDropdown") {
      // Highlight Municipality (ADM2)
      // Reset ADM1 to default so we see the municipality inside it
      adm1Layer?.eachLayer((l) => l.setStyle(styles.adm1));
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
        const nameEn = option.getAttribute("data-name"); // Get English Name

        label.innerText = option.innerText;

        // Save the English name to the button so the map can find it
        btn.setAttribute("data-selected-name", nameEn || "");

        closeAllMenus();

        btn.style.borderColor = val !== "any" ? "var(--tu_blue_primary)" : "";

        // Dispatch selection event
        wrapper.dispatchEvent(
          new CustomEvent("selectionChanged", {
            detail: { value: val },
            bubbles: true,
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
    m.classList.remove("show");
    setTimeout(() => {
      if (!m.classList.contains("show")) m.style.display = "none";
    }, 200);
  });
  document
    .querySelectorAll(".filter_pill")
    .forEach((b) => b.classList.remove("active"));
}

function getMenuFromWrapper(wrapperId) {
  const wrapper = document.getElementById(wrapperId);
  return (
    wrapper?.querySelector(".dropdown_content") ||
    document.querySelector(`.dropdown_content[data-parent-id="${wrapperId}"]`)
  );
}

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
    childLabel.innerText = childOptions[0].innerText;
    childBtn.style.borderColor = "";

    childOptions.forEach((opt) => {
      const dep = opt.getAttribute("data-region");
      opt.style.display =
        selectedValue === "any" ||
        dep === selectedValue ||
        opt.getAttribute("data-value") === "any"
          ? "block"
          : "none";
    });
  });
}

function handleDependentWithVisibility(parentId, childId) {
  const childWrapper = document.getElementById(childId);
  const parentWrapper = document.getElementById(parentId);
  if (!childWrapper || !parentWrapper) return;

  syncDropdowns(parentId, childId);
  const checkVisibility = (val) => {
    childWrapper.style.display = val === "any" ? "none" : "inline-block";
  };
  parentWrapper.addEventListener("selectionChanged", (e) =>
    checkVisibility(e.detail.value),
  );
  checkVisibility("any");
}
