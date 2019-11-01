<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use DB;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $jsonResult = array();
        if ($request->id) {
            $id = $request->id;
            if ($id == 'sub') {
                $jsonResult = DB::table('categories')->where('parent_id', '!=', '0')->get();
                return Response::json(array(
                    'sub_category' => $jsonResult),
                    200
                );
            } else {
                $jsonResult = DB::table('categories')->where('parent_id', $id)->get();
                return Response::json(array(
                    'sub_category' => $jsonResult),
                    200
                );
            }
        } else {
            $tableIds = DB::select(DB::raw("SELECT id,name,icon,description,status FROM categories WHERE parent_id=0"));
            for ($i = 0; $i < count($tableIds); $i++) {
                $jsonResult[$i]["id"] = $tableIds[$i]->id;
                $jsonResult[$i]["name"] = $tableIds[$i]->name;
                $jsonResult[$i]["icon"] = $tableIds[$i]->icon;
                $jsonResult[$i]["description"] = $tableIds[$i]->description;
                $jsonResult[$i]["status"] = $tableIds[$i]->status;
                $id = $tableIds[$i]->id;
                $jsonResult[$i]["sub_category"] = DB::select(DB::raw("SELECT id,name,icon,description,status FROM categories WHERE parent_id =$id"));
            }

            return Response::json(array(
                'categories' => $jsonResult),
                200
            );
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|unique:categories',
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->description = $request->description;
        $category->icon = $request->icon;
        try {
            if ($category->save()) {
                return response()->json(['message' => 'Category created'], 200);
            }
        } catch (\QueryException  $queryException) {
//            return response()->json(['message' => $queryException->getMessage()],404);
        } catch (\Exception $ex) {

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }

    public
    function getAjaxRequestSubCategory(Request $request)
    {
        $categories = Category::where('parent_id', $request->id)->where('status', 'Publish')->get();
        if (count($categories)) {
            foreach ($categories as $category) {
                echo "<option value='" . $category->name . "'>$category->name</option>";
            }
        }
    }
}
