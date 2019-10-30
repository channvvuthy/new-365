<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Category;
use App\Location;
use App\Brand;
use App\Banner;
use App\Information;
use DB;
use Auth;
use Image;

class HomeController extends Controller
{
    public function getIdex()
    {
        $lastpost = Post::orderBy('created_at', 'desc')->paginate(24);
        $popular = Post::orderBy('views', 'desc')->paginate(24);
        $categoty = Category::where('parent_id', '0')->get();
        $subcategory = Category::where('parent_id', '!=', '0')->get();
        $location = Location::where('status', 'Publish')->get();
        return view('khmer24.index')->withLastpost($lastpost)->withCategoty($categoty)->withSubcategory($subcategory)->withLocation($location)->withPopular($popular);
    }

    public function getUpdatePassword(Request $request)
    {
        if (!empty($request->email)) {
            $user = User::where('email', $request->email)->first();
            if ($request->token == $user->register_key) {
                $lastpost = Post::orderBy('created_at', 'desc')->paginate(24);
                $popular = Post::orderBy('views', 'desc')->paginate(24);
                $categoty = Category::where('parent_id', '0')->get();
                $subcategory = Category::where('parent_id', '!=', '0')->get();
                $location = Location::where('status', 'Publish')->get();
                return view('khmer24.index')->withLastpost($lastpost)->withCategoty($categoty)->withSubcategory($subcategory)->withLocation($location)->withPopular($popular)->with('reset_password', 'Reset your password');
            } else {
                return response("Your email request does no exist");
            }
        } else {
            return response("Page requrest not found");
        }
    }

    public function viewdetail()
    {
        $id = $_GET['id'];
        $categoty = Category::where('parent_id', '0')->get();
        $subcategory = Category::where('parent_id', '!=', '0')->get();
        $location = Location::where('status', 'Publish')->get();
        $post = Post::where('id', $id)->first();
        $view = (int)$post->views + 1;
        $postview = Post::find($id);
        $postview->views = $view;
        $postview->save();
        $adsright = Banner::where('status', 'Publish')->where('position', 'Right')->get();
        return view('khmer24.detail-view')->withCategoty($categoty)->withSubcategory($subcategory)->withLocation($location)->withPost($post)->with('product_detail', 'product_detail')->withAdsright($adsright);
    }

    public function storemarket()
    {
        return view('khmer24.user-store');
    }

    public function postProduct()
    {
        $categoty = Category::where('parent_id', '0')->get();
        $location = Location::where('status', 'Publish')->get();
        $subcategory = Category::where('parent_id', '!=', '0')->get();
        $rulepost = Information::where('type', 'Post-rule')->first();
        return view('khmer24.post-product')->withCategoty($categoty)->withLocation($location)->withSubcategory($subcategory)->withRulepost($rulepost);
    }

    public function getbrandCategory(Request $request)
    {
        $id = $request->catid;
        $catname = $request->subcatname;
        $brand = Brand::where('sub_category_name', $catname)->where('status', 'Publish')->get();
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

    public function searchResult(Request $request)
    {
        $categoty = Category::where('parent_id', '0')->get();
        $subcategory = Category::where('parent_id', '!=', '0')->get();
        $location = Location::where('status', 'Publish')->get();
        $adsleft = Banner::where('status', 'Publish')->where('position', 'Left')->get();
        $adsright = Banner::where('status', 'Publish')->where('position', 'Right')->get();
        $adstop = Banner::where('status', 'Publish')->where('position', 'Top')->get();
        if (!empty($_GET['cats'])) {
            $varcate = str_replace('||', '&', $_GET['cats']);
            $post = Post::where('category_name', $varcate)->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
        } else {
            // 
            $categoryName = $_GET['category'];
            $locationName = $_GET['location'];
            $keyword = $_GET['p'];
            if (empty($_GET['sort-by'])) {
                if (!empty($categoryName) && !empty($locationName) && !empty($keyword)) {
                    if (!empty($_GET['pricefrom']) || !empty($_GET['priceto'])) {
                        $post = Post::where('price', '>=', $_GET['pricefrom'])->where('price', '<=', $_GET['priceto'])->where('sub_category_name', $categoryName)->where('location_name', $locationName)->where('name', 'like', '%' . $keyword . '%')->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    } else {
                        $post = Post::where('sub_category_name', $categoryName)->where('location_name', $locationName)->where('name', 'like', '%' . $keyword . '%')->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    }
                }
                if (!empty($categoryName) && !empty($locationName) && empty($keywork)) {
                    if (!empty($_GET['pricefrom']) || !empty($_GET['priceto'])) {
                        $post = Post::where('price', '>=', $_GET['pricefrom'])->where('price', '<=', $_GET['priceto'])->where('sub_category_name', $categoryName)->where('location_name', $locationName)->where('name', 'like', '%' . $keyword . '%')->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    } else {
                        $post = Post::where('sub_category_name', $categoryName)->where('location_name', $locationName)->where('name', 'like', '%' . $keyword . '%')->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    }
                }
                if (!empty($categoryName) && empty($locationName) && empty($keywork)) {
                    if (!empty($_GET['pricefrom']) || !empty($_GET['priceto'])) {
                        $post = Post::where('price', '>=', $_GET['pricefrom'])->where('price', '<=', $_GET['priceto'])->where('sub_category_name', $categoryName)->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    } else {
                        $post = Post::where('sub_category_name', $categoryName)->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    }
                }
                if (empty($categoryName) && !empty($locationName) && empty($keywork)) {
                    if (!empty($_GET['pricefrom']) || !empty($_GET['priceto'])) {
                        $post = Post::where('price', '>=', $_GET['pricefrom'])->where('price', '<=', $_GET['priceto'])->where('location_name', $locationName)->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    } else {
                        $post = Post::where('location_name', $locationName)->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    }
                }
                if (empty($categoryName) && empty($locationName) && !empty($keywork)) {
                    if (!empty($_GET['pricefrom']) || !empty($_GET['priceto'])) {
                        $post = Post::where('price', '>=', $_GET['pricefrom'])->where('price', '<=', $_GET['priceto'])->where('name', 'like', '%' . $keyword . '%')->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    } else {
                        $post = Post::where('name', 'like', '%' . $keyword . '%')->orderBy('created_at', 'desc')->paginate(24);
                    }
                }
                if (empty($categoryName) && !empty($locationName) && !empty($keyword)) {
                    if (!empty($_GET['pricefrom']) || !empty($_GET['priceto'])) {
                        $post = Post::where('price', '>=', $_GET['pricefrom'])->where('price', '<=', $_GET['priceto'])->where('location_name', $locationName)->where('name', 'like', '%' . $keyword . '%')->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    } else {
                        $post = Post::where('location_name', $locationName)->where('name', 'like', '%' . $keyword . '%')->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    }
                }
                if (empty($categoryName) && empty($locationName) && !empty($keyword)) {
                    if (!empty($_GET['pricefrom']) || !empty($_GET['priceto'])) {
                        $post = Post::where('price', '>=', $_GET['pricefrom'])->where('price', '<=', $_GET['priceto'])->where('name', 'like', '%' . $keyword . '%')->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    } else {
                        $post = Post::where('name', 'like', '%' . $keyword . '%')->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    }
                }
                if (empty($categoryName) && empty($locationName) && empty($keyword)) {
                    if (!empty($_GET['pricefrom']) || !empty($_GET['priceto'])) {
                        $post = Post::where('price', '>=', $_GET['pricefrom'])->where('price', '<=', $_GET['priceto'])->where('name', 'like', '%' . $keyword . '%')->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    } else {
                        $post = Post::where('name', 'like', '%' . $keyword . '%')->where('status', 'Published')->orderBy('created_at', 'desc')->paginate(24);
                    }
                }
            } else {
                $keysearch = array();
                if ($categoryName != "") {
                    $keysearch[] = ['posts.sub_category_name', $categoryName];
                }
                if ($locationName != "") {
                    $keysearch[] = ['posts.location_name', $locationName];
                }
                if ($keyword != "") {
                    $keysearch[] = ['posts.name', 'LIKE', '%' . $keyword . '%'];
                }
                if (!empty($_GET['postby'])) {
                    if ($_GET['postby'] == 'last') {
                        if (!empty($_GET['pricefrom']) || !empty($_GET['priceto'])) {
                            if (!empty($keysearch)) {
                                $post = Post::where('price', '>=', $_GET['pricefrom'])->where('price', '<=', $_GET['priceto'])->where($keysearch)->orderBy('created_at', 'desc')->where('status', 'Published')->paginate(24);
                            } else {
                                $post = Post::where('price', '>=', $_GET['pricefrom'])->where('price', '<=', $_GET['priceto'])->orderBy('created_at', 'desc')->where('status', 'Published')->paginate(24);
                            }
                        } else {
                            if (!empty($keysearch)) {
                                $post = Post::where($keysearch)->orderBy('created_at', 'desc')->where('status', 'Published')->paginate(24);
                            } else {
                                $post = Post::orderBy('created_at', 'desc')->where('status', 'Published')->paginate(24);
                            }
                        }
                    }
                    // 
                    if ($_GET['postby'] == 'popular') {
                        if (!empty($_GET['pricefrom']) || !empty($_GET['priceto'])) {
                            if (!empty($keysearch)) {
                                $post = Post::where($keysearch)->where('price', '>=', $_GET['pricefrom'])->where('price', '<=', $_GET['priceto'])->where('status', 'Published')->orderBy('views', 'desc')->paginate(24);
                            } else {
                                $post = Post::where('price', '>=', $_GET['pricefrom'])->where('price', '<=', $_GET['priceto'])->orderBy('views', 'desc')->paginate(24);
                            }
                        } else {
                            if (!empty($keysearch)) {
                                $post = Post::where($keysearch)->where('status', 'Published')->orderBy('views', 'desc')->paginate(24);
                            } else {
                                $post = Post::where('status', 'Published')->orderBy('views', 'desc')->paginate(24);
                            }
                        }
                    }
                }
            }
            //
        }
        return view('khmer24.search-result')->withCategoty($categoty)->withSubcategory($subcategory)->withLocation($location)->withPost($post)->withAdsleft($adsleft)->withAdstop($adstop)->withAdsright($adsright);
    }

    public function savePost(Request $request)
    {
        $url = $request->url;
        $imageFile = $request->photo;

        foreach ($imageFile as $file) {//this statement will loop through all files.
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
        $imageThum = rtrim(str_replace($arr, '', $imageThum), ','); // img thum

        $imageFile = '[' . $imageFile . ']';
        $imageThum = '[' . $imageThum . ']'; //img thum
        $imageFile = $imageFile;
        $post = new Post();
        $post->user_id = Auth::user()->id;
        $post->name = $request->name;
        $post->brand = $request->variation_type;
        $post->price = $request->price;
        $post->description = $request->description;
        $post->username = $request->username;
        $post->phone = $request->phone;
        $post->email = $request->email;
        $post->images = $imageFile;
        $post->img_thum = $imageThum;
        $post->sub_category_name = $request->subcategoryname;
        $post->category_name = $request->categoryname;
        $post->location_name = $request->location;
        $post->address = $request->categoryname;
        $post->Save();
        return redirect()->back()->with('message_save', 'Your product has been saved!');
    }

    public function getstore($id, $name)
    {
        $post = Post::where('user_id', $id)->where('status', 'Published')->orderBy('id', 'desc')->paginate(10);
        return view('user-stores')->withPost($post)->withId($id);
    }

    public function getHowtouse()
    {
        $categoty = Category::where('parent_id', '0')->get();
        $subcategory = Category::where('parent_id', '!=', '0')->get();
        $location = Location::where('status', 'Publish')->get();
        $howtouse = Information::where('type', 'Use')->get();
        return view('how-to-use')->withHowtouse($howtouse)->withCategoty($categoty)->withSubcategory($subcategory)->withLocation($location);
    }

    public function getUpgradebusiness()
    {
        $categoty = Category::where('parent_id', '0')->get();
        $subcategory = Category::where('parent_id', '!=', '0')->get();
        $location = Location::where('status', 'Publish')->get();
        $business = Information::where('type', 'Business')->get();
        return view('upgrade-business')->withBusiness($business)->withCategoty($categoty)->withSubcategory($subcategory)->withLocation($location);
    }
}
