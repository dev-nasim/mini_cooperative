<aside id="sidebar" class="js-custom-scroll side-nav">
    <ul id="sideNav" class="side-nav-menu side-nav-menu-top-level mb-0">
        <li class="side-nav-menu-item active">
            <a class="side-nav-menu-link media align-items-center" href="{{url('/home')}}">
                <span class="side-nav-menu-icon d-flex mr-3">
                     <img src="{{ asset('img/dashboard.png') }}" style="width: 22px">
                </span>
                <span class="side-nav-fadeout-on-closed media-body">Dashboard</span>
            </a>
        </li>

        <li class="side-nav-menu-item active">
            <a class="side-nav-menu-link media align-items-center" href="{{url('user')}}">
                <span class="side-nav-menu-icon d-flex mr-3">
                    <img src="{{ asset('img/user.png') }}" style="width: 22px">
                </span>
                <span class="side-nav-fadeout-on-closed media-body">User</span>
            </a>
        </li>

        <li class="side-nav-menu-item active">
            <a class="side-nav-menu-link media align-items-center" href="{{url('cooperative')}}">
                <span class="side-nav-menu-icon d-flex mr-3">
                    <img src="{{ asset('img/checklist.png') }}" style="width: 22px">
                </span>
                <span class="side-nav-fadeout-on-closed media-body">Cooperative</span>
            </a>
        </li>

        <li class="side-nav-menu-item active">
            <a class="side-nav-menu-link media align-items-center" href="{{url('group')}}">
                <span class="side-nav-menu-icon d-flex mr-3">
                    <img src="{{ asset('img/puzzle.png') }}" style="width: 22px">
                </span>
                <span class="side-nav-fadeout-on-closed media-body">Group</span>
            </a>
        </li>

        <li class="side-nav-menu-item active">
            <a class="side-nav-menu-link media align-items-center" href="{{ url('member') }}">
                <span class="side-nav-menu-icon d-flex mr-3">
                    <img src="{{ asset('img/group.png') }}" style="width: 22px">
                </span>
                <span class="side-nav-fadeout-on-closed media-body">Member</span>
            </a>
        </li>

        <li class="side-nav-menu-item side-nav-has-menu">
            <a class="side-nav-menu-link media align-items-center" href="#" data-target="#subUsers">
                <span class="side-nav-menu-icon d-flex mr-3">
                    <img src="{{ asset('img/save-money.png') }}" style="width: 22px">
                </span>
                <span class="side-nav-fadeout-on-closed media-body">Saving</span>
                <span class="side-nav-control-icon d-flex">
                    <i class="gd-angle-right side-nav-fadeout-on-closed"></i>
                </span>
                <span class="side-nav__indicator side-nav-fadeout-on-closed"></span>
            </a>
            <ul id="subUsers" class="side-nav-menu side-nav-menu-second-level mb-0">
                <li class="side-nav-menu-item">
                    <a class="side-nav-menu-link" href="{{url('saving_accounts')}}">Account</a>
                </li>
                <li class="side-nav-menu-item">
                    <a class="side-nav-menu-link" href="{{url('deposit')}}">Deposit</a>
                </li>
            </ul>
        </li>

        <li class="side-nav-menu-item active">
            <a class="side-nav-menu-link media align-items-center" href="{{ url('deposit_reports') }}">
                <span class="side-nav-menu-icon d-flex mr-3">
                    <img src="{{ asset('img/report.png') }}" style="width: 22px">
                </span>
                <span class="side-nav-fadeout-on-closed media-body">Report</span>
            </a>
        </li>

{{--        <li class="side-nav-menu-item active">--}}
{{--            <a class="side-nav-menu-link media align-items-center" href="/">--}}
{{--                <span class="side-nav-menu-icon d-flex mr-3">--}}
{{--                    <img src="{{ asset('img/money.png') }}" style="width: 22px">--}}
{{--                </span>--}}
{{--                <span class="side-nav-fadeout-on-closed media-body">Withdraw</span>--}}
{{--            </a>--}}
{{--        </li>--}}
    </ul>
</aside>
