<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pimpinan;
use Illuminate\Http\Request;

class PimpinanController extends Controller
{
    public function index()
    {
        $pimpinan = Pimpinan::first();

        if (! $pimpinan) {
            $pimpinan = Pimpinan::create([
                'nama_desa' => 'Desa Suranenggala Kidul',
                'nama_kepala_desa' => 'Pemerintah Desa Suranenggala Kidul',
            ]);
        }

        return view('admin.pimpinan.index', compact('pimpinan'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_desa' => 'required|string|max:255',
            'nama_kepala_desa' => 'required|string|max:255',
        ]);

        $pimpinan = Pimpinan::first();

        if (! $pimpinan) {
            $pimpinan = new Pimpinan;
        }

        $pimpinan->fill($validated);
        $pimpinan->save();

        return redirect()->route('admin.pimpinan.index')->with('success', 'Data Pimpinan berhasil diperbarui.');
    }
}
