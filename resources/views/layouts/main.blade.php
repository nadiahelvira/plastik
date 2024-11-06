<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Wolfie</title>
       
<!-- Font Awesome 5 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />

  <!-- Bootstrap -->

  <!-- Date Picker -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <!-- Data Table -->
  <link rel="stylesheet" type="text/css" href="{{url('https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css') }}"> 
  
  <!-- Data Table Button -->
  <link rel="stylesheet" href="{{url('https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css') }}">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- Local Asset -->
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<!-- Date Picker -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


  @yield('styles')
  <script>
   var tabCount = 0; // To uniquely identify each tab and iframe

function addTab(title, url) {

    tabCount++;

    // Create unique IDs for the tab and its content
    const tabId = `tab-${tabCount}`;
    const iframeId = `iframe-${tabCount}`;

    // Add the tab header with the link
    $("#tabs ul").append(`
        <li id="tab-header-${tabCount}">
            <a href="#${tabId}">${title}</a>
            <span class="ui-icon ui-icon-close" role="button" onclick="closeTab(${tabCount})"></span>
        </li>
    `);

    // Add the tab content with an iframe and set src to the specified URL
    $("#tabs").append(`<div id="${tabId}" class="tab-content"><iframe id="${iframeId}" src="${url}" width="100%" height="500px" frameborder="0"></iframe></div>`);


 

    // Refresh the tabs to recognize new tab added dynamically
    $("#tabs").tabs("refresh");

    // Activate the new tab
    $("#tabs").tabs("option", "active", tabCount - 1);
	$('.mega-menu').hide();
  }
  
  
  

function closeTab(tabIndex) {
    // Remove the tab header and content
    $(`#tab-header-${tabIndex}`).remove();
    $(`#tab-${tabIndex}`).remove();

    // Refresh the tabs to reflect the changes
    $("#tabs").tabs("refresh");

    // Activate the previous tab if any
     const activeTabs = $("#tabs ul li").length;
    if (activeTabs > 0) {
        // Activate the previous tab if any
        $("#tabs").tabs("option", "active", activeTabs - 1);
    } else {
        // If no tabs are left, reload the page
        location.reload();
    }
}
  
  </script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar ( Menu Atas ) -->
  @include('layouts.navigation')

  <!-- Sidebar ( Menu Samping ) -->
  @include('layouts.sidebar')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
		<div class="col-md-12">
  <div id="tabs">
  <ul></ul>
  </div></div></div></div></div>
  
  @yield('content3')
</div>
  
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-light">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- Local Asset -->
<script src="{{asset('js/app.js')}}"></script>

<!-- jQuery -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.bootstrap4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.25/dataRender/datetime.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@yield('javascripts')
@yield('footer-scripts')
<script>


$(document).ready(function () {
  // Initialize the jQuery UI Tabs widget
  $("#tabs").tabs();

  // tab saat pertama kali login, akan mengarah ke sini
  addTab("Home", "{{ Url('/sup') }}");
 
  // Function to add a new tab
  

});

$(document).ready(function() {
  $('.vertical-menu .nav-link').on('click', function(event) {
    event.preventDefault(); // Prevent default action, if needed
	
    var megaMenu = $(this).next('.mega-menu');
    
    // Toggle the mega menu visibility
    $('.mega-menu').not(megaMenu).hide(); // Hide other mega menus if any
    megaMenu.toggle();
  });

  // Optional: Hide the mega menu when clicking outside
  $(document).on('click', function(event) {
    if (!$(event.target).closest('.vertical-menu').length) {
      $('.mega-menu').hide();
    }
  });
});

</script>
</body>

</html>
