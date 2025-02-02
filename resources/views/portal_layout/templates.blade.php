@if (request()->header('X-Partial-Content') == true)
    @yield('content')
@else
 
    @if (!isset($hideHeaderFooter))
        @include('portal_layout.navbar')
    @else
        @include('layout.head')
    @endif

    <script src="{!! asset('js/toast.js') !!}"></script>
    <script src="{!! asset('js/loading.js') !!}"></script>
    <script src="{!! asset('js/httpClient.js') !!}"></script>
    <script>
        initializeHttpClient("{!! csrf_token() !!}");
    </script>
    <script src="{!! asset('js/navigator.js') !!}"></script>
    <script src="{!! asset('js/vue_initial.js') !!}"></script>
    <script src="{!! asset('js/ckeditor_initial.js') !!}"></script>
    <?php 
    if(!isset($hideHeaderFooter)){
        $style = "min-height: 100vh; padding-top:50px; margin-bottom:100px";
    }else{
        $style = "";
    }
    ?>


    <body>
        <div id="root-content" style="{{$style}}">
            @yield('content')
        </div>
        @if (!isset($hideHeaderFooter))
            @include('portal_layout.footer')
        @endif

    </body>

    
    @include('layout.foot')
@endif
