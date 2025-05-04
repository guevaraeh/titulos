<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    public function titulation_certificates(): BelongsToMany
    {
        return $this->belongsToMany(TitulationCertificate::class);
    }
}
