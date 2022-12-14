<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    public function getLastOne()
    {
        return self::orderBy('id', 'DESC')->first()->toArray();
    }

}
