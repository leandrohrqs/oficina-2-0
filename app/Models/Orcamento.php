<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function seller()
    {
        return $this->belongsTo(Vendedor::class,'id_vendedor');
    }

}
