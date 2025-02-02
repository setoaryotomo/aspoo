<?php 
namespace App\Providers;

/**
* ServiceProvider
*
*/
class ModuleViewServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     *
     *
     * 
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../Modules/Employee/Views', 'Employee');
        $this->loadViewsFrom(__DIR__.'/../Modules/Dashboard/Views', 'Dashboard');
        $this->loadViewsFrom(__DIR__.'/../Modules/Menu/Views', 'Menu');
        $this->loadViewsFrom(__DIR__.'/../Modules/User/Views', 'User');
        $this->loadViewsFrom(__DIR__.'/../Modules/Role/Views', 'Role');
        $this->loadViewsFrom(__DIR__.'/../Modules/Permission/Views', 'Permission');
        $this->loadViewsFrom(__DIR__.'/../Modules/Module/Views', 'Module');

        $this->loadViewsFrom(__DIR__.'/../Modules/Penjualan/Views', 'Penjualan');
        $this->loadViewsFrom(__DIR__.'/../Modules/DataBarang/Views', 'DataBarang');
        $this->loadViewsFrom(__DIR__.'/../Modules/Diskon/Views', 'Diskon');
        $this->loadViewsFrom(__DIR__.'/../Modules/Pembelian/Views', 'Pembelian');
        $this->loadViewsFrom(__DIR__.'/../Modules/Satuan/Views', 'Satuan');
        $this->loadViewsFrom(__DIR__.'/../Modules/Portal/Views', 'Portal');
        $this->loadViewsFrom(__DIR__.'/../Modules/InputSCM/Views', 'InputSCM');
        $this->loadViewsFrom(__DIR__.'/../Modules/PortalUser/Views', 'PortalUser');
        $this->loadViewsFrom(__DIR__.'/../Modules/Slider/Views', 'Slider');
        $this->loadViewsFrom(__DIR__.'/../Modules/KategoriProduk/Views', 'KategoriProduk');
        $this->loadViewsFrom(__DIR__.'/../Modules/Keranjang/Views', 'Keranjang');
        $this->loadViewsFrom(__DIR__.'/../Modules/TransaksiBarang/Views', 'TransaksiBarang');
        $this->loadViewsFrom(__DIR__.'/../Modules/ApproveUser/Views', 'ApproveUser');
        $this->loadViewsFrom(__DIR__.'/../Modules/ApproveTransaksi/Views', 'ApproveTransaksi');
        $this->loadViewsFrom(__DIR__.'/../Modules/ValidasiTransaksi/Views', 'ValidasiTransaksi');
        $this->loadViewsFrom(__DIR__.'/../Modules/KirimBarang/Views', 'KirimBarang');
        $this->loadViewsFrom(__DIR__.'/../Modules/Komposisi/Views', 'Komposisi');
        $this->loadViewsFrom(__DIR__.'/../Modules/MasterUMKM/Views', 'MasterUMKM');
        $this->loadViewsFrom(__DIR__.'/../Modules/permintaanparcel/Views', 'permintaanparcel');
        
        // VIEW_MARKER
        // Add view in the line below (DONT REMOVE THIS SECTION !!!!!!, because this line is LINE_MARKER used by Module Generator)
    }
}