<?php
namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Models\ProductVariationTemp;
use App\Models\Sku;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\Variation;
use App\Models\VariationRelation;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    use ImageTrait;

    public function show()
    {
        return view('product.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $product = Product::with('category', 'brand')->orderByDesc('productId')->get();
        return datatables()->of($product)
            ->addColumn('featureImage', function (Product $product){
                if (isset($product->featureImage)) {
                    return '<img height="50px" width="50px" src="'.url($product->featureImage).'" alt="">';
                }
                return '';
            })
            ->addColumn('fkCategoryId', function (Product $product){
                if (isset($product->fkCategoryId)) {
                    return @$product->category->categoryName;
                }
                return '';
            })
            ->addColumn('fkBrandId', function (Product $product){
                if (isset($product->fkBrandId)) {
                    return @$product->brand->brandName;
                }
                return '';
            })
            ->addColumn('status', function (Product $product){
                if ($product->status === 'active') {
                    return '<label class="btn btn-success">Active</label>';
                }
                return '<label class="btn btn-danger">Inactive</label>';
            })
            ->setRowAttr([
                'align'=>'center',
            ])
            ->rawColumns(['featureImage', 'status'])
            ->make(true);
    }

    public function create()
    {
        Session::put('uniqueSession', uniqid('', false));
        $parentCategories = Category::query()->where('parent', '!=', null)->pluck('parent')->unique();
        $categories = Category::query()->whereNotIn('categoryId', $parentCategories)->get();
        $brands = Brand::query()->where('status', 'active')->get();
        $units = Unit::all();
        $variations = Variation::all();
        return view('product.create', compact('categories', 'brands', 'units', 'variations'));
    }

    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        $validated = $this->validate($request, [
            //product
            'productName' => 'required|string|unique:product|max:255',
            'productCode' => 'required|string|unique:product|max:100',
            'slug' => 'nullable|string|unique:product|max:255',
            'tag' => 'required|string|max:45',
            'fkCategoryId' => 'required|numeric',
            'fkBrandId' => 'required|numeric',
            'fkUnitId' => 'required|numeric',
            'type' => 'required|string|max:10',
            'featureImage' => 'required|image|mimes:jpeg,png,jpg',
            'status' => 'required|string',
            'newArrived' => 'nullable|numeric',
            'isRecommended' => 'nullable|numeric',
            //product details
            'shortDescription' => 'required|string',
            'longDescription' => 'nullable|string',
            'fabricDetails' => 'nullable|string',   
            'pattern' => 'nullable|string', 
            'fit' => 'nullable|string',
            'nace' => 'nullable|string',      
            'sleeve' => 'nullable|string', 
            'style' => 'nullable|string',        
            //product image
            'image' => 'required_if:type,single',
            //sku
            'barcode' => 'required_if:type,single|nullable|string|max:50',
            'salePrice' => 'nullable|numeric',
            'regularPrice' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'discountType' => 'required_with:discount|nullable|string|max:50',
            'stockAlert' => 'required_if:type,single|nullable|numeric',
            //stock
            'sQuantity' => 'required_if:type,single',
        ]);

        DB::transaction(function() use ($validated) {
            $productDetails = ProductDetail::query()->create([
                'shortDescription' => $validated['shortDescription'],
                'longDescription' => $validated['longDescription'],
                'fabricDetails' => $validated['fabricDetails'],
                'pattern' => $validated['pattern'],
                'fit' => $validated['fit'],
                'nace' => $validated['nace'],
                'sleeve' => $validated['sleeve'],
                'style' => $validated['style'],
            ]);
            
            $featureImage = $validated['featureImage'];
            $imageName = $featureImage->getClientOriginalName(); 
            $imagePath = 'productImage/' . $imageName;           
            
            $featureImage->move(public_path('productImage'), $imageName);           
            
            $imagePath = 'productImage/' . $imageName;           
            
            $image = Image::make(public_path($imagePath));           
            
            $image->resize(264, 264);           
            
            $image->save();

            $imagePathWithPublic = 'public/' . $imagePath;

            $product = Product::query()->create([
                'productName' => $validated['productName'],
                'productCode' => $validated['productCode'],
                'slug' => isset($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['productName']),
                'tag' => $validated['tag'],
                'fkCategoryId' => $validated['fkCategoryId'],
                'fkBrandId' => $validated['fkBrandId'],
                'fkUnitId' => $validated['fkUnitId'],
                'fkProductDetailsId' => $productDetails->productDetailsId,
                'type' => $validated['type'],
                'featureImage' => $imagePathWithPublic,
                'status' => $validated['status'],
                'newArrived' => $validated['newArrived'] ?? null,
                'isRecommended' => $validated['isRecommended'] ?? null,
            ]);

            if ($product->type === "single") {
                $sku = Sku::query()->create([
                    'barcode' => $validated['barcode'],
                    'fkProductId' => $product->productId,
                    'salePrice' => $validated['salePrice'],
                    'regularPrice' => $validated['regularPrice'],
                    'discount' => $validated['discount'],
                    'discountType' => $validated['discountType'],
                    'stockAlert' => $validated['stockAlert'],
                    'status' => $validated['status'],
                ]);

                $stock = Stock::query()->create([
                    'fkskuId' => $sku->skuId,
                    'batchId' => 0,
                    'stock' => $validated['sQuantity'],
                    'type' => 'in',
                    'identifier' => 'purchase',
                ]);

                if (isset($validated['image'])) {
                    foreach ($validated['image'] as $image) 
                    {
                        ProductImage::query()->create([
                            'fkProductId' => $product->productId,
                            'fkSkuId' => $sku->skuId,
                            'image' => $this->save_image('productImage', $image),
                        ]);
                    }
                }
            }

            if ($product->type === 'variation') {
                $sessionId = Session::get('uniqueSession');
                $productVariationTemps = ProductVariationTemp::where('sessionId', $sessionId)->get();
                if(!empty($productVariationTemps)){
                    foreach($productVariationTemps as $productVariationTemp) {
                        $sku = Sku::query()->create([
                            'barcode' => $productVariationTemp->barcode,
                            'fkProductId' => $product->productId,
                            'salePrice' => $productVariationTemp->salePrice,
                            'regularPrice' => $productVariationTemp->regularPrice,
                            'discount' => $productVariationTemp->discount,
                            'discountType' => $productVariationTemp->discountType,
                            'stockAlert' => $productVariationTemp->stockAlert,
                            'status' => $validated['status'],
                        ]);

                        $stock = Stock::query()->create([
                            'fkskuId' => $sku->skuId,
                            'batchId' => 0,
                            'stock' => $productVariationTemp->quantity,
                            'type' => 'in',
                            'identifier' => 'purchase',
                        ]);



                        if (isset($productVariationTemp->variationId1)) {
                            VariationRelation::query()->create([
                                'skuId' => $sku->skuId,
                                'productId' => $product->productId,
                                'variationId' => $productVariationTemp->variationId1,
                            ]);
                        }

                        if (isset($productVariationTemp->variationId2)) {
                            VariationRelation::query()->create([
                                'skuId' => $sku->skuId,
                                'productId' => $product->productId,
                                'variationId' => $productVariationTemp->variationId2,
                            ]);
                        }

                        foreach (json_decode($productVariationTemp->variationImage) as $variationImage) 
                        {
                            ProductImage::query()->create([
                                'fkProductId' => $product->productId,
                                'fkSkuId' => $sku->skuId,
                                'image' => $variationImage,
                            ]);
                        }
                    }
                }
                ProductVariationTemp::where('sessionId', $sessionId)->delete();
            }
        });

        Session::flash('success', 'Product Created Successfully!');
        return redirect()->route('product.show');
    }

    public function edit($productId)
    {
        Session::put('uniqueSession', uniqid('', false));
        $product = Product::with('productDetails', 'sku', 'productImages')->where('productId', $productId)->first();
        $parentCategories = Category::query()->where('parent', '!=', null)->pluck('parent')->unique();
        $categories = Category::query()->whereNotIn('categoryId', $parentCategories)->get();
        $brands = Brand::query()->where('status', 'active')->get();
        $units = Unit::all();
        $variations = Variation::all();
        $sku = Sku::where('fkProductId', $productId)->first();
        $stockIn = Stock::where('fkskuId',$sku->skuId)->where('type','in')->where('identifier','purchase')->sum('stock');

        $stockOut = Stock::where('fkskuId',$sku->skuId)->where('type','out')->where('identifier','sale')->sum('stock');
        $stock = $stockIn - $stockOut;
        if($stock < 0){
            $stock = 0;
        }
        return view('product.edit', compact( 'product', 'categories', 'brands', 'units', 'variations','stock'));
    }

    public function update(Request $request, $productId): RedirectResponse
    {
       
        $validated = $this->validate($request, [
            //product
            'productName' => 'required|string|max:255|unique:product,productName,'.$productId.',productId',
            'productCode' => 'required|string|max:100|unique:product,productCode,'.$productId.',productId',
            'slug' => 'nullable|string|max:255',
            'tag' => 'required|string|max:45',
            'fkCategoryId' => 'required|numeric',
            'fkBrandId' => 'required|numeric',
            'fkUnitId' => 'required|numeric',
            'type' => 'required|string|max:10',
            'featureImage' => 'nullable|image|mimes:jpeg,png,jpg',
            'status' => 'nullable|string',
            'newArrived' => 'nullable|numeric',
            'isRecommended' => 'nullable|numeric',
            //product details
            'shortDescription' => 'required|string',
            'longDescription' => 'nullable|string',
            'fabricDetails' => 'nullable|string',
            'pattern'=>'nullable|string',
            'fit'=>'nullable|string',
            'neck'=>'nullable|string',
            'sleeve'=>'nullable|string',
            'style'=>'nullable|string',
            //product image
            'image' => 'nullable',
            //sku (product type single)
            'barcode' => 'required_if:type,single|nullable|string|max:50',
            'salePrice' => 'nullable',
            'regularPrice' => 'nullable',
            'discount' => 'nullable',
            'discountType' => 'required_with:discount|nullable|string|max:50',
            'stockAlert' => 'required_if:type,single|nullable|numeric',
            //stock
            'sQuantity' => 'required_if:type,single',
        ]);

        DB::transaction(function() use ($validated, $productId) {
            $product = Product::query()->where('productId', $productId)->first();
            if (!empty($product)) {
                $productDetails = ProductDetail::query()->where('productDetailsId', $product->fkProductDetailsId)->first();

                if (!empty($productDetails)) 
                {
                    $productDetails->update([
                        'shortDescription' => $validated['shortDescription'],
                        'longDescription' => $validated['longDescription'],
                        'fabricDetails' => $validated['fabricDetails'],
                        'pattern' => $validated['pattern'],
                        'fit' => $validated['fit'],
                        'nace' => $validated['neck'],
                        'sleeve' => $validated['sleeve'],
                        'style' => $validated['style'],
                    ]);
                }

                if (empty($validated['featureImage'])) {
                    $featureImage = $product->featureImage;
                } else {
                    $this->deleteImage($product->featureImage);
                    $featureImage = $validated['featureImage'];
                    $imageName = $featureImage->getClientOriginalName(); 
                    $imagePath = 'productImage/' . $imageName;           
                    
                    $featureImage->move(public_path('productImage'), $imageName);           
                    
                    $imagePath = 'productImage/' . $imageName;           
                    
                    $image = Image::make(public_path($imagePath));           
                    
                    $image->resize(264, 264);           
                    
                    $image->save();
        
                    $imagePathWithPublic = 'public/' . $imagePath;
                }

                $product->update([
                    'productName' => $validated['productName'],
                    'productCode' => $validated['productCode'],
                    'slug' => isset($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['productName']),
                    'tag' => $validated['tag'],
                    'fkCategoryId' => $validated['fkCategoryId'],
                    'fkBrandId' => $validated['fkBrandId'],
                    'fkUnitId' => $validated['fkUnitId'],
                    'type' => $validated['type'],
                    'featureImage' => $imagePathWithPublic,
                    'status' => $validated['status'],
                    'newArrived' => $validated['newArrived'] ?? null,
                    'isRecommended' => $validated['isRecommended'] ?? null,
                ]);

                if ($product->type === "single") {
                    Sku::query()->where('fkProductId', $product->productId)->delete();
                    $sku = Sku::query()->create([
                        'barcode' => $validated['barcode'],
                        'fkProductId' => $product->productId,
                        'salePrice' => $validated['salePrice'],
                        'regularPrice' => $validated['regularPrice'],
                        'discount' => $validated['discount'],
                        'discountType' => $validated['discountType'],
                        'stockAlert' => $validated['stockAlert'],
                        'status' => $validated['status'],
                    ]);

                    $stock = Stock::query()->create([
                        'fkskuId' => $sku->skuId,
                        'batchId' => 0,
                        'stock' => $validated['sQuantity'],
                        'type' => 'in',
                        'identifier' => 'edit',
                    ]);

                    if (isset($validated['image'])) {
                        foreach ($validated['image'] as $image) {
                            ProductImage::query()->create([
                                'fkProductId' => $product->productId,
                                'fkSkuId' => $sku->skuId,
                                'image' => $this->save_image('productImage', $image),
                            ]);
                        }
                    }
                }

                if ($product->type === 'variation') {
                    $sessionId = Session::get('uniqueSession');                    
                    $productVariationTemps = ProductVariationTemp::where('sessionId', $sessionId)->get();
                    if(!empty($productVariationTemps)){
                        foreach($productVariationTemps as $productVariationTemp) {
                            $sku = Sku::query()->create([
                                'barcode' => $productVariationTemp->barcode,
                                'fkProductId' => $product->productId,
                                'salePrice' => $productVariationTemp->salePrice,
                                'regularPrice' => $productVariationTemp->regularPrice,
                                'discount' => $productVariationTemp->discount,
                                'discountType' => $productVariationTemp->discountType,
                                'stockAlert' => $productVariationTemp->stockAlert,
                                'status' => $validated['status'],
                            ]);

                            if (isset($productVariationTemp->variationId1)) 
                            {
                                VariationRelation::query()->create([
                                    'skuId' => $sku->skuId,
                                    'productId' => $product->productId,
                                    'variationId' => $productVariationTemp->variationId1,
                                ]);
                            }

                            if (isset($productVariationTemp->variationId2)) {
                                VariationRelation::query()->create([
                                    'skuId' => $sku->skuId,
                                    'productId' => $product->productId,
                                    'variationId' => $productVariationTemp->variationId2,
                                ]);
                            }

                            foreach (json_decode($productVariationTemp->variationImage) as $variationImage) {
                                ProductImage::query()->create([
                                    'fkProductId' => $product->productId,
                                    'fkSkuId' => $sku->skuId,
                                    'image' => $variationImage,
                                ]);
                            }
                        }
                    }

                    
                    ProductVariationTemp::where('sessionId', $sessionId)->delete();
                }
            }
        });

        Session::flash('success', 'Product Updated Successfully!');
        return redirect()->route('product.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $product = Product::query()->where('productId', $request->productId)->first();
        If (!empty($product)) {
            $product->delete();
        }
        return response()->json();
    }

    public function variationTypeChange(Request $request): JsonResponse
    {
        $variations = Variation::where('variationType', $request->variationType)->get();
        return response()->json(['variations' => $variations]);
    }

    public function variationStore(Request $request): JsonResponse
    {        
        $validated = $this->validate($request, [
            'variationType1' => 'required_without:variationType2|different:variationType2|nullable|string',
            'variationType2' => 'required_without:variationType1|different:variationType1',
            'variationValue1' => 'required_with:variationType1',
            'variationValue2' => 'required_with:variationType2',
            'barcode' => 'required|string|max:50',
            'regularPrice' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'discountType' => 'nullable|string|max:50',
            'salePrice' => 'nullable|numeric',
            'stockAlert' => 'required|numeric',
            'variationImage' => 'required',
            'sQuantityVar' => 'required',
        ]);

        if (isset($validated['variationValue1'])) {
            $variation1 = Variation::where('variationId', $validated['variationValue1'])->first();
        }

        if (isset($validated['variationValue2'])) {
            $variation2 = Variation::where('variationId', $validated['variationValue2'])->first();
        }

        if (isset($validated['variationImage'])) {
            foreach ($validated['variationImage'] as $image) {
                $images[] = $this->save_image('productImage', $image);
            }
        }

        $productVariationTemp = ProductVariationTemp::query()->create([
            'barcode' => $validated['barcode'],
            'sessionId' => Session::get('uniqueSession'),
            'variationType1' => $validated['variationType1'],
            'variationValue1' => $variation1->variationValue ?? null,
            'variationId1' => $variation1->variationId ?? null,
            'variationType2' => $validated['variationType2'],
            'variationValue2' => $variation2->variationValue ?? null,
            'variationId2' => $variation2->variationId ?? null,
            'regularPrice' => $validated['regularPrice'],
            'salePrice' => $validated['salePrice'],
            'discount' => $validated['discount'],
            'discountType' => $validated['discountType'],
            'stockAlert' => $validated['stockAlert'],
            'variationImage' => !empty($images) ? json_encode($images) : null,
            'quantity' => $validated['sQuantityVar'],
        ]);



        $productVariationTemps = ProductVariationTemp::where('sessionId', $productVariationTemp->sessionId)->get();
        $view = view('product.productVariationTemp', compact('productVariationTemps'))->render();

        return response()->json(['html' => $view]);
    }

    public function variationListShow(Request $request)
    {
        $products = Product::with('sku', 'sku.variationRelation.variation', 'sku.variationImage')->where('productId', $request->productId)->first();
        return view('product.productVariationList', compact('products'));
    }

    //Variation Edit Page
    public function variationAjaxEdit(Request $request)
    {
        $variations = Variation::all();
        $variationRelation = VariationRelation::where('skuId', $request->skuId)->pluck('variationRelationId');
        $variationData = VariationRelation::where('skuId', $request->skuId)->pluck('variationId');
        $variationValue = Variation::whereIn('variationId', $variationData)->pluck('variationValue');
        $variationId = Variation::whereIn('variationId', $variationData)->pluck('variationId');
        $variationType = Variation::whereIn('variationId', $variationData)->pluck('variationType');
        $sku = Sku::with('variationRelation', 'variationRelation.variation')->where('skuId', $request->skuId)->first();

        return view('product.variationEdit', compact('sku', 'variationId', 'variations', 'variationRelation', 'variationData', 'variationValue', 'variationType'));
    }

    //Update Variation
    public function variationUpdate(Request $request): JsonResponse
    {
        $this->validate($request, [
            //            'barcode' => 'required',
            'variationType1' => 'required_without:variationType2|different:variationType2',
            'variationType2' => 'required_without:variationType1|different:variationType1',
            'variationValue1' => 'required_with:variationType1',
            'variationValue2' => 'required_with:variationType2',
            'regularPrice' => 'required',
        ]);

        $sku = Sku::where('skuId', $request->skuId)->first();

        $stock = Stock::where('fkskuId', $sku->skuId)->first();


        if ($request->variationRelationId1) {
            $variationRelation = VariationRelation::where('variationRelationId', $request->variationRelationId1)->first();
            $variationRelation->variationData = $request->variationValue1;
            $variationRelation->save();
        }

        if ($request->variationRelationId2) {
            $variationRelation = VariationRelation::where('variationRelationId', $request->variationRelationId2)->first();
            $variationRelation->variationData = $request->variationValue2;
            $variationRelation->save();
        }

        if ($request->hasFile('variationImage')) {
            foreach ($request->file('variationImage') as $vImage) {
                ProductImage::query()->create([
                    'fkProductId' => $sku->fkproductId,
                    'fkSkuId' => $sku->skuId,
                    'image' => $this->save_image('productImage', $vImage),
                ]);
            }
        }

        $fkproductId = $sku->fkproductId;
        $sku->barcode = $request->barcode;
        $sku->salePrice = $request->salePrice;
        $sku->regularPrice = $request->regularPrice;
        $sku->stockAlert = $request->stockAlert;
        $sku->save();

        if(empty($stock)){
            if (!empty($request->variationQuantity)) {
                $stock = new Stock();
                $stock->fkskuId = $sku->skuId;
                $stock->batchId = 0;
                $stock->stock = $request->variationQuantity;
                $stock->type = 'in';
                $stock->identifier = 'purchase';
                $stock->save();
            }
        }else{
            $stock->stock = $request->variationQuantity;
            $stock->save();
        }

        $products = Product::with('sku', 'sku.variationRelation', 'sku.variationRelation.variationDetailsdata', 'sku.variationImage')->where('productId', $fkproductId)->first();
        $view = view('product.productVariationList', compact('products'))->render();
        return response()->json(['html' => $view]);
    }

    public function deleteProductVariationTemp(Request $request): JsonResponse
    {
        $productVariationTemp = ProductVariationTemp::query()->where('productVariationTempId', $request->productVariationTempId)->first();
        If (!empty($productVariationTemp)) {
            $productVariationTemp->delete();
        }
        return response()->json();
    }

    public function deleteProductImage(Request $request): JsonResponse
    {
        $productImage = ProductImage::query()->where('productImageId', $request->productImageId)->first();
        if (!empty($productImage)) {
            $this->deleteImage($productImage->image);
            $productImage->delete();
        }
        return response()->json();
    }

    //Product Search
    public function productSearch(Request $data): JsonResponse
    {
        if (!empty($data->barCode)) {
            $productId = Sku::query()->where('barcode', $data->barCode)->first()->fkproductId;
            if (!empty($productId)) {
                $productData = Product::with(['sku.variationRelation.variation'])
                    ->where('status', 'active')
                    ->findOrfail($productId);

                return response()->json(['product' => $productData]);
            }

            return response()->json(['message' => 'Product not found'], 406);
        }

        if (!empty($data->category)) {
            $productData = Product::with(['sku.variationRelation.variation'])
                ->where(function ($query) use ($data) {
                    return $query->where('fkCategoryId', $data->category);
                })
                ->where('status', 'active')
                ->get();

            return response()->json(['product' => $productData]);
        } elseif (!empty($data->brand)) {
            $productData = Product::with(['sku.variationRelation.variation'])
                ->where(function ($query) use ($data) {
                    return $query->where('fkbrandId', $data->brand);
                })
                ->where('status', 'active')
                ->get();

            return response()->json(['product' => $productData]);
        } else {
            $productData = Product::with('sku.variationRelation.variation')
                ->where(function ($query) use ($data) {
                    return $query->where('productName', 'LIKE', '%' . $data->productIdOrName . '%')
                        ->orWhere('productId', 'LIKE', '%' . $data->productIdOrName . '%')
                        ->orWhere('productCode', 'LIKE', '%' . $data->productIdOrName . '%');
                })
                ->where('status', 'active')->get();

            return response()->json(['product' => $productData]);
        }
    }

    //Find Sub-Category
    public function findSubCategory(Request $request)
    {
        $subcategories = Category::where('parent', $request->categoryId)->get();

        return response()->json(['subcategories' => $subcategories]);
    }

    public function productImageDelete(Request $request)
    {
        $productImage = ProductImage::where('product_imageId', $request->productImageId);
        $productImage->delete();
        return response()->json();
    }

     //Variation Status Change
     public function variationStatusChange(Request $request)
     {
         $sku = Sku::where('skuId', $request->skuId)->first();
         if ($sku->status == 'active') {
             $sku->status = 'inactive';
         } elseif ($sku->status == 'inactive') {
             $sku->status = 'active';
         }
         $sku->save();

         return response()->json(['status' => $sku->status, 'skuId' => $sku->skuId]);
     }

     //New Variation Add
    public function variationAddNew(Request $request)
    {
        $this->validate($request, [
            //            'barcode' => 'required|unique:product_variation_temp',
            'variationType1' => 'required_without:variationType2|different:variationType2',
            'variationType2' => 'required_without:variationType1|different:variationType1',
            'variationValue1' => 'required_with:variationType1',
            'variationValue2' => 'required_with:variationType2',
            'regularPrice' => 'required'
        ]);

        //sku store
        $sku = new Sku();
        $sku->barcode = $request->barcode;
        $sku->fkproductId = $request->productId;
        $sku->salePrice = $request->salePrice;
        $sku->regular_price = $request->regularPrice;
        $sku->stockAlert = $request->stockAlert;
        $sku->save();

        if (!empty($request->variationQuantity)) {
            $stock = new Stock();
            $stock->fkskuId = $sku->skuId;
            $stock->batchId = 0;
            $stock->stock = $request->variationQuantity;
            $stock->type = 'in';
            $stock->identifier = 'purchase';
            $stock->save();
        }

        $productDetails = new ProductDetail();
        $productDetails->description = $request->variationDetails;
        $productDetails->fabricDetails = $request->variationShortDes;
        $productDetails->productId = $request->productId;
        $productDetails->fkskuId = $sku->skuId;
        $productDetails->save();

        //variation store
        if ($request->variationValue1) {
            $variationRelation = new VariationRelation();
            $variationRelation->skuId = $sku->skuId;
            $variationRelation->productId = $request->productId;
            $variationRelation->variationData = $request->variationValue1;
            $variationRelation->save();
        }

        if ($request->variationValue2) {
            $variationRelation = new VariationRelation();
            $variationRelation->skuId = $sku->skuId;
            $variationRelation->productId = $request->productId;
            $variationRelation->variationData = $request->variationValue2;
            $variationRelation->save();
        }

        if ($request->hasFile('variationImage')) {
            foreach ($request->file('variationImage') as $vimage) {
                $productImage = new ProductImage();
                $productImage->fkskuId = $sku->skuId;
                $productImage->fkProductId = $request->productId;
                $originalExtension = $vimage->getClientOriginalExtension();
                $uniqueImageName = $sku->skuId . rand(100, 999) . '.' . $originalExtension;
                $image = Image::make($vimage);
                //$image->resize(280, 280);
                $image->save(public_path() . '/productImages/' . $uniqueImageName);
                $productImage->image = $uniqueImageName;
                $productImage->save();
            }
        }

        $products = Product::with('sku', 'sku.variationRelation', 'sku.variationRelation.variationDetailsdata', 'sku.variationImage')->where('productId', $sku->fkproductId)->first();
        $view = view('product.tempVariationAjax', compact('products'))->render();

        return response()->json(['html' => $view]);
    }

}
