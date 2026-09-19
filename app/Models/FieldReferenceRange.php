<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldReferenceRange extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'min_value' => 'float',
            'max_value' => 'float',
            'weighted_average' => 'float',
            'normal_value' => 'float',
            'warning_value' => 'float',
            'alert_value' => 'float',
        ];
    }

    /**
     * Classifica un valore rispetto alle soglie cliniche del campo.
     * La direzione (alto o basso patologico) è dedotta dal verso di normal_value -> warning_value.
     * Restituisce null quando non ci sono soglie sufficienti o il valore è nella norma.
     */
    public function severityFor(float $value): ?string
    {
        if ($this->normal_value === null || $this->warning_value === null) {
            return null;
        }

        $highIsBad = $this->warning_value >= $this->normal_value;

        if ($highIsBad) {
            if ($this->alert_value !== null && $value >= $this->alert_value) {
                return 'alert';
            }

            return $value >= $this->warning_value ? 'warning' : null;
        }

        if ($this->alert_value !== null && $value <= $this->alert_value) {
            return 'alert';
        }

        return $value <= $this->warning_value ? 'warning' : null;
    }
}
