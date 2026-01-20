<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlantController extends Controller
{
    // Metode index bisa diakses oleh siapa saja
    public function index()
    {
        $plants = Plant::all();
        return view('plants.index', compact('plants'));
    }

    // Metode create hanya bisa diakses oleh pengguna yang sudah login
    public function create()
    {
        $plants = Plant::select('id', 'common_name')->get(); // Ambil id dan nama umum
        return view('plants.create', compact('plants'));
    }

    // Metode store hanya bisa diakses oleh pengguna yang sudah login
    public function store(Request $request)
    {
        $request->validate([
            'common_name' => 'required|string|max:255',
            'genus' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'origin' => 'required|string|max:255',
            'breeder' => 'required|string|max:255',
            'description' => 'required|string',
            'female_parents_id' => 'nullable|exists:plants,id',
            'male_parents_id' => 'nullable|exists:plants,id',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        // Menangani upload foto
        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $photos[] = $file->store('plants', 'public'); // Menyimpan foto di storage public
            }
        }

        // Menyimpan data tanaman ke database
        Plant::create([
            'common_name' => $request->common_name,
            'synonym' => $request->synonym,
            'genus' => $request->genus,
            'family' => $request->family,
            'origin' => $request->origin,
            'breeder' => $request->breeder,
            'description' => $request->description,
            'photos' => json_encode($photos), // Simpan array foto sebagai JSON
            'female_parents_id' => $request->female_parents_id,
            'male_parents_id' => $request->male_parents_id,
            'user_id' => Auth::id(),
            'status' => 'available', // Status default saat input pertama
        ]);

        return redirect()->route('plants.index')->with('success', 'Data tanaman berhasil ditambahkan.');
    }

    // Metode edit hanya bisa diakses oleh pengguna yang sudah login
    public function edit($id)
    {
        $plant = Plant::findOrFail($id);
        $plants = Plant::select('id', 'common_name')->get(); // Tambahkan ini untuk dropdown parents

        if ($plant->status == 'editing' && $plant->user_id != Auth::id()) {
            return redirect()->route('plants.index')->with('error', 'Tanaman sedang diedit oleh pengguna lain.');
        }

        // Update status menjadi editing jika user sedang mengedit
        $plant->update(['status' => 'editing', 'edited_by' => Auth::id()]);

        return view('plants.edit', compact('plant', 'plants'));
    }

    // Metode update hanya bisa diakses oleh pengguna yang sudah login
    public function update(Request $request, $id)
    {
        $plant = Plant::findOrFail($id);

        $request->validate([
            'common_name' => 'required|string|max:255',
            'genus' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'origin' => 'required|string|max:255',
            'breeder' => 'required|string|max:255',
            'description' => 'required|string',
            'female_parents_id' => 'nullable|exists:plants,id',
            'male_parents_id' => 'nullable|exists:plants,id',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photos = json_decode($plant->photos, true) ?: [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $photos[] = $file->store('plants', 'public');
            }
        }

        $plant->update([
            'common_name' => $request->common_name,
            'synonym' => $request->synonym,
            'genus' => $request->genus,
            'family' => $request->family,
            'origin' => $request->origin,
            'breeder' => $request->breeder,
            'description' => $request->description,
            'photos' => json_encode($photos),
            'female_parents_id' => $request->female_parents_id,
            'male_parents_id' => $request->male_parents_id,
            'status' => 'revised',
            'edited_by' => Auth::id(),
        ]);

        return redirect()->route('plants.index')->with('success', 'Data tanaman berhasil diperbarui.');
    }

    // Metode destroy hanya bisa diakses oleh pengguna yang sudah login
    public function destroy($id)
    {
        $plant = Plant::findOrFail($id);
        $plant->delete();

        return redirect()->route('plants.index')->with('success', 'Data tanaman berhasil dihapus.');
    }
}
