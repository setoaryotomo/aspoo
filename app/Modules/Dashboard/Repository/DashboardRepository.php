<?php

namespace App\Modules\Dashboard\Repository;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\InputSCM\Models\BarangSCM;
use App\Modules\InputSCM\Models\UMKM;
use App\Modules\Komposisi\Models\Komposisi;
use App\Modules\Portal\Model\UserDetail;
use App\Modules\PortalUser\Models\TokoUser;
use App\Modules\TransaksiBarang\Models\TransaksiBarang;
use App\Modules\TransaksiBarang\Models\TransaksiBarangChildren;
use App\Modules\User\Model\UserRoleModel;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Midtrans\Transaction;

class DashboardRepository 
{
    public static function getTanggal($periode){
        $date = date("Y-m-d");
        $periode = strval($periode);
        switch($periode){
            case "7":
                $periode = date("Y-m-d",strtotime("-7 day",strtotime($date)));
                break;
            case "14":
                $periode = date("Y-m-d",strtotime("-14 day",strtotime($date)));
                break;
            case "30":
                $periode = date("Y-m-d",strtotime("-30 day",strtotime($date)));
                break;
            case "all":
                $periode = null;
                break;
            default :
                $periode = null;
                break;
        }
        return $periode;

    }
}