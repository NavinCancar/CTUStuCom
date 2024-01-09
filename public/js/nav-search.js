//Thích ứng cho navbar và thanh search
document.addEventListener("DOMContentLoaded", function () {
    // Get the search form and the search toggler
    var searchForm = document.querySelector('.nav-search');
    var searchToggler = document.querySelector('.search-toggler');

    // Add a click event listener to the search toggler
    searchToggler.addEventListener('click', function () {
      // Toggle the visibility of the search form
      searchForm.style.display = (searchForm.style.display === 'none' || searchForm.style.display === '') ? 'flex' : 'none';
    });

    // Add a resize event listener to hide the search form on smaller screens
    window.addEventListener('resize', function () {
      if (window.innerWidth <= 767) {
        searchForm.style.display = 'none';
      } else {
        searchForm.style.display = 'flex';
      }
    });
  });