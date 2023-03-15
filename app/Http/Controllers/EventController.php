<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Services\ResponseApi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Redirect,Response;
class EventController extends Controller
{
    public function addEvent (Request $request) {
         try {
            $validator =\Validator::make($request->all(),[
                'title'=>'required',
                'datetime_start'=>'required',
            
            ]);
            $validator->after(function($validator) use ($request){

                if ($request->is_event==1) {
                    if (!$request->datetime_end) {
                        $validator->errors()->add('datetime_end', 'The datetime end field is required.');
                    }
                    $startDate = new Carbon($request->datetime_start);
                    $endDate = new Carbon($request->datetime_end);
                    $result = $endDate->gt($startDate); //Greater Than CHECK ngày có lớn hơn.
                    if (!$result) {
                        $validator->errors()->add('end_date', 'Event must end after it start');
                    }
                }
                
            });
            if($validator->fails()){
                return ResponseApi::errors($validator->errors());
            }
            else {
                $event = new Event();
                
                if ($request->id) {
                    $event = Event::where('id', $request->id)->first();
                }
                
                $event->title = $request->title;
                $event->is_event = $request->is_event;
                $event->start_date = $request->datetime_start;
                $event->end_date =  $request->datetime_end;
                $event->description = $request->description;
                $event->color =$request->color;
                $event->save();
                $msg="Success!";
                return ResponseApi::notifis($msg);

            }   
        }catch (\Exception $e) {
            return ResponseApi::fails("Fail!");
        }
        
    }
    public function selectEvent(Request $request)
    {   
        $events = Event::all();
        if($request->type != '2') 
        {
            $events = Event::where('is_event', $request->type)->get();
        } 
        $messge="yes";
        return ResponseApi::success($events, $messge);

        
    }
    public function deleteEvent(Request $request) {
    
            $id = $request->id;
            Event::where('id', $id)->delete();
            $msg="xoa thanh cong";
            return json_encode($msg);      
    }

}
