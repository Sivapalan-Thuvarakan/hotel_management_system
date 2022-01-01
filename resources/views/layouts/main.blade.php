<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <!-- SELECT 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @toastr_css
</head>

<body>
    {{-- <div class="page-loader" id="page-loader" >
        <img src="/assets/images/Fountain.gif" class="m-auto" />
      </div> --}}
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h5>Lak-Derana Hotel</h5>
            </div>

            <ul class="list-unstyled components">
                <li class={{ (request()->is('dashboard')) ? 'active' : '' }}>
                    <a href="{{route('dashboard')}}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                {{-- <p>Dummy Heading</p> --}}
                {{-- <li class={{ (request()->is('/home')) ? 'active' : '' }}>
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="#">Home 1</a>
                        </li>
                        <li>
                            <a href="#">Home 2</a>
                        </li>
                        <li>
                            <a href="#">Home 3</a>
                        </li>
                    </ul>
                </li> --}}
                {{-- <p class="text-black">Dummy Heading</p> --}}
                @can('can-view-department')
                <li class={{ (request()->is('departments*')) ? 'active' : '' }}>
                    <a href="{{route('departments.index')}}"><i class="fas fa-building"></i> Departments</a>
                </li>
                @endcan

                @can('can-view-user')
                <li class={{ (request()->is('users*')) ? 'active' : '' }}>
                    <a href="{{route('users.index')}}"><i class="fas fa-users"></i> Users</a>
                </li>
                @endcan

                @can('can-view-role')
                <li class={{ (request()->is('roles*')) ? 'active' : '' }}>
                    <a href="{{route('roles.index')}}"><i class="fas fa-user-tag"></i> Roles</a>
                </li>
                @endcan

                @can('can-view-room_type')
                <li class={{ (request()->is('room_types*')) ? 'active' : '' }}>
                    <a href="{{route('room_types.index')}}"><i class="fas fa-th"></i> Room Types</a>
                </li>
                @endcan

                @can('can-view-room')
                <li class={{ (request()->is('rooms*')) ? 'active' : '' }}>
                    <a href="{{route('rooms.index')}}"><i class="fas fa-th"></i> Rooms</a>
                </li>
                @endcan

                @can('can-view-customer')
                <li class={{ (request()->is('customers*')) ? 'active' : '' }}>
                    <a href="{{route('customers.index')}}"><i class="fas fa-users"></i> Customers</a>
                </li>
                @endcan

                @can('can-view-supplier')
                <li class={{ (request()->is('suppliers*')) ? 'active' : '' }}>
                    <a href="{{route('suppliers.index')}}"><i class="fas fa-users"></i> Suppliers</a>
                </li>
                @endcan

                @can('can-view-stock')
                <li class={{ (request()->is('stocks*')) ? 'active' : '' }}>
                    <a href="{{route('stocks.index')}}"><i class="fas fa-box-open"></i> Stocks</a>
                </li>
                @endcan

                @can('can-view-product')
                <li class={{ (request()->is('products*')) ? 'active' : '' }}>
                    <a href="{{route('products.index')}}"><i class="fas fa-boxes"></i> products</a>
                </li>
                @endcan

                @can('can-view-reservations')
                <li class={{ (request()->is('reservations*')) ? 'active' : '' }}>
                    <a href="{{route('reservations.index')}}"><i class="fas fa-bookmark"></i> Room Reservations</a>
                </li>
                @endcan

                @can('can-view-sales')
                <li class={{ (request()->is('sales*')) ? 'active' : '' }}>
                    <a href="{{route('sales.index')}}"><i class="fas fa-shopping-cart"></i> sales</a>
                </li>
                @endcan
                @can('can-view-reports')
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-file-alt"></i> Reports</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        @can('can-view-reservation_report')
                        <li>
                            <a href="{{route('reports.reservation')}}"> Reservation Report</a>
                        </li>
                        @endcan
                        {{-- <li>
                            <a href="#">Page 2</a>
                        </li>
                        <li>
                            <a href="#">Page 3</a>
                        </li> --}}
                    </ul>
                </li>
                @endcan


            </ul>

            {{-- <ul class="list-unstyled CTAs">
                <li>
                    <a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a>
                </li>
                <li>
                    <a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a>
                </li>
            </ul> --}}
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-bars"></i>
                        {{-- <span>Toggle Sidebar</span> --}}
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            @can('can-add-reservations')
                            <li class="nav-item">
                                <a href="{{route('reservations.create')}}" class="btn btn-md btn-primary mr-1 mb-2 mt-1"><i class="fas fa-plus"></i> Add Reservation</a>
                            </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{route('profile.index')}}" class="btn btn-md btn-warning mr-1 mb-2 mt-1"><i class="fas fa-user-circle"></i> Profile</a>
                            </li>
                            <li class="nav-item">
                                <button  onclick="logout()" class="btn btn-md btn-secondary mr-1 mb-2 mt-1"><i class="fas fa-sign-out-alt"></i> Logout</button>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                            {{-- <li class="nav-item">
                            <a class="dropdown-item btn-dark" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </nav>

            @yield('content')
        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}
    <script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js" integrity="sha512-vBmx0N/uQOXznm/Nbkp7h0P1RfLSj0HQrFSzV8m7rOGyj30fYAOKHYvCNez+yM8IrfnW0TCodDEjRqf6fodf/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- SELECT 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- @jquery --}}
    @toastr_js
    @toastr_render

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>

    <script>
        function logout() {
            Swal.fire({
                title: 'Are you sure?',
                html: "You want to logout" ,
                icon:  'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                $('#logout-form').submit();
                }
            })
        }
    </script>

    <script>
        // $(window).on('load', function() {
        //     setTimeout(function(){ $('.page-loader').fadeOut('slow'); }, 1000);
        // });
    </script>
    @stack('scripts')
</body>

</html>
