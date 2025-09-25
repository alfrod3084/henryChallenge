<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table = "rule";
    protected $primaryKey = "id_rule";

    protected $fillable = [
        'actions',
        'status'
    ];
}
