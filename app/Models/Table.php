<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends Model
{
    protected $table = 'tables';

    protected $fillable = [
        'user_id', 
        'table_id', 
        'reservation_time', 
        'status'
    ];

    /**
     * Relation : Une réservation appartient à un utilisateur (client).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : Une réservation est liée à l'emplacement d'une table physique.
     */
    public function tableData(): BelongsTo
    {
        return $this->belongsTo(ReservationData::class, 'table_id');
    }

    /**
     * CORRIGÉ : Relation HasMany vers ReservationProduct
     */
    public function products(): HasMany
    {
        return $this->hasMany(ReservationProduct::class, 'reservation_id');
    }
}