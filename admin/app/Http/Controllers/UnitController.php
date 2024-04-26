<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UnitController extends Controller
{
    public function show()
    {
        return view('unit.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $unit = Unit::all();
        return datatables()->of($unit)
            ->setRowAttr([
                'align'=>'center',
            ])
            ->make(true);
    }

    public function create()
    {
        return view('unit.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'unitName' => 'required|string|max:45',
        ]);

        Unit::query()->create([
            'unitName' => $validated['unitName'],
        ]);

        Session::flash('success', 'Unit Created Successfully!');
        return redirect()->route('unit.show');
    }

    public function edit($unitId)
    {
        $unit = Unit::query()->where('unitId', $unitId)->first();
        return view('unit.edit', compact( 'unit'));
    }

    public function update(Request $request, $unitId): RedirectResponse
    {
        $validated = $this->validate($request, [
            'unitName' => 'required|string|max:45',
        ]);

        $unit = Unit::query()->where('unitId', $unitId)->first();
        if(!empty($unit)) {
            $unit->update([
                'unitName' => $validated['unitName'],
            ]);
        }

        Session::flash('success', 'Unit Updated Successfully!');
        return redirect()->route('unit.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $unit = Unit::query()->where('unitId', $request->unitId)->first();
        If (!empty($unit)) {
            $unit->delete();
        }
        return response()->json();
    }
}
