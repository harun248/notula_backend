<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notulas;
use App\Meets;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotulasController extends Controller
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
    public function notulas(){

        // $notulas = Notulas::join('meets','meets.id','=','notulas.meets_id')
        $notulas = Notulas::join('meets','meets.id','=','notulas.meets_id')->
        select('notulas.id','notulas.user_id', 'notulas.meets_id','meets.date',
        'notulas.created_at', 'notulas.updated_at','meets.title as meets_title')
        ->get();
        // $notulas = DB::table('vwNotulas')->get();
        foreach($notulas as $notula){

            $notula->user;
            $notula->meets;


        }

        return response()->json([
            'success' => true,
            'notula' => $notulas
        ]);
    }
    public function myNotulas(){
        // $notulas = Notulas::where('user_id',Auth::user()->id)->orderBy('id','desc')->get();
        $notulas = Notulas::join('meetings','meetings.id','=',    'notulas.meetings_id')->
        select('notulas.id','notulas.user_id', 'notulas.meetings_id','notulas.title','meetings.date',
        'notulas.created_at', 'notulas.updated_at','meetings.title as meetings_title')
        ->where('notulas.user_id',Auth::user()->id)->orderBy('notulas.id','desc')->get();
        // $meets = Meets::where('meet_user_id',Auth::user()->id)->orderBy('id_meets','desc')->get();
        $user = Auth::user();

        // foreach($notulas as $notula){

        //     $notula->user;
        //     $notula->meets;


        // }
        return response()->json([
            'success' => true,
            'notulas' => $notulas,
            'user' => $user,
            // 'meets'=>$meets
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
