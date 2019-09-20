<?php
namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\Privilege;
use BajakLautMalaka\PmiAdmin\Http\Requests\StorePrivilege;
use BajakLautMalaka\PmiAdmin\Http\Requests\UpdatePrivilege;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use DB;

class PrivilegeController extends Controller{

	
	public function index(Request $request,Privilege $privileges)
	{

		$role_id 	= ($request->has('r_id'))? $request->r_id : 0 ;
		$privileges = $privileges->select(DB::raw("privileges.id,privileges.name, pc.name AS privilege_category, if(rp.id,rp.privilege_id,false) AS privilege_id"));
		$privileges = $privileges->leftJoin(DB::raw("(select * from role_privilege where role_id=$role_id) AS rp"),  function($join) {
      		$join->on('rp.privilege_id', '=', 'privileges.id');
    	});
    	$privileges = $privileges->join(DB::raw('privilege_categories AS pc'), function($join){
    		$join->on('privileges.privilege_category_id', '=', 'pc.id');
    	});
    	$privileges = $privileges->get();
		return response()->success($privileges);
	}

	public function show(Privilege $privilege)
	{
		return response()->success($privilege->load('privilegeCategory'));
	}

	public function store(StorePrivilege $request)
	{
		$privileges = Privilege::create($request->all());
		return response()->success($privileges);
	}

	public function update(UpdatePrivilege $request, Privilege $privilege)
	{
		$privilege->update($request->all());
		return response()->success($privilege);
	}

	public function destroy(Privilege $privilege)
	{
		try{
			$privilege->delete();
			return response()->success($privilege);
		} catch ( \Illuminate\Database\QueryException $e) {
			$collection = collect(['message' => 'Error! Privilage memiliki items']);
            $privilege       = $collection->merge($privilege);
            return response()->fail($privilege);
		}
	}
}