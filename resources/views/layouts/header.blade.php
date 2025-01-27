<header class="header bg-body">
    <nav class="navbar flex-nowrap p-0">
        <div class="navbar-brand-wrapper d-flex justify-content-center align-items-center col-auto">
            <!-- Logo For Mobile View -->
            <a class="navbar-brand navbar-brand-mobile" href="/">
                <img class="img-fluid w-100" src="{{ asset('img/system_logo.jpg') }}" alt="Graindashboard">
            </a>
            <!-- End Logo For Mobile View -->

            <!-- Logo For Desktop View -->
            <a class="navbar-brand navbar-brand-desktop" href="/">
                <img class="side-nav-show-on-closed" src="{{ asset('img/system_logo.jpg') }}" alt="Graindashboard" style="width: auto; height: 65px;">
                <img class="side-nav-hide-on-closed" src="{{ asset('img/system_logo.jpg') }}" alt="Graindashboard" style="width: auto; height: 65px;">
            </a>
            <!-- End Logo For Desktop View -->
        </div>


        <div class="header-content col px-md-3">
            <div class="d-flex align-items-center">
                <!-- Side Nav Toggle -->
                <a class="js-side-nav header-invoker d-flex mr-md-2" href="#" data-close-invoker="#sidebarClose"
                   data-target="#sidebar" data-target-wrapper="body">
                    <i class="gd-align-left"></i>
                </a>
                <!-- End Side Nav Toggle -->

                <!-- User Avatar -->
                <div class="dropdown mx-3 dropdown ml-2 ml-auto">
                    <a id="profileMenuInvoker" class="header-complex-invoker" href="#" aria-controls="profileMenu" aria-haspopup="true"
                       aria-expanded="false" data-unfold-event="click" data-unfold-target="#profileMenu" data-unfold-type="css-animation"
                       data-unfold-duration="300" data-unfold-animation-in="fadeIn" data-unfold-animation-out="fadeOut">
                        <span class="mr-md-2 avatar-placeholder"><i class="gd-user"></i></span>
                        <span class="d-none d-md-block">{{Auth::user()->name}}</span>
                        <i class="gd-angle-down d-none d-md-block ml-2"></i>
                    </a>

                    <ul id="profileMenu" class="unfold unfold-user unfold-light unfold-top unfold-centered position-absolute pt-2 pb-1 mt-4 unfold-css-animation unfold-hidden fadeOut"
                        aria-labelledby="profileMenuInvoker" style="animation-duration: 300ms;">
                        <li class="unfold-item">
                            <a class="unfold-link d-flex align-items-center text-nowrap" href="#">
                                <span class="unfold-item-icon mr-3">
                                  <i class="gd-user"></i>
                                </span>Profile
                            </a>
                        </li>
                        <li class="unfold-item unfold-item-has-divider">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <a class="unfold-link d-flex align-items-center text-nowrap" href="javascript:void(0);" onclick="this.closest('form').submit();">
                                    <span class="unfold-item-icon mr-3">
                                        <i class="gd-power-off"></i>
                                    </span>Sign Out
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
