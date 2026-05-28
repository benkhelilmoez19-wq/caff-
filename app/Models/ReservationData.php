<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationData extends Model
{
    protected $table = 'reservations_data'; 
    protected $fillable = ['table_number', 'capacity', 'is_available'];
}