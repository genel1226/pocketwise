<?php

namespace App\Models\PocketWise;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'category_id', 'allocated_amount', 'spent_amount', 'month_year'])]
class Envelopes extends Model
{
    /** @use HasFactory<\Database\Factories\PocketWise\EnvelopesFactory> */
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
