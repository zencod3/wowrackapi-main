<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionCreateRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\SubscriptionResource;
use App\Models\Service;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function createSubscription(int $idUser, SubscriptionCreateRequest $request):JsonResponse
    {
//        $user = Auth::user();
//        $data = $request->validated();
////        $subscription = Service::where()
//        $service = Service::where('id', $user->id)
//            ->where('id', $idUser)
//            ->first();
//
//        if ($service) {
//            $subscription = new Subscription($data);
//            $subscription->user_id = $user->id;
//            $subscription->service_id = $service->id;
//            $subscription->save();
//
//            return (new SubscriptionResource($subscription))->response()->setStatusCode(201);
//        } else {
//            $response = [
//                'message' => 'No matching service found.',
//            ];
//
//            return response()->json($response, 200); // You can adjust the status code as needed
//        }
        $user = Auth::user();
        $data = $request->validated();

        // Menggunakan service_id dari request JSON
        $serviceIdFromRequest = $data['service_id'] ?? null;

        // Mencari Service berdasarkan service_id dari request JSON
        $service = Service::where('id', $user->id)
            ->where('id', $serviceIdFromRequest)
            ->first();

        if ($service) {
            $subscription = new Subscription($data);
            $subscription->user_id = $user->id;
            $subscription->service_id = $service->id;
            $subscription->save();

            return (new SubscriptionResource($subscription))->response()->setStatusCode(201);
        } else {
            $response = [
                'message' => 'No matching service found.',
            ];

            return response()->json($response, 200); // You can adjust the status code as needed
        }
    }
    public function getSubscriptionsByUserId(): JsonResponse
    {
        $user = Auth::user();

        // Mengambil semua data Subscription berdasarkan user_id
        $subscriptions = Subscription::where('user_id', $user->id)->get();

        // Mengembalikan data dalam bentuk JSON menggunakan SubscriptionResource
        $subscriptionResources = SubscriptionResource::collection($subscriptions);

        return response()->json($subscriptionResources, 200);
    }
}
