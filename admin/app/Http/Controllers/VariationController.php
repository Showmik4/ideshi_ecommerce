<?php

namespace App\Http\Controllers;

use App\Models\Variation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VariationController extends Controller
{
    public function show()
    {
        return view('variation.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $variation = Variation::all();
        return datatables()->of($variation)
            ->addColumn('variationValue', function (Variation $variation){
                if ($variation->variationType === 'color') {
                    return '<label class="btn btn-md" style="background-color: '.$variation->variationValue.'"></label><p>'.$variation->variationValue.'</p>';
                }
                return $variation->variationValue;
            })
            ->setRowAttr([
                'align'=>'center',
            ])
            ->rawColumns(['variationValue'])
            ->make(true);
    }

    public function create()
    {
        return view('variation.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'variationType' => 'required|string|max:50',
            'selectionType' => 'required|string|max:50',
            'color' => 'required_if:variationType,color|nullable|string|max:50',
            'size' => 'required_if:variationType,size|nullable|string|max:50',
        ]);

        Variation::query()->create([
            'variationType' => $validated['variationType'],
            'selectionType' => $validated['selectionType'],
            'variationValue' => $validated['size'] ?? $validated['color'],
        ]);

        Session::flash('success', 'Variation Created Successfully!');
        return redirect()->route('variation.show');
    }

    public function edit($variationId)
    {
        $variation = Variation::query()->where('variationId', $variationId)->first();
        return view('variation.edit', compact( 'variation'));
    }

    public function update(Request $request, $variationId): RedirectResponse
    {
        $validated = $this->validate($request, [
            'variationType' => 'required|string|max:50',
            'selectionType' => 'required|string|max:50',
            'color' => 'required_if:variationType,color|nullable|string|max:50',
            'size' => 'required_if:variationType,size|nullable|string|max:50',
        ]);

        $variation = Variation::query()->where('variationId', $variationId)->first();
        if(!empty($variation)) {
            $variation->update([
                'variationType' => $validated['variationType'],
                'selectionType' => $validated['selectionType'],
                'variationValue' => $validated['size'] ?? $validated['color'],
            ]);
        }

        Session::flash('success', 'Variation Updated Successfully!');
        return redirect()->route('variation.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $variation = Variation::query()->where('variationId', $request->variationId)->first();
        If (!empty($variation)) {
            $variation->delete();
        }
        return response()->json();
    }
}
