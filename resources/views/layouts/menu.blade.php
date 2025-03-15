<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="./">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./even">Even Numbers</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./prime">Prime Numbers</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./multable">Multiplication Table</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./minitest">Mini Test</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./products">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./crud">Users</a>
        </li>
        @if(auth()->check())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('profile') }}">Profile</a>
    </li>
@endif

        </ul>
        </ul>
        <ul class="navbar-nav">
            @auth
            <li class="nav-item"><a class="nav-link">{{auth()->user()->name}}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('do_logout')}}">Logout</a></li>
            @else
            <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Login</a></li>
            @endauth
            <li class="nav-item"><a class="nav-link" href="{{route('register')}}">Register</a></li>
        </ul>
        
        

    </div>
</nav>