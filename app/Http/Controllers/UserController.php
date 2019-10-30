<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Store;
use Auth;
use Mail;
use App\Save;
use App\User;

use App\Post;
use App\Category;
use App\Location;
use App\Brand;
use App\Banner;
use App\Information;
use Tymon\JWTAuth\Facades\JWTAuth;
use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $offset = 0;
        $limit = 30;
        if (!empty($request->offset)) {
            $offset = $request->offset;
        }
        if (!empty($request->limit)) {
            $limit = $request->limit;
        }
        $user = DB::select("SELECT * FROM users WHERE  id=$id");
        $product_list_by_user = DB::select("SELECT * FROM posts  WHERE user_id=$id ORDER BY id DESC LIMIT $offset,$limit");
        $product_favorites = DB::select("SELECT * FROM posts INNER  JOIN  saves ON posts.id=saves.post_id WHERE saves.user_id=$id");
        return Response::json(array(
            'user' => $user,
            'product_list_by_user' => $product_list_by_user,
            'product_favorites' => $product_favorites
        ),
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function postProfile(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
    }

    public function postUpdateStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|min:6',
            'google_map' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user['id'];
        $name = $request->name;
        $address = $request->address;
        $phone = $request->phone;
        $google_map = $request->google_map;
        $photo = $request->file('photo');
        $image = "";
        if (!empty($photo)) {
            $fileName = $photo->getClientOriginalName();
            $newFile = md5(rand(1, 100)) . $fileName;
            $allow_ex = ["jpg", "PNG", "png", "gif"];
            $ex = $photo->getClientOriginalExtension();
            if (in_array($ex, $allow_ex)) {
                return response()->json(['success' => false, 'error' => "Please upload image that validate extensions"]);

            }
            $photo->move("images", $newFile);
            $image = URL::to('/') . '/images/' . $newFile;
        }
        try {
            $store = Store::where('user_id', $userId)->first();
            $store->user_id = $userId;
            $store->name = $name;
            $store->address = $address;
            $store->phone = $phone;
            $store->google_map = $google_map;
            $store->photo = $image;
            $store->save();
            return response()->json(['success' => true, 'message' => "Your store has been update completed!"]);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()]);

        }


    }

    //
    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users',
            'password' => 'required|min:5',
            'cpassword' => 'required|min:5',
        ]);

        $user = new User();
        $string = $request->email;
        $string = substr($string, 0, strpos($string, '@'));
        $fullname = preg_replace('/[0-9]+/', '', $string);
        $user->name = $fullname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $registerkey = bcrypt($request->email);
        $registerkey = str_replace("/", "", $registerkey);
        $user->verification_code = $registerkey;
        $user->save();

        $store = new Store();
        $store->name = $fullname;
        $store->user_id = $user->id;
        $store->save();
        $to = $request->email;
        $subject = "Confirmation Email";
        $message = "
        <html>
        <head><title>Please Confirmation Email!</title></head>
        <body>
        <h2>Welcome to 365daymarket.com/</h2>
        <a href='http://365daymarket.com/confirm.email/" . $registerkey . "'>Click Here</a>
        <p>Thank for register with us!</p>
        <p>Sincerely,</p><p>The 365daymarket Team.</p>
        </body>
        </html>
        ";
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <info@365daymarket.com>' . "\r\n";
        if (mail($to, $subject, $message, $headers)) {
            return redirect()->back()->with('message', 'Please Confirm Your Email Address');
        }

    }

    public function getConfirm($key)
    {
        if ($user = User::where('verification_code', $key)->first()) {
            $userAccess = $user;
            $user->verified = 1;
            $user->save();
            Auth::login($userAccess);
            $username = Auth::user()->username;
            return redirect()->route('home');
        } else {
            return "Access denied";
        }
    }

    public function postLogin(Request $request)
    {
        // $this->validate($request,[
        //     'email'=>'required|unique:users',
        // ]);
        // $oldUrl=URL::previous();
        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            if (Auth::user()->verified == "1") {
                return redirect()->back();
            } else {
                Auth::logout();
                return redirect()->back()->with('message_login_error', '<a href="https://mail.google.com/">Please confirm your email address to login</a>');
            }
        }
        return redirect()->back()->withInput()->withErrors(['message__error' => 'Incorrect Email or Password']);
    }

    public function logoutUser()
    {
        Auth::logout();
        return redirect()->back();
    }

    public function getConfirmforgot(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if ($user) {
            $register_key = bcrypt($user->id);
            $data = ['email' => $email, 'userName' => $user->username, 'register_key' => $register_key];
            $user->register_key = $register_key;
            $user->save();
            try {
                Mail::send('email.forgot-pwd', $data, function ($message) use ($email) {
                    $message->from('info@365daymarket.com', '365daymarket');
                    $message->to($email)->subject('Confirm Email');
                });
                return 1;

            } catch (\Exception $ex) {
                return $ex->getMessage();
            }

        } else {
            return 0;
        }
    }

    public function getUserprofile()
    {
        if (!empty(Auth::user())) {
            $categoty = Category::where('parent_id', '0')->get();
            $subcategory = Category::where('parent_id', '!=', '0')->get();
            $location = Location::where('status', 'Publish')->get();
            if (!empty($_GET['adsID'])) {
                $post = Post::find($_GET['adsID']);
                $rulepost = Information::where('type', 'Post-rule')->first();
                return view('user-manage')->withCategoty($categoty)->withSubcategory($subcategory)->withLocation($location)->withPost($post)->withRulepost($rulepost);
            } else {
                return view('user-manage')->withCategoty($categoty)->withSubcategory($subcategory)->withLocation($location);
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function removePhoto(Request $request)
    {
        $id = $request->id;
        $old = $request->old;
        $photo = str_replace('\/', '/', $request->photo);
        $checkfile = str_replace($photo, '', $old);
        $arr = ['"",', '""', ',""'];
        $checkfile = str_replace($arr, '', $checkfile);
        $checkfile = rtrim($checkfile, ',');
        $getpost = Post::find($id);
        if ($checkfile != '') {
            $getpost->images = '[' . $checkfile . ']';
        }
        $getpost->save();
        // return;
    }

    public function getResetPassword(Request $request)
    {
        $email = $request->email;
        $oldPassword = $request->oldPassword;
        if (!empty($email)) {
            $user = User::where('email', $email)->first();
            if (count($user)) {
                Auth::login($user);
                $user->password = bcrypt($oldPassword);
                $user->save();
                return "Password reset successful";
            }
        }
        return "Fail!";

    }

    public function changeProfile(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $url = $request->url;
        $photo = $request->file('profile');
        $randName = rand(0, 99999);
        $file_name = $randName . $photo->getClientOriginalName();
        $photo->move('uploads/', $file_name);
        $imageFile = $url . 'uploads/' . $file_name;
        $user->image = $imageFile;
        $user->save();
        return redirect()->back();
    }

    public function editUserprofile(Request $request)
    {
        $id = $request->id;
        $userID = Auth::user()->id;
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $location = $request->location;
        $address = $request->address;
        $maplat = $request->maplat;
        $maplon = $request->maplon;

        $user = User::find($userID);
        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->location = $location;
        $user->save();

        $store = Store::find($id);
        $store->name = $name;
        $store->address = $address;
        $store->phone = $phone;
        $store->maplat = $maplat;
        $store->maplon = $maplon;
        $store->save();

        return redirect()->back();
    }

    public function editProductuser(Request $request)
    {
        $id = $request->id;
        $url = $request->url;
        $oldphoto = $request->oldphoto;
        $imageFile = $request->photo;
        if (!empty($imageFile)) {
            foreach ($imageFile as $file) {//this statement will loop through all files.
                $file_name = $file->getClientOriginalName(); //Get file original name
                //$file->move('uploads/' , $file_name); // move files to destination folder
                //$imageFile.='"'.$url.'uploads/'.$file_name.'",';
                //
                $file_name = $file->getClientOriginalName(); //Get file original name
                //
                list($width, $height) = getimagesize($file);

                //
                $wm = $width / 2;
                $hm = $height / 2;
                $img = Image::make($file);

                $img->text('365daymarket.com', $wm, $hm, function ($font) {
                    // $font->file('foo/bar.ttf');
                    $font->file(public_path('fonts/enfont/Arimo-Bold.ttf'));
                    $font->size(34);
                    // $font->color('#444');
                    $font->color(array(245, 248, 255, 0.80));
                    $font->valign('center');
                    $font->align('center');
                    // $font->angle(45);
                });
                // draw transparent text

                $path = public_path('uploads/');
                $today = date('Y-m-d H-i-s');

                // $file->move('uploads/' , $file_name); // move files to destination folder
                $img->save($path . $today . '-' . $file_name);
                $img->fit(280, null)->save($path . $today . '_thum_' . $file_name); //create thum

                $imageFile .= '"' . $url . 'uploads/' . $today . '-' . $file_name . '",';
                $imageThum .= '"' . $url . 'uploads/' . $today . '_thum_' . $file_name . '",';
            }
            $arr = ['array', 'Array'];
            $imageFile = rtrim(str_replace($arr, '', $imageFile), ',');
            $imageThum = rtrim(str_replace($arr, '', $imageThum), ',');// img thum

            $imageFile = $imageFile;
            if (!empty($oldphoto)) {
                $photos = $oldphoto . ',' . $imageFile;
                $photos = '[' . $photos . ']';
                $imageThum = '[' . $imageThum . ']';
            } else {
                $photos = '[' . $imageFile . ']';
                $imageThum = '[' . $imageThum . ']';
            }
        } else {
            $photos = '[' . $oldphoto . ']';
        }

        $post = Post::find($id);
        $post->user_id = Auth::user()->id;
        $post->name = $request->name;
        $post->brand = $request->variation_type;
        $post->price = $request->price;
        $post->description = $request->description;
        $post->username = $request->username;
        $post->phone = $request->phone;
        $post->email = $request->email;
        $post->location_name = $request->location;
        $post->category_name = $request->categoryname;
        $post->sub_category_name = $request->subcategoryname;
        // $post->address=$request->categoryname;
        $post->images = $photos;
        if (!empty($request->photo)) {
            $post->img_thum = $imageThum;
        }
        $post->Save();
        return redirect()->back()->with('updated_success', 'Your product has been updated!');
    }

    public function getSubcategories(Request $request)
    {
        $id = $request->id;
        $catName = $request->cat;
        $subcategories = Category::where('parent_id', $id)->get();
        ?>
        <label class="col-md-3">Sub category </label>
        <select name="subcategory" class="col-md-6 getsub_category" required>
            <option value="">Choose subcategory ...</option>
            <?php
            foreach ($subcategories as $categories) {
                ?>
                <option value="<?php echo $categories->name; ?>"><?php echo $categories->name; ?></option>
                <?php
            }
            ?>
        </select>
        <?php
        return;
    }

    public function categoryGetbrand(Request $request)
    {
        $catName = $request->cat;
        $brand = Brand::where('sub_category_name', $catName)->where('status', 'Publish')->get();
        if (count($brand) > 0) {
            ?>
            <label class="col-md-3">Type <span class="red">*</span>:</label>
            <select name="variation_type" class="variationselect" required>
                <?php foreach ($brand as $key => $brandlist): ?>
                    <option value="<?php echo $brandlist->name; ?>"><?php echo $brandlist->name; ?></option>
                <?php endforeach ?>
            </select>
            <?php
        }
        return;
    }

    public function removeAdsuser(Request $request, $id)
    {
        $id = $request->id;
        $post = Post::find($id);
        $post->status = 'deleted';
        $post->save();
        return redirect()->back()->with('delete_success', 'Your product is deleted!');
    }

    // login facebook controller

    public function redirectToProvider(Request $request)

    {

        // $page=$request->page;

        // $userid = $request->userID;

        // $id = $request->id;

        // $storeID=$request->storeID;

        // $SaveTo=$request->SaveTo;

        // Session::put('page',$page);

        // session::put('restID', $id);

        // session::put('storeID', $storeID);

        // Session::put('SaveTo', $SaveTo);

        return Socialite::driver('facebook')->redirect();

    }


    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */

    public function handleProviderCallback()
    {

        $user = Socialite::driver('facebook')->user();
        $suerID = $user->getId();
        $username = $user->getName();
        $email = $user->getEmail();
        $userPhoto = $user->getAvatar();

        $existUser = User::where("email", $email)->first();
        $existId = User::where("fb_userID", $suerID)->first();
        // dd($suerID);exit;      
        // echo Session::get('storeID')."<br/>";
        // echo Session::get('page');exit;
        // $urlSave = Session::get('page')."?userID=".$existUser->id."&id=".Session::get('restID');
        if (!empty($email)) {
            if ($existUser) {
                $url = Session::get('page') . "?userID=" . $existUser->id . "&id=" . Session::get('restID');
                Auth::login($existUser);
                if (Session::get('page') == 'store-review-preview') {
                    return redirect()->to($url);
                } else {
                    if (Session::get('SaveTo') == 'store-save') {
                        $user_ID = $existUser->id;
                        $store_ID = Session::get('storeID');
                        $store = Store::find($store_ID);
                        $exists = $store->userSave->contains($user_ID);
                        if ($exists == false) {
                            $store->save();
                            $store->userSave()->attach($user_ID);
                        }
                        return redirect()->to(str_replace('||', '&', Session::get('page')));
                        // return Session::get('page');

                    } else {
                        return redirect()->to(str_replace('||', '&', Session::get('page')));
                    }
                }
                // return redirect()->to(Session::get('page'));
            }
        } else {
            if ($existId) {
                $url = Session::get('page') . "?userID=" . $existId->id . "&id=" . Session::get('restID');
                Auth::login($existId);
                if (Session::get('page') == 'store-review-preview') {
                    return redirect()->to($url);
                } else {
                    if (Session::get('SaveTo') == 'store-save') {
                        $user_ID = $existId->id;
                        $store_ID = Session::get('storeID');
                        $store = Store::find($store_ID);
                        $exists = $store->userSave->contains($user_ID);
                        if ($exists == false) {
                            $store->save();
                            $store->userSave()->attach($user_ID);
                        }
                        return redirect()->to(str_replace('||', '&', Session::get('page')));
                        // return Session::get('page');

                    } else {
                        return redirect()->to(str_replace('||', '&', Session::get('page')));
                    }
                }
            }
        }

        // elseif ($email==Null) {
        //     if ($existId) {
        //        // dd($existId);exit;   
        //     } 
        // }
        $createUser = new User();
        $createUser->remember_token = $user->token;
        $createUser->username = $username;
        $createUser->email = $email;
        $createUser->fb_userID = $suerID;
        // $createUser->password=bcrypt($suerID);
        $createUser->photo = $userPhoto;
        $createUser->permission = "3";
        $createUser->permission_type = "User";
        // $createUser->register_key=bcrypt($email);
        $createUser->verified = "1";
        $createUser->account_type = "1";
        $createUser->save();
        Auth::login($createUser);
        if (Session::get('page') == 'store-review-preview') {
            return redirect()->to($url);
        } else {
            // if (Session::get('page'=='store-save')) {
            //     return redirect()->to(Session::get('locationss'));
            // }else{
            //     return redirect()->to(Session::get('page'));
            // }
            return redirect()->to(str_replace('||', '&', Session::get('page')));
        }
        // return redirect()->to(Session::get('page'));

    }

    public function postForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }
        $reset_password = str_random(30);
        $user = User::where('email', $request->email)->first();
        $user->reset_password = $reset_password;
        $data = array('name' => $user->email, 'reset_password' => $reset_password);
        $email = $user->email;
        $user->save();
        try {
            Mail::send('email.api_forgot_password', $data, function ($message) use ($email) {
                $message->from('channvuthyit@gmail.com', 'Chann Vuthy');
                $message->to($email)->subject('Forgot password');
            });
                return response()->json(['success' => false, 'message' => 'Please  check your email address. We have been send code to your email ready!']);

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function postResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reset_password' => 'required',
            'new_password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }
        $reset_password = $request->reset_password;
        $new_password = $request->new_password;
        $user = User::where('reset_password', $reset_password)->first();
        if ($user) {
            $user->password = bcrypt($new_password);
            $user->reset_password = "";
            $user->save();
            return response()->json(['success' => true, 'message' => 'Your password has been update success!']);
        }
        return response()->json(['success' => false, 'message' => 'Your reset password code was expired']);

    }
}
