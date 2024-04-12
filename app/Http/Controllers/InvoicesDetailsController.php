<?php

namespace App\Http\Controllers;

use App\Models\invoices_details;
use Illuminate\Http\Request;

use App\Models\invoice_attachments;
use App\Models\Invoices;
use App\Models\Sections;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use phpseclib3\File\ASN1\Maps\DirectoryString;
use function PHPUnit\Framework\directoryExists;
class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = sections::where('section_name', $request->section_name)->first()->id;
        $objects=invoices_details::where('id_Invoice',$id)->get();
          $files=invoice_attachments::where('invoice_id',$id)->get();

  //      $objects=invoices_details::all();
        return view('invoices.invoices_details',compact('objects','files'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = invoices::where('id',$id)->first();
        $details  = invoices_Details::where('id_Invoice',$id)->get();
        $attachments  = invoice_attachments::where('invoice_id',$id)->get();

        return view('invoices.invoices_details',compact('invoices','details','attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoices = invoice_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);



        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function get_file($invoice_number,$file_name)
    {
//        $st="Attachments";
        $pathToFile = public_path("Attachments".'/'.$invoice_number.'/'.$file_name);
        return response()->download($pathToFile);
    }
    public function open_file($invoice_number,$file_name)
    {
//        $st="Attachments";
        $pathToFile = public_path("Attachments".'/'.$invoice_number.'/'.$file_name);
        return response()->file($pathToFile);
    }
}