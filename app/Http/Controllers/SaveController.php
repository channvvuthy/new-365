<?php

namespace App\Http\Controllers;

use App\Save;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use DB;

class SaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Save $save
     * @return \Illuminate\Http\Response
     */
    public function show(Save $save)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Save $save
     * @return \Illuminate\Http\Response
     */
    public function edit(Save $save)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Save $save
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Save $save)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Save $save
     * @return \Illuminate\Http\Response
     */
    public function destroy(Save $save)
    {
        //
    }

    public function getSaveProductToFavorite(Request $request)
    {
        $pid = $request->product_id;
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user['id'];
        $check = DB::select("SELECT * FROM saves WHERE post_id=$pid AND user_id=$userId");
        if (count($check)) {
            DB::table('saves')->where('post_id', $pid)->where('user_id', $userId)->delete();
            return Response::json(array(
                'message' => 'You have been unsave success!',
            ),
                202
            );
        } else {
            DB::table('saves')->insert(['post_id' => $pid, 'user_id' => $userId,'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
            return Response::json(array(
                'message' => 'You have been saved success!',
            ),
                202
            );
        }

    }
}
