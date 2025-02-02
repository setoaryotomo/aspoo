<?php

namespace App\Modules\InputSCM\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InputSCM extends Model
{
    use SoftDeletes;
    protected $table = 'input_scm';
    protected $guarded = [];

}