<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Support\Facades\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ShopController extends Controller
{  
    
    public function view()    
    {               
        $brands = Brand::query()->where('status', 'active')->get();
        $categories =Category::query()->where('homeShow', 1)->get();   
        $parentCategories = Category::query()->where('parent', null)->orderBy('category_serial')->get();
        $subCategories = Category::query()->where('parent', '!=', null)->orderBy('category_serial')->get();    
        return view('shop',compact('brands','categories','parentCategories','subCategories'));
    }

    // public function search(Request $request)
    // {
    //     $searchText = $request->input('search_text');       
    //     $products = Product::where('productName', 'like', '%' . $searchText . '%')->get();
    //     return response()->json(['results' => $products]);
    // }

    public function getFilteredProducts(Request $request)
    {    
        
        $selectedBrands = $request->input('brands', []);
        $selectedCategory = $request->input('category', []);   
        $filterText=$request->get('search', '');       
        $min_search=$request->get('minAmount','');        
        $max_search=$request->get('maxAmount','');       
        $filters=$request->get('filter', '');
        
        $category=Category::query()->get();
        $query = Product::with('brand', 'category','sku')
            ->where('status', 'active')
            ->orderByDesc('created_at');          
            if (!empty($filterText)) 
            {
                $query->where('productName', 'like', '%' . $filterText . '%');
            }

            if (!empty($min_search) && !empty($max_search)) {                
                $query->whereHas('sku', function ($q) use ($min_search, $max_search) {
                    $q->whereBetween('regularPrice', [$min_search, $max_search]);
                });
            }    

            if ($category->pluck('categoryId')->contains($filters)) {
                $query->whereHas('category', function ($q) use ($filters) {
                    $q->where('categoryId', $filters);
                });
            } 
                     
    
        // Apply filters if they are provided
        if (!empty($selectedBrands) || !empty($selectedCategory)) 
        {
            $query->where(function ($query) use ($selectedBrands, $selectedCategory) 
            {
                $query->when(!empty($selectedBrands), function ($query) use ($selectedBrands) 
                {
                    $query->whereHas('brand', function ($q) use ($selectedBrands) 
                    {
                        $q->whereIn('brandId', $selectedBrands);
                    });
                });

                $query->when(!empty($selectedCategory), function ($query) use ($selectedCategory) 
                {
                    $query->orWhereHas('category', function ($q) use ($selectedCategory) 
                    {
                        $q->whereIn('categoryId', $selectedCategory);
                    });
                });
            });
        }
   
        $perPage = 8;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $products = $query->paginate($perPage, ['*'], 'page', $currentPage);
    
        $response = [
            'data' => View::make('ajaxProductList', ['products' => $products])->render(),
            'pagination' => $products->links()->toHtml(),
        ];
    
        return response()->json($response);
    }

    public function search_product(Request $request)
    {
        // $products=Product::where('productName', 'like', '%'.$request->search.'%')
        // ->orderby('productId','desc')
        // ->paginate(8);

        // if($products->count() >= 1)       
        // {
        //     return view('ajaxProductList',compact('products'))->render();
        // }
    }   
}
