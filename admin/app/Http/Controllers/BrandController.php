<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    use ImageTrait;

    public function show()
    {
        return view('brand.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $brand = Brand::all();
        return datatables()->of($brand)
            ->addColumn('brandLogo', function (Brand $brand){
                if (isset($brand->brandLogo)) {
                    return '<img height="50px" width="50px" src="'.url($brand->brandLogo).'" alt="">';
                }
                return '';
            })
            ->addColumn('status', function (Brand $brand){
                if ($brand->status === 'active') {
                    return '<label class="btn btn-success">Active</label>';
                }
                return '<label class="btn btn-danger">Inactive</label>';
            })
            ->setRowAttr([
                'align'=>'center',
            ])
            ->rawColumns(['brandLogo', 'status'])
            ->make(true);
    }

    public function create()
    {
        return view('brand.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'brandName' => 'required|string|max:255|alpha',
            'brandLogo' => 'required|image|mimes:jpeg,png,jpg',
            'status' => 'required|string|max:45',
        ]);

        Brand::query()->create([
            'brandName' => $validated['brandName'],
            'brandLogo' => $this->save_image('brandImage', $validated['brandLogo']),
            'status' => $validated['status'],
        ]);

        Session::flash('success', 'Brand Created Successfully!');
        return redirect()->route('brand.show');
    }

    public function edit($brandId)
    {
        $brand = Brand::query()->where('brandId', $brandId)->first();
        return view('brand.edit', compact( 'brand'));
    }

    public function update(Request $request, $brandId): RedirectResponse
    {
        $validated = $this->validate($request, [
            'brandName' => 'nullable|string|max:255|alpha',
            'brandLogo' => 'nullable|image|mimes:jpeg,png,jpg',
            'status' => 'required|string|max:45',
        ]);

        $brand = Brand::query()->where('brandId', $brandId)->first();
        if(!empty($brand)) {
            if (empty($validated['brandLogo'])) {
                $brandLogo = $brand->brandLogo;
            } else {
                $this->deleteImage($brand->brandLogo);
                $brandLogo = $this->save_image('brandImage', $validated['brandLogo']);
            }

            $brand->update([
                'brandName' => $validated['brandName'],
                'brandLogo' => $brandLogo,
                'status' => $validated['status'],
            ]);
        }

        Session::flash('success', 'Brand Updated Successfully!');
        return redirect()->route('brand.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $brand = Brand::query()->where('brandId', $request->brandId)->first();
        If (!empty($brand)) {
            $brand->delete();
        }
        return response()->json();
    }
}
