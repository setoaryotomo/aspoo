@extends('portal_layout.templates')
@section('content')
    @php
        function rupiah($harga)
        {
            $rupiah = 'Rp. ' . number_format($harga, 0, ',', '.');
            return $rupiah;
        }
        
    @endphp
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        .setelahcheckout {
            font-family: 'Poppins';
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: 150px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .btn-kembali {
            margin-top: 50px;
            background-color: #606C5D;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-kembali:hover {
            background-color: #0056b3;
        }
    </style>
    <div class="setelahcheckout">
        <div class="card">
            <div class="card-body text-center">
                <h1>Silahkan Transfer Uang ke Bank Berikut</h1>
                @foreach($rekening as $rek)
                    <h3>{{ $rek->tipe_rekening }} : {{ $rek->kode_rekening }} : {{ $rek->pemilik_rekening }}</h3>
                @endforeach
                <h3>Total Biaya : {{ rupiah(intval($harga)) }}</h3>
                <br><br><br>
                <a class="btn btn-danger" href="{{ url('') }}/p/">Kembali ke Portal</a>
            </div>
        </div>
    </div>
@endsection