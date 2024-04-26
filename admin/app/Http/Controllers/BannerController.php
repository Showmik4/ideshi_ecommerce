<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Promotion;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class BannerController extends Controller
{
    use ImageTrait;

    public function show()
    {
        return view('banner.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $banner = Banner::with('promotion')->get();
        return datatables()->of($banner)
            ->addColumn('imageLink', function (Banner $banner){
                if (isset($banner->imageLink)) {
                    return '<img height="50px" width="50px" src="'.url($banner->imageLink).'" alt="">';
                }
                return '';
            })
            ->addColumn('status', function (Banner $banner)
            {
                if ($banner->status === 'active') {
                    return '<label class="btn btn-success">Active</label>';
                }
                return '<label class="btn btn-danger">Inactive</label>';
            })
            ->addColumn('fkPromotionId', function (Banner $banner){
                if (isset($banner->fkPromotionId)) {
                    return @$banner->promotion->promotionCode;
                }
                return '';
            })
            ->setRowAttr([
                'align'=>'center',
            ])
            ->rawColumns(['imageLink', 'status'])
            ->make(true);
    }

    public function create()
    {
        $promotions = Promotion::query()->where('status', 'active')->get();
        return view('banner.create', compact('promotions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'bannerTitle' => 'required|string|max:255',
            'type' => 'nullable|string|max:45',
            'status' => 'required|string|max:45',
            'imageLink' => 'required|image|mimes:jpeg,png,jpg',
            'pageLink' => 'nullable|string',
            'fkPromotionId' => 'nullable|numeric',
        ]);
       
        Banner::query()->create([
            'bannerTitle' => $validated['bannerTitle'],
            'type' => $validated['type'],
            'status' => $validated['status'],
            'imageLink' => $this->save_image('bannerImage', $validated['imageLink']),
            'pageLink' => $validated['pageLink'] ?? null,
            'fkPromotionId' => $validated['fkPromotionId'],
            'banner_description_1' => $request->input('banner_description_1'),
            'banner_description_2' => $request->input('banner_description_2'),
        ]);

        Session::flash('success', 'Banner Created Successfully!');
        return redirect()->route('banner.show');
    }

    public function edit($bannerId)
    {
        $promotions = Promotion::query()->where('status', 'active')->get();
        $banner = Banner::query()->where('bannerId', $bannerId)->first();
        return view('banner.edit', compact( 'banner', 'promotions'));
    }

    public function update(Request $request, $bannerId): RedirectResponse
    {
        $validated = $this->validate($request, [
            'bannerTitle' => 'required|string|max:255',
            'type' => 'nullable|string|max:45',
            'status' => 'required|string|max:45',
            'imageLink' => 'nullable|image|mimes:jpeg,png,jpg',
            'pageLink' => 'nullable|string',
            'fkPromotionId' => 'nullable|numeric',
            // 'banner_description_1'=>'nullable|string|max:255'
        ]);

        $banner = Banner::query()->where('bannerId', $bannerId)->first();
        if(!empty($banner)) {
            if (empty($validated['imageLink'])) {
                $imageLink = $banner->imageLink;
            } else {
                $this->deleteImage($banner->imageLink);
                $imageLink = $this->save_image('bannerImage', $validated['imageLink']);
            }
          
            $banner->update([
                'bannerTitle' => $validated['bannerTitle'],
                'type' => $validated['type'],
                'status' => $validated['status'],
                'imageLink' => $imageLink,
                'pageLink' => $validated['pageLink'] ?? null,
                'fkPromotionId' => $validated['fkPromotionId'],
                'banner_description_1' => $request->input('banner_description_1'),
                'banner_description_2' => $request->input('banner_description_2'),
            ]);         
        }

        Session::flash('success', 'Banner Updated Successfully!');
        return redirect()->route('banner.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $banner = Banner::query()->where('bannerId', $request->bannerId)->first();
        If (!empty($banner)) {
            $banner->delete();
        }
        return response()->json();
    }
}
