<?php

namespace App\Policies;

use App\Models\PatientVisit;
use App\Models\User;

class PatientVisitPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PatientVisit $patientVisit): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PatientVisit $patientVisit): bool
    {
        return $this->ownsOrSameCenter($user, $patientVisit);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PatientVisit $patientVisit): bool
    {
        return $this->ownsOrSameCenter($user, $patientVisit);
    }

    /**
     * Determine whether the user can delete multiple models.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PatientVisit $patientVisit): bool
    {
        return $this->ownsOrSameCenter($user, $patientVisit);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PatientVisit $patientVisit): bool
    {
        return $this->ownsOrSameCenter($user, $patientVisit);
    }

    private function ownsOrSameCenter(User $user, PatientVisit $patientVisit): bool
    {
        if ($user->is_superuser) {
            return true;
        }

        if ($patientVisit->created_by === $user->getKey()) {
            return true;
        }

        return filled($user->centercode) && $patientVisit->centrocode === $user->centercode;
    }
}
