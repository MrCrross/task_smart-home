<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentPaginationRequest;
use App\Http\Resources\EquipmentTypeResource;
use App\Models\EquipmentType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(EquipmentPaginationRequest $request)
    {
        return EquipmentTypeResource::collection(EquipmentType::paginate(10,$request->search));
    }

    /**
     * @return EquipmentTypeResource
     */
    public function get()
    {
        return new EquipmentTypeResource(EquipmentType::all());
    }
}
