<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <!-- ... -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
</head>
<body>
    <div id="app">
    </div>

</body>
</html>
