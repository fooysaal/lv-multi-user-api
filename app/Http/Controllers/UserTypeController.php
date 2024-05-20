<?php

namespace App\Http\Controllers;

use App\Models\UserType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        return view('crud.userType-index', compact('userTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crud.userType-create');
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

        return redirect()->route('user-types')->with('success', 'User Type created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $userType = UserType::findorFail($id);

        return view('crud.userType-edit', compact('userType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $userType = UserType::findOrFail($id);

        if ($request->has('is_active') && $request->get('is_active') == 'changeStatus') {
            $userType->is_active = !$userType->is_active;
            $userType->save();

            return redirect()->route('user-types')
                ->with('success', 'User Type status changed successfully');
        }

        // For other update logic
        $request->validate([
            'name' => 'required|unique:user_types,name,' . $id,
        ]);

        $userType->name = $request->name;
        $userType->description = $request->description;
        $userType->save();

        return redirect()->route('user-types')
            ->with('success', 'User Type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userType = UserType::findorFail($id);

        $userType->delete();

        return redirect()->route('user-types')->with('success', 'User Type deleted successfully');
    }

    /**
     * Display a listing of the thrashed resource.
     */
    public function trashed()
    {
        $userTypes = UserType::onlyTrashed()->get();

        return view('crud.userType-index', compact('userTypes'));
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $userType = UserType::withTrashed()->findorFail($id);
        $userType->restore();

        return redirect()->route('user-types')->with('success', 'User Type restored successfully');
    }

    /**
     * Remove the specified resource from storage permanently.
     */
    public function forceDelete($id)
    {
        $userType = UserType::withTrashed()->findorFail($id);
        $userType->forceDelete();

        return redirect()->route('user-types.trashed')->with('success', 'User Type deleted permanently');
    }
}
