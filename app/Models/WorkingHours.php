<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHours extends Model
{
    use HasFactory;
    static function getString($id){
        $id = WorkingHours::where("id", $id)->count();
        if($id != 0){
            $val = WorkingHours::where("id", $id)->get();
            return $val[0]["hours"];
        }else{
            return "";
        }
    }
}
