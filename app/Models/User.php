<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\CarbonInterface;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasName
{
    public const CREATED_AT = 'created';

    public const UPDATED_AT = 'modified';

    protected $guarded = ['id'];

    public $incrementing = false;

    protected $keyType = 'string';

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

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

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value): string => filled($value) ? $value : trim($this->last_name.' '.$this->first_name),
        );
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
