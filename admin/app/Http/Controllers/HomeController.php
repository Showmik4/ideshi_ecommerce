<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\OrderInfo;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        $order=OrderInfo::count();
        $client=Customer::count();
        $product=Product::count();
        $category=Category::count();
        return view('home',compact('order','client','product','category'));
    }

    public function upload(Request $request): void
    {
        if($request->hasFile('upload') && $request->file('upload') !== null) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName .= '_' . time() . '.' . $extension;

            if (!File::isDirectory('public/ckImages')) {
                File::makeDirectory(('public/ckImages'), 0777, true, true);
            }

            $request->file('upload')->move(public_path('ckImages'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = url('public/ckImages/'.$fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
