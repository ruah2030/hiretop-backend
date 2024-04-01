<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Experience;
use Validator;

class ExperienceController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = [
            'status' => 'success',
            'message' => 'User is created successfully.',
            'data' => Experience::all(),
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
            'data' => Experience::paginate($perPage),
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
            'desc' => 'required',
            'start_at' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }
        $experience = Experience::create(array_merge($request->all(), ['user_id' => auth()->id()]));

        return response()->json([
            'status' => 'success',
            'message' => 'experience is created successfully.',
            'data' => $experience,
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'desc' => 'required',
            'start_at' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }
        $experience = Experience::whereId($id)->first();
        $experience->name = request("name");
        $experience->desc = request("desc");
        $experience->start_at = request("start_at");
        if ($request->finished_at) {
            $experience->finished_at = request("finished_at");
        }
        $experience->save();
        return response()->json([
            'status' => 'success',
            'message' => 'experience is updated successfully.',
            'data' => $experience,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Experience::where('id', $id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'experience is deleted successfully.',
            'data' => null,
        ], 200);
    }
}
