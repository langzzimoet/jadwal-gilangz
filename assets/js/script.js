document.addEventListener("DOMContentLoaded", function () {
  // Enable tooltips
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Sidebar toggle for mobile
  document
    .querySelector(".navbar-toggler")
    .addEventListener("click", function () {
      document.querySelector(".sidebar").classList.toggle("show");
    });

  // Active menu item highlight
  var currentPage = window.location.pathname.split("/").pop();
  var menuItems = document.querySelectorAll(".sidebar .nav-link");

  menuItems.forEach(function (item) {
    var itemHref = item.getAttribute("href").split("/").pop();
    if (itemHref === currentPage) {
      item.classList.add("active");
    }
  });
});
