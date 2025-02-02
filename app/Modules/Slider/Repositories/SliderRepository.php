<?php

namespace App\Modules\Slider\Repositories;

use App\Modules\Slider\Models\Slider;

class SliderRepository
{
    public static function datatable($per_page = 15)
    {
        $data = Slider::paginate($per_page);
        return $data;
    }
    public static function get($slider_id)
    {
        $slider = Slider::where('id', $slider_id)->first();
        return $slider;
    }
    public static function create($slider)
    {
        $slider = Slider::create($slider);
        return $slider;
    }

    public static function update($slider_id, $slider)
    {
        Slider::where('id', $slider_id)->update($slider);
        $slider = Slider::where('id', $slider_id)->first();
        return $slider;
    }

    public static function delete($slider_id)
    {
        $delete = Slider::where('id', $slider_id)->delete();
        return $delete;
    }
}
