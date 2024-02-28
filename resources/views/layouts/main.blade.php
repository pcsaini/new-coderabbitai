<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{ config('app.name') }} - @yield('title')</title>
    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css') }}?v={{ config('app.version') }}" rel="stylesheet"/>

    <!-- CSS Libs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link href="{{ asset('dist/css/style.css') }}?v={{ config('app.version') }}" rel="stylesheet"/>
</head>
<body>

@yield('main-content')


<!-- Libs Js -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"
        integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>
    const notyf = new Notyf();
</script>

@if (session('success'))
    <script>
        notyf.success({
            message: "{{ session('success') }}",
            dismissible: true,
            position: {
                x: 'right',
                y: 'top',
            },
            duration: 5000,
        });
    </script>
@endif

@if (session('error'))
    <script>
        notyf.error({
            message: "{{ session('error') }}",
            dismissible: true,
            position: {
                x: 'right',
                y: 'top',
            },
            duration: 5000,
        });
    </script>
@endif

@yield('scripts')
</body>
</html>
