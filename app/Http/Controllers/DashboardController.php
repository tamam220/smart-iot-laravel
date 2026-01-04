<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Datastream;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $devices = $user->devices;

        // Cari device yang dipilih, jika tidak ada ambil yang pertama
        if ($request->has('device_id')) {
            $currentDevice = Device::where('id', $request->device_id)->where('user_id', $user->id)->first();
        } else {
            $currentDevice = $devices->first();
        }

        // AMBIL DATASTREAMS MILIK DEVICE AKTIF
        $datastreams = $currentDevice ? $currentDevice->datastreams : [];

        return view('dashboard', compact('devices', 'currentDevice', 'datastreams'));
    }

    // Fungsi Membuat Device Baru
    public function storeDevice(Request $request)
    {
        $request->validate([
            'device_name' => 'required|string|max:255',
        ]);

        Device::create([
            'user_id' => Auth::id(),
            'name'    => $request->device_name,
            'token'   => Str::random(32),
            'widgets' => '[]', // Inisialisasi dengan array kosong string
        ]);

        return redirect()->route('dashboard')->with('status', 'Device berhasil dibuat!');
    }

    // Fungsi Membuat Datastream (V0, V1, dst)
    public function storeDatastream(Request $request)
    {
        $request->validate([
            'device_id' => 'required',
            'name' => 'required',
            'pin' => 'required'
        ]);

        Datastream::create([
            'device_id' => $request->device_id,
            'name' => $request->name,
            'pin' => $request->pin
        ]);

        return back()->with('success', 'Datastream berhasil dibuat!');
    }

    // FUNGSI SIMPAN DASHBOARD (Ini yang dipanggil tombol Simpan)
  public function saveDashboard(Request $request)
{
    try {
        $request->validate([
            'device_id' => 'required',
            'widgets'   => 'required', 
        ]);

        $device = Device::where('id', $request->device_id)
                        ->where('user_id', Auth::id())
                        ->first();

        if ($device) {
            // Karena JavaScript mengirim JSON.stringify, 
            // kita ubah dulu menjadi Array agar sesuai dengan $casts di Model
            $device->widgets = json_decode($request->widgets, true);
            $device->save();

            return response()->json(['message' => 'Berhasil disimpan ke Database!']);
        }

        return response()->json(['message' => 'Device tidak ditemukan'], 404);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}
}