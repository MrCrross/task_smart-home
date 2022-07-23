<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentPaginationRequest;
use App\Http\Requests\EquipmentStoreRequest;
use App\Http\Requests\EquipmentUpdateRequest;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Services\EquipmentService;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(EquipmentPaginationRequest $request)
    {
        return EquipmentResource::collection(Equipment::paginate(10,$request->search));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EquipmentStoreRequest $request
     * @param EquipmentService $service
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function store(EquipmentStoreRequest $request,EquipmentService $service)
    {
        return EquipmentResource::collection($service->store($request->equipments));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return EquipmentResource
     */
    public function show($id)
    {
        return new EquipmentResource(Equipment::one($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EquipmentUpdateRequest $request
     * @param EquipmentService $service
     * @param int $id
     * @return EquipmentResource
     */
    public function update(EquipmentUpdateRequest $request,EquipmentService $service, $id)
    {
        return new EquipmentResource($service->update($request,$id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Equipment::destroy($id);
        return response()->json([
            'success'=>true
        ]);
    }
}
