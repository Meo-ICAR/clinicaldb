<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientVisit extends Model
{
    protected $table = 'patient_visits';

    public const CREATED_AT = 'created';

    public const UPDATED_AT = 'modified';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'visitadel' => 'date',
            'Trattamentonuovodal' => 'date',
            'menopausa' => 'boolean',
            'HIVRNAnorilevabile' => 'boolean',
            'ProteurinaFlag' => 'boolean',
            'active' => 'boolean',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
