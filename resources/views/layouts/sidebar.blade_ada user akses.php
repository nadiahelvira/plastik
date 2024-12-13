<!-- Main Sidebar Container -->

<style>
    /* General sidebar styling */
    .vertical-menu {
      width: 50px;
      height: 100vh;
      background-color: #343a40;
      position: relative;
    }
	
	.content-box {
	  flex-grow: 1; /* This makes the child content fill the height */
	  background-color: lightgray; /* Just for demonstration */
	  padding: 20px;
	}

    /* Main menu items */
    .vertical-menu a {
      color: white;
      padding: 10px;
      text-decoration: none;
      display: block;
    }

    /*.vertical-menu a:hover {
      background-color: #495057;
      color: white;
    }*/

    /* Mega menu container */
    .mega-menu {
      position: absolute;
      /* top: 800; */
      /* top: 50; */
      left: 100px;
      width: 850px;
     
      background-color: white;
      display: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 5px;
      z-index: 9999 !important;
    }

    #a {
      top:10;
    }

    #b {
      top:40;
    }

    #c {
      top:50;
    }

    #d {
      top:200;
    }

    #e {
      top:160;
    }

    #f {
      top:180;
    }

    #g {
      top:300;
    }

    #h {
      top:310;
    }

    #i {
      top:320;
    }

    #j {
      top:400;
    }

    #k {
      top:120;
    }

    /* Display mega menu on hover */
    .vertical-menu a:hover + .mega-menu,
    .mega-menu:hover {
      /* display: block; */
    }

    /* Sub-menu styling */
    .mega-menu .row {
      padding: 5px;
    }

    .mega-menu h5 {
      color: #343a40;
    }

    .mega-menu ul {
      list-style: none;
      padding: 0;
    }

    .mega-menu ul li a {
      text-decoration: none;
      color: #343a40;
      padding: 5px 0;
      display: block;
    }

    .mega-menu ul li a:hover {
      color: #007bff;
    }

    .menu-card {
	
      text-align: center;
      padding: 5px;	 
      border-radius: 5px;
      box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease;
    }

    .menu-card:hover {
      background-color: #f8f9fa;
    }

    .menu-card h6 {
      margin-top: 12px;
	  color:black;
	  
    }

    .menu-card i {
      font-size: 30px;
      margin-bottom: 10px;
    }

    .font-size {
      font-size: large; /* or you can use a specific size like 16px, 1.5em, etc. */
    }

  </style>

  <!-- pengaturan lebar sidebar, block hitam, space kesamping, bayangan putih (all in)-->

  <style>

    /* untuk block hitam */
    .main-sidebar, .main-sidebar::before {
      width: 100px !important;
    }

    .main-sidebar, .main-sidebar:hover {
      width: 100px !important;
    }

    /* bayangan putih yg ada panahnya di atur disini */
    .sidebar-mini .main-sidebar .nav-link, .sidebar-mini-md .main-sidebar .nav-link, .sidebar-mini-xs .main-sidebar .nav-link {
      width: calc(100px - 0.5rem * 2);
      transition: width ease-in-out 0.3s;
    }

    /* batas */

    /* untuk space ke samping setelahnya */
    @media (min-width: 768px) {
      body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper, body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer, body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header {
        transition: margin-left 0.3s ease-in-out;
        margin-left: 100px;
      }
    }

    /* batas */

    /* icon bergerak */

    @keyframes wiggle {
        0%, 100% {
            transform: rotate(0deg);
        }
        25% {
            transform: rotate(-20deg);
        }
        50% {
            transform: rotate(20deg);
        }
        75% {
            transform: rotate(-20deg);
        }
    }
    .nav-item a:hover .nav-icon {
        animation: wiggle 0.6s ease-in-out infinite;
    }

    /* batas */

  </style>

  <!-- tutupannya -->
  
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="overflow-y: visible;">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link" style="text-align: center">
        <img src="{{ url('/img/company.jpg') }}" alt="LookmanDjaja Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">UD. ASRI RAYA</span>
    </a>

    <!-- Sidebar -->
    <div class="vertical-menu">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{-- <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="test">
        </div> --}}
            <div class="info">
                <!-- <a href="#" class="d-block">{{ Auth::user()->name }}</a> -->
                <a href="#" class="d-block"></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <!-- tammbahan untuk dashboard -->
                    <a href="#" onclick="javascript:addTab('Dashboard', '{{ url('dashboard') }}')" class="nav-link">
                    <!-- batas dashboard (jangan lupa web dan controller)-->
                    
                    <i class="nav-icon fas fa-home"></i>
                        <p></p>
                    </a>
                </li>
                @php
                    $all = DB::table('user_akses')->get();
                    $generalMenu = DB::table('user_akses')
                        ->where('devisi', Auth::user()->divisi)
                        ->groupBy('general_menu')
                        ->select('general_menu')
                        ->get();
                    // dd($generalMenu);
                @endphp
                @foreach ($generalMenu as $item)
                    <li class="nav-header" ></li>

                    @php

                        $groupMenu = DB::table('user_akses')
                            ->where('devisi', Auth::user()->divisi)
                            ->where('general_menu', $item->general_menu)
                            ->groupBy('group_menu','group_icon_menu')
                            ->select('group_menu','group_icon_menu')
                            ->get();

                    @endphp
                    @foreach ($groupMenu as $group)
                        @php
                            $detailMenu = DB::table('user_akses')
                                ->where('devisi', Auth::user()->divisi)
                                ->where('general_menu', $item->general_menu)
                                ->where('group_menu', $group->group_menu)
                                ->get();
                            // dd($groupMenu);
                        @endphp
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="{{ $group->group_icon_menu ?? '' }}" data-bs-toggle="tooltip" title="{{ $group->group_menu }}"></i>
                                <p>
                                </p>
                            </a>
                            <div class="mega-menu" id="a">
                                <div class="row d-flex">
                                    @foreach ($detailMenu as $detail)
                                        <div class="col-md-3">
                                            <div class="menu-card" style="">
                                                <a
                                                    href="javascript:addTab('{{ $detail->nama_menu }}', '{{ url($detail->url) }}')">
                                                    <!-- <i class="nav-icon far fa-user fa-10x icon-purple"></i> -->
                                                    <i style="margin-left:-5px;font-size: 40px;"
                                                        class="{{ $detail->icon_menu }}"></i>
                                                    <h6>{{ $detail->nama_menu }}</h6>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endforeach



            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
