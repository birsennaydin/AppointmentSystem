<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\WorkingHours;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    private $hours=null;
    private $appointment_obj = null;
    private $returnArray = [];
    private $date= null;

    /**
     */
    public function __construct()
    {
        $this->hours = WorkingHours::all();
        $this->appointment_obj = Appointment::all();
        $this->date = date("Y-m-d");
    }


    public function getHours( $date = null){

        $date = ($date == null) ? date("Y-m-d"):$date;
        foreach ($this->hours as $key => $val){
            $check = $this->appointment_obj->where("date", $this->date)->where("hour", $val["id"])->count();
            $val["is_active"] = ($check == 0) ? true:false;
            $this->returnArray[] = $val;
        }
        return response()->json($this->returnArray);
    }

    public function appointmentStore(Request $request){

        $this->returnArray["status"] = false;
        $all = $request->except("_token");
        $check_appointment = $this->appointment_obj->where("date", $all["date"])->where("hour", $all["hour"])->count();
        if($check_appointment != 0){
            $this->returnArray["message"] = "This date and hour are not suitable, You can choose an other date and hour.";
            return response()->json($this->returnArray);
        }
       // return response()->json($all["notification_type"]);
        $this->appointment_obj = new Appointment();
        $this->appointment_obj->fullName = $all["fullName"];
        $this->appointment_obj->phone = $all["phone"];
        $this->appointment_obj->email = $all["email"];
        $this->appointment_obj->date = $all["date"];
        $this->appointment_obj->hour = $all["hour"];
       // $this->appointment_obj->is_active = $all["is_active"];
        $this->appointment_obj->description = $all["description"];
        $this->appointment_obj->notification_type = $all["notification_type"];
        $create_appointment = $this->appointment_obj->save();

        if($create_appointment){
            $this->returnArray["status"] = true;
            $this->returnArray["message"]= "Your appointment successfully created by the system.";
        }else{
            $this->returnArray["message"]= "Your appointment couldn't be created. Please contact with us.";
        }
        return response()->json($this->returnArray);
    }
}
