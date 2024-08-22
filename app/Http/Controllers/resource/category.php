<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category as Categories;
use Carbon\Carbon;


class category extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Categories::with('parent')->orderBy('category_name')->get();
        return view('category.index',['category'=>$category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category=Categories::where('parent_category', NULL)->orderBy('category_name')->get();
        return view('category.create',['category'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cat_name' => 'required|unique:tbl_category,category_name',
            'cat_code' => 'required|unique:tbl_category,category_code',
        ]);
    
            try {
                $category = new Categories();
                $category->category_name = $request->cat_name;    
                $category->category_code = $request->cat_code;
                $category->parent_category  = $request->parent_category;    
                $category->	remarks  = $request->remarks;    
                $category->save();
        
                return redirect()->route('category.index')->with('success', 'Category Created Successfully');
            } catch (\Exception $e) {
                // Log the exception message
                return redirect()->back()->with('error', $e->getMessage());
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Categories::find($id);
        $parent_cat = Categories::where('id', '!=', $id)->where('parent_category', NULL)->orderBy('category_name')->get();
        return view('category.edit',compact('category','parent_cat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cat_name' => 'required|unique:tbl_category,category_name,'.$id,
            'cat_code' => 'required|unique:tbl_category,category_code,'.$id,
        ]);
    
            try {
                $category = Categories::findOrFail($id);
                $category->category_name = $request->cat_name;    
                $category->category_code = $request->cat_code;
                $category->parent_category  = $request->parent_category;    
                $category->	remarks  = $request->remarks;    
                $category->save();
        
                return redirect()->route('category.index')->with('success', 'Category Updated Successfully');
            } catch (\Exception $e) {
                // Log the exception message
                return redirect()->back()->with('error', $e->getMessage());
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deletecat(Request $request)
    {

        $category = Categories::findOrFail($request->input('id'));
        if (!$category) {
        return response()->json(['error' => 'Category not found.'], 404);
        }
        $category->deleted_at = Carbon::parse(now())->format('Y-m-d H:i:s');
        $category->save();
        $category->children()->update(['deleted_at' => Carbon::now()]);
        return response()->json(['success' => 'The Category has been deleted!']);
        
    }
}
