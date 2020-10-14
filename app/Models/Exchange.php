<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    public function currencyFrom()
    {
        return $this->belongsTo('App\Models\Currency', 'from_currency_id', 'id');
    }

    public function currencyTo()
    {
        return $this->belongsTo('App\Models\Currency', 'to_currency_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
