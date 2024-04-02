<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use Validator;

class OfferController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 5);
        $response = [
            'status' => 'success',
            'message' => 'Offer is created successfully.',
            'data' => Offer::whereActive(true)->paginate($perPage),
        ];

        return response()->json($response, 201);
    }
    /**
     * Display a listing of the resource.
     */
    public function paginateIndex(Request $request)
    {
        $perPage = $request->query('per_page', 5);
        $response = [
            'status' => 'success',
            'message' => 'Offer is created successfully.',
            'data' => Offer::whereUserId(auth()->id())->paginate($perPage),
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
            'title' => 'required',
            'taxonomy' => 'required',
            'mode' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }
        $offer = Offer::create(
            array_merge($request->all(), ['user_id' => auth()->id()])
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Offer is created successfully.',
            'data' => $offer,
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'taxonomy' => 'required',
            'mode' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }
        $offer = Offer::whereId($id)->first();
        $offer->title = request("title");
        $offer->taxonomy = request("taxonomy");
        $offer->mode = request("mode");
        $offer->type = request("type");
        $offer->description = request("description");
        $offer->active = request("active");
        $offer->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Offer is updated successfully.',
            'data' => $offer,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Offer::where('id', $id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Offer is deleted successfully.',
            'data' => null,
        ], 200);
    }

    public function saveInputFile($request, $file_name)
    {
        if ($request->hasFile($file_name)) {
            $file = $request->file($file_name);
            $path =  $file->store('uploads', 'public');
            return  $path;
        }
    }
}
