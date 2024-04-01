<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class UserController extends Controller
{
    public function userPartialUpdate(Request $request)
    {
        User::whereId(auth()->id())->update([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'occupation' => request('occupation'),
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'User is updated successfully.',
            'data' => User::where('id', auth()->id())->first(),
        ], 201);
    }

    public function updatePassword(Request $request)
    {
        $user = User::where("id", auth()->id())->first();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        if (Hash::check($request->old_password, auth()->user()->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json(['message' => 'Password changed successfully'], 200);
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'Invalid credentials'
        ], 401);;
    }

    public function updateOrCreateOrganisationMeta(Request $request)
    {
        Meta::updateOrCreate(
            [
                'meta_key' => Meta::ORG_NAME,
                'meta_ref' => auth()->id()
            ],
            ['meta_value' => request("org_name")]
        );
        Meta::updateOrCreate(
            [
                'meta_key' => Meta::ORG_NAME,
                'meta_ref' => auth()->id()
            ],
            ['meta_value' => request(Meta::ORG_NAME)]
        );
        Meta::updateOrCreate(
            [
                'meta_key' => Meta::CULTURE,
                'meta_ref' => auth()->id()
            ],
            ['meta_value' => request(Meta::CULTURE)]
        );
        Meta::updateOrCreate(
            [
                'meta_key' => Meta::OVERVIEW,
                'meta_ref' => auth()->id()
            ],
            ['meta_value' => request(Meta::OVERVIEW)]
        );
        Meta::updateOrCreate(
            [
                'meta_key' => Meta::HISTORY,
                'meta_ref' => auth()->id()
            ],
            ['meta_value' => request(Meta::HISTORY)]
        );
    }

    public function getUserMeta(Request $request)
    {
        $meta = Meta::whereMetaRef(auth()->id())->get();
        return response()->json([
            'status' => 'success',
            'message' => 'User is updated successfully.',
            'data' => $meta,
        ], 201);
    }
}
