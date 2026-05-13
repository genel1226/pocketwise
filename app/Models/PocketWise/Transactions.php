<?php

namespace App\Models\PocketWise;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'category_id', 'envelope_id', 'amount', 'type', 'description', 'date', 'tags', 'receipt_path', 'is_recurring'])]
class Transactions extends Model
{
    /** @use HasFactory<\Database\Factories\PocketWise\TransactionsFactory> */
    use HasFactory;

    protected $casts = [
        'tags' => 'array',
    ];
}
