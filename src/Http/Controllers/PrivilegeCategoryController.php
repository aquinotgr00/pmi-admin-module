<?php
namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\PrivilegeCategory;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class PrivilegeCategoryController extends Controller{

	
	public function index(Request $request,PrivilegeCategory $categories)
	{
		$categories = $this->handleSeachName($request,$categories);  
		$categories = $categories->with('privileges')->get();
		return response()->success($categories);
	}

	private function handleSeachName(Request $request,$categories)
	{
		if ($request->has('s')) {
			$categories = $categories->where('name','like','%'.$request->s.'%');
		}
		return $categories;
	}

	public function show(PrivilegeCategory $category)
	{
		return response()->success($category);
	}

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required|unique:privilege_categories'
		]);

		$categories = PrivilegeCategory::create($request->all());
		return response()->success($categories);
	}

	public function update(Request $request, PrivilegeCategory $category)
	{
		$request->validate([
			'name' => 'unique:privilege_categories,name,'.$category->id
		]);

		$category->update($request->all());
		return response()->success($category);
	}

	public function destroy(PrivilegeCategory $category)
	{
		try{
			$category->delete();
			return response()->success($category);
		} catch ( \Illuminate\Database\QueryException $e) {
			$collection = collect(['message' => 'Error! CategoryPrivilage memiliki items']);
            $category       = $collection->merge($category);
            return response()->fail($category);
		}
	}
}