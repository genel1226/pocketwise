<?php

namespace App\Models\PocketWise;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['user_id', 'name', 'type', 'is_fixed', 'monthly_budget', 'icon', 'color'])]
class Categories extends Model
{
    /** @use HasFactory<\Database\Factories\PocketWise\CategoriesFactory> */
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function getUserNameAttribute()
    // {
    //     return $this->user?->name;
    // }
}
