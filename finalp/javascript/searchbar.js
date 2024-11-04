const items = [
  { name: "Casio Scientific Calculator", link: "/items/calcu/calcu.html" },
  { name: "ID Lace", link: "/items/idlace/idlace.html" },
  { name: "B5 Binder Notebook", link: "/items/binder/binder.html" },
  { name: "PE Uniform Set", link: "/items_uniforms/peunif/peunif.html" },
  { name: "College Blouse", link: "/items_uniforms/blouse/blouse.html"},
  { name: "University Collar Pin", link: "/items_uniforms/collarpin/collarpin.html"},
  { name: "CICS Department Shirt", link: "/items_deptshirt/cics/cics.html" },
  { name: "CAS Department Shirt", link: "/items_deptshirt/cas/cas.html" },
  { name: "CABE Department Shirt", link: "/items_deptshirt/cabe/cabe.html" },
];

function matchItems(input) {
  input = input.toUpperCase();
  return items.filter((item) => item.name.toUpperCase().includes(input));
}

function updateResults() {
  const input = document.getElementById("product-search").value;
  const dropdownResults = document.getElementById("dropdown-results");

  dropdownResults.innerHTML = ""; // Clear previous results

  if (input) {
    const matchedProducts = matchItems(input);

    if (matchedProducts.length > 0) {
      matchedProducts.forEach((item) => {
        const li = document.createElement("li");
        const a = document.createElement("a");

        a.href = item.link; 
        a.textContent = item.name;
        a.style.textDecoration = "none"; 
        a.style.color = "black"; // text color

        li.appendChild(a);
        dropdownResults.appendChild(li);
      });

      dropdownResults.style.display = "block"; // Show dropdown if there are matches
    } else {
      dropdownResults.style.display = "none"; // Hide dropdown if no matches
    }
  } else {
    dropdownResults.style.display = "none"; // Hide dropdown if input is empty
  }
}

document.addEventListener("click", function (event) {
  const dropdownResults = document.getElementById("dropdown-results");
  const searchInput = document.getElementById("product-search");

  if (!dropdownResults.contains(event.target) && event.target !== searchInput) {
    dropdownResults.style.display = "none";
  }
});

document
  .getElementById("product-search")
  .addEventListener("input", updateResults);
