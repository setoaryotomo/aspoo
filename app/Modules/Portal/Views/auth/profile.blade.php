@extends('portal_layout.templates')
@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }

    .page-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 10px;
        font-family: 'Roboto', sans-serif;
    }

    .content-box {
        background-color: #f0f0f0;
        padding: 20px;
        border-radius: 10px;
        display: flex;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .form-container {
        padding-right: 20px;
    }

    .profile-box {
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        text-align: center;
        position: relative;
        max-width: 280px;
        margin-bottom: 20px;
    }

    .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: 0 auto;
        object-fit: cover;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        box-sizing: border-box;
        background-color: #fff;
        color: #333;
    }

    .form-label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .change-image {
        font-size: 12px;
        color: #333;
        cursor: pointer;
        margin-top: 10px;
    }

    .save-button {
        background-color: #E1B587;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .save-button:hover {
        background-color: #FBF7EB;
    }

    .upload-button {
        background-color: #E1B587;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .upload-button:hover {
        background-color: #FBF7EB;
    }
</style>
<div class="container mt-5">
    <div class="page-title">Profile Pengguna</div>
    <form method="POST" action="{{ url('/p/profile') }}" enctype="multipart/form-data">
        @csrf
        <div class="content-box row" style="margin-bottom: 70px;">
            <div class="col-md-9 form-container">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" value="{{ $user->username }}" id="username" name="username" placeholder="Username">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" value="{{ $user->name }}" id="nama" name="nama" placeholder="Nama">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" id="email" name="email" placeholder="Email">
                </div>
                <div class="mb-3">
                    <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control" value="{{ $data->telepon }}" id="nomorTelepon" name="telepon" placeholder="Nomor Telepon">
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="provinsi">Pilih Provinsi</label>
                        <select name="provinsi" id="provinsi" class="form-control" data-dependent="provinsi">
                            <option value="">{{ $data->provinsi ? $data->provinsiModel->name : 'Pilih Provinsi' }}</option>
                            @foreach($asal['provinsi'] as $provinsi)
                                <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="kota">Kota / Kabupaten</label>
                        <select name="kota" id="kota" class="form-control dynamic" data-dependent="kota">
                            <option value="">{{ $data->kota ? $data->kotaModel->name : 'Pilih Kota / Kabupaten' }}</option>
                        </select>
                    </div>
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
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Alamat">{{ $data->alamat }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" value="{{ $data->tanggal_lahir }}" id="tanggalLahir" name="tanggal_lahir">
                </div>
                <div class="mb-3">
                    <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select custom-select" id="jenisKelamin" name="jenis_kelamin">
                        <option value="{{ $data->jenis_kelamin }}">{{ $data->jenis_kelamin ?? 'Pilih Jenis Kelamin' }}</option>
                        <option>Laki-Laki</option>
                        <option>Perempuan</option>
                    </select>
                </div>
                <div class="mb-3 text-end">
                    <button type="submit" class="save-button">Simpan</button>
                </div>
            </div>
            <div class="col-md-3 d-flex justify-content-center align-items-center">
                <div class="profile-box">
                    <?php 
                        $foto = $data->foto_readable ?? url('/img/portal/user-icon.png');
                    ?>
                    <img id="previewImage" src="{{ $foto }}" alt="Profile Picture" class="profile-image">
                    <div class="change-image">
                        <label for="uploadImage" class="upload-button">Pilih Gambar</label>
                        <input type="file" name="foto" id="uploadImage" style="display: none" accept="image/*" max-size="1000000">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
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
