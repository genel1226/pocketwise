<?php

namespace App\Models\PocketWise;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'name', 'target_amount', 'current_amount', 'deadline'])]
class SavingsGoals extends Model
{
    /** @use HasFactory<\Database\Factories\PocketWise\SavingsGoalsFactory> */
    use HasFactory;
}
