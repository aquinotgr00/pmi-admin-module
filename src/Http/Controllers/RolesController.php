<?php
namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\Role;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class RolesController extends Controller{

	
	public function index(Request $request,Role $roles)
	{
		$roles = $this->handleSeachName($request,$roles);  
		$roles = $roles->with('privileges')->get();
		return response()->success($roles);
	}

	private function handleSeachName(Request $request,$roles)
	{
		if ($request->has('s')) {
			$roles = $role->where('name','like','%'.$request->s.'%');
		}
		return $roles;
	}

	public function show(Role $role)
	{
		return response()->success($role);
	}

	public function store(Request $request,Role $role)
	{
		$request->validate([
			'name' => 'required|unique:roles'
		]);
		$role->name = $request->name;
		$role->save();
		return response()->success($role);
	}

	public function update(Request $request, Role $role)
	{
		$request->validate([
			'name' => 'unique:roles,name,'.$role->id
		]);
		$role->name = $request->name;
		$role->save();

		return response()->success($role);
	}

	public function destroy(Role $role)
	{
		try{
			$role->delete();
			return response()->success($role);
		} catch ( \Illuminate\Database\QueryException $e) {
			$collection = collect(['message' => 'Error! Role memiliki items']);
            $role       = $collection->merge($role);
            return response()->fail($role);
		}
	}
}