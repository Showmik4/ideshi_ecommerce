<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Promotion;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PromotionController extends Controller
{
    public function show()
    {
        return view('promotion.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $promotion = Promotion::all();
        return datatables()->of($promotion)
            ->addColumn('status', function (Promotion $promotion){
                if ($promotion->status === 'active') {
                    return '<label class="btn btn-success">Active</label>';
                }
                return '<label class="btn btn-danger">Inactive</label>';
            })
            ->setRowAttr([
                'align'=>'center',
            ])
            ->rawColumns(['status'])
            ->make(true);
    }

    public function create()
    {
        return view('promotion.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'promotionTitle' => 'required|string|max:255',
            'promotionCode' => 'required|string|max:45',  
            'amount' => 'required',            
            'status' => 'required|string|max:45',
            'useLimit' => 'required|numeric',
        ]);

        Promotion::query()->create([
            'promotionTitle' => $validated['promotionTitle'],
            'promotionCode' => $validated['promotionCode'],                   
            'startDate' => $request->input('startDate'),
            'endDate' => $request->input('endDate'),    
            'type' => $request->input('type'),         
            'amount' => $validated['amount'],           
            'status' => $validated['status'],
            'useLimit' => $validated['useLimit'],
        ]);

        Session::flash('success', 'Promotion Created Successfully!');
        return redirect()->route('promotion.show');
    }

    public function edit($promotionId)
    {
        $promotion = Promotion::query()->where('promotionId', $promotionId)->first();
        return view('promotion.edit', compact( 'promotion'));
    }

    public function update(Request $request, $promotionId): RedirectResponse
    {
        $validated = $this->validate($request, [
            'promotionTitle' => 'required|string|max:255',
            'promotionCode' => 'required|string|max:45',
            'startDate' => 'required',
            'endDate' => 'required',
            'amount' => 'required_if:percentage,null|nullable|numeric',
            'percentage' => 'required_if:amount,null|nullable|numeric',
            'status' => 'required|string|max:45',
            'useLimit' => 'required|numeric',
        ]);

        $promotion = Promotion::query()->where('promotionId', $promotionId)->first();
        if(!empty($promotion)) {
            $promotion->update([
                'promotionTitle' => $validated['promotionTitle'],
                'promotionCode' => $validated['promotionCode'],
                'startDate' => $validated['startDate'],
                'endDate' => $validated['endDate'],
                'amount' => $validated['amount'],
                'percentage' => $validated['percentage'],
                'status' => $validated['status'],
                'useLimit' => $validated['useLimit'],
            ]);
        }

        Session::flash('success', 'Promotion Updated Successfully!');
        return redirect()->route('promotion.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $promotion = Promotion::query()->where('promotionId', $request->promotionId)->first();
        if (!empty($promotion)) {
            $banner = Banner::query()->where('fkPromotionId', $promotion->promotionId)->first();
            if (!empty($banner)) {
                $banner->delete();
            }
            $promotion->delete();
        }
        return response()->json();
    }
}
