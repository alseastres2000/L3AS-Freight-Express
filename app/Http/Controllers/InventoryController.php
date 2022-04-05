<?php

namespace App\Http\Controllers;

use ZipArchive;

use App\Models\Inventory;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventory.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = Inventory::create([
            'code' => Str::uuid()->toString(),
            'name' => $request->name,
            'quantity' => $request->quantity ?? 0,
            'weight' => $request->weight ?? 0,
            'address_from' => $request->address_from,
            'address_to' => $request->address_to,
            'description' => $request->description,
            'created_by' => auth()->user()->id
        ]);

        if($request->hasFile('attachments'))
        {
            $files = $request->file('attachments');
            $pathToFile = storage_path('app/public/attachments/'.$item->code);
            File::makeDirectory($pathToFile, 0777, true, true);

            foreach ($files as $file) {
                $file->move($pathToFile, $file->getClientOriginalName());
            }
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        $inventory->fill($request->except('attachments'))->save();

        if($request->hasFile('attachments'))
        {
            $files = $request->file('attachments');
            $pathToFile = storage_path('app/public/attachments/'.$item->code);
            File::makeDirectory($pathToFile, 0777, true, true);

            foreach ($files as $file) {
                $file->move($pathToFile, $file->getClientOriginalName());
            }
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        $pathToFile = storage_path('app/public/attachments/'.$inventory->code);

        if(File::exists($pathToFile))
        {
            File::deleteDirectory($pathToFile);
        }

        $inventory->delete();

        return back();
    }
}
