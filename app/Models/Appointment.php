<?php

namespace App\Models;

use App\Traits\StateMachine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    Use StateMachine;

    protected $table = "appointment";
    protected $primaryKey = "id_appointment";

    protected $fillable = [
        'title',
        'id_patient',
        'id_location',
        'status'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'id_patient', 'id_patient');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'id_location', 'id_location');
    }

    public static array $states = [
        'draft' => ['submitted'],
        'submitted' => ['approved', 'rejected'],
        'approved' => [],
        'rejected' => [],
        'confirmed' => ['approved', 'rejected']
    ];
}
