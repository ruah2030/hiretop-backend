<?php

namespace App\Http\Controllers;

use App\Models\Ability;
use Illuminate\Http\Request;
use Validator;
class AbilityController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = [
            'status' => 'success',
            'message' => 'User is created successfully.',
            'data' => Ability::all(),
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
            'message' => 'User is created successfully.',
            'data' => Ability::paginate($perPage),
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
            'name' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }
        $Ability = Ability::create(array_merge($request->all(), ['user_id' => auth()->id()]));

        return response()->json([
            'status' => 'success',
            'message' => 'Ability is created successfully.',
            'data' => $Ability,
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }
        $Ability = Ability::whereId($id)->first();
        $Ability->name = request("name");
        $Ability->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Ability is updated successfully.',
            'data' => $Ability,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Ability::where('id', $id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Ability is deleted successfully.',
            'data' => null,
        ], 200);
    }
}
