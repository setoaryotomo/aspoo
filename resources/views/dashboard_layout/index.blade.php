@if (request()->header('X-Partial-Content') == true)
    @yield('content')
@else
    {!! View::make('layout.head') !!}

    <body>
        <script src="{!! asset('js/toast.js') !!}"></script>
        <script src="{!! asset('js/loading.js') !!}"></script>
        <script src="{!! asset('js/httpClient.js') !!}"></script>
        <script>
            initializeHttpClient("{!! csrf_token() !!}");
        </script>
        <script src="{!! asset('js/navigator.js') !!}"></script>
        <script src="{!! asset('js/vue_initial.js') !!}"></script>
        <script src="{!! asset('js/ckeditor_initial.js') !!}"></script>
        <div class="wrapper">
            {!! View::make('dashboard_layout.header') !!}
            {!! View::make('dashboard_layout.sidebar') !!}
            <div class="main-panel">
                <div id="root-content" class="content">
                    @yield('content')
                </div>
                {!! View::make('dashboard_layout.footer') !!}
            </div>
            
        </div>
        {!! View::make('layout.foot') !!}
    </body>
@endif
