<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NBADraft extends Model
{

    protected $table = 'nbadraft'; // <-- exact table name in MySQL
    protected $fillable = ['name', 'team', 'draft_year', 'pick_number'];
}
