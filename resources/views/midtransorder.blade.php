@extends("portal_layout.templates")
@section("content")
</head>

<body>
    <div class="container">
        <h1 class="my-3">Detail Order</h1>
        <div class="card" style="width: 18rem;">
            <img src="{{URL::asset('/img/portal/produk.png')}}" class="card-img-top" alt="Product Image">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ab, accusamus!.</p>
                <form action="/bayar" method="POST">
                    @csrf
                        <div class="mb-3">
                            <label for="qty" class="form-label">Jumlah Pesanan</label>
                            <input type="number" name="qty" class="form-control" id="qty"
                                placeholder="jumlah yang di pesan">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Pelanggan</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="masukan nama">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">No. Telp</label>
                            <input type="text" name="phone" class="form-control" id="phone"
                                placeholder="masukan no hp">
                        </div>
                        <div class="mb-3">
                            <label for="addres" class="form-label">Alamat</label>
                            <textarea name="addres" id="addres" cols="30" rows="10"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Bayar</button>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

@endsection