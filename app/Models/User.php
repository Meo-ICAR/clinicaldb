<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\CarbonInterface;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements HasName
{
    public const CREATED_AT = 'created';

    public const UPDATED_AT = 'modified';

    protected $guarded = ['id'];

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFilamentName(): string
    {
        $name = trim(implode(' ', array_filter([
            $this->first_name,
            $this->last_name,
        ])));

        return $name !== '' ? $name : ($this->email ?: $this->username ?: 'Utente');
    }

    public function insertedPatients(): HasMany
    {
        return $this->hasMany(Patient::class, 'created_by');
    }

    public function performedVisits(): HasMany
    {
        return $this->hasMany(PatientVisit::class, 'created_by');
    }

    public function modifiedPatients(): HasMany
    {
        return $this->hasMany(Patient::class, 'modified_by');
    }

    public function modifiedVisits(): HasMany
    {
        return $this->hasMany(PatientVisit::class, 'modified_by');
    }

    public function scopeWithActivityCounts(Builder $query, ?CarbonInterface $since = null): Builder
    {
        $counts = [
            'insertedPatients',
            'performedVisits',
            'modifiedPatients as patients_modified_count',
            'modifiedVisits as visits_modified_count',
        ];

        if ($since !== null) {
            $counts['modifiedPatients as patients_modified_count'] = fn (Builder $query): Builder => $query->where('modified', '>=', $since);
            $counts['modifiedVisits as visits_modified_count'] = fn (Builder $query): Builder => $query->where('modified', '>=', $since);
        }

        return $query->withCount($counts);
    }
}
