const checkboxes = document.querySelectorAll(
  '.shipped-from-filter input[type="checkbox"]'
);

checkboxes.forEach((checkbox) => {
  checkbox.addEventListener("change", function () {
    checkboxes.forEach((cb) => {
      if (cb !== this) {
        cb.checked = false;
      }
    });
  });
});

document.querySelectorAll(".category h5").forEach((item) => {
  item.addEventListener("click", (event) => {
    document.querySelectorAll(".category h5").forEach((item) => {
      item.classList.remove("active-category");
    });
    event.target.classList.add("active-category");
  });
});
