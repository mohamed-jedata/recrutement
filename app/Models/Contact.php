<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Organisation;


class Contact extends Model
{
    use softDeletes;
    use HasFactory;

    protected $table = 'contact';



     /**
     * Get the organisatiob associated with the contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function organ()
    {
        return $this->belongsTo(Organisation::class,'organisation_id');
    }
}


