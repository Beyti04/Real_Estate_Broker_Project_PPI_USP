document.addEventListener("DOMContentLoaded", () => {
  // 1. UI Components Initialization
  burgerMenu();
  selectMenu();

  // 2. Dropdown Dependencies Logic
  syncDropdowns("regionDropdown", "locationDropdown");
  syncDropdowns("categoryDropdown", "typeDropdown");
  handleDependentWithVisibility("locationDropdown", "neighborhoodDropdown");

  // 3. Map Initialization (Point to your ADM1 simplified file)
  initMapHighlighting(
    "map-container",
    "map/geoBoundaries-BGR-ADM1_simplified.geojson"
  );

  // 4. Horizontal Scroll for Filter Bar
  const filterBar = document.querySelector(".filter_bar");
  if (filterBar) {
    filterBar.addEventListener("wheel", (e) => {
        if (e.deltaY !== 0) {
          e.preventDefault();
          filterBar.scrollLeft += e.deltaY;
          closeAllMenus();
        }
      }, { passive: false }
    );
  }
});

/**
 * CORE MAP FUNCTION
 * Handles map rendering and region highlighting
 */
function initMapHighlighting(containerId, geoJsonPath) {
  const mapElement = document.getElementById(containerId);
  if (!mapElement) return;

  // Initialize Map
  const map = L.map(containerId).setView([42.7339, 25.4858], 7);
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "© OpenStreetMap contributors",
  }).addTo(map);

  let geoJsonLayer;

  const styles = {
    default: {
      fillColor: "#154073",
      weight: 1,
      color: "white",
      fillOpacity: 0.2,
    },
    highlight: {
      fillColor: "#ff4757",
      weight: 3,
      color: "#ffffff",
      fillOpacity: 0.7,
    },
  };

  // Load GeoJSON Data
  fetch(geoJsonPath)
    .then((res) => res.json())
    .then((data) => {
      geoJsonLayer = L.geoJson(data, { style: styles.default }).addTo(map);
      // Fix for flexbox rendering issues
      setTimeout(() => map.invalidateSize(), 300);
    })
    .catch((err) => console.error("Map Data Error:", err));

  const highlightRegion = (englishName) => {
    if (!geoJsonLayer || !englishName) return;

    geoJsonLayer.eachLayer((layer) => {
      const props = layer.feature.properties;
      // Match against the English name from the GeoJSON properties
      if (props.shapeName === englishName) {
        layer.setStyle(styles.highlight);
        map.fitBounds(layer.getBounds(), { padding: [40, 40], animate: true });
      } else {
        layer.setStyle(styles.default);
      }
    });
  };

  // Listen for Selection Changes on the document level
  document.addEventListener("selectionChanged", (e) => {
    if (e.target.id === "regionDropdown") {
      const selectedValue = e.detail.value;

      if (selectedValue === "any") {
        geoJsonLayer.eachLayer((l) => l.setStyle(styles.default));
        map.setView([42.7339, 25.4858], 7);
        return;
      }

      // Read English Name from the button (transferred during click)
      const btn = e.target.querySelector(".dropdown_toggle");
      const englishName = btn.getAttribute("data-selected-name");

      if (englishName) {
        highlightRegion(englishName);
      }
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
  document.querySelectorAll(".filter_pill").forEach((b) => b.classList.remove("active"));
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
    checkVisibility(e.detail.value)
  );
  checkVisibility("any");
}