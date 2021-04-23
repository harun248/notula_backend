<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Meetings;
use App\Notulas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MeetingsController extends Controller
{
    // Create Notula
    public function create(Request $request){

        $notula = new Notulas;
        $notula->user_id = Auth::user()->id;
        $notula->subject = $request->subject;
        $notula->title = $request->title;
        $notula->title_meet = $request->title_meet;
        $notula->date = $request->date;
        $notula->start_time = $request->start_time;
        $notula->end_time = $request->end_time;


        //mistake
        $notula->save();
        $notula->user;
        return response()->json([
            'success' => true,
            'message' => 'success',
            'notula' => $notula
        ]);
    }
    //
    public function meetings(){
        $meetings = Meetings::orderBy('date','desc')->get();
        foreach($meetings as $meetings){

            $meetings->user;


        }

        return response()->json([
            'success' => true,
            'meetings' => $meetings
        ]);
    }
    public function myMeetings(){
        $meetings = Meetings::where('user_id',Auth::user()->id)->orderBy('date','desc')->get();
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'meetings' => $meetings,
            'user' => $user
        ]);
    }
    // public function show_objekvalue($pid){
    //     $show=DB::table('objekvalues')->where('object_id',$pid) ->get();

    // return response([
    //     'status' => true,
    //     'message' => 'Show Objek Value',
    //     'data' => $show
    //  ], 200);


    // }
    public function myNotulas($meetingsid){
        // $meets = Notulas::where('user_id',Auth::user()->id)->orderBy('id','desc')->get();
        $meetings = Notulas::join('meetings','meetings.id','=',    'notulas.meetings_id')->
        select('notulas.id','notulas.user_id', 'notulas.meetings_id','notulas.title','meetings.date',
        'notulas.created_at', 'notulas.updated_at','meetings.title as meetings_title')
        ->where('notulas.user_id',Auth::user()->id)->where('notulas.meetings_id',$meetingsid)->get();

        // ->where('meets_id',Db::tables('meets')->id)
        // ->orderBy('notulas.id','desc')

        $user = Auth::user();
        // $meets = Db::tables('meets');
        return response()->json([
            'success' => true,
            'meetings' => $meetings,
            'user' => $user
        ]);
    }

    public function update(Request $request){
        $post = Notulas::find($request->id);
        // check if user is editing his own post
        // we need to check user id with post user id
        if(Auth::user()->id != $notula->user_id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
        $notula->subject = $request->subject;
        $notula->title = $request->title;
        $notula->title_meet = $request->title_meet;
        $notula->date = $request->date;
        $notula->start_time = $request->start_time;
        $notula->end_time = $request->end_time;

        $notula->update();
        return response()->json([
            'success' => true,
            'message' => 'Notula edited'
        ]);
    }

    public function delete(Request $request){
        $notula = Notulas::find($request->id);
        // check if user is editing his own post
        if(Auth::user()->id !=$notula->user_id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }

        $notula->delete();
        return response()->json([
            'success' => true,
            'message' => 'notula deleted'
        ]);
    }
}