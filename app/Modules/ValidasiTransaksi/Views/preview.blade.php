@extends('dashboard_layout.index')
@section('content')
    @php
        function rupiah($angka)
        {
            $rupiah = 'Rp. ' . number_format($angka, 0, ',', '.');
            return $rupiah;
        }
        
    @endphp
    <div class="page-inner" id="preview">

        <div class="card">
            <div class="card-header">
                <div class="card-title">Detail Transaksi</div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Kode Transaksi</td>
                            <td>Biaya Pengiriman</td>
                            <td>Harga Pesanan</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data->transaksi as $transaksi)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $transaksi->kode_transaksi }}</td>
                                <td>{{ rupiah($transaksi->biaya_pengiriman) }}</td>
                                <td>{{ rupiah($transaksi->total_biaya) }}</td>
                                <td style="color: green; font-weight:bolder"><strong>Telah Terbayar</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-center">
                                Total Biaya
                            </td>
                            <td>{{ rupiah(intval($data->total_biaya) + intval($data->kode_unik)) }}</td>
                        </tr>
                    </tfoot>
                </table>
                <div class=" mr-4">
                    <p>Kode Unik : {{ $data->kode_unik }}
                        <span class="float-right">Pembayaran : Midtrans sebagai mitra pembayaran
                        </span>
                    </p>
                </div>
            </div>
            <div class="card-footer ">
                <div class="float-right">
                    <button class="btn btn-primary" @click="klikApprove('{{ $data->kode_transaksi }}')">
                        Approve
                    </button>
                    <button class="btn btn-danger" @click="klikTolak('{{ $data->kode_transaksi }}')">
                        Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        createApp({
            methods: {
                async klikTolak(kode) {
                    try {
                        Swal.fire({
                            title: 'Tuliskan Alasan Anda Menolak',
                            input: 'text',
                            inputAttributes: {
                                autocapitalize: 'off'
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Yakin',
                            showLoaderOnConfirm: true,
                            preConfirm: (data) => {
                                try {
                                    var response = httpClient.post(
                                    `{{ url()->current() }}/delete`, {
                                        pesan: data
                                    })
                                    return response
                                } catch (error) {
                                    Swal.showValidationMessage(
                                        `Request failed: ${error}`
                                    )
                                }

                            },
                            allowOutsideClick: () => Swal.isLoading()
                        }).then((result) => {
                            console.log(result)

                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: `Data berhasil ditolak!`,
                                })
                                window.location.href = `{{ url('validasi-transaksi') }}`
                            }
                        })

                    } catch (err) {
                        hideLoading()
                        showToast({
                            message: err.message,
                            type: 'error'
                        })
                    }
                },
                async klikApprove(kode) {
                    try {
                        showLoading()
                        const response = await httpClient.post('{{ url()->current() }}', {
                            kode: kode
                        })
                        console.log(response)
                        hideLoading()
                        showToast({
                            message: response.data.result.message
                        })
                        window.location.href = "{{ url('/validasi-transaksi') }}"

                    } catch (err) {
                        hideLoading()
                        showToast({
                            message: err.message,
                            type: 'error'
                        })
                    }

                }
            }
        }).mount("#preview")
    </script>
@endsection
