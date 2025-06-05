<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

//use Illuminate\Database\Eloquent\Relations\HasMany;

class TitulationCertificate extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }

    /*public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }*/
}
