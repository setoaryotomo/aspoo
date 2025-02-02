<?php

namespace App\Modules\PortalUser\Models;
    
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class PortalUser extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $table = 'users_portal';
    protected $guarded = [];

}