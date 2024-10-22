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
                $attendance->lat=floatval($request->lat);
                $attendance->lng=floatval($request->lng);
                $attendance->save();
            }elseif($attendance->check_out==null && $attendance->status=='attendance'){
              $attendance->check_out=date('H:i:s');
              $attendance->lat=floatval($request->lat);
              $attendance->lng=floatval($request->lng);
              $attendance->save();
            }else{
              return $this->sendResponse(null,"you can't check in or check out",200);
            }
        }else{
          return $this->sendResponse(null,"you can't check in or check out",200);
        }
        return $this->sendResponse(null,'successfuly',200);
      }

      public function home(){
        $user=auth()->user();
        $response['user_name']=$user->name;
        $response['user_image']=getFirstMediaUrl($user,$user->avatarCollection);
        $response['work_start_time']='09:00 am';
        $response['work_end_time']='05:00 pm';
        $response['work_location']='Al Mohazab Al Halabi - AMMAN - Jordan';
        $attendance=Attendance::where('user_id',auth()->user()->id)->where('date',date('Y-m-d'))->where('status','attendance')->first();
        if($attendance && $attendance->check_in!=null){
            $response['check_in']=$attendance->check_in;
        }else{
            $response['check_in']=null;
        }
        if($attendance && $attendance->check_out!=null){
          $response['check_out']=$attendance->check_out;
        }else{
          $response['check_out']=null;
        }
        if($attendance && $attendance->check_in!=null && $attendance->check_out==null){
          $response['user_status']=true;
        }else{
          $response['user_status']=false;
        }
        $response['attendance_count']=Attendance::where('user_id',auth()->user()->id)->where('status','attendance')->count();
        $response['absence_count']=Attendance::where('user_id',auth()->user()->id)->where('status','absence')->count();
        $response['vacation_count']=Attendance::where('user_id',auth()->user()->id)->where('status','vacation')->count();
        return $this->sendResponse($response,null,200);
      }

      public function create_attendance(){
        $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'Client');
            })
            ->get();
        foreach($users as $user){
          $attendance=Attendance::where('user_id',$user->id)->where('date',date('Y-m-d'))->first();
          if(!$attendance){
            Attendance::create(['user_id'=>$user->id,
                                'date'=>date('Y-m-d')
                                ]);
          }
        }
        return $this->sendResponse(null,'success',200);
      }
}