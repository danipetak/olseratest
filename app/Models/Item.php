<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    use HasFactory;
    protected $table    =   'item';

    public function pajak()
    {
        return $this->hasMany(Pajak::class, 'item_id', 'id')->select("id", "nama", DB::raw("CONCAT(ROUND(rate), '%') as rate")) ;
    }
}
