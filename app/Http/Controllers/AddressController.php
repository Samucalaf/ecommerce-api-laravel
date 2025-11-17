<?php

namespace App\Http\Controllers;

use App\Http\Requests\Addresse\StoreAddresseRequest;
use App\Http\Requests\Addresse\UpdateAddresseRequest;
use App\Http\Resources\AddressResource;
use App\Http\Resources\AddressCompleteResource;
use Illuminate\Http\Request;
use App\Services\AddressService;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $addressService;

    public function __construct(AddressService $addresseService)
    {
        $this->addressService = $addresseService;
    }
    
    public function index(Request $request)
    {
        $user = $request->user();
        $addresses = $this->addressService->listUserAddresses($user->id);
        
        return response()->json([
            'data' => AddressResource::collection($addresses)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddresseRequest $request)
    {
        $dataValidated = $request->validated();
        $address = $this->addressService->createAddress($dataValidated);
        
        return response()->json([
            'message' => 'Address created successfully',
            'data' => new AddressCompleteResource($address)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $userId = $request->user()->id;
        $address = $this->addressService->getAddressById($userId, $id);
        
        return response()->json([
            'data' => new AddressCompleteResource($address)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddresseRequest $request, string $id)
    {
        $dataValidated = $request->validated();
        $address = $this->addressService->updateAddress($id, $dataValidated);
        
        return response()->json([
            'message' => 'Address updated successfully',
            'data' => new AddressCompleteResource($address)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $userId = $request->user()->id;
        $this->addressService->deleteAddress($userId, $id);
        
        return response()->json([
            'message' => 'Address deleted successfully'
        ], 200);
    }
}
