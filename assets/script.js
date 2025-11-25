// assets/script.js
// Simple jQuery-based AJAX loader for links with class="ajax-link"
$(document).ready(function () {

  // Click handler for any ajax-link
  $(document).on("click", ".ajax-link", function (e) {
    e.preventDefault();
    var page = $(this).data("page");
    if (!page) return;
    // Load the page into #main-content using ajax_page.php as a safe loader
    $("#main-content").load("ajax_page.php?page=" + encodeURIComponent(page), function(response, status, xhr){
      if (status === "error") {
        $("#main-content").html("<div class='card'><div class='card-body'><h5>Error loading page</h5><pre>" + xhr.status + " " + xhr.statusText + "</pre></div></div>");
      }
    });
    // Update browser URL (optional) without reload
    try {
      var newUrl = "?page=" + encodeURIComponent(page);
      history.pushState({page: page}, "", newUrl);
    } catch(e) { /* ignore history errors */ }
  });

  // Handle browser Back/Forward to reload content
  window.addEventListener('popstate', function(e){
    var params = new URLSearchParams(window.location.search);
    var page = params.get('page') || 'dashboard_content.php';
    $("#main-content").load("ajax_page.php?page=" + encodeURIComponent(page));
  });

});
