<?php

namespace App\Http\Controllers;

use App\Models\UserType;
use Illuminate\Http\Request;
use App\Http\Resources\UserTypeResource;
use App\Http\Requests\UserTypeCreateRequest;
use App\Http\Requests\UserTypeUpdateRequest;

class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userTypes = UserType::all();

        return response()->json([
            'status' => 'success',
            'message' => 'User Types retrieved successfully',
            'data' => UserTypeResource::collection($userTypes),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserTypeCreateRequest $request)
    {
        $userType = new UserType();

        $userType->name = $request->name;
        $userType->description = $request->description;
        $userType->is_active = $request->is_active;

        $userType->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User Type created successfully',
            'data' => new UserTypeResource($userType),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserType $userType)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User Type retrieved successfully',
            'data' => new UserTypeResource($userType),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserType $userType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserTypeUpdateRequest $request, $id)
    {
        $userType = UserType::find($id);

        $userType->name = $request->name;
        $userType->description = $request->description;
        $userType->is_active = $request->is_active;

        $userType->update();

        return response()->json([
            'status' => 'success',
            'message' => 'User Type updated successfully',
            'data' => new UserTypeResource($userType),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userType = UserType::find($id);

        $userType->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User Type deleted successfully',
        ]);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id){
        $userType = UserType::withTrashed()->find($id);
        $userType->restore();

        return response()->json([
            'status' => 'success',
            'message' => 'User Type restored successfully',
            'data' => new UserTypeResource($userType),
        ]);
    }

    /**
     * Remove the specified resource from storage permanently.
     */
    public function forceDelete($id){
        $userType = UserType::withTrashed()->find($id);
        $userType->forceDelete();

        return response()->json([
            'status' => 'success',
            'message' => 'User Type deleted permanently',
        ]);
    }
}
