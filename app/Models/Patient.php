<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $table = 'patients';

    public const CREATED_AT = 'created';

    public const UPDATED_AT = 'modified';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'arruolato' => 'date',
            'annonascita' => 'date',
            'datanascita' => 'date',
            'datahiv' => 'date',
            'positivodal' => 'date',
            'trattamentodal' => 'date',
            'cd4data' => 'date',
            'menopausa' => 'boolean',
            'cammino' => 'boolean',
            'sport' => 'boolean',
            'active' => 'boolean',
        ];
    }

    public function visits(): HasMany
    {
        return $this->hasMany(PatientVisit::class, 'patient_id');
    }

    protected static function booted(): void
    {
        static::creating(function (self $patient): void {
            if (auth()->check()) {
                $patient->created_by ??= auth()->id();
                $patient->modified_by ??= auth()->id();
            }
        });

        static::updating(function (self $patient): void {
            if (auth()->check()) {
                $patient->modified_by = auth()->id();
            }
        });
    }
}
