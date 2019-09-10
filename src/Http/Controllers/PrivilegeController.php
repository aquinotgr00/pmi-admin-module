<?php
namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\Privilege;
use BajakLautMalaka\PmiAdmin\Http\Requests\StorePrivilege;
use BajakLautMalaka\PmiAdmin\Http\Requests\UpdatePrivilege;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class PrivilegeController extends Controller{

	
	public function index(Request $request,Privilege $privileges)
	{
		$privileges = $this->handleSeachName($request,$privileges);  
		$privileges = $privileges->get();
		return response()->success($privileges);
	}

	private function handleSeachName(Request $request,$privileges)
	{
		if ($request->has('s')) {
			$privileges = $privileges->where('name','like','%'.$request->s.'%');
		}
		return $privileges;
	}

	public function show(Privilege $privileges)
	{
		return response()->success($privileges);
	}

	public function store(StorePrivilege $request)
	{
		$privileges = Privilege::create($request->all());
		return response()->success($privileges);
	}

	public function update(UpdatePrivilege $request, Privilege $privileges)
	{
		$privileges->update($request->all());
		return response()->success($privileges);
	}

	public function destroy(Privilege $privileges)
	{
		try{
			$privileges->delete();
			return response()->success($privileges);
		} catch ( \Illuminate\Database\QueryException $e) {
			$collection = collect(['message' => 'Error! Privilage memiliki items']);
            $privileges       = $collection->merge($privileges);
            return response()->fail($privileges);
		}
	}
}