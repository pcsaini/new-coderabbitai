@extends('layouts.main')

@section('main-content')

    <div class="d-flex flex-column">
        <div class="page page-center pt-5 mt-5">
        <div class="container-tight py-4">
            <div class="text-center mb-4">
                <a href="#" class="navbar-brand navbar-brand-autodark text-gray-500 fs-1">ABC Bank</a>
            </div>

            @yield('content')
        </div>
        </div>
    </div>


@endSection
