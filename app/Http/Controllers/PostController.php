<?php

namespace App\Http\Controllers;

use App\Post;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use URL;
use Image;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostController extends Controller
{

    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset = 0;
        $limit = 20;
        if (!empty($request->offset)) {
            $offset = $request->offset;
        }
        if (!empty($request->limit)) {
            $limit = $request->limit;
        }
        $product = DB::select("SELECT id,name,price,images,location_name,created_at,updated_at FROM posts ORDER BY id DESC LIMIT $offset,$limit ");
        $popular = DB::select("SELECT id,name,price,images,location_name,created_at,updated_at FROM posts ORDER BY views DESC LIMIT $offset,$limit ");
        if (!empty($request->q)) {
            $q = $request->q;
            $product = DB::select("SELECT id,name,price,images,location_name ,created_at,updated_at FROM posts WHERE name LIKE  '%" . $q . "%' ORDER BY id DESC LIMIT $offset,$limit ");
            $popular = DB::select("SELECT id,name,price,images,location_name ,created_at,updated_at FROM posts WHERE name LIKE  '%" . $q . "%' ORDER BY views DESC LIMIT $offset,$limit ");
        }


        return Response::json(
            [
                'products' => $product,
                'populars' => $popular
            ], 200
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
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, $id)
    {
        $product = DB::select("SELECT * FROM posts WHERE id =$id");
        $user = DB::select("SELECT users.* FROM users INNER JOIN posts ON users.id=posts.user_id WHERE posts.id=$id");
        foreach ($user as $detail) {
            $user_id = $detail->id;
        }
        foreach ($product as $relate) {
            $relate_category = $relate->sub_category_name;
        }
        $relate_posts = DB::select("SELECT posts.* FROM posts WHERE  sub_category_name ='$relate_category' AND posts.id!=$id");
        $store = DB::select("SELECT * FROM stores WHERE  user_id=$user_id");
        if (count($product)) {
            return Response::json(array(
                'product' => $product,
                'user' => $user,
                'store' => $store,
                'relate_posts' => $relate_posts
            ),
                200
            );
        }
        return Response::json(array(
            'error' => "There is no result for this product id"),
            200
        );

    }

    public function getProductByCategory(Request $request)
    {
        $offset = 0;
        $limit = 30;
        if (!empty($request->offset)) {
            $offset = $request->offset;
        }
        if (!empty($request->limit)) {
            $limit = $request->limit;
        }
        $product = DB::select("SELECT id,name,price,images,location_name,sub_category_name,created_at,updated_at FROM posts ORDER BY id DESC LIMIT $offset,$limit ");
        if (!empty($request->category)) {
            $q = $request->category;
            $product = DB::select("SELECT id,name,price,images,location_name,sub_category_name ,created_at,updated_at FROM posts WHERE sub_category_name ='$q' ORDER BY id DESC LIMIT $offset,$limit ");
        }


        return Response::json(array(
            'products' => $product),
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = DB::select("SELECT * FROM posts WHERE id={$id}");
        return Response::json(array(
            'product' => $product),
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'location_name' => 'required|min:6',
            'sub_category_name' => 'required',
            'username' => 'required',
            'phone' => 'required',
            'product_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }
        $id = $request->product_id;
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user['id'];
        $name = $request->name;
        $price = $request->price;
        $description = $request->description;
        $address = $request->address;
        $location_name = $request->location;
        $user_name = $request->user_name;
        $email = $request->email;
        $phone = $request->phone;
        $image = $request->file('image');
        $sub_category_name = $request->sub_category_name;
        $imageInsert = array();
        if (!empty($image)) {
            foreach ($image as $img) {
                $rand = md5(rand(1, 100));
                $file_name = $img->getClientOriginalName();
                $new_file_name = URL::to('/') . '/images/' . $rand . $file_name;
                array_push($imageInsert, $new_file_name);
                $img->move('images', $new_file_name);

            }
        }
        $imageInsert = json_encode($imageInsert);
        $post = Post::find($id);
        $post->name = $name;
        $post->price = $price;
        $post->description = $description;
        $post->location_name = $location_name;
        $post->address = $address;
        $post->user_id = $request->user_id;
        $post->username = $user_name;
        $post->sub_category_name = $sub_category_name;
        $post->brand = $request->brand;
        $post->email = $email;
        $post->phone = $phone;
        $post->images = $imageInsert;
        $post->user_id = $userId;
        $post->save();
        return response()->json(['success' => true, 'message' => 'Your product has been updated!']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    public function getForm()
    {
        return view('show-form');
    }

    public function postCreatePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'location_name' => 'required|min:6',
            'sub_category_name' => 'required',
            'username' => 'required',
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user['id'];
        $name = $request->name;
        $price = $request->price;
        $description = $request->description;
        $address = $request->address;
        $location_name = $request->location;
        $user_name = $request->user_name;
        $email = $request->email;
        $phone = $request->phone;
        $image = $request->file('image');
        $sub_category_name = $request->sub_category_name;
        $imageInsert = array();
        if (!empty($image)) {
            foreach ($image as $file) {
                $file_name = $file->getClientOriginalName();
                list($width, $height) = getimagesize($file);
                $wm = $width / 2;
                $hm = $height / 2;
                $img = Image::make($file);

                $img->text('365daymarket.com', $wm, $hm, function ($font) {
                    $font->file(public_path('fonts/enfont/Arimo-Bold.ttf'));
                    $font->size(34);
                    $font->color(array(245, 248, 255, 0.80));
                    $font->valign('center');
                    $font->align('center');
                });

                $path = public_path('test/');
                $file_name = str_replace(" ", "", $file_name);
                $today = date('Ymd His');
                $new_file_name = URL::to('/') . '/images/' . $today . $file_name;
                array_push($imageInsert, $new_file_name);
                $img->save($path . $today . $file_name);

            }
        }
        $imageInsert = json_encode($imageInsert);
        $post = new Post();
        $post->name = $name;
        $post->price = $price;
        $post->description = $description;
        $post->location_name = $location_name;
        $post->address = $address;
        $post->user_id = $userId;
        $post->username = $user_name;
        $post->sub_category_name = $sub_category_name;
        $post->brand = $request->brand;
        $post->email = $email;
        $post->phone = $phone;
        $post->images = $imageInsert;
        $post->user_id = $userId;
        $post->save();
        return response()->json(['success' => true, 'message' => 'Your product has been created!']);


    }

    public function postUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'location_name' => 'required|min:6',
            'sub_category_name' => 'required',
            'username' => 'required',
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }
        //$user = JWTAuth::parseToken()->authenticate();
        $userId = 1;#$user['id'];
        $name = $request->name;
        $price = $request->price;
        $description = $request->description;
        $address = $request->address;
        $location_name = $request->location;
        $user_name = $request->user_name;
        $email = $request->email;
        $phone = $request->phone;
        $image = $request->file('image');
        $sub_category_name = $request->sub_category_name;
        $product_id = $request->id;
        $imageInsert = array();
        if (!empty($image)) {
            foreach ($image as $file) {
                $file_name = $file->getClientOriginalName();
                list($width, $height) = getimagesize($file);
                $wm = $width / 2;
                $hm = $height / 2;
                $img = Image::make($file);

                $img->text('365daymarket.com', $wm, $hm, function ($font) {
                    $font->file(public_path('fonts/enfont/Arimo-Bold.ttf'));
                    $font->size(34);
                    $font->color(array(245, 248, 255, 0.80));
                    $font->valign('center');
                    $font->align('center');
                });

                $path = public_path('test/');
                $file_name = str_replace(" ", "", $file_name);
                $today = date('Ymd His');
                $new_file_name = URL::to('/') . '/images/' . $today . $file_name;
                array_push($imageInsert, $new_file_name);
                $img->save($path . $today . $file_name);

            }
        }
        $imageInsert = json_encode($imageInsert);
        $post = Post::find($product_id);
        $post->name = $name;
        $post->price = $price;
        $post->description = $description;
        $post->location_name = $location_name;
        $post->address = $address;
        $post->user_id = $userId;
        $post->username = $user_name;
        $post->sub_category_name = $sub_category_name;
        $post->brand = $request->brand;
        $post->email = $email;
        $post->phone = $phone;
        $post->images = $imageInsert;
        $post->user_id = $userId;
        $post->save();
        return response()->json(['success' => true, 'message' => 'Your product has been updated!']);
    }

    public function testAPI(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'location_name' => 'required|min:6',
            'sub_category_name' => 'required',
            'username' => 'required',
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user['id'];
        $name = $request->name;
        $price = $request->price;
        $description = $request->description;
        $address = $request->address;
        $location_name = $request->location;
        $user_name = $request->user_name;
        $email = $request->email;
        $phone = $request->phone;
        $image = $request->file('image');
        $sub_category_name = $request->sub_category_name;
        $imageInsert = array();
        if (!empty($image)) {
            foreach ($image as $file) {
                $file_name = $file->getClientOriginalName();
                list($width, $height) = getimagesize($file);
                $wm = $width / 2;
                $hm = $height / 2;
                $img = Image::make($file);

                $img->text('365daymarket.com', $wm, $hm, function ($font) {
                    $font->file(public_path('fonts/enfont/Arimo-Bold.ttf'));
                    $font->size(34);
                    $font->color(array(245, 248, 255, 0.80));
                    $font->valign('center');
                    $font->align('center');
                });

                $path = public_path('test/');
                $file_name = str_replace(" ", "", $file_name);
                $today = date('Ymd His');
                $img->save($path . $today . $file_name);

            }
        }
    }
}
