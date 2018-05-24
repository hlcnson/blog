<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <!-- Dùng phương thức asset để nạp các file css và js.
    Các file này phải được đặt trong thư mục public/css và public/js -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <!-- Sử dụng phương thức check của class tên Auth để
                xác định người dùng đã được chứng thực hay chưa -->
                @if (Auth::check())
                    <!-- Đã được chứng thực, hiển thị menu -->
                    <!-- Khu vực menu -->
                    <div class="col-lg-4">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="list-group-item">
                                <!-- Dùng phương thức route() với đối số là tên tham
                                chiếu của route (định nghĩa trong web.php) để tạo route 
                                bao gồm cả prefix (nếu có) tự động cho link -->
                                <a href="{{ route('post.create') }}">Create a new post</a>
                            </li>
                            <li class="list-group-item">
                                <!-- Dùng phương thức route() với đối số là tên tham
                                chiếu của route (định nghĩa trong web.php) để tạo route 
                                bao gồm cả prefix (nếu có) tự động cho link -->
                                <a href="{{ route('posts') }}">All posts</a>
                            </li>
                            <li class="list-group-item">
                                <!-- Dùng phương thức route() với đối số là tên tham
                                chiếu của route (định nghĩa trong web.php) để tạo route 
                                bao gồm cả prefix (nếu có) tự động cho link -->
                                <a href="{{ route('posts.trashed') }}">All trashed posts</a>
                            </li>
                            <li class="list-group-item">
                                <!-- Dùng phương thức route() với đối số là tên tham
                                chiếu của route (định nghĩa trong web.php) để tạo route 
                                bao gồm cả prefix (nếu có) tự động cho link -->
                                <a href="{{ route('categories') }}">Categories</a>
                            </li>

                            <li class="list-group-item">
                                <!-- Dùng phương thức route() với đối số là tên tham
                                chiếu của route (định nghĩa trong web.php) để tạo route 
                                bao gồm cả prefix (nếu có) tự động cho link -->
                                <a href="{{ route('tags') }}">Tags</a>
                            </li>
                            <!-- Phương thức Auth::user() trả về đối tượng user đã được chứng
                            thực. Field tên admin xác định user có phải admin hay không. -->
                            @if(Auth::user()->admin)
                                <li class="list-group-item">
                                    <!-- Dùng phương thức route() với đối số là tên tham
                                    chiếu của route (định nghĩa trong web.php) để tạo route 
                                    bao gồm cả prefix (nếu có) tự động cho link -->
                                    <a href="{{ route('users') }}">Users</a>
                                </li>
                                <li class="list-group-item">
                                    <!-- Dùng phương thức route() với đối số là tên tham
                                    chiếu của route (định nghĩa trong web.php) để tạo route 
                                    bao gồm cả prefix (nếu có) tự động cho link -->
                                    <a href="{{ route('user.create') }}">Create a new user</a>
                                </li>
                            @endif
                            
                            <li class="list-group-item">
                                <!-- Dùng phương thức route() với đối số là tên tham
                                chiếu của route (định nghĩa trong web.php) để tạo route 
                                bao gồm cả prefix (nếu có) tự động cho link -->
                                <a href="{{ route('user.profile') }}">My profile</a>
                            </li>

                            <li class="list-group-item">
                                <!-- Dùng phương thức route() với đối số là tên tham
                                chiếu của route (định nghĩa trong web.php) để tạo route 
                                bao gồm cả prefix (nếu có) tự động cho link -->
                                <a href="{{ route('tag.create') }}">Create new tag</a>
                            </li>

                            <li class="list-group-item">
                                <!-- Dùng phương thức route() với đối số là tên tham
                                chiếu của route (định nghĩa trong web.php) để tạo route 
                                bao gồm cả prefix (nếu có) tự động cho link -->
                                <a href="{{ route('category.create') }}">Create a new category</a>
                            </li>
                            
                        </ul>
                    </div>
                @endif
                
                <!-- khu vực nội dung chính -->
                <div class="col-lg-8">
                    <!-- Xuất phần view có tên content ở đây -->
                    @yield('content')
                </div>
            </div>
        </div>


    </div>

    <!-- Scripts -->
    <!-- Dùng phương thức asset để nạp các file css và js.
    Các file này phải được đặt trong thư mục public/css và public/js -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script>
        // Kiểm tra xem Session có key tên success hay không
        @if (Session::has('success'))
            // Có khóa success -> sử dụng thư viện toastr để hiển thị thông điệp.
            // Sử dụng phương thức get của class Session để lấy nội dung của khóa success
            toastr.success("{{ Session::get('success') }}");
        @endif

        // Kiểm tra xem Session có key tên info hay không
        @if (Session::has('info'))
            // Có khóa info -> sử dụng thư viện toastr để hiển thị thông điệp.
            // Sử dụng phương thức get của class Session để lấy nội dung của khóa info
            toastr.info("{{ Session::get('info') }}");
        @endif
    </script>
</body>
</html>
