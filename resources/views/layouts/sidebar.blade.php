<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3"> Admin </div>
  </a>
  
  <!-- Divider -->
  <hr class="sidebar-divider my-0">
  
  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('state') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>State</span></a>
  </li>
   <li class="nav-item">
    <a class="nav-link" href="{{ route('district') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>District</span></a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" href="{{ route('voters') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Voters</span></a>
  </li>

    <li class="nav-item">
    <a class="nav-link" href="{{ route('report') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Report</span></a>
  </li>

    <li class="nav-item">
    <a class="nav-link" href="{{ route('activity') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Activity</span></a>
  </li>

  
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">
  
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
  
  
</ul>