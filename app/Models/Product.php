<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    // Colonnes autorisées à être insérées ou modifiées en Base de données
    protected $fillable = [
        'category_id', 
        'name', 
        'price', 
        'image', 
        'description'
    ];

    /**
     * Relation : Un produit appartient à une seule catégorie.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation : Un produit peut être ajouté à plusieurs réservations (pré-commandes).
     * Passe par la table pivot 'reservation_products'.
     */
    public function reservations(): BelongsToMany
    {
        // 'tables' est le nom de votre table de réservations en BDD
        // On récupère aussi la colonne 'quantity' stockée dans la table pivot
        return $this->belongsToMany(Table::class, 'reservation_products', 'product_id', 'reservation_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}