<?php

namespace App\Models\PocketWise;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'name', 'total_amount', 'remaining_amount', 'interest_rate', 'minimum_payment', 'due_date'])]
class Debts extends Model
{
    /** @use HasFactory<\Database\Factories\PocketWise\DebtsFactory> */
    use HasFactory;
}
