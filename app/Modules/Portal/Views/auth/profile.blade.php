@extends('portal_layout.templates')
@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@400;500;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        color: #333;
    }

    .page-title {
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 20px;
        font-family: 'Roboto', sans-serif;
        color: #2c3e50;
    }

    .content-box {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }

    .form-container {
        flex: 1;
        min-width: 300px;
    }

    .profile-box {
        padding: 25px;
        background-color: #f9f9f9;
        border-radius: 12px;
        text-align: center;
        width: 280px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        align-self: flex-start;
    }

    .profile-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 15px;
        object-fit: cover;
        border: 3px solid #E1B587;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
        background-color: #fff;
        color: #333;
        font-size: 14px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #E1B587;
        box-shadow: 0 0 0 3px rgba(225, 181, 135, 0.2);
        outline: none;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #555;
        font-size: 14px;
    }

    .change-image {
        font-size: 13px;
        color: #555;
        cursor: pointer;
        margin-top: 15px;
        display: inline-block;
    }

    .save-button {
        background-color: #E1B587;
        color: #fff;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
        font-weight: 500;
        font-size: 15px;
        margin-top: 10px;
    }

    .save-button:hover {
        background-color: #d4a276;
        transform: translateY(-2px);
    }

    .upload-button {
        background-color: #E1B587;
        color: #fff;
        border: none;
        padding: 8px 15px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 13px;
        font-weight: 500;
    }

    .upload-button:hover {
        background-color: #d4a276;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: flex;
        gap: 20px;
    }

    .form-row .form-group {
        flex: 1;
    }

    @media (max-width: 768px) {
        .content-box {
            flex-direction: column;
            padding: 20px;
        }
        
        .profile-box {
            width: 100%;
            margin-bottom: 25px;
        }
        
        .form-row {
            flex-direction: column;
            gap: 0;
        }
    }
</style>

<div class="container mt-4 mb-5">
    <div class="page-title">Profile Pengguna</div>
    <form method="POST" action="{{ url('/p/profile') }}" enctype="multipart/form-data">
        @csrf
        <div class="content-box">
            <div class="form-container">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" value="{{ $data->nama }}" id="nama" name="nama" placeholder="Nama Lengkap">
                    </div>
                    @if(!empty($toko->nama))
                    <div class="form-group">
                        <label for="nama_toko" class="form-label">Nama Toko</label>
                        <input type="text" class="form-control" value="{{ $toko->nama }}" id="nama_toko" name="nama_toko" placeholder="Nama Toko">
                    </div>
                    @endif
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control" value="{{ $data->telepon }}" id="nomorTelepon" name="telepon" placeholder="Nomor Telepon">
                    </div>
                </div>

                @if(!empty($toko->nama))
                <div class="form-row">
                    <div class="form-group">
                        <label for="npwp" class="form-label">NPWP</label>
                        <input type="text" class="form-control" value="{{ $toko->npwp }}" id="npwp" name="npwp" placeholder="NPWP">
                    </div>
                    <div class="form-group">
                        <label for="ijin_usaha" class="form-label">Ijin Usaha</label>
                        <input type="text" class="form-control" value="{{ $toko->ijin_usaha }}" id="ijin_usaha" name="ijin_usaha" placeholder="Ijin Usaha">
                    </div>
                    <div class="form-group">
                        <label for="omset" class="form-label">Omset</label>
                        <input type="text" class="form-control" value="{{ $toko->omset }}" id="omset" name="omset" placeholder="Omset">
                    </div>
                </div>
                @endif
                
                <div class="form-group">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Alamat Lengkap">{{ $data->alamat }}</textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="provinsi">Provinsi</label>
                        <select name="provinsi" id="provinsi" class="form-control" data-dependent="provinsi">
                            <option value="">{{ $data->provinsi ? $data->provinsiModel->name : 'Pilih Provinsi' }}</option>
                            @foreach($asal['provinsi'] as $provinsi)
                                <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="kota">Kota/Kabupaten</label>
                        <select name="kota" id="kota" class="form-control dynamic" data-dependent="kota">
                            <option value="">{{ $data->kota ? $data->kotaModel->name : 'Pilih Kota/Kabupaten' }}</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="kecamatan">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" class="form-control dynamic" data-dependent="kecamatan">
                            <option value="">{{ $data->kecamatan ? $data->kecamatanModel->name : 'Pilih Kecamatan' }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="kelurahan">Kelurahan</label>
                        <select name="kelurahan" id="kelurahan" class="form-control dynamic" data-dependent="kelurahan">
                            <option value="">{{ $data->kelurahan ? $data->kelurahanModel->name : 'Pilih Kelurahan' }}</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" value="{{ $data->tanggal_lahir }}" id="tanggalLahir" name="tanggal_lahir">
                    </div>
                    <div class="form-group">
                        <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                        <select style="height: 50px" class="form-select custom-select" id="jenisKelamin" name="jenis_kelamin">
                            <option value="{{ $data->jenis_kelamin }}">{{ $data->jenis_kelamin ?? 'Pilih Jenis Kelamin' }}</option>
                            <option>Laki-Laki</option>
                            <option>Perempuan</option>
                        </select>
                    </div>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="save-button">Simpan Perubahan</button>
                </div>
            </div>
            
            <div class="profile-box">
                <?php 
                    $foto = $data->foto_readable ?? url('/img/portal/user-icon.png');
                ?>
                <img id="previewImage" src="{{ $foto }}" alt="Profile Picture" class="profile-image">
                <div class="change-image">
                    <label for="uploadImage" class="upload-button">Ubah Foto Profil</label>
                    <input type="file" name="foto" id="uploadImage" style="display: none" accept="image/*" max-size="1000000">
                </div>
                <p style="font-size: 12px; color: #777; margin-top: 10px;">Format: JPG, PNG (Max 1MB)</p>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Image preview functionality
        $('#uploadImage').change(function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    $('#previewImage').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        // Dynamic dropdown functionality
        $('#provinsi').change(function () {
            if ($(this).val() != '') {
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                var provinsiValue = $('#provinsi option:selected').val();

                $.ajax({
                    url: "{{ route('getkota.fetch')}}",
                    method: "POST",
                    data: {
                        select: select,
                        value: value,
                        provinsi: provinsiValue,
                        _token: _token,
                        dependent: dependent
                    },
                    success: function (result) {
                        $('#kota').html(result);
                        $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
                        $('#kelurahan').html('<option value="">Pilih Kelurahan</option>');
                    }
                });
            }
        });

        $('#kota').change(function () {
            if ($(this).val() != '') {
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                var kotaValue = $('#kota option:selected').val();

                $.ajax({
                    url: "{{ route('getkecamatan.fetch')}}",
                    method: "POST",
                    data: {
                        select: select,
                        value: value,
                        kota: kotaValue,
                        _token: _token,
                        dependent: dependent
                    },
                    success: function (result) {
                        $('#kecamatan').html(result);
                        $('#kelurahan').html('<option value="">Pilih Kelurahan</option>');
                    }
                });
            }
        });

        $('#kecamatan').change(function () {
            if ($(this).val() != '') {
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                var kecamatanValue = $('#kecamatan option:selected').val();

                $.ajax({
                    url: "{{ route('getkelurahan.fetch')}}",
                    method: "POST",
                    data: {
                        select: select,
                        value: value,
                        kecamatan: kecamatanValue,
                        _token: _token,
                        dependent: dependent
                    },
                    success: function (result) {
                        $('#kelurahan').html(result);
                    }
                });
            }
        });
    });
</script>
@endsection