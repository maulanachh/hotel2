<?php

namespace App\Models\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class asalBooking extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $table = 'ms_stts_asalbooking';
    protected $primaryKey = 'aslbooking_id';
    protected $connection = 'mysql';
    protected $fillable = [
        'aslbooking_name',
        'keterangan',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->deleted_by = Auth::id();
            $model->save();
        });
    }
}
