<?php

namespace App\Modules\PortalUser\Repositories;

use App\Modules\PortalUser\Models\PortalUser;

class PortalUserRepository
{
    public static function datatable($per_page = 15)
    {
        $data = PortalUser::paginate($per_page);
        return $data;
    }
    public static function get($portaluser_id)
    {
        $portaluser = PortalUser::where('id', $portaluser_id)->first();
        return $portaluser;
    }
    public static function create($portaluser)
    {
        $portaluser = PortalUser::create($portaluser);
        return $portaluser;
    }

    public static function update($portaluser_id, $portaluser)
    {
        PortalUser::where('id', $portaluser_id)->update($portaluser);
        $portaluser = PortalUser::where('id', $portaluser_id)->first();
        return $portaluser;
    }

    public static function delete($portaluser_id)
    {
        $delete = PortalUser::where('id', $portaluser_id)->delete();
        return $delete;
    }
}
