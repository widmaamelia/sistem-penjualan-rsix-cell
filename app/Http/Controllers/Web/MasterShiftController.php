<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MasterShift;
use Illuminate\Http\Request;

class MasterShiftController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'super') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }
        $masterShifts = MasterShift::orderBy('jam_mulai')->get();
        return view('admin.master_shift.index', compact('masterShifts'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'super') return abort(403);

        $request->validate([
            'nama_shift' => 'required|string|max:100',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        MasterShift::create($request->all());

        return redirect()->route('master_shift.index')->with('success', 'Master Shift berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'super') return abort(403);

        $request->validate([
            'nama_shift' => 'required|string|max:100',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $shift = MasterShift::findOrFail($id);
        $shift->update($request->all());

        return redirect()->route('master_shift.index')->with('success', 'Master Shift berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'super') return abort(403);

        try {
            $shift = MasterShift::findOrFail($id);
            $shift->delete();
            return redirect()->route('master_shift.index')->with('success', 'Master Shift berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('master_shift.index')->with('error', 'Shift tidak dapat dihapus karena sudah digunakan di jadwal.');
        }
    }
}
