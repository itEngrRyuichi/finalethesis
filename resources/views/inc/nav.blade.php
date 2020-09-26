<!--Guest-->
<nav class="navbar navbar-expand-md">
    <div class="container">
        <a href="/home" class="navbar-brand">{{config('app.name', 'CPU-SHS.Online')}}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/home"><i class="fa fa-home"></i>Home</a>
                </li>
                @guest
                @else
                    @if (Auth::user()->userType_id === 1)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#account" id="AccountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i>Account
                            </a>
                        <div class="dropdown-menu" aria-labelledby="AccountDropdown">
                            <a class="dropdown-item" href="/teacherAccountlist"><i class="fa fa-address-card"></i>Teacher Accounts List</a>
                            <a class="dropdown-item" href="/sectionCatalog"><i class="fa fa-th-list"></i>Section Catalog</a>
                            <a class="dropdown-item" href="/acceptTeacherAccount"><i class="fa fa-user-plus"></i>Accept Teacher Account</a>
                            <a class="dropdown-item" href="/accountAccessCode"><i class="fa fa-code"></i>New Access Code</a>
                        </div>
                        
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#class" id="ClassDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-graduation-cap"></i>Class
                        </a>
                        <div class="dropdown-menu" aria-labelledby="CLassDropdown">
                            <a class="dropdown-item" href="/subjectCatalog"><i class="fa fa-th-list"></i>Subject Catalog</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#resources" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-folder-open"></i>Resources
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/resource"><i class="fa fa-book-open"></i>Your Resources</a>
                        </div>
                    </li>
                    @elseif (Auth::user()->userType_id === 2)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#account" id="AccountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i>Account
                            </a>
                        <div class="dropdown-menu" aria-labelledby="AccountDropdown">
                            <a class="dropdown-item" href="/studentAccountlist"><i class="fa fa-address-card"></i>Student Accounts List</a>
                            <a class="dropdown-item" href="/sectionCatalog"><i class="fa fa-th-list"></i>Section Catalog</a>
                            <a class="dropdown-item" href="/acceptStudentAccount"><i class="fa fa-user-plus"></i>Accept Student Account</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#class" id="ClassDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-graduation-cap"></i>Class
                        </a>
                        <div class="dropdown-menu" aria-labelledby="CLassDropdown">
                            <a class="dropdown-item" href="/subjectCatalog"><i class="fa fa-th-list"></i>Subject Catalog</a>
                            <a class="dropdown-item" href="/onGoingClasses"><i class="fa fa-columns"></i>Dashboard</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#resources" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-folder-open"></i>Rsources
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/onlineQuizsStorage"><i class="fa fa-folder"></i>Quizes</a>
                            <a class="dropdown-item" href="/resource"><i class="fa fa-book-open"></i>Your Resources</a>
                        </div>
                    </li>
                    @elseif (Auth::user()->userType_id === 3)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#account" id="AccountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i>Account
                            </a>
                        <div class="dropdown-menu" aria-labelledby="AccountDropdown">
                            <a class="dropdown-item" href="/parentAccountlist"><i class="fa fa-address-card"></i>Parent Accounts List</a>
                            <a class="dropdown-item" href="/acceptParentAccount"><i class="fa fa-user-plus"></i>Accept Parent Account</a>
                            <a class="dropdown-item" href="/sectionCatalog"><i class="fa fa-th-list"></i>Section Catalog</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#class" id="ClassDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-graduation-cap"></i>Class
                        </a>
                        <div class="dropdown-menu" aria-labelledby="CLassDropdown">
                            <a class="dropdown-item" href="/subjectCatalog"><i class="fa fa-th-list"></i>Subject Catalog</a>
                            <a class="dropdown-item" href="/enrollment"><i class="fa fa-door-open"></i>Enroll</a>
                            <a class="dropdown-item" href="/onGoingClasses"><i class="fa fa-columns"></i>Dashboard</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#resources" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-folder-open"></i>Resources
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/resource"><i class="fa fa-book-open"></i>Your Resources</a>
                        </div>
                    </li>
                    @elseif (Auth::user()->userType_id === 4)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#account" id="AccountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i>Account
                            </a>
                        <div class="dropdown-menu" aria-labelledby="AccountDropdown">
                            <a class="dropdown-item" href="/sectionCatalog"><i class="fa fa-th-list"></i>Section Catalog</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#class" id="ClassDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-graduation-cap"></i>Class
                        </a>
                        <div class="dropdown-menu" aria-labelledby="CLassDropdown">
                            <a class="dropdown-item" href="/subjectCatalog"><i class="fa fa-th-list"></i>Subject Catalog</a>
                            <a class="dropdown-item" href="/onGoingClasses"><i class="fa fa-columns"></i>Dashboard</a>
                        </div>
                    </li>
                    @endif
                @endguest
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="access">Register</a>
                        </li>
                    @endif
                @else
                    <span class="navbar-text">
                        <a href="/viewAccountDetail">{{ Auth::user()->name }}</a>
                    </span>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#notification" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('logout') }}" 
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out-alt"></i>
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>