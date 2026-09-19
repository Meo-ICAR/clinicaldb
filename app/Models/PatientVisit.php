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

    protected static function booted(): void
    {
        static::creating(function (self $visit): void {
            if (auth()->check()) {
                $visit->created_by ??= auth()->id();
                $visit->modified_by ??= auth()->id();
            }
        });

        static::updating(function (self $visit): void {
            if (auth()->check()) {
                $visit->modified_by = auth()->id();
            }
        });
    }
}
