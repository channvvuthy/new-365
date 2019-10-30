<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset = 0;
        $limit = 30;
        if (!empty($request->offset)) {
            $offset = $request->offset;
        }
        if (!empty($request->limit)) {
            $limit = $request->limit;
        }
        $banners = DB::select("SELECT * FROM banners ORDER BY id DESC LIMIT $offset,$limit ");
        if (!empty($request->q)) {
            $q = $request->q;
            $banners = DB::select("SELECT * FROM banners WHERE name LIKE  '%" . $q . "%' ORDER BY id DESC LIMIT $offset,$limit ");
        }
        if (!empty($request->position)) {
            $position = $request->position;
            $banners = DB::select("SELECT * FROM banners WHERE position ='$request->position' ORDER BY id DESC LIMIT $offset,$limit ");

        }


        return Response::json(array(
            'banners' => $banners),
            200
        );
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
