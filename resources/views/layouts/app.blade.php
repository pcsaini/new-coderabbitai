@extends('layouts.main')

@section('main-content')
    <div class="page">
        <!-- Navbar -->
        @include('layouts.includes.header')

        @include('layouts.includes.navbar')
        <div class="page-wrapper">
            <!-- Page body -->
            <div class="page-body">
                <div class="container">
                    <!-- Content here -->

                    @yield('content')
                </div>
            </div>
        </div>
    </div>
@endSection
