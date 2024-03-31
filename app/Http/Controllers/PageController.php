<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    function introduce(){
        $bestsellingProducts = Product::bestselling()->paginate(7);
        return view('client.page.introduce', compact('bestsellingProducts'));
    }

    function contact(){
        $bestsellingProducts = Product::bestselling()->paginate(7);
        return view('client.page.contact', compact('bestsellingProducts'));
    }


}
