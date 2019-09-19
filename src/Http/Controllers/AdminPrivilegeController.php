<?php
namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\AdminPrivilege;
use BajakLautMalaka\PmiAdmin\Privilege;
use BajakLautMalaka\PmiAdmin\Http\Requests\StoreAdminPrivilege;
use BajakLautMalaka\PmiAdmin\Http\Requests\UpdateAdminPrivilege;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use DB;

class AdminPrivilegeController extends Controller{

	
	public function index(Request $request,Privilege $privileges)
	{

		$admin_id 	= ($request->has('a_id'))? $request->a_id : 0 ;
		$privileges = $privileges->select(DB::raw("privileges.id,privileges.name, pc.name AS privilege_category, if(rp.id,rp.privilege_id,false) AS privilege_id"));
		$privileges = $privileges->leftJoin(DB::raw("(select * from admin_privileges where admin_id=$admin_id) AS rp"),  function($join) {
      		$join->on('rp.privilege_id', '=', 'privileges.id');
    	});
    	$privileges = $privileges->join(DB::raw('privilege_categories AS pc'), function($join){
    		$join->on('privileges.privilege_category_id', '=', 'pc.id');
    	});
    	$privileges = $privileges->get();
		return response()->success($privileges);
	}

	private function handleByAdminId(Request $request,$adminprivileges)
	{
		if ($request->has('a_id')) {
			$adminprivileges = $adminprivileges->where('admin_id',$request->a_id);
		}
		return $adminprivileges;
	}

	public function show(AdminPrivilege $adminprivilege)
	{
		return response()->success($adminprivilege);
	}

	public function store(StoreAdminPrivilege $request, AdminPrivilege $adminprivilege)
	{
		$adminprivilege->admin_id 		= $request->admin_id;
		$adminprivilege->privilege_id 	= $request->privilege_id;
		$adminprivilege->save();
		return response()->success($adminprivilege);
	}

	public function update(UpdateAdminPrivilege $request, AdminPrivilege $adminprivilege)
	{
		$adminprivilege->admin_id 		= $request->admin_id;
		$adminprivilege->privilege_id 	= $request->privilege_id;
		$adminprivilege->save();
		return response()->success($adminprivilege);
	}

	public function destroy(AdminPrivilege $adminprivilege)
	{
		try{
			$adminprivilege->delete();
			return response()->success($adminprivilege);
		} catch ( \Illuminate\Database\QueryException $e) {
			$collection = collect(['message' => 'Error! CategoryPrivilage memiliki items']);
            $adminprivilege       = $collection->merge($adminprivilege);
            return response()->fail($adminprivilege);
		}
	}
}