@include('layouts.partials.header')
    <div id="app">
        @include('layouts.partials.navbar')

        @yield('content')
    </div>

@include('layouts.partials.footer')