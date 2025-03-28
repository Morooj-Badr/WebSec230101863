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
                <a class="nav-link" href="./transcript">Transcript</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./calculator">Calculator</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('exam.start') }}">MCQ</a>
            </li>
            @if(auth()->check())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('questions.index') }}">Manage Questions</a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products_list') }}">Products</a>
            </li>
            @can('show_users')
            <li class="nav-item">
                <a class="nav-link" href="{{route('users')}}">Users</a>
            </li>
            @endcan
            @if(auth()->user()->can('list_customers'))
<li class="nav-item">
    <a class="nav-link" href="{{ route('customers.index') }}">Customers</a>
</li>
@endif

            @if(auth()->check())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student') }}">Students</a>
            </li>
            @endif
        </ul>
        <ul class="navbar-nav">
            @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile') }}">{{ auth()->user()->name }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('do_logout') }}">Logout</a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>
            @endauth
        </ul>
    </div>
</nav>
