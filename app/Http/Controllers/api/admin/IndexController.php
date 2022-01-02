<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Models\WorkingHours;
use Illuminate\Http\Request;
use App\Models\Appointment;

class IndexController extends Controller
{

    public function all(){
        $return_array = [];
        /*Waiting*/
        $return_array["waiting"] = Appointment::where("is_active",0)->orderBy("hour", "asc")->paginate(9);
        $return_array["waiting"]->getCollection()->transform(function ($value){
            $value["working"] = WorkingHours::getString($value["hour"]);
            return $value;
        });

        /*Reject*/
        $return_array["reject"] = Appointment::where("is_active",2)->orderBy("hour", "asc")->paginate(9);
        $return_array["reject"]->getCollection()->transform(function ($value){
            $value["working"] = WorkingHours::getString($value["hour"]);
            return $value;
        });

        /*List*/
        $return_array["list"] = Appointment::where("is_active",1)->where("date",">", date("Y-m-d"))->orderBy("hour", "asc")->paginate(9);
        $return_array["list"]->getCollection()->transform(function ($value){
            $value["working"] = WorkingHours::getString($value["hour"]);
            return $value;
        });

        /*Last List*/
        $return_array["last_list"] = Appointment::where("date", "<",date("Y-m-d"))->orderBy("hour", "asc")->paginate(9);
        $return_array["last_list"]->getCollection()->transform(function ($value){
            $value["working"] = WorkingHours::getString($value["hour"]);
            return $value;
        });

        /*Today List */
        $return_array["today_list"] = Appointment::where("is_active",1)->where("date", date("Y-m-d"))->orderBy("hour", "asc")->paginate(9);
        $return_array["today_list"]->getCollection()->transform(function ($value){
            $value["working"] = WorkingHours::getString($value["hour"]);
            return $value;
        });

        return response()->json($return_array);

    }
    public function process(Request $request){
        $all = $request->except("_token");
        Appointment::where("id",$all["id"])->update(["is_active" => $all["type"]]);
        return response()->json(["status"=>true]);
    }
    public function getWaitingList(){
        $data = Appointment::where("is_active",0)->orderBy("hour", "asc")->paginate(9);
        $data->getCollection()->transform(function ($value){
            $value["working"] = WorkingHours::getString($value["hour"]);
            return $value;
        });
        return response()->json($data);
    }

    public function getRejectList(){
        $data = Appointment::where("is_active",2)->orderBy("hour", "asc")->paginate(9);
        $data->getCollection()->transform(function ($value){
            $value["working"] = WorkingHours::getString($value["hour"]);
            return $value;
        });
        return response()->json($data);
    }


    public function getList(){
        $data = Appointment::where("is_active",1)->where("date",">", date("Y-m-d"))->orderBy("hour", "asc")->paginate(9);
        $data->getCollection()->transform(function ($value){
            $value["working"] = WorkingHours::getString($value["hour"]);
            return $value;
        });
        return response()->json($data);
    }

    public function getTodayList(){
        $data = Appointment::where("is_active",1)->where("date", date("Y-m-d"))->orderBy("hour", "asc")->paginate(9);
        $data->getCollection()->transform(function ($value){
            $value["working"] = WorkingHours::getString($value["hour"]);
            return $value;
        });
        return response()->json($data);
    }

    public function getLastList(){
        $data = Appointment::where("date", "<",date("Y-m-d"))->orderBy("hour", "asc")->paginate(9);
        $data->getCollection()->transform(function ($value){
            $value["working"] = WorkingHours::getString($value["hour"]);
            return $value;
        });
        return response()->json($data);
    }
}
