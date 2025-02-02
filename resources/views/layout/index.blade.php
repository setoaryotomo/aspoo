{!! View::make('layout.head') !!}
<script src="{!! asset('js/toast.js') !!}"></script>
<script src="{!! asset('js/loading.js') !!}"></script>
<script src="{!! asset('js/httpClient.js') !!}"></script>
<script>
    initializeHttpClient("{!! csrf_token() !!}");
</script>
<script src="{!! asset('js/navigator.js') !!}"></script>
<script src="{!! asset('js/vue_initial.js') !!}"></script>
<script src="{!! asset('js/ckeditor_initial.js') !!}"></script>
@yield('content')

{!! View::make('layout.foot') !!}
