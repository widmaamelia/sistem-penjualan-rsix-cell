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

            // Dapatkan jadwal shift karyawan di cabang ini pada tanggal terpilih
            $schedules = JadwalShift::with(['masterShift'])
                ->where('id_cabang', $user->id_cabang)
                ->whereDate('tanggal', $tanggal)
                ->get()
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
            $query = JadwalShift::with(['user', 'masterShift', 'cabang'])->orderBy('tanggal', 'desc');

            if ($request->filled('id_cabang')) {
                $query->where('id_cabang', $request->id_cabang);
            }

            if ($request->filled('tanggal')) {
                $query->whereDate('tanggal', $request->tanggal);
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
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'hari' => 'required|array|min:1',
            'hari.*' => 'integer|between:1,7',
            'tipe' => 'nullable|in:biasa,lembur,izin',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $karyawan = User::findOrFail($request->id_user);
        if ($karyawan->role !== 'karyawan' || $karyawan->id_cabang !== $user->id_cabang) {
            return redirect()->back()->with('error', 'Karyawan tidak valid atau bukan berasal dari cabang Anda.');
        }

        $startDate = Carbon::parse($request->tanggal_mulai);
        $endDate = Carbon::parse($request->tanggal_selesai);
        $selectedDays = $request->input('hari', []);

        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
        
        $insertedCount = 0;
        $skippedCount = 0;

        foreach ($period as $date) {
            $dayOfWeek = $date->dayOfWeekIso; // 1 (Senin) - 7 (Minggu)

            if (in_array($dayOfWeek, $selectedDays)) {
                $formattedDate = $date->format('Y-m-d');

                // Cek bentrok (karyawan yang sama pada tanggal dan shift yang sama)
                $exists = JadwalShift::where('id_user', $request->id_user)
                    ->where('tanggal', $formattedDate)
                    ->where('id_master_shift', $request->id_master_shift)
                    ->exists();

                if ($exists) {
                    $skippedCount++;
                    continue;
                }

                JadwalShift::create([
                    'id_cabang' => $user->id_cabang,
                    'id_user' => $request->id_user,
                    'id_master_shift' => $request->id_master_shift,
                    'tanggal' => $formattedDate,
                    'tipe' => $request->input('tipe', 'biasa'),
                    'keterangan' => $request->keterangan,
                    'status' => $request->input('tipe') === 'izin' ? 'dibatalkan' : 'terjadwal'
                ]);

                $insertedCount++;
            }
        }

        if ($insertedCount === 0) {
            return redirect()->back()->with('error', 'Tidak ada jadwal baru yang ditambahkan (jadwal bentrok atau hari tidak terpilih).');
        }

        $message = "Berhasil menjadwalkan {$insertedCount} shift kerja.";
        if ($skippedCount > 0) {
            $message .= " ({$skippedCount} jadwal dilewati karena bentrok).";
        }

        return redirect()->route('jadwal_shift.index')->with('success', $message);
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
