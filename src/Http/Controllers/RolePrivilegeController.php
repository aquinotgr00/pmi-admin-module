<?php
namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\RolePrivilege;
use BajakLautMalaka\PmiAdmin\Http\Requests\StoreRolePrivilege;
use BajakLautMalaka\PmiAdmin\Http\Requests\UpdateRolePrivilege;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class RolePrivilegeController extends Controller{

	
	public function index(Request $request,RolePrivilege $rolesprivileges)
	{
		
		$rolesprivileges = $rolesprivileges->all();
		return response()->success($rolesprivileges);
	}

	public function show(RolePrivilege $rolesprivilege)
	{
		return response()->success($rolesprivilege);
	}

	public function store(StoreRolePrivilege $request)
	{
		$rolesprivilege = RolePrivilege::create($request->all());
		return response()->success($rolesprivilege);
	}

	public function update(UpdateRolePrivilege $request, RolePrivilege $rolesprivilege)
	{
		$rolesprivilege->update($request->all());
		return response()->success($rolesprivilege);
	}

	public function destroy(RolePrivilege $rolesprivilege)
	{
		try{
			$rolesprivilege->delete();
			return response()->success($rolesprivilege);
		} catch ( \Illuminate\Database\QueryException $e) {
			$collection = collect(['message' => 'Error! Role privilage memiliki items']);
            $rolesprivilege      = $collection->merge($rolesprivilege);
            return response()->fail($rolesprivilege);
		}
	}
}