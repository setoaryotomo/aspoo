@extends("portal_layout.templates")
@section("content")
<div class="container">
    <!-- Tutorial Text Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                {{-- <div class="card-header bg-primary text-white text-center py-3">
                    <h2 class="mb-0">
                        <i class="fas fa-box me-2"></i>
                        Tutorial Pemesanan Parcel ASPOO
                    </h2>
                </div> --}}
                <div class="card-body p-4">
                    <div class="tutorial-content">
                        <h4 class="text-primary mb-3">
                            {{-- <i class="fas fa-play-circle me-2"></i> --}}
                            Panduan Lengkap Pemesanan Parcel
                        </h4>
                        
                        <div class="step-by-step">
                            <div class="step-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">1</div>
                                    <div>
                                        <h5 class="text-dark mb-2"><b>Pilih Lokasi Pengiriman</b></h5>
                                        <img src="{{ asset('img/portal/satu.png') }}" alt="" style="border: 1px solid black;">
                                        <p class="text-muted mb-0">Pilih provinsi dan kota/kabupaten tujuan pengiriman parcel. Pastikan alamat tujuan sudah benar sesuai dengan yang diinginkan.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="step-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">2</div>
                                    <div>
                                        <h5 class="text-dark mb-2"><b>Tentukan Budget dan Berat</b></h5>
                                        <img src="{{ asset('img/portal/hargaberat.png') }}" alt="" style="border: 1px solid black;">
                                        
                                        <p class="text-muted mb-0">Masukkan budget yang diinginkan untuk parcel dan estimasi berat maksimal (10 kg). Sistem akan memberikan rekomendasi sesuai dengan budget yang Anda tentukan.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="step-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">3</div>
                                    <div>
                                        <h5 class="text-dark mb-2"><b>Atur Detail Pemesanan</b></h5>
                                        <img src="{{ asset('img/portal/detail.png') }}" alt="" style="border: 1px solid black;">
                                        <p class="text-muted mb-0">Tentukan jumlah item dalam parcel, jumlah parcel yang dipesan, dan pilih tanggal pengiriman yang diinginkan.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="step-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">4</div>
                                    <div>
                                        <h5 class="text-dark mb-2"><b>Filter Barang</b></h5>
                                        <img src="{{ asset('img/portal/tujuh.png') }}" alt="" style="border: 1px solid gray;">
                                        <p class="text-muted mb-0">Gunakan filter untuk memilih kategori barang yang diinginkan atau tidak diinginkan, bahan dasar, basah/kering, rasa, dan produsen tertentu, serta nama produk spesifik yang ingin dipesan atau dihindari dalam parcel. Anda dapat memilih produk spesifik seperti Abon, Biskuit, atau produk lainnya.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="step-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">5</div>
                                    <div>
                                        <h5 class="text-dark mb-2"><b>Pilih Rekomendasi Parcel</b></h5>
                                        <img src="{{ asset('img/portal/delapan.png') }}" alt="" style="border: 1px solid gray;">
                                        <p class="text-muted mb-0">Setelah proses filter, sistem akan menampilkan 3 rekomendasi parcel berdasarkan preferensi Anda. Pilih salah satu yang paling sesuai dengan kebutuhan.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="step-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="step-number bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">6</div>
                                    <div>
                                        <h5 class="text-dark mb-2"><b>Konfirmasi Pemesanan</b></h5>
                                        <p class="text-muted mb-0">Klik tombol "Pesan" untuk mengkonfirmasi pemesanan parcel. Pastikan semua detail sudah benar sebelum melanjutkan ke proses pembayaran.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Tips:</strong> Pastikan alamat pengiriman sudah benar dan sesuai dengan keinginan. Sistem akan memberikan estimasi terbaik berdasarkan budget dan preferensi yang Anda pilih.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Section -->
    <div class="text-center my-4" style="display: none">
        <img src="https://lh3.googleusercontent.com/d/1SJ6fNTHzDEakHnIqQHXWyW7Z9nEdJV9A"
             alt="Tutorial Parcel"
             class="img-fluid rounded mx-auto d-block shadow-lg"
             style="max-width: 1000px; width: 100%; height: auto;">
    </div>
</div>

<style>
.step-number {
    min-width: 40px;
    min-height: 40px;
    font-size: 18px;
}

.step-item {
    padding: 15px;
    border-left: 3px solid #e9ecef;
    margin-left: 20px;
    position: relative;
}

.step-item:hover {
    background-color: #f8f9fa;
    border-radius: 8px;
    border-left-color: #007bff;
}

.card {
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.tutorial-content h4 {
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
    margin-bottom: 25px;
}

.alert {
    border-radius: 10px;
    border: none;
}
</style>
@endsection