<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MetaController extends Controller
{
    public function show()
    {
        return view('meta.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $meta = Meta::all();
        return datatables()->of($meta)
            ->setRowAttr([
                'align'=>'center',
            ])
            ->make(true);
    }

    public function create()
    {
        return view('meta.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'metaName' => 'required|string|max:255',
            'metaContent' => 'required|string|max:255',
        ]);

        Meta::query()->create([
            'metaName' => $validated['metaName'],
            'metaContent' => $validated['metaContent'],
        ]);

        Session::flash('success', 'Meta Created Successfully!');
        return redirect()->route('meta.show');
    }

    public function edit($metaId)
    {
        $meta = Meta::query()->where('metaId', $metaId)->first();
        return view('meta.edit', compact( 'meta'));
    }

    public function update(Request $request, $metaId): RedirectResponse
    {
        $validated = $this->validate($request, [
            'metaName' => 'required|string|max:255',
            'metaContent' => 'required|string|max:255',
        ]);

        $meta = Meta::query()->where('metaId', $metaId)->first();
        if(!empty($meta)) {
            $meta->update([
                'metaName' => $validated['metaName'],
                'metaContent' => $validated['metaContent'],
            ]);
        }

        Session::flash('success', 'Meta Updated Successfully!');
        return redirect()->route('meta.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $meta = Meta::query()->where('metaId', $request->metaId)->first();
        If (!empty($meta)) {
            $meta->delete();
        }
        return response()->json();
    }
}
