<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile_number',
        'ID_card_image',
        'vehicle_number',
        'additional_ID_cards', 
    ];

    protected $casts = [
        'additional_ID_cards' => 'array', // Add this line
    ];
}
