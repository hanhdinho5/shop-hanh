<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Product;


class PostController extends Controller
{
    function post(){
        $bestsellingProducts = Product::bestselling()->paginate(7);
        $posts = Post::paginate(4);

        return view('client.post.post', compact('bestsellingProducts', 'posts'));
    }

    function detail($slug, $id){
        $detail = Post::find($id);
        // dd($detail);
        // return $detail;
        $bestsellingProducts = Product::bestselling()->paginate(7);
        return view("client.post.detail", compact('bestsellingProducts', 'detail'));
    }
}
