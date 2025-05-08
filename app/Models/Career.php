<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Career extends Model
{
    public function students(): HasMany
    {
        return $this->HasMany(Student::class);
    }
}
