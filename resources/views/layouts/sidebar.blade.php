<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
      <div class="sidebar-brand-text mx-3">ÓRGANON</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
      <a class="nav-link" href="{{ route('home')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
      {{ __('client.clients') }}
    </div>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('clients.index') }}">
        <i class="fas fa-user-friends"></i>
        <span>{{ __('client.clients') }}</span></a>
    </li>

    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('project.projects') }}
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('projects.index') }}">
        <i class="fas fa-project-diagram"></i>
        <span>{{ __('project.projects') }}</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('tasks.my-tasks') }}">
        <i class="fas fa-tasks"></i>
        <span>{{ __('task.my_tasks') }}</span>
      </a>
    </li>

</ul>
  <!-- End of Sidebar -->