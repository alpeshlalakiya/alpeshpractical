<?php
/**
 * Created by PhpStorm.
 * User: roshani
 * Date: 18/12/20
 * Time: 7:06 PM
 */

namespace App\Http\Controllers;

use App\Blog;
use App\BlogCommentMapper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Symfony\Component\Console\Input\Input;

class BlogController extends Controller
{
    public function index(Request $request)  {
        $posts = Blog::all();
        return View::make('blog')->with('posts', $posts);
    }

    public function addComment(Request $request) {
        $response = array();
        $result = array();
        $validatedData = Validator::make($request->all(), [
            'comment' => 'required',
        ]);


        if ($validatedData->fails()) {
            $response = array();
            $response['code'] = 201;
            $response['content'] = $validatedData->errors();

            return response($response, $response['code'])
                ->header('content-type', 'application/json');
        }

        $addComment = new BlogCommentMapper();
        $addComment->blog_id = $request->blog_id;
        $addComment->comment = $request->comment;
        $result=  $addComment->save();

        if(isset($result)) {
            $response["code"] = 200;
            $response["status"] = "success";
            $response["message"] = "success";
            $response["content"] = "Comment Saved Succesfully";
        } else {
            $response["code"] = 201;
            $response["status"] = "error";
            $response["message"] = "Invalid Password";
            $response["content"] = "There is some error";
        }

        return response($response, $response["code"])
            ->header('Content-Type', "application/json");
    }
}