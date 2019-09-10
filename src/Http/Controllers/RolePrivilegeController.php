<?php
namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\RolePrivilege;
use BajakLautMalaka\PmiAdmin\Http\Requests\StoreRolePrivilege;
use BajakLautMalaka\PmiAdmin\Http\Requests\UpdateRolePrivilege;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class RolePrivilegeController extends Controller{

	
	public function index(Request $request,RolePrivilege $privileges)
	{
		
		$privileges = $privileges->all();
		return response()->success($privileges);
	}

	public function show(RolePrivilege $privileges)
	{
		return response()->success($privileges);
	}

	public function store(StoreRolePrivilege $request)
	{
		$privileges = RolePrivilege::create($request->all());
		return response()->success($privileges);
	}

	public function update(UpdateRolePrivilege $request, RolePrivilege $privileges)
	{
		$privileges->update($request->all());
		return response()->success($privileges);
	}

	public function destroy(RolePrivilege $privileges)
	{
		try{
			$privileges->delete();
			return response()->success($privileges);
		} catch ( \Illuminate\Database\QueryException $e) {
			$collection = collect(['message' => 'Error! Role privilage memiliki items']);
            $privileges       = $collection->merge($privileges);
            return response()->fail($privileges);
		}
	}
}