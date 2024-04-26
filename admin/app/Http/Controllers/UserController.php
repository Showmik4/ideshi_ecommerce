<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function customerSearch(Request $data)
    {
        return Customer::where('phone', 'like', "%{$data->phoneNumber}%")->get();
    }

    public function customerData(Request $r)
    {
        $customerData = Customer::with('user', 'address')->find($r->customerName);
        // $point = $customerData->totalPoint($customerData->customerId);
        // $customerData->point = $point;

        return response()->json($customerData);
    }

    public function customerStore(Request $data)
    {
        $this->validate($data, [
           'firstName' => 'required',
           'lastName' => 'required',
           'phone' => 'required|numeric',
        ]);

        $user = empty($data->id) ? new User() : User::find($data->id);
        $user->firstName = $data->firstName;
        $user->lastName = $data->lastName ?? null;
        $user->email = $data->email ?? null;
        $user->password = null;
        $user->fkuserTypeId = '2';
        $user->save();

        $customer = empty($data->id) ? new Customer() : Customer::where('fkuserId', $data->id)->first();
        $customer->fkuserId = $user->userId;
        $customer->phone = $data->phone;
        $customer->optional_phone = $data->optionalPhone;
        $customer->status = 'active';
        $customer->save();

        $customerId = $customer->customerId;

        $address =empty($data->id) ? new Address() : Address::where('fkcustomerId', $customerId)->first();
        $address->fkcustomerId = $customerId;
        $address->billingAddress = $data->billingAddress;
        $address->shippingAddress = $data->shippingAddress ?? null;
        $address->fkshipment_zoneId = $data->deliveryLocation ?? null;
        $address->save();

        $customerData = Customer::with('user', 'address')->find($customerId);

        return $customerData;
    }

    public function userProfile()
    {
        $user = User::query()->where('userId', Auth::user()->userId)->first();
        return view('user.profile', compact('user'));
    }

    public function updateUserProfile(Request $request): RedirectResponse
    {
        $user = User::query()->where('userId', Auth::user()->userId)->first();
        if(!empty($user)) {
            $validated = $this->validate($request, [
                'firstName' => 'required|string|max:50',
                'lastName' => 'nullable|string|max:50',
                'phone' => 'required|string|unique:user,phone,'.$user->userId.',userId',
                'email' => 'required|string|unique:user,email,'.$user->userId.',userId',
                'password' => 'required_with:new_password,confirm_password|nullable|string|min:8',
                'new_password' => 'required_with:password,confirm_password|nullable|string|min:8',
                'confirm_password' => 'required_with:password,new_password|same:new_password|nullable|string|min:8',
            ]);

            $user->update([
                'firstName' => $validated['firstName'],
                'lastName' => $validated['lastName'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
            ]);

            if (isset($validated['password'], $validated['new_password'], $validated['confirm_password'])) {
                if ($validated['password'] !== $validated['new_password']) {
                    if ($validated['new_password'] === $validated['confirm_password'] && Hash::check($validated['password'], Auth::user()->password)) {
                        $user->update(['password' => bcrypt($validated['new_password'])]);

                        Session::flash('success', 'Password updated successfully!');
                        return redirect()->back();
                    }
                    Session::flash('error', 'Password did not match!');
                    return redirect()->back();
                }
                Session::flash('error', 'Please enter new password!');
                return redirect()->back();
            }

            Session::flash('success', 'User Profile Updated Successfully!');
            return redirect()->back();
        }

        Session::flash('error', 'No user Found!');
        return redirect()->back();
    }
}
