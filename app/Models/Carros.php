<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carros extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nome_veiculo', 'ano', 'link', 'quilometragem', 'portas', 'cor', 'cambio', 'combustivel'];
}
