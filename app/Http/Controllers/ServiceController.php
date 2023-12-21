<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceCreteRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ServiceResource;
use App\Models\Article;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function createService(ServiceCreteRequest $request):JsonResponse
    {
        $data = $request->validated();

        $service = new Service($data);
        $service->save();

        return (new ServiceResource($service))->response()->setStatusCode(200);
    }
    public function getService(): JsonResponse
    {
        $services = Service::all();
        $services_count = $services->count();

        return (ServiceResource::collection($services))
            ->additional(['article_count' => $services_count])
            ->response()
            ->setStatusCode(200);
    }
}
