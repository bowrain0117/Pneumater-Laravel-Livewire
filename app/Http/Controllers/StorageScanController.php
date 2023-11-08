<?php

namespace App\Http\Controllers;

use App\Models\StorageScan;
use App\Models\StorageScanTire;
use Illuminate\Http\Request;

class StorageScanController extends Controller
{
    public function index()
    {
        return view('storage-scan.index', [
            'storageScans' => StorageScan::orderBy('created_at', 'DESC')->get(),
        ]);
    }

    public function create()
    {
        return view('storage-scan.create');
    }

    public function show(StorageScan $storageScan)
    {
        return view('storage-scan.show', ['storageScan' => $storageScan]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'uploadFile' => 'required|file|max:8162',
        ]);

        $storageScan = StorageScan::create([
            'name' => $request->name,
        ]);

        $path = $request->uploadFile->getRealPath();
        $lines = array_map('str_getcsv', file($path));
        foreach ($lines as $line) {
            StorageScanTire::create([
                'storage_scan_id' => $storageScan->id,
                'tire_id' => $line[2],
                'ean' => $line[4] ?? '',
                'rack_identifier' => strtoupper($line[0]),
                'rack_position' => $line[1],
            ]);
        }

        return redirect()->route('storage-scan.index');
    }

    public function destroy(StorageScan $storageScan)
    {
        $storageScan->scanTires()->delete();
        $storageScan->delete();

        return redirect()->route('storage-scan.index');
    }
}
