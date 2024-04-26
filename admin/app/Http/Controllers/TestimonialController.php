<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TestimonialController extends Controller
{
    use ImageTrait;

    public function show()
    {
        return view('testimonial.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $testimonial = Testimonial::all();
        return datatables()->of($testimonial)
            ->addColumn('imageLink', function (Testimonial $testimonial){
                if (isset($testimonial->imageLink)) {
                    return '<img height="50px" width="50px" src="'.url($testimonial->imageLink).'" alt="">';
                }
                return '';
            })
            ->addColumn('homeShow', function (Testimonial $testimonial){
                if ($testimonial->homeShow === 1) {
                    return '<i class="fa fa-check"></i>';
                }
                return '';
            })
            ->addColumn('status', function (Testimonial $testimonial){
                if ($testimonial->status === 'active') {
                    return '<label class="btn btn-success">Active</label>';
                }
                return '<label class="btn btn-danger">Inactive</label>';
            })
            ->setRowAttr([
                'align'=>'center',
            ])
            ->rawColumns(['homeShow', 'imageLink', 'status'])
            ->make(true);
    }

    public function create()
    {
        return view('testimonial.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'name' => 'required|string|max:45',
            'designation' => 'required|string|max:100',
            'imageLink' => 'required|image|mimes:jpeg,png,jpg',
            'details' => 'required|string',
            'homeShow' => 'nullable|numeric',
            'status' => 'required|string|max:45',
        ]);

        Testimonial::query()->create([
            'name' => $validated['name'],
            'designation' => $validated['designation'],
            'imageLink' => $this->save_image('testimonialImage', $validated['imageLink']),
            'details' => $validated['details'],
            'homeShow' => $validated['homeShow'] ?? null,
            'status' => $validated['status'],
        ]);

        Session::flash('success', 'Testimonial Created Successfully!');
        return redirect()->route('testimonial.show');
    }

    public function edit($testimonialId)
    {
        $testimonial = Testimonial::query()->where('testimonialId', $testimonialId)->first();
        return view('testimonial.edit', compact( 'testimonial'));
    }

    public function update(Request $request, $testimonialId): RedirectResponse
    {
        $validated = $this->validate($request, [
            'name' => 'required|string|max:45',
            'designation' => 'required|string|max:100',
            'imageLink' => 'nullable|image|mimes:jpeg,png,jpg',
            'details' => 'required|string',
            'homeShow' => 'nullable|numeric',
            'status' => 'required|string|max:45',
        ]);

        $testimonial = Testimonial::query()->where('testimonialId', $testimonialId)->first();
        if (!empty($testimonial)) {
            if (empty($validated['imageLink'])) {
                $imageLink = $testimonial->imageLink;
            } else {
                $this->deleteImage($testimonial->imageLink);
                $imageLink = $this->save_image('testimonialImage', $validated['imageLink']);
            }

            $testimonial->update([
                'name' => $validated['name'],
                'designation' => $validated['designation'],
                'imageLink' => $imageLink,
                'details' => $validated['details'],
                'homeShow' => $validated['homeShow'] ?? null,
                'status' => $validated['status'],
            ]);
        }

        Session::flash('success', 'Testimonial Updated Successfully!');
        return redirect()->route('testimonial.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $testimonial = Testimonial::query()->where('testimonialId', $request->testimonialId)->first();
        If (!empty($testimonial)) {
            $testimonial->delete();
        }
        return response()->json();
    }
}
