@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="app">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Module</h6>
            </div>
            <div class="card-body">
                <form ref="menu_form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Nama Module</label>
                                <input v-model="module.name" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Deskripsi Module</label>
                                <input v-model="module.description" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-header">
                <h4 class="card-title">Menu Utama Modul</h6>
            </div>
            <div class="card-body">
                <form ref="menu_form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Nama Menu</label>
                                <input v-model="menu.name" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Path</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon3">/</span>
                                    </div>
                                    <input v-model="menu.path" class="form-control" type="email" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Description</label>
                                <input v-model="menu.description" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Parent</label>
                                <vue-multiselect v-model="menu.parent_id" :searchable="true" :options="menuParents" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-header">
                <div class="row justify-content-between px-3">
                    <h4 class="card-title">Property Modul</h6>
                        <button @click="handleAddPropertyClick" class="btn btn-primary btn-round btn-sm">Tambah
                            Property</button>
                </div>
            </div>
            <div class="card-body">
                <form ref="property_form">
                    <div class="row align-items-center" v-for="(property, index) in properties" :key="index">
                        <div class="form-group">
                            <label class="form-control-label">Nama Properti</label>
                            <input v-model="property.name" class="form-control" type="text">
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-control-label">Label Properti</label>
                                <input v-model="property.label" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-control-label">Tipe Properti</label>
                                <vue-multiselect v-model="property.type" :searchable="true" :options="propertyTypes" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-control-label">Panjang Properti</label>
                                <input v-model="property.length" class="form-control" type="number">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-control-label">Tipe Input</label>
                                <vue-multiselect v-model="property.input_type" :searchable="true"
                                    :options="inputTypes" />
                            </div>
                        </div>
                        <button @click="handleRemovePropertyClick(index)" type="button"
                            class="btn btn-danger btn-rounded btn-icon mr-3 mt-4">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="pb-2 pr-4">
                <div class="d-flex justify-content-end">
                    <button type="button" @click="back" class="btn bg-warning mr-2 text-white">
                        Cancel
                    </button>
                    <button type="button" @click="store" class="btn bg-primary mr-1 text-white">
                        Save Data
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        createApp({
            data() {
                return {
                    module: {
                        name: null,
                        description: null
                    },
                    menu: {
                        name: null,
                        path: null,
                        description: null,
                        parent_id: null
                    },
                    properties: [],
                    menuParents: [{
                        value: null,
                        label: "No Parent"
                    }, ],
                    propertyTypes: [
                        "string",
                        "bigInteger",
                        "integer",
                        "float",
                        "tinyInteger",
                        "smallInteger",
                        "double",
                        "decimal",
                        "text",
                        "longtext",
                        "mediumtext",
                        "date",
                        "dateTime",
                        "timestamp",
                        "time",
                        "boolean",
                        "binary"
                    ],
                    inputTypes: [
                        'INPUT',
                        'INPUT-NUMBER',
                        'CHECKBOX',
                        'PASSWORD',
                        'RADIO',
                        'SELECT',
                        'TEXTAREA'
                    ],
                }
            },
            watch: {
                'module.name'(value) {
                    this.menu.path = value.toLowerCase().split(" ").join("-")
                }
            },
            created() {
                this.fetchMenuParents()
            },
            methods: {
                async fetchMenuParents() {
                    const response = await httpClient.get("{!! url('menu/parents') !!}")
                    this.menuParents = [
                        ...this.menuParents,
                        ...response.data.result.map(el => {
                            return {
                                value: el.id,
                                label: el.name
                            }
                        })
                    ]
                },
                back() {
                    history.back()
                },
                handleAddPropertyClick() {
                    this.properties.push({
                        name: null,
                        label: null,
                        type: null,
                        length: null,
                        input_type: null
                    })
                },
                handleRemovePropertyClick(index) {
                    this.properties.splice(index, 1)
                },
                async store() {
                    const module_payload = this.module;
                    const menu = this.menu;
                    const property = this.properties;
                    const payload = {
                        module: module_payload,
                        menu,
                        property
                    }
                    showLoading()
                    try {
                        const response = await httpClient.post("{!! url('module') !!}", payload)
                        hideLoading()
                        showToast({
                            message: "Berhasil membuat module"
                        })
                        this.back()
                    } catch (err) {
                        hideLoading()
                        const hasResult = Object.keys(err.result).some(key => !!err.result[key]);
                        const result = Object.values(err.result);
                        var messages = "";
                        if(hasResult){
                            result.forEach(el => {
                                messages += el.join('')+"<br>";
                            });
                            err.message = messages;
                        }
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
        }).mount('#app');
    </script>
@endsection
