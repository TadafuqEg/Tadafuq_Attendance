<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Models\Attendance;
use App\Models\JoinUs;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTP;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends ApiController
{
      public function check_in_out(Request $request){
        $validator  =   Validator::make($request->all(), [
              
            'lat' => 'required',
            'lng' => 'required',
            
        ]);
        // dd($request->all());
        if ($validator->fails()) {

            return $this->sendError(null,$validator->errors(),400);
        }

        $attendance=Attendance::where('user_id',auth()->user()->id)->where('date',date('Y-m-d'))->first();
        if($attendance){
            if($attendance->check_in==null && $attendance->status=='non'){
                $attendance->check_in=date('H:i:s');
                $attendance->status='attendance';
                $attendance->save();
            }elseif($attendance->check_out==null && $attendance->status=='attendance'){
              $attendance->check_out=date('H:i:s');
              $attendance->save();
            }else{
              return $this->sendResponse(null,"you can't check in or check out",200);
            }
        }else{
          return $this->sendResponse(null,"you can't check in or check out",200);
        }
        return $this->sendResponse(null,'successfuly',200);
      }
}