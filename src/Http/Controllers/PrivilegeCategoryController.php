<?php
namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\PrivilegeCategory;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class PrivilegeCategoryController extends Controller{

	
	public function index(Request $request,PrivilegeCategory $categories)
	{
		$categories = $this->handleSeachName($request,$categories);  
		$categories = $categories->get();
		return response()->success($categories);
	}

	private function handleSeachName(Request $request,$categories)
	{
		if ($request->has('s')) {
			$categories = $categories->where('name','like','%'.$request->s.'%');
		}
		return $categories;
	}

	public function show(PrivilegeCategory $categories)
	{
		return response()->success($categories);
	}

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required|unique:privilege_categories'
		]);

		$categories = PrivilegeCategory::create($request->all());
		return response()->success($categories);
	}

	public function update(Request $request, PrivilegeCategory $categories)
	{
		$request->validate([
			'name' => 'unique:privilege_categories,name,'.$categories->id
		]);

		$categories->update($request->all());
		return response()->success($categories);
	}

	public function destroy(PrivilegeCategory $categories)
	{
		try{
			$categories->delete();
			return response()->success($categories);
		} catch ( \Illuminate\Database\QueryException $e) {
			$collection = collect(['message' => 'Error! CategoryPrivilage memiliki items']);
            $categories       = $collection->merge($categories);
            return response()->fail($categories);
		}
	}
}