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
     * Direzione clinica dedotta confrontando normal_value con warning_value:
     * 'high' se un valore alto è patologico (warning >= normal), 'low' se lo è un valore basso.
     * Restituisce null quando mancano le soglie per determinarla.
     */
    public function direction(): ?string
    {
        if ($this->normal_value === null || $this->warning_value === null) {
            return null;
        }

        return $this->warning_value >= $this->normal_value ? 'high' : 'low';
    }

    /**
     * Classifica un valore rispetto alle soglie cliniche del campo.
     * Restituisce null quando non ci sono soglie sufficienti o il valore è nella norma.
     */
    public function severityFor(float $value): ?string
    {
        $direction = $this->direction();

        if ($direction === null) {
            return null;
        }

        if ($direction === 'high') {
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
