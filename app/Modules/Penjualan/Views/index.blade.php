@extends('dashboard_layout.index')
@section('content')

<div id="pos">

</div>

<script>
    createApp({
        created(){
            this.redirectLogin();
        },
        methods : {
            redirectLogin(){
                window.open("{{url('pos')}}", '_blank', 'noreferrer');
            }
        }

    }).mount("#pos")
</script>


@endsection