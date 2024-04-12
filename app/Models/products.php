<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;

    protected $fillable=[
        'Product_name',
        'description',
        'section_id',
    ];
//    علشان اعرض من ال جدول الالي هو ون تو ميني اعرض منه عمود معين عن طريق id
    public function section()
    {
        return $this->belongsTo(Sections::class);
    }
}
