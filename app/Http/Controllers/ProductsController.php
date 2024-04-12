<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\Sections;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections =Sections::all();
        $products=Products::all();
      return view('products.products',compact('sections','products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           //        الطريقة الثانية لل validation
           $validatedData = $request->validate([
            'Product_name' => 'required|unique:Products|max:255',
            'description' => 'required'],[
            'Product_name.required'=>"يرجي ادخال اسم المنتج",
            'Product_name.unique'=>"اسم المنتج مكرر من فضلك ادخل اسم جديد",
            'description.required'=>"يرجي ادخال الملاحظات",
        ]);

        Products::create([
            'Product_name' =>$request['Product_name'],
            'description'  =>$request['description'],
            'section_id' =>$request['section_id'],
        ]);

        session()->flash('Add','تم اضافة القسم بنجاح');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, products $products)
    {
        //     first دي معناها ان انا رايح الجدول اجيب حاجه واه فقط
        //     اما لو عايز اجيب اكتر من حاجه استخدم get

        $id = sections::where('section_name', $request->section_name)->first()->id;
        $Products = Products::findOrFail($request->pro_id);
        $pro_id = $request->pro_id;

        $this->validate($request, [
            'Product_name' => 'required|max:255|unique:Products,Product_name,'.$pro_id,
            'description' => 'required'],[
            'Product_name.required'=>"يرجي ادخال اسم المنتج",
            'Product_name.unique'=>"اسم المنتج مكرر من فضلك ادخل اسم جديد",
            'description.required'=>"يرجي ادخال الملاحظات",
        ]);

        $Products->update([
            'Product_name' => $request->Product_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);

        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,products $products)
    {
        $Products = Products::findOrFail($request->pro_id);
        $Products->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }
}
