<?php
namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\AdminPrivilege;
use BajakLautMalaka\PmiAdmin\Http\Requests\StoreAdminPrivilege;
use BajakLautMalaka\PmiAdmin\Http\Requests\UpdateAdminPrivilege;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class AdminPrivilegeController extends Controller{

	
	public function index(Request $request,AdminPrivilege $privileges)
	{
		$privileges = $privileges->all();
		return response()->success($privileges);
	}

	public function show(AdminPrivilege $privileges)
	{
		return response()->success($privileges);
	}

	public function store(StoreAdminPrivilege $request)
	{
		$privileges = AdminPrivilege::create($request->all());
		return response()->success($privileges);
	}

	public function update(UpdateAdminPrivilege $request, AdminPrivilege $privileges)
	{
		$privileges->update($request->all());
		return response()->success($privileges);
	}

	public function destroy(AdminPrivilege $privileges)
	{
		try{
			$privileges->delete();
			return response()->success($privileges);
		} catch ( \Illuminate\Database\QueryException $e) {
			$collection = collect(['message' => 'Error! CategoryPrivilage memiliki items']);
            $privileges       = $collection->merge($privileges);
            return response()->fail($privileges);
		}
	}
}