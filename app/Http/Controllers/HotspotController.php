<?php

namespace App\Http\Controllers;

use App\Http\Resources\HotspotResource;
use App\Models\Hotspot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HotspotController extends Controller
{
    public function index():JsonResponse
    {
        $hotspots = Hotspot::all();
        $hotspotsCount = $hotspots->count();

        return (HotspotResource::collection($hotspots))
            ->additional(['hotspot_count' => $hotspotsCount])
            ->response()
            ->setStatusCode(200);
    }

    public function show(Hotspot $hotspot): JsonResponse
    {
        return response()->json(new HotspotResource($hotspot), 200);
    }


    public function store(Request $request):JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'lang' => 'required',
            'long' => 'required',
        ]);

        $hotspot = Hotspot::create($request->all());

        return (new HotspotResource($hotspot))->response()->setStatusCode(201);
    }
}
