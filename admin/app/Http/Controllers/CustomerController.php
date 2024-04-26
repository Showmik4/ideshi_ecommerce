<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use App\Models\ShipmentZone;
use App\Models\User;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    use ImageTrait;

    public function show()
    {
        return view('customer.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $customer = Customer::with('user')->get();
        return datatables()->of($customer)
            ->addColumn('customerImage', function (Customer $customer){
                if (isset($customer->customerImage)) {
                    return '<img height="50px" width="50px" src="'.url($customer->customerImage).'" alt="">';
                }
                return '';
            })
            ->addColumn('name', function (Customer $customer){
                return @$customer->user->firstName.' '.@$customer->user->lastName;
            })
            ->addColumn('billingAddress', function (Customer $customer){
                return @$customer->address->billingAddress;
            })
            ->addColumn('shippingAddress', function (Customer $customer){
                return @$customer->address->shippingAddress;
            })
            ->addColumn('created_at', function (Customer $customer){
                return date('Y-m-d', strtotime($customer->created_at));
            })
            ->addColumn('email', function (Customer $customer){
                return @$customer->user->email;
            })
            ->addColumn('status', function (Customer $customer){
                if ($customer->status === 'active') {
                    return '<label class="btn btn-success">Active</label>';
                }
                return '<label class="btn btn-danger">Inactive</label>';
            })
            ->setRowAttr([
                'align'=>'center',
            ])
            ->rawColumns(['customerImage', 'status'])
            ->make(true);
    }

    public function create()
    {
        $shipmentZones = ShipmentZone::query()->where('status', 'active')->get();
        return view('customer.create', compact('shipmentZones'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'firstName' => 'required|string|max:50',
            'lastName' => 'nullable|string|max:50',
            'phone' => 'required|string|max:20|unique:user',
            'email' => 'required|email|max:50|unique:user',
           
            'billingAddress' => 'required|string',
            'shippingAddress' => 'nullable|string',
            'fkShipmentZoneId' => 'required|numeric',
            'status' => 'required|string|max:45',
        ]);

        DB::transaction(function() use ($validated) {
            $address = Address::query()->create([
                'billingAddress' => $validated['billingAddress'],
                'shippingAddress' => $validated['shippingAddress'],
            ]);

            $user = User::query()->create([
                'firstName' => $validated['firstName'],
                'lastName' => $validated['lastName'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'password' => Hash::make('12345678'),
                'fkUserTypeId' => 2,
            ]);

            Customer::query()->create([
                'fkUserId' => $user->userId,
                'phone' => $validated['phone'],
                // 'customerImage' => isset($validated['customerImage']) ? $this->save_image('customerImage', $validated['customerImage']) : null,
                'fkAddressId' => $address->addressId,
                'fkShipmentZoneId' => $validated['fkShipmentZoneId'],
                'status' => $validated['status'],
            ]);
        });

        Session::flash('success', 'Customer Created Successfully!');
        return redirect()->route('customer.show');
    }

    public function edit($customerId)
    {
        $customer = Customer::with('user', 'address')->where('customerId', $customerId)->first();
        $shipmentZones = ShipmentZone::query()->where('status', 'active')->get();
        return view('customer.edit', compact( 'customer', 'shipmentZones'));
    }

    public function update(Request $request, $customerId): RedirectResponse
    {
        $customer = Customer::query()->where('customerId', $customerId)->first();

        if (!empty($customer)) {
            $user = User::query()->where('userId', $customer->fkUserId)->first();

            if (!empty($user)) {
                $validated = $this->validate($request, [
                    'firstName' => 'required|string|max:50',
                    'lastName' => 'nullable|string|max:50',
                    'phone' => 'required|string|max:20|unique:user,phone,'.$user->userId.',userId',
                    'email' => 'required|email|max:50|unique:user,email,'.$user->userId.',userId',
                    // 'customerImage' => 'nullable|image|mimes:jpeg,png,jpg',
                    'billingAddress' => 'required|string',
                    'shippingAddress' => 'nullable|string',
                    'fkShipmentZoneId' => 'required|numeric',
                    'status' => 'required|string|max:45',
                ]);

                DB::transaction(function() use ($validated, $customer, $user) {
                    Address::query()->where('addressId', $customer->fkAddressId)->update([
                        'billingAddress' => $validated['billingAddress'],
                        'shippingAddress' => $validated['shippingAddress'],
                    ]);

                    $user->update([
                        'firstName' => $validated['firstName'],
                        'lastName' => $validated['lastName'],
                        'phone' => $validated['phone'],
                        'email' => $validated['email'],
                        'password' => $user->password ?? Hash::make('12345678'),
                        'fkUserTypeId' => 2,
                    ]);

                    // if (empty($validated['customerImage'])) {
                    //     $customerImage = $customer->customerImage;
                    // } else {
                    //     $this->deleteImage($customer->customerImage);
                    //     $customerImage = $this->save_image('customerImage', $validated['customerImage']);
                    // }

                    $customer->update([
                        'phone' => $validated['phone'],
                        // 'customerImage' => $customerImage,
                        'fkShipmentZoneId' => $validated['fkShipmentZoneId'],
                        'status' => $validated['status'],
                    ]);
                });
            }
        }

        Session::flash('success', 'Customer Updated Successfully!');
        return redirect()->route('customer.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $customer = Customer::query()->where('customerId', $request->customerId)->first();
        If (!empty($customer)) {
            $customer->delete();
        }
        return response()->json();
    }
}
