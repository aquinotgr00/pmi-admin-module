<?php
namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\Role;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class RolesController extends Controller{

	
	public function index(Request $request,Role $roles)
	{
		$roles = $this->handleSeachName($request,$roles);  
		$roles = $roles->get();
		return response()->success($roles);
	}

	private function handleSeachName(Request $request,$roles)
	{
		if ($request->has('s')) {
			$roles = $roles->where('name','like','%'.$request->s.'%');
		}
		return $roles;
	}

	public function show(Role $roles)
	{
		return response()->success($roles);
	}

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required|unique:roles'
		]);

		$roles = Role::create($request->all());
		return response()->success($roles);
	}

	public function update(Request $request, Role $roles)
	{
		$request->validate([
			'name' => 'unique:roles,name,'.$roles->id
		]);

		$roles->update($request->all());
		return response()->success($roles);
	}

	public function destroy(Role $roles)
	{
		try{
			$roles->delete();
			return response()->success($roles);
		} catch ( \Illuminate\Database\QueryException $e) {
			$collection = collect(['message' => 'Error! Role memiliki items']);
            $roles       = $collection->merge($roles);
            return response()->fail($roles);
		}
	}
}