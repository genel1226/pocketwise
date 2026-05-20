<?php

namespace App\Models\PocketWise;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'category_id', 'envelope_id', 'amount', 'type', 'description', 'date', 'tags', 'receipt_path', 'is_recurring'])]
class Transactions extends Model
{
    /** @use HasFactory<\Database\Factories\PocketWise\TransactionsFactory> */
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function envelope()
    {
        return $this->belongsTo(Envelopes::class);
    }
}
