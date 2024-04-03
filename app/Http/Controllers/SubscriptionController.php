<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Validator;

class SubscriptionController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function paginateIndex(Request $request)
    {
        $perPage = $request->query('per_page', 5);
        $response = [
            'status' => 'success',
            'message' => 'Experience is created successfully.',
            'data' => Offer::with("users")
            ->whereActive(true)
            ->whereUserId(auth()->id())->paginate($perPage),
        ];

        return response()->json($response, 201);
    }


    /**
     * Store a newly created resource in storage.
     * @authenticated
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'offer_id' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }
        $subscription =  Subscription::where([
            "offer_id" => request("offer_id"),
            "user_id" => auth()->id()
        ])->first();
        if ($subscription) {
            return response()->json([
                'status' => 'failed',
                'message' => 'You are already registered!',
                'data' => $validate->errors(),
            ], 403);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Subscription is created successfully.',
            'data' => Subscription::create(
                [
                    "offer_id" => request("offer_id"),
                    "user_id" => auth()->id(),
                    'step' => Subscription::INIT
                ]
            )
        ], 200);
    }
}
