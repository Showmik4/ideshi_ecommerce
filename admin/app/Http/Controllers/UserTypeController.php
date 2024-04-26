<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserTypeController extends Controller
{
    public function show()
    {
        return view('userType.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $userType = UserType::all();
        return datatables()->of($userType)
            ->setRowAttr([
                'align'=>'center',
            ])
            ->make(true);
    }

    public function create()
    {
        return view('userType.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'typeName' => 'required|string|max:45',
        ]);

        UserType::query()->create([
            'typeName' => $validated['typeName'],
        ]);

        Session::flash('success', 'UserType Created Successfully!');
        return redirect()->route('userType.show');
    }

    public function edit($userTypeId)
    {
        $userType = UserType::query()->where('userTypeId', $userTypeId)->first();
        return view('userType.edit', compact( 'userType'));
    }

    public function update(Request $request, $userTypeId): RedirectResponse
    {
        $validated = $this->validate($request, [
            'typeName' => 'required|string|max:45',
        ]);

        $userType = UserType::query()->where('userTypeId', $userTypeId)->first();
        if(!empty($userType)) {
            $userType->update([
                'typeName' => $validated['typeName'],
            ]);
        }

        Session::flash('success', 'UserType Updated Successfully!');
        return redirect()->route('userType.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $userType = UserType::query()->where('userTypeId', $request->userTypeId)->first();
        If (!empty($userType)) {
            User::query()->where('fkUserTypeId', $userType->userTypeId)->update([
                'fkUserTypeId' => null,
            ]);
            $userType->delete();
        }
        return response()->json();
    }
}
