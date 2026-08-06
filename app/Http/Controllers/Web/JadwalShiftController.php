<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\JadwalShift;
use App\Models\MasterShift;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalShiftController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $tanggal = $request->input('tanggal', Carbon::today()->format('Y-m-d'));
        
        $masterShifts = MasterShift::all();

        if ($user->role === 'admin cabang') {
            // Dapatkan seluruh karyawan aktif di cabang ini
            $karyawans = User::where('id_cabang', $user->id_cabang)
                ->where('role', 'karyawan')
                ->where('status', 'aktif')
                ->get();

            // Dapatkan jadwal shift terbaru karyawan di cabang ini (mengabaikan tanggal)
            $schedules = JadwalShift::with(['masterShift'])
                ->where('id_cabang', $user->id_cabang)
                ->orderBy('created_at', 'desc')
                ->get()
                ->unique('id_user')
                ->keyBy('id_user');

            // Susun data agar menampilkan seluruh karyawan beserta status jadwalnya
            $karyawanSchedules = [];
            foreach ($karyawans as $kar) {
                $sch = $schedules->get($kar->id_user);
                $karyawanSchedules[] = (object) [
                    'karyawan' => $kar,
                    'jadwal' => $sch,
                ];
            }

            return view('admin.jadwal_shift.index', compact('karyawanSchedules', 'masterShifts', 'tanggal', 'karyawans'));
        } else {
            // Super Admin: Tampilkan riwayat jadwal secara global
            $query = JadwalShift::with(['user', 'masterShift', 'cabang'])->orderBy('created_at', 'desc');

            if ($request->filled('id_cabang')) {
                $query->where('id_cabang', $request->id_cabang);
            }

            $jadwalShifts = $query->paginate(15)->withQueryString();

            return view('admin.jadwal_shift.index', compact('jadwalShifts', 'masterShifts', 'tanggal'));
        }
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'admin cabang') return abort(403);

        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_master_shift' => 'required|exists:master_shifts,id_master_shift',
            'tanggal' => 'required|date',
        ]);

        $karyawan = User::findOrFail($request->id_user);
        if ($karyawan->role !== 'karyawan' || $karyawan->id_cabang !== $user->id_cabang) {
            return redirect()->back()->with('error', 'Karyawan tidak valid atau bukan berasal dari cabang Anda.');
        }

        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');

        // Cek bentrok
        $ada = JadwalShift::where('id_user', $request->id_user)
            ->where('tanggal', $tanggal)
            ->where('id_master_shift', $request->id_master_shift)
            ->exists();

        if ($ada) {
            return redirect()->back()->with('error', 'Jadwal bentrok: Karyawan sudah memiliki shift ini pada tanggal tersebut.');
        }

        JadwalShift::create([
            'id_user' => $request->id_user,
            'id_cabang' => $user->id_cabang,
            'id_master_shift' => $request->id_master_shift,
            'tanggal' => $tanggal,
            'status' => 'terjadwal',
            'tipe' => 'biasa',
            'keterangan' => null
        ]);

        return redirect()->back()->with('success', 'Jadwal shift berhasil ditambahkan.');
    }

    public function setIzin(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->role !== 'admin cabang') return abort(403);

        $request->validate([
            'keterangan' => 'required|string|max:255',
        ]);

        $jadwal = JadwalShift::findOrFail($id);
        if ($jadwal->id_cabang !== $user->id_cabang) return abort(403);

        $jadwal->update([
            'tipe' => 'izin',
            'keterangan' => $request->keterangan,
            'status' => 'dibatalkan',
        ]);

        return redirect()->route('jadwal_shift.index')->with('success', 'Jadwal karyawan berhasil ditandai sebagai Izin.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalShift::findOrFail($id);
        $user = auth()->user();

        if ($user->role === 'admin cabang' && $jadwal->id_cabang !== $user->id_cabang) {
            return abort(403);
        }

        if ($jadwal->status !== 'terjadwal' && $jadwal->status !== 'dibatalkan') {
            return redirect()->route('jadwal_shift.index')->with('error', 'Jadwal yang sudah berjalan tidak dapat dihapus.');
        }

        $jadwal->delete();
        return redirect()->route('jadwal_shift.index')->with('success', 'Jadwal shift berhasil dihapus.');
    }
}
