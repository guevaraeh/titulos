<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

//use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function titulation_certificates(): BelongsToMany
    {
        return $this->belongsToMany(TitulationCertificate::class);
    }

    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class, 'career_id');
    }

    /*public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }*/

}
