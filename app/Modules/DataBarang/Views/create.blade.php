@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner">
        <div id="add-data-barang" class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    
                    @if(isset($specified_user_id))
                    <h4 class="card-title">Tambah Data Barang {{ $umkm->nama }}</h4>
                    {{-- <span class="ml-3 badge badge-info">Untuk User ID: {{ $specified_user_id }}</span> --}}
                    @else
                    <h4 class="card-title">Tambah Data Barang</h4>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <form ref="data_barang_form" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">

                            {{-- pilih barang --}}

                            <div class="form-group" style="margin-bottom: 0.5px">
                                <label class="form-control-label">Foto Produk</label>
                                <div class="custom-file">
                                    <input v-model="barang.foto" type="file" class="custom-file-input" id="customFile" @change="handleFileChange">
                                    <label class="custom-file-label" for="customFile">Pilih file</label>
                                </div>
                                Format: JPG, PNG. Maksimal 2MB
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Kategori Umum *</label>
                                <vue-multiselect 
                                    v-model="barang.kategori_umum" 
                                    :options="kategoriumum_list"
                                    placeholder="Pilih Kategori Umum"
                                    :allow-empty="false"
                                    :searchable="true"
                                    required>
                                </vue-multiselect>
                            </div>

                            {{-- <div class="form-group">
                                <label class="form-control-label">Kategori Umum *</label>
                                <input 
                                    v-model="barang.kategori_umum" 
                                    class="form-control input-with-datalist" 
                                    type="text" 
                                    list="kategoriUmumOptions"
                                    placeholder="Ketik atau pilih kategori umum"
                                    required>
                                <datalist id="kategoriUmumOptions" class="custom-datalist">
                                    <option v-for="option in kategoriumum_list" :value="option.label"></option>
                                </datalist>
                            </div> --}}
                            
                            <div class="form-group">
                                <label class="form-control-label">Kategori Nama *</label>
                                <vue-multiselect 
                                    v-model="barang.kategori_nama" 
                                    :options="kategorinama_list"
                                    placeholder="Pilih Kategori Nama"
                                    :allow-empty="false"
                                    :searchable="true"
                                    required>
                                </vue-multiselect>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Kategori Produk *</label>
                                <vue-multiselect 
                                    v-model="barang.kategori_produk" 
                                    :options="kategoriproduk_list"
                                    placeholder="Pilih Kategori Produk"
                                    :allow-empty="false"
                                    :searchable="true"
                                    required>
                                </vue-multiselect>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-control-label">Jenis Kemasan *</label>
                                <vue-multiselect 
                                    v-model="barang.jenis_kemasan" 
                                    :options="jeniskemasan_list"
                                    placeholder="Pilih Jenis Kemasan"
                                    :allow-empty="false"
                                    :searchable="true"
                                    required>
                                </vue-multiselect>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Produsen</label>
                                <vue-multiselect 
                                    v-model="barang.produsen" 
                                    :options="produsen_list"
                                    placeholder="Pilih Produsen"
                                    :allow-empty="true"
                                    :searchable="true">
                                </vue-multiselect>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Keterangan</label>
                                <textarea class="form-control" v-model="barang.keterangan" rows="3" placeholder="Deskripsi produk"></textarea>
                            </div>

                            

                            <div class="row">
                                <div class="col-md-6" style="display: none">
                                    <div class="form-group">
                                        <label class="form-control-label">Harga Supplier *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input v-model="barang.harga_supplier" class="form-control" type="number" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Harga Umum *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input v-model="barang.harga_umum" class="form-control" type="number" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Berat *</label>
                                        <div class="input-group">
                                            <input v-model="barang.berat" class="form-control" type="number" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">gram</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4" style="display: none">
                                    <div class="form-group">
                                        <label class="form-control-label">Diskon</label>
                                        <div class="input-group">
                                            <input v-model="barang.diskon" class="form-control" type="number">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Stok *</label>
                                        <input v-model="barang.stock_global" class="form-control" type="number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 13px">
                                        <label class="form-control-label">Expired</label>
                                        <input v-model="barang.expired" class="form-control" type="date">
                                    </div>
                                </div>
                                
                            </div>

                            
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 6px">
                                <label class="form-control-label">Nama Barang *</label>
                                <input 
                                    v-model="barang.nama_barang" 
                                    class="form-control input-with-datalist" 
                                    type="text" 
                                    list="namaOptions"
                                    placeholder="Nama Barang"
                                    required>
                                <datalist id="namaOptions" class="custom-datalist">
                                    <option v-for="option in namabarang_list" :value="option.label"></option>
                                </datalist>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Bahan Dasar *</label>
                                <vue-multiselect 
                                    v-model="barang.bahan_dasar" 
                                    :options="bahandasar_list"
                                    placeholder="Pilih Bahan Dasar"
                                    :allow-empty="false"
                                    :searchable="true"
                                    required>
                                </vue-multiselect>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Kekhasan *</label>
                                <vue-multiselect 
                                    v-model="barang.kekhasan" 
                                    :options="kekhasan_list"
                                    placeholder="Pilih Kekhasan"
                                    :allow-empty="false"
                                    :searchable="true"
                                    required>
                                </vue-multiselect>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Basah Kering *</label>
                                <vue-multiselect 
                                    v-model="barang.basah_kering" 
                                    :options="basahkering_list"
                                    placeholder="Pilih Basah/Kering"
                                    :allow-empty="false"
                                    :searchable="true"
                                    required>
                                </vue-multiselect>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Rasa *</label>
                                <vue-multiselect 
                                    v-model="barang.rasa" 
                                    :options="rasa_list"
                                    placeholder="Pilih Rasa"
                                    :allow-empty="false"
                                    :searchable="true"
                                    required>
                                </vue-multiselect>
                            </div>
                            
                            {{-- <div class="form-group">
                                <label class="form-control-label">Bahan Kemasan *</label>
                                <input v-model="barang.bahan_kemasan" class="form-control" type="text" required>
                            </div> --}}
                            <div class="form-group">
                                <label class="form-control-label">Bahan Kemasan *</label>
                                <vue-multiselect 
                                    v-model="barang.bahan_kemasan" 
                                    :options="bahankemasan_list"
                                    placeholder="Pilih Bahan Kemasan"
                                    :searchable="true"
                                    :allow-empty="false"
                                    required>
                                </vue-multiselect>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Info Penting</label>
                                <textarea class="form-control" v-model="barang.info_penting" rows="3" placeholder="Informasi penting tentang produk"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6" style="display: none">
                                    <div class="form-group">
                                        <label class="form-control-label">Satuan *</label>
                                        <vue-multiselect 
                                            v-model="barang.satuan_id" 
                                            :searchable="true" 
                                            :options="satuan_list"
                                            placeholder="Pilih satuan"
                                            required>
                                        </vue-multiselect>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Panjang</label>
                                        <div class="input-group">
                                            <input v-model="barang.panjang" class="form-control" type="number">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Lebar</label>
                                        <div class="input-group">
                                            <input v-model="barang.lebar" class="form-control" type="number">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Tinggi</label>
                                        <div class="input-group">
                                            <input v-model="barang.tinggi" class="form-control" type="number">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Available</label>
                                    <vue-multiselect 
                                        v-model="barang.available" 
                                        :options="availableOptions"
                                        :allow-empty="false"
                                        required>
                                    </vue-multiselect>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group" style="">
                                    <label class="form-control-label">Pilih Barang</label>
                                    <vue-multiselect 
                                        v-model="barang.scm_barang_id" 
                                        :options="barang_list"
                                        placeholder="Pilih Barang"
                                        :allow-empty="true"
                                        :searchable="true">
                                    </vue-multiselect>
                                </div>
                            </div>
                        </div>

                            <div class="row" style="display: none">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Panjang</label>
                                        <div class="input-group">
                                            <input v-model="barang.panjang" class="form-control" type="number">
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Lebar</label>
                                        <div class="input-group">
                                            <input v-model="barang.lebar" class="form-control" type="number">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Tinggi</label>
                                        <div class="input-group">
                                            <input v-model="barang.tinggi" class="form-control" type="number">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" @click="back" class="btn btn-sm bg-warning mr-2 text-white">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </button>
                        <button type="button" @click="store" class="btn btn-sm bg-primary mr-2 text-white">
                            <i class="fas fa-save mr-1"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        Vue.createApp({
            data() {
                return {
                    barang: {
                        satuan_id: null,
                        berat: null,
                        available: 'Yes',
                        diskon: 0,
                        harga_supplier: 0,
                        @if(isset($specified_user_id))
                        created_by_user_id: {{ $specified_user_id }},
                        @endif
                    },
                    produsen_list: [],
                    kategoriumum_list:[],
                    kategorinama_list:[],
                    kategoriproduk_list:[],
                    rasa_list:[],
                    jeniskemasan_list:[],
                    bahandasar_list:[],
                    kekhasan_list:[],
                    basahkering_list:[],
                    bahankemasan_list:[],
                    namabarang_list:[],
                    barang_list: [],
                    satuan_list: [],
                    
                    // Options for dropdowns
                    // kategoriUmumOptions: ['Makanan', 'Minuman', 'Snack', 'Kue', 'Rempah', 'Buah', 'Sayur', 'Daging'],
                    // kategoriUmumOptions: ['Abon', 'biskuit', 'Bubuk', 'Bubuk wedang', 'Cookies', 'jenang', 'kacang', 'kentang', 'keripik', 'kerupuk', 'kue', 'Kwaci', 'Minuman', 'Minuman Serbuk', 'Olahan Ikan', 'sambal', 'sari buah', 'Serundeng', 'sirup', 'snack', 'Tahu Bakso', 'talam', 'tape ketan', 'teh', 'telor asin', 'test'],

                    // kategoriNamaOptions: ['Tradisional', 'Modern', 'Impor', 'Lokal', 'Organik', 'Khusus'],
                    // kategoriUmumOptions: ['Abon', 'Abon Ayam', 'Abon Bandeng', 'Abon Ikan', 'Abon Sapi', 'Amplang', 'Ampyang', 'Apple Pie', 'Aromanis', 'Ayam', 'Bajigur', 'Bakpia', 'Bakpia Kukus', 'Bakpia Ubi', 'Bakso', 'Bakso Goreng (Basreng)', 'Balung Kethek', 'Banana Cookies', 'Banana Roll', 'Bandeng', 'Bandeng Kropok', 'Bandeng Presto', 'Bandrek', 'Bangket', 'Banquet', 'Bawang Goreng', 'Begelan', 'Belinjo', 'Belut', 'Bolen', 'Bolu', 'Brambang', 'Brem', 'Brownies', 'Bumbu', 'Butter Cookies', 'Carica', 'Ceker Ayam', 'Cendol', 'Cheese Stick', 'Chiffon Cake', 'Cimol', 'Cincau', 'Coklat', 'Combro', 'Cookies', 'Cuangki', 'Dendeng', 'Dodol', 'Dollar', 'Dollar Wijen', 'Donat', 'Eggrolls', 'Empal Gepuk', 'Emping', 'Enting Enting Kacang', 'Enting Enting Mlinjo', 'Enting Enting Wijen', 'Enting-Enting', 'Fish Skin', 'Gam', 'Ganep', 'Gapit', 'Gemblong', 'Gembus', 'Gendar', 'Geplak', 'Gethuk', 'Gudeg', 'Gula Aren', 'Iga Sapi', 'Ikan Layur', 'Jahe', 'Jamu', 'Jamur', 'Jenang', 'Jipang', 'Kacang', 'Kacang Atom', 'Kacang Bali', 'Kacang Bangkok', 'Kacang Bawang', 'Kacang Kapri', 'Kacang Kedelai', 'Kacang Koro', 'Kacang Mete', 'Kacang Telur', 'Karak', 'Kastengel', 'Kecap', 'Kecipir', 'Keciput', 'Kembang Goyang', 'Kering Kentang', 'Keripik', 'Keripik Bekicot', 'Keripik Beling', 'Keripik Jamur', 'Keripik Singkong', 'Keripik Wader', 'Kerupuk', 'Kerupuk Bakso', 'Kerupuk Bandeng', 'Kerupuk Bawang', 'Kerupuk Belitung', 'Kerupuk Beras', 'Kerupuk Buah Naga', 'Kerupuk Cakar', 'Kerupuk Cipir', 'Kerupuk Cumi', 'Kerupuk Dele', 'Kerupuk Gendar', 'Kerupuk Gethuk', 'Kerupuk Ikan', 'Kerupuk Jamur', 'Kerupuk Jengkol', 'Kerupuk Kaca', 'Kerupuk Keju', 'Kerupuk Kemplang', 'Kerupuk Kentang', 'Kerupuk Kuku Macan', 'Kerupuk Kulit', 'Kerupuk Lombok', 'Kerupuk Mangga', 'Kerupuk Paru', 'Kerupuk Pedas', 'Kerupuk Puli', 'Kerupuk Rambak', 'Kerupuk Seblak', 'Kerupuk Singkong', 'Kerupuk Stik', 'Kerupuk Tahu', 'Kerupuk Tengiri', 'Kerupuk Tongkol', 'Kerupuk Udang', 'Kerupuk Urat', 'Kletikan', 'Kopi', 'Krasikan', 'Kremesan', 'Kripik', 'Kripik Anggur', 'Kripik Apel', 'Kripik Bakso', 'Kripik Bawang', 'Kripik Bayam', 'Kripik Belut', 'Kripik Brownies', 'Kripik Buah Naga', 'Kripik Cakar', 'Kripik Carica', 'Kripik Ceker', 'Kripik Cimol', 'Kripik Cireng', 'Kripik Cumi', 'Kripik Daun Kangkung', 'Kripik Daun Kenikir', 'Kripik Durian', 'Kripik Gadung', 'Kripik Gembus', 'Kripik Gethuk', 'Kripik Iga', 'Kripik Ikan', 'Kripik Jagung', 'Kripik Jamur', 'Kripik Kaca', 'Kripik Kacang', 'Kripik Kentang', 'Kripik Kulit Ayam', 'Kripik Kulit Ikan', 'Kripik Labu', 'Kripik Layur', 'Kripik Lele', 'Kripik Maicih', 'Kripik Mangga', 'Kripik Melon', 'Kripik Nanas', 'Kripik Nangka', 'Kripik Nuget', 'Kripik Pangsit', 'Kripik Pare', 'Kripik Paru', 'Kripik Pegagan', 'Kripik Pete', 'Kripik Pisang', 'Kripik Salak', 'Kripik Sawi', 'Kripik Singkong', 'Kripik Sukun', 'Kripik Tahu', 'Kripik Talas', 'Kripik Tela', 'Kripik Tembolok', 'Kripik Tempe', 'Kripik Tulang', 'Kripik Ubi', 'Kripik Udang', 'Kripik Usus', 'Kripik Daun Singkong', 'Kripik Singkong', 'Krupuk Intip', 'Kue', 'Kue Blinjo', 'Kue Jahe', 'Kue Kacang', 'Kue Kapit', 'Kue Kelapa', 'Kue Keranjang', 'Kue Kering', 'Kue Pia', 'Kue Pie', 'Kunyit Asem', 'Kuping Gajah', 'Kwaci', 'Lanting', 'Lapis Legit', 'Ledre', 'Lidah Kucing', 'Lontong', 'Lumpia', 'Madu', 'Madu Mongso', 'Makaroni', 'Manisan', 'Marning', 'Mete', 'Mie Keju', 'Mie Lidi', 'Mie Ongklok', 'Minuman', 'Moaci', 'Moci', 'Nastar', 'Nopia', 'Onde Onde', 'Opak', 'Otak Otak', 'Pangsit', 'Pare', 'Paru', 'Pastel', 'Permen', 'Petis', 'Peyek', 'Pia', 'Pie', 'Pilus', 'Popcorn', 'Proll', 'Putri Salju', 'Rambak', 'Rambut Nenek', 'Rempelo', 'Rempeyek', 'Rendang', 'Rengginang', 'Resoles', 'Rolade', 'Roll Cake', 'Rollcake', 'Roti', 'Rumput Laut', 'Sagon', 'Sagu Keju', 'Sale Pisang', 'Sambal', 'Sambal Petis', 'Sarang Madu', 'Satru', 'Sawala', 'Seblak', 'Sekoteng', 'Selondok', 'Sempe', 'Semprit', 'Semprong', 'Serbat', 'Serbuk Jahe', 'Serundeng', 'Singkong', 'Sirup Jahe', 'Sirup Kawista', 'Sirup Temu Lawak', 'Sirup Tjampolay', 'Slondok', 'Snack', 'Soes', 'Soes Ayam', 'Soes Coklat', 'Soes Keju', 'Soes Kering', 'Soft Cookies', 'Spikoe', 'Stik', 'Sumpia', 'Sus Kering', 'Tahu', 'Tahu Bakso', 'Tahu Bulat', 'Talam', 'Tape Ketan', 'Tau Sa Ko', 'Teh', 'Telor Asin', 'Tempe Keripik', 'Tempe Sagu', 'Temulawak', 'Tengiri', 'Terasi', 'Test', 'Timus', 'Tiwul', 'Tradisional', 'Tumpi', 'Untir Untir', 'Wajik', 'Wajit', 'Walangan', 'Wedang Bajigur', 'Wedang Bandrek', 'Wedang Canting', 'Wedang Jahe', 'Wedang Jambos', 'Wedang Jogja', 'Wedang Plethok', 'Wedang Ronde', 'Wedang Secang', 'Wedang Serai', 'Wedang Sinom', 'Wedang Telang', 'Wedang Uwuh', 'Widaran', 'Wingko', 'Yangko'],
                    // kategoriNamaOptions: ['Abon', 'Abon ayam', 'Abon bandeng', 'Abon ikan', 'Abon sapi', 'Amplang', 'Ampyang', 'Apple Pie', 'Aromanis', 'Ayam', 'Bajigur', 'Bakpia', 'Bakpia Kukus', 'Bakpia ubi', 'Bakso', 'Bakso Goreng (basreng)', 'balung kethek', 'Banana Cookies', 'Banana Roll', 'Bandeng', 'Bandeng kropok', 'Bandeng Presto', 'Bandrek', 'Bangket', 'Banquet', 'Bawang Goreng', 'Begelan', 'Belinjo', 'Belut', 'Bolen', 'Bolu', 'Brambang', 'Brem', 'Brownies', 'Bumbu', 'Butter Cookies', 'carica', 'Ceker Ayam', 'Cendol', 'Cheese Stick', 'Chiffon Cake', 'Cimol', 'Cincau', 'Coklat', 'combro', 'Cookies', 'Cuangki', 'Dendeng', 'Dodol', 'Dollar', 'Dollar Wijen', 'Donat', 'Eggrolls', 'Empal Gepuk', 'Emping', 'Enting enting kacang', 'Enting enting Mlinjo', 'Enting enting Wijen', 'Enting-Enting', 'Fish Skin', 'Gam', 'Ganep', 'Gapit', 'Gemblong', 'Gembus', 'Gendar', 'Geplak', 'Gethuk', 'Gudeg', 'Gula Aren', 'Iga Sapi', 'Ikan Layur', 'Jahe', 'Jamu', 'Jamur', 'Jenang', 'Jipang', 'kacang', 'kacang atom', 'kacang bali', 'kacang bangkok', 'kacang bawang', 'kacang kapri', 'Kacang kedelai', 'kacang koro', 'Kacang Mete', 'kacang telur', 'Karak', 'Kastengel', 'Kecap', 'Kecipir', 'keciput', 'kembang goyang', 'kering kentang', 'Keripik', 'keripik bekicot', 'keripik beling', 'keripik jamur', 'Keripik singkong', 'Keripik wader', 'Kerupuk', 'kerupuk bakso', 'kerupuk bandeng', 'kerupuk bawang', 'Kerupuk belitung', 'kerupuk beras', 'kerupuk buah naga', 'kerupuk cakar', 'Kerupuk cipir', 'kerupuk cumi', 'kerupuk dele', 'kerupuk gendar', 'kerupuk gethuk', 'kerupuk ikan', 'kerupuk jamur', 'kerupuk jengkol', 'kerupuk kaca', 'Kerupuk keju', 'Kerupuk kemplang', 'kerupuk kentang', 'kerupuk kuku macan', 'Kerupuk kulit', 'kerupuk lombok', 'kerupuk mangga', 'Kerupuk paru', 'kerupuk pedas', 'kerupuk puli', 'kerupuk rambak', 'Kerupuk seblak', 'kerupuk singkong', 'Kerupuk stik', 'kerupuk tahu', 'kerupuk tengiri', 'kerupuk tongkol', 'kerupuk udang', 'kerupuk urat', 'Kletikan', 'Kopi', 'Krasikan', 'Kremesan', 'kripik', 'Kripik anggur', 'Kripik apel', 'Kripik bakso', 'kripik bawang', 'kripik bayam', 'kripik belut', 'kripik brownies', 'kripik buah naga', 'Kripik cakar', 'kripik carica', 'kripik ceker', 'kripik cimol', 'kripik cireng', 'kripik cumi', 'kripik daun kangkung', 'kripik daun kenikir', 'kripik durian', 'kripik gadung', 'kripik gembus', 'Kripik gethuk', 'Kripik iga', 'Kripik ikan', 'Kripik jagung', 'Kripik jamur', 'kripik kaca', 'kripik kacang', 'kripik kentang', 'kripik kulit ayam', 'Kripik kulit ikan', 'kripik labu', 'Kripik layur', 'kripik lele', 'kripik maicih', 'kripik mangga', 'kripik melon', 'Kripik nanas', 'Kripik nangka', 'kripik nuget', 'kripik pangsit', 'Kripik pare', 'Kripik paru', 'kripik pegagan', 'kripik pete', 'kripik pisang', 'kripik salak', 'kripik sawi', 'kripik singkong', 'kripik sukun', 'Kripik tahu', 'Kripik talas', 'kripik tela', 'kripik tembolok', 'kripik tempe', 'kripik tulang', 'kripik ubi', 'kripik udang', 'kripik usus', 'kripk daun singkong', 'krpik singkong', 'krupuk intip', 'Kue', 'Kue Blinjo', 'kue jahe', 'kue kacang', 'Kue Kapit', 'kue kelapa', 'kue keranjang', 'Kue Kering', 'Kue Pia', 'Kue Pie', 'Kunyit Asem', 'kuping gajah', 'Kwaci', 'lanting', 'Lapis Legit', 'Ledre', 'lidah kucing', 'Lontong', 'Lumpia', 'Madu', 'Madu Mongso', 'Makaroni', 'Manisan', 'Marning', 'Mete', 'Mie Keju', 'Mie Lidi', 'mie ongklok', 'Minuman', 'Moaci', 'moci', 'Nastar', 'Nopia', 'Onde Onde', 'Opak', 'otak otak', 'pangsit', 'pare', 'paru', 'Pastel', 'Permen', 'Petis', 'peyek', 'Pia', 'Pie', 'Pilus', 'Popcorn', 'Proll', 'Putri Salju', 'Rambak', 'rambut nenek', 'rempelo', 'rempeyek', 'Rendang', 'Rengginang', 'Resoles', 'rolade', 'Roll Cake', 'Rollcake', 'Roti', 'Rumput Laut', 'Sagon', 'sagu keju', 'Sale Pisang', 'Sambal', 'sambal petis', 'Sarang Madu', 'satru', 'Sawala', 'seblak', 'Sekoteng', 'Selondok', 'sempe', 'Semprit', 'semprong', 'Serbat', 'Serbuk Jahe', 'Serundeng', 'Singkong', 'sirup jahe', 'sirup kawista', 'sirup temu lawak', 'Sirup Tjampolay', 'Slondok', 'Snack', 'Soes', 'Soes Ayam', 'Soes Coklat', 'Soes Keju', 'Soes Kering', 'Soft Cookies', 'Spikoe', 'Stik', 'Sumpia', 'Sus Kering', 'Tahu', 'Tahu Bakso', 'Tahu Bulat', 'talam', 'tape ketan', 'Tau Sa Ko', 'teh', 'Telor Asin', 'tempe keripik', 'tempe sagu', 'Temulawak', 'tengiri', 'Terasi', 'test', 'timus', 'tiwul', 'Tradisional', 'tumpi', 'untir untir', 'Wajik', 'Wajit', 'walangan', 'Wedang  Bajigur', 'Wedang Bandrek', 'Wedang Canting', 'Wedang Jahe', 'Wedang Jambos', 'Wedang Jogja', 'Wedang Plethok', 'Wedang Ronde', 'Wedang Secang', 'Wedang Serai', 'Wedang Sinom', 'Wedang Telang', 'Wedang Uwuh', 'Widaran', 'Wingko', 'Yangko'],
                    
                    // kategoriProdukOptions: ['Siap Saji', 'Bahan Mentah', 'Bahan Olahan', 'Kemasan', 'Bulk'],
                    // kategoriProdukOptions: ['Beverage', 'food snack', 'minuman', 'Siap Saji'],
                    
                    // rasaOptions: ['Manis', 'Asin', 'Pedas', 'Asam', 'Gurih', 'Netral', 'Pahit'],
                    // rasaOptions: ['Asam', 'Asin', 'Coklat', 'Durian', 'Gurih', 'Gurih, Manis', 'Keju', 'Kopi', 'Manis', 'Mix', 'Pahit', 'Pedas', 'Rempah', 'test', 'Tiramisu'],

                    // jenisKemasanOptions: ['Plastik', 'Kaleng', 'Kardus', 'Botol', 'Jarum', 'Vakum', 'Dus'],
                    // jenisKemasanOptions: ['Box', 'Bungkusan', 'Goodie Bag','kardus','Press Pouch','Standing Pouch','test','Toples'],

                    // bahanDasarOptions: ['Tepung', 'Gula', 'Gandum', 'Beras', 'Daging', 'Sayuran', 'Buah', 'Susu', 'Telur'],
                    // bahanDasarOptions: ['Almond', 'Anggur', 'Apel', 'Apel, Coklat', 'Asam', 'Asem', 'Ayam', 'bakso', 'bakso, jamur', 'Bandeng', 'Bawang', 'Bawang Bombai', 'Bawang Merah', 'Bawang Putih', 'bayam', 'Bekicot', 'Belinjo', 'Belut', 'Beras', 'Beras Ketan', 'Beras/beras ketan', 'Blinjo', 'Buah', 'Buah Naga', 'Buah Naga Putih', 'Bubuk Temulawak', 'Cabe', 'cakar ayam', 'Carica', 'Ceker ', 'ceker ayam', 'Cincau ', 'Coklat', 'Coklat, almond', 'coklat, kacang', 'Coklat, Kurma ', 'Cumi', 'cumi cumi', 'Cumi-Cumi', 'Daging', 'daging ayam', 'Daging Sapi', 'Daging Sapi/Ayam', 'daun kenikir', 'Daun Pegagan', 'Daun serai', 'daun singkong', 'Daun Sinom', 'Daun telang', 'Durian', 'Gembus', 'Green Tea', 'Gula Aren', 'Gula Palem', 'gula pasir', 'Gula, kacang', 'iga sapi', 'Ikan', 'Ikan Bandeng', 'Ikan Layur', 'Ikan Lele', 'ikan nila', 'ikan tenggiri', 'ikan tengiri', 'ikan tongkol', 'Ikan Wader', 'Jagung', 'Jahe', 'Jahe Merah', 'Jahe, kencur', 'Jahe, serai, apel', 'Jahe, Sereh, Uwuh', 'Jamur', 'Jamur Kancing', 'jamur kuping', 'jamur tiram', 'Jenang', 'jengkol', 'Kacang', 'Kacang gajah ', 'kacang hijau', 'kacang tanah', 'Kacang tepung', 'Kacang Trembesi ', 'Kakao', 'Kaldu Ayam', 'kangkung', 'kapri', 'Kawista', 'kayu secang', 'Kedelai', 'Keju', 'kelapa', 'Kelapa Parut', 'Kencur', 'Kenikir', 'kentang ', 'Kerak Nasi', 'Kerupuk Bawang', 'Ketan', 'Ketan hitam', 'Ketan Putih/Hitam', 'Ketela', 'kopi', 'Koro', 'kulit ayam', 'Kulit Ikan', 'kulit ikan kakap', 'kulit ikan patin', 'Kulit Sapi ', 'Kulit sapi/kerbau', 'kulit tahu', 'Kuncup Teh Hitam', 'kwaci', 'labu', 'Labu Kuning', 'Mangga', 'melon', 'Mete', 'Mlinjo', 'nanas', 'Nangka', 'Nasi ', 'Nasi/beras', 'Nira Kelapa', 'Oat, kacang-kacangan', 'pare', 'Paru', 'paru sapi', 'Parutan kelapa, jahe', 'petai', 'petis', 'Pisang', 'Pisang, biji-bijian', 'Pisang, minyak kelapa', 'Rambak', 'Rempah', 'Rempah-rempah', 'salak', 'Sari Ayam Kampung', 'Sari Jahe', 'Sari Ketan Hitam', 'sawi', 'Siingkong', 'Singkong', 'Singkong keju', 'singkong kering', 'Singkong, kentang', 'Singkong, udang', 'Sirsak', 'sukun', 'Tahu', 'talas', 'Tape ', 'Tape Ketan', 'tape, Coklat', 'tape, sirsak', 'Tapioka', 'Tapioka, keju', 'Tapioka, singkong', 'tela', 'Tela ungu', 'telo ungu', 'telur bebek', 'Tempe', 'Temulawak', 'Tepun, pisang, coklat', 'Tepung', 'Tepung Almond', 'tepung beras', 'Tepung beras ketan', 'Tepung beras, tapioka', 'Tepung Gandum', 'Tepung Garut', 'Tepung Ketan', 'Tepung ketan, pisang', 'tepung ketan, salak', 'Tepung Protein, Maizena', 'Tepung Singkong', 'Tepung Tapioka', 'Tepung tapioka/sagu', 'tepung terigu', 'Tepung Terigu, Almond', 'Tepung Terigu, Kacang', 'Tepung Terigu, keju', 'Tepung Teriigu', 'tepung trigu', 'Tepung, almond', 'Tepung, coklat', 'Tepung, Daging', 'Tepung, Ikan', 'Tepung, jahe', 'tepung, keju', 'Tepung, pisang', 'Tepung, sari udang', 'Teri', 'Terigu', 'test', 'tulang iga', 'ubi', 'Ubi gadung', 'Ubi Jalar', 'ubi talas', 'Ubi ungu', 'Udang', 'Udang Rebon', 'Udang, ikan tenggiri', 'umbi gadung ', 'urat sapi', 'usus', 'Usus Ayam ', 'Wijen'],
                    
                    // kekhasanOptions: ['Halal', 'Non-Halal', 'Vegetarian', 'Vegan', 'Gluten-Free', 'Organik', 'Non-MSG'],
                    // kekhasanOptions: ['Semarang','Solo','N/A'],
                    
                    // basahKeringOptions: ['Basah', 'Kering', 'Semi Basah', 'Cair'],
                    // basahKeringOptions: ['Basah', 'Kering', 'Semi Basah', 'Cair','Serbuk'],
                    // bahanKemasanOptions: ['kardus','Karton','kertas','Metalized','Plastik'],

                    availableOptions: ['Yes','No'],
                    
                    path: null,
                    name: null,
                    @if(isset($specified_user_id))
                    isUserSpecific: true,
                    specifiedUserId: {{ $specified_user_id }},
                    @else
                    isUserSpecific: false,
                    specifiedUserId: null,
                    @endif
                }
            },
            created() {
                this.fetchProdusenList(),
                this.fetchKategoriumumList(),
                this.fetchKategorinamaList(),
                this.fetchKategoriprodukList(),
                this.fetchRasaList(),
                this.fetchJeniskemasanList(),
                this.fetchBahandasarList(),
                this.fetchKekhasanList(),
                this.fetchBasahkeringList(),
                this.fetchBahankemasanList(),
                this.fetchNamabarangList(),
                this.fetchBarangList(),
                this.fetchSatuanList().then(() => {
                // Set default satuan to "Gram" after fetching satuan_list
                const gramOption = this.satuan_list.find(satuan => satuan.label.toLowerCase() === 'gram');
                if (gramOption) {
                    this.barang.satuan_id = gramOption.value;
                }
            });
            },
            watch: {
                "barang.scm_barang_id": {
                    handler: function(value) {
                        let barang_data = this.barang_list.find(barang_item => barang_item.value == value)
                        this.path = `${barang_data.label.toLowerCase().split(" ").join("-")}`
                        if (this.name != null && this.name != "") {
                            this.path += `/${this.name.toLowerCase().split(" ").join("-")}`
                        }
                        this.barang.scm_barang_id = value
                        console.log(this.barang)
                    },
                    deep: true,
                },
                // "barang.produsen": {
                //     handler: function(value) {
                //         let barang_data = this.produsen_list.find(barang_item => barang_item.value == value)
                //         this.path = `${barang_data.label.toLowerCase().split(" ").join("-")}`
                //         if (this.name != null && this.name != "") {
                //             this.path += `/${this.name.toLowerCase().split(" ").join("-")}`
                //         }
                //         this.barang.produsen = value
                //         console.log(this.barang)
                //     },
                //     deep: true,
                // },
                "barang.satuan_id": {
                    handler: function(value) {
                        let satuan_data = this.satuan_list.find(satuan_item => satuan_item.value == value)
                        this.path = `${satuan_data.label.toLowerCase().split(" ").join("-")}`
                        if (this.name != null && this.name != "") {
                            this.path += `/${this.name.toLowerCase().split(" ").join("-")}`
                        }
                        this.barang.satuan_id = value
                        console.log(this.barang)
                    },
                    deep: true,
                },
            },
            methods: {
                handleFileChange(event) {
                    this.barang.foto = event.target.files[0];
                    if (this.barang.foto) {
                        const label = event.target.nextElementSibling;
                        label.textContent = this.barang.foto.name;
                    }
                },
                async fetchBarangList() {
                    const response = await httpClient.get("{!! url('data-barang/all') !!}")
                    this.barang_list = [
                        ...this.barang_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.id,
                                label: `ID: ${el.id} - ${el.nama_barang}`
                            }
                        })
                    ]
                },
                async fetchNamabarangList() {
                    const response = await httpClient.get("{!! url('data-barang/all') !!}")
                    this.namabarang_list = [
                        ...this.namabarang_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.nama_barang,
                                label: el.nama_barang
                            }
                        })
                    ]
                },
                async fetchProdusenList() {
                    const response = await httpClient.get("{!! url('data-barang/produsenall') !!}")
                    this.produsen_list = [
                        ...this.produsen_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.produsen,
                                label: el.produsen
                            }
                        })
                    ]
                },
                async fetchKategoriumumList() {
                    const response = await httpClient.get("{!! url('data-barang/kategoriumumall') !!}")
                    this.kategoriumum_list = [
                        ...this.kategoriumum_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.kategori_umum,
                                label: el.kategori_umum
                            }
                        })
                    ]
                },
                async fetchKategorinamaList() {
                    const response = await httpClient.get("{!! url('data-barang/kategorinamaall') !!}")
                    this.kategorinama_list = [
                        ...this.kategorinama_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.kategori_nama,
                                label: el.kategori_nama
                            }
                        })
                    ]
                },
                async fetchKategoriprodukList() {
                    const response = await httpClient.get("{!! url('data-barang/kategoriprodukall') !!}")
                    this.kategoriproduk_list = [
                        ...this.kategoriproduk_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.kategori_produk,
                                label: el.kategori_produk
                            }
                        })
                    ]
                },
                async fetchRasaList() {
                    const response = await httpClient.get("{!! url('data-barang/rasaall') !!}")
                    this.rasa_list = [
                        ...this.rasa_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.rasa,
                                label: el.rasa
                            }
                        })
                    ]
                },
                async fetchJeniskemasanList() {
                    const response = await httpClient.get("{!! url('data-barang/jeniskemasanall') !!}")
                    this.jeniskemasan_list = [
                        ...this.jeniskemasan_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.jenis_kemasan,
                                label: el.jenis_kemasan
                            }
                        })
                    ]
                },
                async fetchBahandasarList() {
                    const response = await httpClient.get("{!! url('data-barang/bahandasarall') !!}")
                    this.bahandasar_list = [
                        ...this.bahandasar_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.bahan_dasar,
                                label: el.bahan_dasar
                            }
                        })
                    ]
                },
                async fetchKekhasanList() {
                    const response = await httpClient.get("{!! url('data-barang/kekhasanall') !!}")
                    this.kekhasan_list = [
                        ...this.kekhasan_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.kekhasan,
                                label: el.kekhasan
                            }
                        })
                    ]
                },
                async fetchBasahkeringList() {
                    const response = await httpClient.get("{!! url('data-barang/basahkeringall') !!}")
                    this.basahkering_list = [
                        ...this.basahkering_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.basah_kering,
                                label: el.basah_kering
                            }
                        })
                    ]
                },
                async fetchBahankemasanList() {
                    const response = await httpClient.get("{!! url('data-barang/bahankemasanall') !!}")
                    this.bahankemasan_list = [
                        ...this.bahankemasan_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.bahan_kemasan,
                                label: el.bahan_kemasan
                            }
                        })
                    ]
                },

                async fetchSatuanList() {
                    const response = await httpClient.get("{!! url('satuan/all') !!}")
                    this.satuan_list = [
                        ...this.satuan_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.id,
                                label: el.satuan_nama
                            }
                        })
                    ]
                },
                back() {
                    history.back()
                },
                resetForm() {
                    this.barang = {}
                    this.$refs.data_barang_form.reset()
                },
                async store() {
                    const barangFormData = new FormData()
                    Object.keys(this.barang).forEach(key => {
                        barangFormData.append(key, this.barang[key])
                    });

                    try {
                        showLoading()
                            let url = "{!! url('data-barang') !!}";
                            
                            if (this.isUserSpecific) {
                                url = `{!! url('data-barang') !!}/${this.specifiedUserId}/create`;
                            }
                            
                            const response = await httpClient.post(url, barangFormData)
                            hideLoading()
                            showToast({
                                message: "Data berhasil ditambahkan"
                            })
                            this.resetForm()
                            history.back()
                    } catch (err) {
                        hideLoading()
                        showToast({
                            message: err.message,
                            type: 'error'
                        })
                    }
                }
            },
            components: {
                'vue-multiselect': VueformMultiselect
            },
        }).mount("#add-data-barang")
    </script>

    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-control-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .custom-file-label::after {
            content: "Browse";
        }
        .multiselect {
            min-height: 38px;
        }
        .multiselect__tags {
            min-height: 38px;
            border-radius: 4px;
            border: 1px solid #ced4da;
        }
        .btn {
            padding: 0.375rem 1rem;
            font-weight: 500;
            border-radius: 4px;
        }
        textarea.form-control {
            min-height: 100px;
        }
    </style>
@endsection