<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    use ImageTrait;

    public function show()
    {
        $setting = Setting::query()->first();
        return view('setting.index', compact('setting'));
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $setting = Setting::all();
        return datatables()->of($setting)
            ->addColumn('logo', function (Setting $setting){
                if (isset($setting->logo)) {
                    return '<img height="50px" width="50px" src="'.url($setting->logo).'" alt="">';
                }
                return '';
            })
            ->addColumn('logoDark', function (Setting $setting){
                if (isset($setting->logoDark)) {
                    return '<img height="50px" width="50px" src="'.url($setting->logoDark).'" alt="">';
                }
                return '';
            })
            ->setRowAttr([
                'align'=>'center',
            ])
            ->rawColumns(['logo', 'logoDark'])
            ->make(true);
    }

    public function create()
    {
        return view('setting.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'companyName' => 'required|string|max:255',
            'email' => 'required|email|max:50',
            'logo' => 'required|image|mimes:jpeg,png,jpg',
            'logoDark' => 'nullable|image|mimes:jpeg,png,jpg',
            'address' => 'required|string',
            'googleMapLink' => 'required|string',
            'phone' => 'required|string|max:30',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'contactText1' => 'nullable|string',
            'contactText2' => 'nullable|string',
            'openingHoursText1' => 'nullable|string|max:255',
            'openingHoursText2' => 'nullable|string|max:255',
            'careerText' => 'nullable|string|max:255',
            'aboutImage' => 'nullable|image|mimes:jpeg,png,jpg',
            'aboutTitle' => 'nullable|string',
            'aboutTop' => 'nullable|string',
            'aboutLeftText' => 'nullable|string',
            'aboutRightText' => 'nullable|string',
            'homeCategoryText' => 'nullable|string',
            'homeNewProductText' => 'nullable|string|max:255',
            'homeNewProductImage' => 'nullable|image|mimes:jpeg,png,jpg',
            'homeMostPopularText' => 'nullable|string|max:255',
            'homeMostPopularImage' => 'nullable|image|mimes:jpeg,png,jpg',
            'homeBestValueText' => 'nullable|string|max:255',
            'homeBestValueImage' => 'nullable|image|mimes:jpeg,png,jpg',
            'homeAboutUsText' => 'nullable|string',
            'homeAboutUsImage' => 'nullable|image|mimes:jpeg,png,jpg',
            'newProductText' => 'nullable|string',
            'homeShowroomText' => 'nullable|string',
            'homeShowroomImage' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        Setting::query()->create([
            'companyName' => $validated['companyName'],
            'email' => $validated['email'],
            'logo' => $this->save_image('settingImage', $validated['logo']),
            'logoDark' => isset($validated['logoDark']) ? $this->save_image('settingImage', $validated['logoDark']) : null,
            'address' => $validated['address'],
            'googleMapLink' => $validated['googleMapLink'],
            'phone' => $validated['phone'],
            'facebook' => $validated['facebook'],
            'twitter' => $validated['twitter'],
            'instagram' => $validated['instagram'],
            'contactText1' => $validated['contactText1'],
            'contactText2' => $validated['contactText2'],
            'openingHoursText1' => $validated['openingHoursText1'],
            'openingHoursText2' => $validated['openingHoursText2'],
            'careerText' => $validated['careerText'],
            'aboutImage' => isset($validated['aboutImage']) ? $this->save_image('settingImage', $validated['aboutImage']) : null,
            'aboutTitle' => $validated['aboutTitle'],
            'aboutTop' => $validated['aboutTop'],
            'aboutLeftText' => $validated['aboutLeftText'],
            'aboutRightText' => $validated['aboutRightText'],
            'homeCategoryText' => $validated['homeCategoryText'],
            'homeNewProductText' => $validated['homeNewProductText'],
            'homeNewProductImage' => isset($validated['homeNewProductImage']) ? $this->save_image('settingImage', $validated['homeNewProductImage']) : null,
            'homeMostPopularText' => $validated['homeMostPopularText'],
            'homeMostPopularImage' => isset($validated['homeMostPopularImage']) ? $this->save_image('settingImage', $validated['homeMostPopularImage']) : null,
            'homeBestValueText' => $validated['homeBestValueText'],
            'homeBestValueImage' => isset($validated['homeBestValueImage']) ? $this->save_image('settingImage', $validated['homeBestValueImage']) : null,
            'homeAboutUsText' => $validated['homeAboutUsText'],
            'homeAboutUsImage' => isset($validated['homeAboutUsImage']) ? $this->save_image('settingImage', $validated['homeAboutUsImage']) : null,
            'newProductText' => $validated['newProductText'],
            'homeShowroomText' => $validated['homeShowroomText'],
            'homeShowroomImage' => isset($validated['homeShowroomImage']) ? $this->save_image('settingImage', $validated['homeShowroomImage']) : null,
        ]);

        Session::flash('success', 'Setting Created Successfully!');
        return redirect()->route('setting.show');
    }

    public function edit($settingId)
    {
        $setting = Setting::query()->where('settingId', $settingId)->first();
        return view('setting.edit', compact( 'setting'));
    }

    public function update(Request $request, $settingId): RedirectResponse
    {
        $validated = $this->validate($request, [
            'companyName' => 'required|string|max:255',
            'email' => 'required|email|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg',
            'logoDark' => 'nullable|image|mimes:jpeg,png,jpg',
            'address' => 'required|string',
            'googleMapLink' => 'required|string',
            'phone' => 'required|string|max:30',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'contactText1' => 'nullable|string',
            'contactText2' => 'nullable|string',
            'openingHoursText1' => 'nullable|string|max:255',
            'openingHoursText2' => 'nullable|string|max:255',
            'free_delivery_area'=>'nullable',
            'return_policy'=>'nullable',
            'payment_hour'=>'nullable',
            'free_shipping_policy'=>'nullable',
            'shipping_cost'=>'nullable',
            'min_price_range'=>'nullable',
            'max_price_range'=>'nullable',
        ]);

        $setting = Setting::query()->first();
        if(!empty($setting)) {
            if (empty($validated['logo'])) {
                $logo = $setting->logo;
            } else {
                $this->deleteImage($setting->logo);
                $logo = $this->save_image('settingImage', $validated['logo']);
            }

            if (empty($validated['logoDark'])) {
                $logoDark = $setting->logoDark;
            } else {
                $this->deleteImage($setting->logoDark);
                $logoDark = $this->save_image('settingImage', $validated['logoDark']);
            }

            $setting->update([
                'companyName' => $validated['companyName'],
                'email' => $validated['email'],
                'logo' => $logo,
                'logoDark' => $logoDark,
                'address' => $validated['address'],
                'googleMapLink' => $validated['googleMapLink'],
                'phone' => $validated['phone'],
                'facebook' => $validated['facebook'],
                'twitter' => $validated['twitter'],
                'instagram' => $validated['instagram'],
                'contactText1' => $validated['contactText1'],
                'contactText2' => $validated['contactText2'],
                'openingHoursText1' => $validated['openingHoursText1'],
                'openingHoursText2' => $validated['openingHoursText2'],
                'free_delivery_area'=>$validated['free_delivery_area'],
                'return_policy'=>$validated['return_policy'],
                'payment_hour'=>$validated['payment_hour'],
                'free_shipping_policy'=>$validated['free_shipping_policy'],   
                'shipping_cost'=>$validated['shipping_cost'],  
                'min_price_range'=>$validated['min_price_range'],
                'max_price_range'=>$validated['max_price_range'],       
              
            ]);
        }

        Session::flash('success', 'Setting Updated Successfully!');
        return redirect()->route('setting.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $setting = Setting::query()->first();
        If (!empty($setting)) {
            $setting->delete();
        }
        return response()->json();
    }
}
