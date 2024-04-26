<?php

namespace App\Http\Controllers;
use Darryldecode\Cart\CartCondition;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ShipmentZone;
use App\Models\Address;
use App\Models\OrderInfo;
use App\Models\Promotion;
use App\Models\Sku;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $top_banners = Banner::query()->where('status', 'active')->where('type','top')->get();
        $newArrival=Product::query()->where('status', 'active')->where('newArrived',1)->orderByDesc('created_at')->get();
        $brands = Brand::query()->where('status', 'active')->get();
        $men_categories =Category::query()->where('homeShow', 1)->where('gender','Men')->get();
        $women_categories =Category::query()->where('homeShow', 1)->where('gender','Women')->get();
        $sale_banners = Banner::with('promotion')->where('status', 'active')->where('type','sale')->get();
        $saving_banners = Banner::with('promotion')->where('status', 'active')->where('type','saving')->get();
        $payday = Banner::with('promotion')->where('status', 'active')->where('type','payday')->get();
        $promo = Banner::with('promotion')->where('status', 'active')->where('type','promo')->get();
        return view('index',compact('top_banners','newArrival','brands','men_categories','women_categories','sale_banners','saving_banners','payday','promo'));
    }

    public function myaccount()
    {
        $customer = Customer::with('user', 'address')->where('fkUserId', Auth::user()->userId)->first();
        $orders = OrderInfo::with('orderItems')->where('fkCustomerId', $customer->customerId)->get();
        return view('my-account',compact('customer','orders'));
    }

    public function myAccountUpdate(Request $request, $userId): RedirectResponse
    {
        $user = User::where('userId', $userId)->first();    
        if ($user) {
            $user->update([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
            ]);
    
            $customer = Customer::where('fkUserId', $userId)->first();
                
            if ($customer) {
                if ($customer->fkAddressId !== null) {
                    Address::where('addressId', $customer->fkAddressId)->update([
                        'billingAddress' => $request->input('billingAddress'),
                    ]);
                } else {
                    $address = Address::create([
                        'billingAddress' => $request->input('billingAddress'),
                    ]);
    
                    $customer->update([
                        'fkAddressId' => $address->addressId,
                    ]);
                }
            }
    
            Session::flash('success', 'Profile updated successfully!');
            return redirect()->back();
        }
    
        Session::flash('error', 'User not found!');
        return redirect()->back();
    }
    

    
    public function checkout()
    {
        // $shippingZones = ShipmentZone::all();
        // $countries = Country::all();
        return view('checkout');
    }

    public function wishlist()
    {
        $customerId = Customer::query()->where('fkUserId', Auth::user()->userId)->first()->customerId;        
        $wishlists = Wishlist::with('sku.product')->where('fkCustomerId', $customerId)->get();
        return view('wishlist', compact('wishlists'));
    }

    public function addToWishlist(Request $request): JsonResponse
    {
        $customerId = Customer::query()->where('fkUserId', Auth::user()->userId)->first()->customerId;
        $wishlistedSku = Wishlist::query()->where('fkSkuId', $request->skuId)->where('fkCustomerId', $customerId)->first();
        if(empty($wishlistedSku)) {
            if(isset($request->skuId, $customerId)) {
                Wishlist::query()->create([
                    'fkSkuId' => $request->skuId,
                    'fkCustomerId' => $customerId,
                ]);
                return response()->json(['success' => 'Product Added to Wishlist Successfully!']);
            }
            return response()->json(['error' => 'Product or Customer Not Found!']);
        }
        return response()->json(['warning' => 'This Product has already added in Wishlist!']);
    }

    public function deleteWishlist(Request $request): JsonResponse
    {
        $customerId = Customer::query()->where('fkUserId', Auth::user()->userId)->first()->customerId;
        Wishlist::query()->where('fkSkuId', $request->skuId)->where('fkCustomerId', $customerId)->delete();
        return response()->json();
    }  
   
        
    public function applyPromoCode(Request $request)
    {
        $promoCode = $request->input('promo_code');       
        $promotion = Promotion::where('promotionCode', $promoCode)
            ->where('status', 'active')
            ->first();
    
        if ($promotion) 
        {           
           
            if ($promotion->totalUsed < $promotion->useLimit) 
            {              
                $discount = $promotion->amount;
                $discountType = $promotion->type;  
                
                return response()->json([
                    'success' => true,
                    'message' => 'Coupon applied successfully',
                    'discountAmount' => $discount,
                    'discountType' => $discountType,
                ]);
            } else {
               
                return response()->json(['error' => true, 'message' => 'Coupon usage limit exceeded']);
            }
        }
      
        else 
        {
           
            return response()->json(['error' => true, 'message' => 'Invalid or inactive coupon code']);
        }
    }

   
        public function page($pageId)
        {
            $page = Page::query()->where('pageId', $pageId)->first();
            return view('page', compact('page'));
        }
  
    
    


}
