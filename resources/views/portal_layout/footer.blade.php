    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap');

        footer {
            box-sizing: border-box;
            background-color: #FBF7EB;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            font-family: 'Poppins', sans-serif;
            margin-top: 60px;
        }

        h4 {
            padding-top: 30px;
            font-size: 20px;
            font-family: 'Poppins', sans-serif;
            color: #757272;
            font-weight: 600px;
        }

        .box {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
        }

        .box img {
            height: auto;
            position: right;
            margin-right: 0px;
        }

        .d-flex {
            display: initial !important;
            /* Atau display: block!important; */
        }

        .detail {
            text-decoration: none;
            font-size: 20px;
            font-family: 'Poppins', sans-serif;
            color: #757272;
            font-weight: bold;
            margin-left: 30px;
        }
    </style>
    <footer class="mt-auto " style="margin-top: 2000px">
        <div class="container d-flex justify-space-between">
            <div class="box">
                <div class="caption">
                    <h4>
                        <a href="{{ url('/p/tentangaspoomarket') }}" class="detail">Tentang Aspoo Market</a>
                    </h4>
                    <h4>
                        <a href="{{ url('/p/kebijakan') }}" class="detail">Kebijakan</a>
                    </h4>
                </div>
                <div>
                    <img src="{{ URL::asset('/img/portal/logo.png') }}" />
                </div>
            </div>
        </div>
    </footer>

    
