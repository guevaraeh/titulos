<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TitulationCertificate extends Model
{
    use SoftDeletes;
    
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }
}
