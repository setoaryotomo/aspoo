<script src="{!! asset('js/core/jquery.3.2.1.min.js') !!}"></script>
<script src="{!! asset('js/core/popper.min.js') !!}"></script>
<script src="{!! asset('js/core/bootstrap.min.js') !!}"></script>

<!-- jQuery UI -->
<script src="{!! asset('js/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js') !!}"></script>
<script src="{!! asset('js/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') !!}"></script>

<!-- jQuery Scrollbar -->
<script src="{!! asset('js/plugins/jquery-scrollbar/jquery.scrollbar.min.js') !!}"></script>


<!-- Chart JS -->
<script src="{!! asset('js/plugins/chart.js/chart.min.js') !!}"></script>

<!-- jQuery Sparkline -->
<script src="{!! asset('js/plugins/jquery.sparkline/jquery.sparkline.min.js') !!}"></script>

<!-- Chart Circle -->
<script src="{!! asset('js/plugins/chart-circle/circles.min.js') !!}"></script>

<!-- Datatables -->
<script src="{!! asset('js/plugins/datatables/datatables.min.js') !!}"></script>

<!-- Bootstrap Notify -->
<script src="{!! asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') !!}"></script>

<!-- jQuery Vector Maps -->
<script src="{!! asset('js/plugins/jqvmap/jquery.vmap.min.js') !!}"></script>
<script src="{!! asset('js/plugins/jqvmap/maps/jquery.vmap.world.js') !!}"></script>

<!-- Sweet Alert -->
<script src="{!! asset('js/plugins/sweetalert/sweetalert.min.js') !!}"></script>

<!-- Atlantis JS -->
<script src="{!! asset('js/atlantis.min.js') !!}"></script>

<script>
    Vue.createApp({
        data() {
            return {
                userData: {},
                isLoggedin: false,
            }
        },
        async created() {
            await this.fetchProfile();
        },
        methods: {
            async fetchProfile() {
                const response = await httpClient.post("{!! url('p/fetch-login') !!}/")
                if (response.data.code == "400") {
                    this.isLoggedin = false
                } else {
                    this.isLoggedin = true
                    this.userData = response.data.result
                    this.userData.roles.forEach(element => {
                        this.userData.roleName = element.name
                    });
                    if (this.userData.detail != undefined) {
                        this.userData.fotodata = this.userData.detail.foto_readable
                    } else {
                        this.userData.fotodata = "{{ URL::asset('/img/portal/user-icon.png') }}"
                    }
                }
                console.log("profile", this.userData)
            },

        }

    }).mount("#navbar")
</script>
</body>

</html>
