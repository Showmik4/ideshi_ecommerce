<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SliderController extends Controller
{
    use ImageTrait;

    public function show()
    {
        return view('slider.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $slider = Slider::all();
        return datatables()->of($slider)
            ->addColumn('imageLink', function (Slider $slider){
                if (isset($slider->imageLink)) {
                    return '<img height="50px" width="50px" src="'.url($slider->imageLink).'" alt="">';
                }
                return '';
            })
            ->addColumn('status', function (Slider $slider){
                if ($slider->status === 'active') {
                    return '<label class="btn btn-success">Active</label>';
                }
                return '<label class="btn btn-danger">Inactive</label>';
            })
            ->setRowAttr([
                'align'=>'center',
            ])
            ->rawColumns(['imageLink', 'status'])
            ->make(true);
    }

    public function create()
    {
        return view('slider.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'titleText' => 'required|string|max:255',
            'mainText' => 'nullable|string|max:255',
            'subText' => 'nullable|string|max:255',
            'imageLink' => 'required|image|mimes:jpeg,png,jpg',
            'status' => 'required|string|max:45',
            'pageLink' => 'nullable|string',
            'serial' => 'required|numeric',
        ]);

        Slider::query()->create([
            'titleText' => $validated['titleText'],
            'mainText' => $validated['mainText'],
            'subText' => $validated['subText'],
            'imageLink' => $this->save_image('sliderImage', $validated['imageLink']),
            'status' => $validated['status'],
            'pageLink' => $validated['pageLink'],
            'serial' => $validated['serial'],
        ]);

        Session::flash('success', 'Slider Created Successfully!');
        return redirect()->route('slider.show');
    }

    public function edit($sliderId)
    {
        $slider = Slider::query()->where('sliderId', $sliderId)->first();
        return view('slider.edit', compact( 'slider'));
    }

    public function update(Request $request, $sliderId): RedirectResponse
    {
        $validated = $this->validate($request, [
            'titleText' => 'required|string|max:255',
            'mainText' => 'nullable|string|max:255',
            'subText' => 'nullable|string|max:255',
            'imageLink' => 'nullable|image|mimes:jpeg,png,jpg',
            'status' => 'required|string|max:45',
            'pageLink' => 'nullable|string',
            'serial' => 'required|numeric',
        ]);

        $slider = Slider::query()->where('sliderId', $sliderId)->first();
        if(!empty($slider)) {
            if (empty($validated['imageLink'])) {
                $imageLink = $slider->imageLink;
            } else {
                $this->deleteImage($slider->imageLink);
                $imageLink = $this->save_image('sliderImage', $validated['imageLink']);
            }

            $slider->update([
                'titleText' => $validated['titleText'],
                'mainText' => $validated['titleText'],
                'subText' => $validated['subText'],
                'imageLink' => $imageLink,
                'status' => $validated['status'],
                'pageLink' => $validated['pageLink'],
                'serial' => $validated['serial'],
            ]);
        }

        Session::flash('success', 'Slider Updated Successfully!');
        return redirect()->route('slider.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $slider = Slider::query()->where('sliderId', $request->sliderId)->first();
        If (!empty($slider)) {
            $slider->delete();
        }
        return response()->json();
    }
}
