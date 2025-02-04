<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('Accueil')}}" class="brand-link">
      <img src="/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/assets/dist/img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{route('Accueil')}}" class="d-block">{{Auth::user()->name ?? ''}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item  {{ request()->routeIs('Accueil*') ? 'menu-open' : '' }}">
            <a href="{{route('Accueil')}}" class="nav-link {{ request()->routeIs('Accueil*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                TABLEAU BORD
              </p>
            </a>
          </li>
          
          <li class="nav-item {{ request()->routeIs('Vehicules*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('Vehicules*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                VEHICULES
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('Liste-Vehicules')}}" class="nav-link {{ request()->routeIs('Liste-Vehicules*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vehicule</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('Vehicules.index')}}" class="nav-link {{ request()->routeIs('Vehicules*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Liste Vehicule</p>
                </a>
              </li>
             
            </ul>
          </li>
          <li class="nav-item {{ request()->routeIs('Conducteurs*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('Conducteurs*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                CONDUCTEURS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('Conducteurs.index')}}" class="nav-link {{ request()->routeIs('Conducteurs*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Conducteur</p>
                </a>
              </li>
             
            </ul>
          </li>
          <li class="nav-item {{ request()->routeIs('Reparations*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('Reparations*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                REPARATIONS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('Reparations.index')}}" class="nav-link {{ request()->routeIs('Reparations*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reparation</p>
                </a>
              </li>
             
            </ul>
          </li>
          <li class="nav-item {{ request()->routeIs('Versements*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('Versements*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                VERSEMENTS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{route('Versements.index')}}" class="nav-link {{ request()->routeIs('Versements*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Versements</p>
                </a>
              </li>
             
            </ul>
          </li>
          <li class="nav-item {{ request()->routeIs('Users*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('Users*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                UTILISATEURS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{route('Users.index')}}" class="nav-link {{ request()->routeIs('Users*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>USERS</p>
                </a>
              </li>
             
            </ul>
          </li>
          <li class="nav-item {{ request()->routeIs('Ressources*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('Ressources*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RESSOURCES
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('Ressources.index')}}" class="nav-link {{ request()->routeIs('Ressources*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>RUBRIQUE</p>
                </a>
              </li>
             
            </ul>
          </li>
          <li class="nav-item {{ request()->routeIs('rapports*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('rapports*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT VEHICULE
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('rapports')}}" class="nav-link {{ request()->routeIs('rapports*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>RAPPORT</p>
                </a>
              </li>
             
            </ul>
          </li>
        
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>