<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantSubmissionAppeal;
use App\Models\PlantSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlantSubmissionAppealController extends Controller
{
   public function create(Request $request, PlantSubmission $plantSubmission)
{
    $submission = $plantSubmission;

    // mode view jika ada ?view
    $isView = $request->has('view');

    $appealQuery = PlantSubmissionAppeal::with('user')
        ->where('plant_submission_id', $submission->id);

    // jika BUKAN admin, hanya boleh lihat appeal miliknya
    if (!Auth::user()->is_admin ?? false) {
        $appealQuery->where('user_id', Auth::id());
    }

    $appeal = $appealQuery->latest()->first();

     // ✅ TAMBAHAN WAJIB
    $parentSubmissions = PlantSubmission::select(
        'plant_id',
        'induk_jantan',
        'induk_betina'
    )->get();

     $users = \App\Models\User::select('name')->get();

    return view('plant_submissions.appeal', compact(
        'submission',
        'isView',
        'parentSubmissions',
        'appeal',
        'users'
    ));
}



    public function store(Request $request, PlantSubmission $plantSubmission)
    {
        $submission = $plantSubmission;
        $request->validate([
            'keterangan' => 'required|string',
            'bukti.*' => 'image|max:512', // 500kb = 512kb (laravel rounding)
        ]);
        $buktiPaths = [];
        if ($request->hasFile('bukti')) {
            foreach ($request->file('bukti') as $file) {
                $buktiPaths[] = $file->store('appeal_bukti', 'public');
            }
        }
        PlantSubmissionAppeal::create([
            'plant_submission_id' => $submission->id,
            'user_id' => Auth::id(),
            'keterangan' => $request->keterangan,
            'bukti' => json_encode($buktiPaths),
            'status' => 'pending',
        ]);
        // update status banding di submission jika perlu
        $submission->update(['status_review' => 'banding']);
        return redirect()->route('plant-submissions.index')->with('success', 'Appeal submitted! We will review it within 3 working days.');
    }

    public function update(Request $request, PlantSubmission $plantSubmission)
    {
        $this->authorize('update', $plantSubmission);

        $request->validate([
            //'plant_id' => 'required|string|max:255',
            'plant_id' => 'required|string|max:255',
            'induk_jantan' => 'nullable|string|max:255',
            'induk_betina' => 'nullable|string|max:255',
            'penyilang' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'uploader_id' => 'required|exists:users,id',
            'status_review' => 'nullable|string|max:255',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|max:4096',
        ]);

        $data = $request->only([
            'plant_id',
            'induk_jantan',
            'induk_betina',
            'penyilang',
            'status_review',
            'keterangan'
        ]);

        // =====================================================
        // VARIEGATED FLAGS (checkbox logic)
        // =====================================================
       $data['plant_id_var']     = (int) $request->input('plant_id_var', 1);
$data['induk_jantan_var'] = (int) $request->input('induk_jantan_var', 1);
$data['induk_betina_var'] = (int) $request->input('induk_betina_var', 1);



        // Convert empty string → null
        foreach (['induk_jantan','induk_betina','penyilang','keterangan'] as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = null;
            }
        }

        // =====================================================
        // ✅ AUTO DELETE GAMBAR LAMA JIKA ADA GAMBAR BARU
        // =====================================================
        if ($request->hasFile('images') || $request->hasFile('image')) {

            // ✅ Ambil & hapus gambar lama
            if ($plantSubmission->image) {
                $oldImages = json_decode($plantSubmission->image, true);

                if (!is_array($oldImages)) {
                    $oldImages = [$plantSubmission->image];
                }

                foreach ($oldImages as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }

            // ✅ Simpan gambar baru
            $imagePaths = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $imagePaths[] = $file->store('plant_images', 'public');
                }
            } else {
                $imagePaths[] = $request->file('image')->store('plant_images', 'public');
            }

            $data['image'] = json_encode($imagePaths);
        }

        // Jika updater bukan uploader
        if (auth()->id() !== $plantSubmission->uploader_id) {
            $data['uploader_approval'] = false;
        }

         $data['uploader_id'] = $request->uploader_id;

        $plantSubmission->update($data);

        return redirect()
            ->route('plant-submissions.index')
            ->with('success', 'Plant updated successfully!');
    }

}
