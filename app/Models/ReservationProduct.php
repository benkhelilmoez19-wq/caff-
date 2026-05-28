<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationProduct extends Model
{
    // Indique explicitement le nom de la table si Laravel ne la devine pas au pluriel
    protected $table = 'reservation_products';

    // Colonnes autorisées à être remplies lors de la création ou mise à jour
    protected $fillable = [
        'reservation_id',
        'product_id',
        'quantity',
    ];

    /**
     * Relation vers la réservation (votre table 'tables').
     */
    public function reservation(): BelongsTo
    {
        // Si votre modèle de réservation s'appelle Table (ou Reservation), remplacez Table::class ci-dessous
        return $this->belongsTo(Table::class, 'reservation_id');
    }

    /**
     * Relation vers le produit.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}