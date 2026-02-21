<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\PlantSubmission;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PlantSubmissionAppeal;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;


class PlantSubmissionController extends Controller
{
    // Daftar submission (member & admin)
  
    public function index(Request $request)
    {
        $status = $request->get('status');
        $user = Auth::user();

        $allowedStatuses = ['approved','pending','rejected','revision','appeal'];
        if ($status && !in_array($status, $allowedStatuses)) {
            abort(404);
        }

        $query = PlantSubmission::with(['uploader','reviewer']);

        // =========================
        // ROLE USER
        // =========================
        if (!$user->is_admin) {
            $query->where(function ($q) use ($user) {
                $q->where('uploader_id', $user->id)
                ->orWhereIn('id', function ($sub) use ($user) {
                    $sub->select('plant_submission_id')
                        ->from('plant_submission_appeals')
                        ->where('user_id', $user->id);
                });
            });
        }


        if ($status === 'revision') {

        $query->where(function ($q) {
            $q->where(function ($qq) {
                $qq->whereNull('induk_jantan')
                ->orWhere('induk_jantan', '');
            })
            ->where(function ($qq) {
                $qq->whereNull('induk_betina')
                ->orWhere('induk_betina', '');
            });
        });

        }
       elseif ($status === 'appeal') {

            $query->whereIn(
                'id',
                PlantSubmissionAppeal::select('plant_submission_id')
            )
            ->where('status_review', '!=', 'approved');

        }
        elseif (in_array($status, ['approved','pending','rejected'])) {

            $query->where('status_review', $status);

        }

       // $submissions = $query->latest()->paginate(3);
        $submissions = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();
        

        // =========================
        // BADGE COUNTS
        // =========================
        $base = PlantSubmission::query();

        if (!$user->is_admin) {
            $base->where('uploader_id', $user->id);
        }

        $counts = [
            'approved' => (clone $base)->where('status_review','approved')->count(),
            'pending'  => (clone $base)->where('status_review','pending')->count(),
            'rejected' => (clone $base)->where('status_review','rejected')->count(),
            'revision' => (clone $base)->where(function ($q) {
                        $q->where(function ($qq) {
                            $qq->whereNull('induk_jantan')
                            ->orWhere('induk_jantan', '');
                        })
                        ->where(function ($qq) {
                            $qq->whereNull('induk_betina')
                            ->orWhere('induk_betina', '');
                        });
                     })->count(),

            'appeal' => $user->is_admin
                        ? PlantSubmissionAppeal::whereHas('submission', function ($q) {
                        $q->where('status_review', '!=', 'approved');
                        })->count()
                        : PlantSubmissionAppeal::where('user_id', $user->id)
                        ->whereHas('submission', function ($q) {
                        $q->where('status_review', '!=', 'approved');})->count(),

        ];

        return view('plant_submissions.index', compact('submissions','status','counts'));
    }




    // Form create submission
    public function create()
    {
    $parentSubmissions = \App\Models\PlantSubmission::select('plant_id', 'penyilang')->get();
    $plants = \App\Models\Plant::select('id', 'common_name')->get();
    $users = \App\Models\User::select('name')->get();
    return view('plant_submissions.create', compact('parentSubmissions', 'plants', 'users'));
    }

    // Store submission
    public function store(Request $request)
    {
        $request->validate([
            'plant_id' => ['required','string','max:255','unique:plant_submissions,plant_id',],
            'induk_jantan' => 'nullable|string|max:255',
            'induk_betina' => 'nullable|string|max:255',
            'penyilang' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|max:4096',
        ]);
        

        $data = $request->only(['plant_id', 'induk_jantan', 'induk_betina', 'penyilang', 'keterangan']);

        // =====================================================
        // VARIEGATED FLAGS (checkbox logic)
        // 0 = true (checked), 1 = false (unchecked)
        // =====================================================
        $data['plant_id_var']     = (int) $request->input('plant_id_var', 1);
        $data['induk_jantan_var'] = (int) $request->input('induk_jantan_var', 1);
        $data['induk_betina_var'] = (int) $request->input('induk_betina_var', 1);


        // ✅ AUTO CAPITAL (SETELAH $data ADA)
        foreach (['induk_jantan', 'induk_betina'] as $field) {
            if (!empty($data[$field])) {
                $data[$field] = ucfirst(strtolower($data[$field]));
            } else {
                $data[$field] = null;
            }
        }
        
        // Convert empty strings to null for nullable fields
        foreach (['induk_jantan', 'induk_betina', 'penyilang', 'keterangan'] as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = null;
            }
        }
        
        $data['uploader_id'] = Auth::id();

        // Otomatis buat entri baru jika induk_jantan belum ada dan tidak kosong
        if (!empty($data['induk_jantan']) && !PlantSubmission::where('plant_id', $data['induk_jantan'])->exists()) {
            PlantSubmission::create([
                'plant_id' => $data['induk_jantan'],
                'plant_id_var' => 1,
                'induk_jantan' => null,
                'induk_jantan_var' => 1,
                'induk_betina' => null,
                'induk_betina_var' => 1,
                'penyilang' => null,
                'uploader_id' => Auth::id(),
                'keterangan' => null,
                'image' => null,
                'status_review' => 'approved',
            ]);
        }
        // Otomatis buat entri baru jika induk_betina belum ada dan tidak kosong
        if (!empty($data['induk_betina']) && !PlantSubmission::where('plant_id', $data['induk_betina'])->exists()) {
            PlantSubmission::create([
                'plant_id' => $data['induk_betina'],
                'plant_id_var' => 1,
                'induk_jantan' => null,
                'induk_jantan_var' => 1,
                'induk_betina' => null,
                'induk_betina_var' => 1,
                'penyilang' => null,
                'uploader_id' => Auth::id(),
                'keterangan' => null,
                'image' => null,
                'status_review' => 'approved',
            ]);
        }

       // --- PROSES COMPRESS IMAGE (Sama dengan ProductController) ---
        $imagePaths = [];
        
        // Cek input images[] (Multiple) atau image (Single fallback)
        $files = $request->file('images') ?? ($request->hasFile('image') ? [$request->file('image')] : []);

        if (!empty($files)) {

            $destinationPath = public_path('storage/plant_images');

            // Pastikan folder ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($files as $file) {

                // Nama unik + webp
                $filename = uniqid() . '_' . time() . '.webp';

                $imageResized = \Image::make($file)
                    ->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('webp', 75);

                $imageResized->save($destinationPath . '/' . $filename);

                $imagePaths[] = 'plant_images/' . $filename;
            }
        }

        if (!empty($imagePaths)) {
            // store as JSON string so we can support multiple images without new column
            $data['image'] = json_encode($imagePaths);
        }

        PlantSubmission::create($data);
        return redirect()->route('plant-submissions.index')->with('success', 'Thanks! Your submission is under review. Please check back within 24 hours.');
    }

    // Edit submission (hanya uploader atau member lain dengan approval uploader)
    public function edit(PlantSubmission $plantSubmission)
        {
            $this->authorize('update', $plantSubmission);
            $parentSubmissions = \App\Models\PlantSubmission::select('plant_id', 'induk_jantan', 'induk_betina')->get();
            $users = \App\Models\User::select('name')->get();
            return view('plant_submissions.edit', compact('plantSubmission', 'parentSubmissions', 'users'));
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
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|max:4096',
        ]);

        $data = $request->only([
            'plant_id',
            'induk_jantan',
            'induk_betina',
            'penyilang',
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
// ✅ AUTO DELETE & COMPRESS GAMBAR BARU
// =====================================================
// =====================================================
// ✅ AUTO DELETE & COMPRESS GAMBAR BARU (WEBP VERSION)
// =====================================================
if ($request->hasFile('images') || $request->hasFile('image')) {

    // 1️⃣ Hapus gambar lama
    if ($plantSubmission->image) {
        $oldImages = json_decode($plantSubmission->image, true);

        if (!is_array($oldImages)) {
            $oldImages = [$plantSubmission->image];
        }

        foreach ($oldImages as $oldImage) {
            if (\Storage::disk('public')->exists($oldImage)) {
                \Storage::disk('public')->delete($oldImage);
            }
        }
    }

    // 2️⃣ Simpan gambar baru (WebP Optimized)
    $imagePaths = [];
    $files = $request->file('images') ?? [$request->file('image')];

    $destinationPath = public_path('storage/plant_images');

    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }

    foreach ($files as $file) {

        $filename = uniqid() . '_' . time() . '.webp';

        $imageResized = \Image::make($file)
            ->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('webp', 75);

        $imageResized->save($destinationPath . '/' . $filename);

        $imagePaths[] = 'plant_images/' . $filename;
    }

    $data['image'] = json_encode($imagePaths);
}


        // Jika updater bukan uploader
        if (auth()->id() !== $plantSubmission->uploader_id) {
            $data['uploader_approval'] = false;
        }

        foreach (['induk_jantan','induk_betina'] as $f) {
            if ($data[$f] === '') {
                $data[$f] = null;
            }
        }

        // =========================
// AUTO CREATE PARENT (UPDATE)
// =========================
foreach (['induk_jantan', 'induk_betina'] as $parentField) {
    if (
        !empty($data[$parentField]) &&
        !PlantSubmission::where('plant_id', $data[$parentField])->exists()
    ) {
        PlantSubmission::create([
            'plant_id' => $data[$parentField],
            'plant_id_var' => 1,
            'induk_jantan' => null,
            'induk_jantan_var' => 1,
            'induk_betina' => null,
            'induk_betina_var' => 1,
            'penyilang' => null,
            'uploader_id' => Auth::id(),
            'keterangan' => null,
            'image' => null,
            'status_review' => 'approved',
        ]);
    }
}


        $plantSubmission->update($data);

        return redirect()
            ->route('plant-submissions.index')
            ->with('success', 'Plant updated successfully!');
    }

    // Review oleh admin
    public function review(Request $request, PlantSubmission $plantSubmission)
    {
        $this->authorize('review', $plantSubmission);

        $request->validate([
            'status_review' => 'required|in:approved,rejected',
        ]);

        $oldStatus = $plantSubmission->status_review;

        $plantSubmission->update([
            'status_review' => $request->status_review,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        // 🔔 CREATE NOTIFICATION IF STATUS CHANGED
        if (
            $oldStatus !== $request->status_review &&
            $plantSubmission->uploader_id !== Auth::id()
        ) {

            $type = $request->status_review === 'approved'
                ? 'plant_approved'
                : 'plant_rejected';

            $message = $request->status_review === 'approved'
                ? 'Your plant submission ' . $plantSubmission->plant_id . ' has been approved 🌿'
                : 'Your plant submission ' . $plantSubmission->plant_id . ' was rejected.';

            Notification::create([
                'user_id' => $plantSubmission->uploader_id,
                'from_user_id' => Auth::id(),
                'type' => $type,
                'notifiable_id' => $plantSubmission->id,
                'notifiable_type' => 'PlantSubmission',
                'data' => [
                    'submission_id' => $plantSubmission->plant_id,
                    'message' => $message
                ]
            ]);
        }

        return redirect()
            ->route('plant-submissions.index')
            ->with('success', 'Status updated successfully!');
    }


    public function getFirstImageAttribute()
    {
        return $this->image[0] ?? null;
    }


    public function adminDestroy(PlantSubmission $plantSubmission)
        {
            if ($plantSubmission->image) {

                $decoded = json_decode($plantSubmission->image, true);

                // Jika multiple images (JSON array)
                if (is_array($decoded)) {
                    foreach ($decoded as $path) {
                        if ($path && Storage::disk('public')->exists($path)) {
                            Storage::disk('public')->delete($path);
                        }
                    }
                } 
                // Fallback kalau ternyata string tunggal
                else {
                    if (Storage::disk('public')->exists($plantSubmission->image)) {
                        Storage::disk('public')->delete($plantSubmission->image);
                    }
                }
            }

            $plantSubmission->delete();

            return redirect()
                ->route('admin.plant-submissions.index')
                ->with('success', 'Plant deleted successfully.');
        }

        public function destroy(PlantSubmission $plantSubmission)
    {
        // =========================
        // AUTHORIZATION
        // =========================
        if (
            !Auth::check() ||
            (!Auth::user()->is_admin && Auth::id() !== $plantSubmission->uploader_id)
        ) {
            abort(403, 'Unauthorized');
        }

        // =========================
        // DELETE IMAGE(S)
        // =========================
        if ($plantSubmission->image) {

            // decode JSON image (support single & multiple)
            $images = json_decode($plantSubmission->image, true);

            if (is_array($images)) {
                foreach ($images as $path) {
                    if ($path && Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            } else {
                // fallback jika image bukan JSON
                if (Storage::disk('public')->exists($plantSubmission->image)) {
                    Storage::disk('public')->delete($plantSubmission->image);
                }
            }
        }

        // =========================
        // DELETE DATA
        // =========================
        $plantSubmission->delete();

        return redirect()
            ->back()
            ->with('success', 'Plant deleted successfully!');
    }

    

}
