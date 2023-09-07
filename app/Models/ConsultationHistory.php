<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationHistory extends Model
{
    use HasFactory;

    protected $table = 'consultation_history';

    protected $fillable = [
        'ip',
        'consult'
    ];

    public function scopeCreated($q, $from, $to)
    {
        if(isset($from) && isset($to)) {
            return $q->whereBetween('created_at', [$from, $to]);
        }
    }
}
