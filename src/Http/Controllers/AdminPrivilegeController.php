<?php
namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\AdminPrivilege;
use BajakLautMalaka\PmiAdmin\Http\Requests\StoreAdminPrivilege;
use BajakLautMalaka\PmiAdmin\Http\Requests\UpdateAdminPrivilege;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class AdminPrivilegeController extends Controller{

	
	public function index(Request $request,AdminPrivilege $adminprivileges)
	{
		$adminprivileges = $adminprivileges->all();
		return response()->success($adminprivileges);
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