<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlantSubmission;
use Illuminate\Support\Facades\Auth;

class PlantSubmissionController extends Controller
{
    // Admin index: show all submissions
    public function index()
    {
        $submissions = PlantSubmission::with(['uploader', 'reviewer'])->latest()->paginate(10);
        return view('admin.plant_submissions.index', compact('submissions'));
    }

    public function create()
    {
        $parentSubmissions = PlantSubmission::select('plant_id', 'penyilang', 'induk_jantan', 'induk_betina')->get();
        $plants = \App\Models\Plant::select('id', 'common_name')->get();
        $users = \App\Models\User::select('name')->get();
        return view('admin.plant_submissions.create', compact('parentSubmissions', 'plants', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plant_id' => 'required|string|max:255',
            'induk_jantan' => 'nullable|string|max:255',
            'induk_betina' => 'nullable|string|max:255',
            'penyilang' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['plant_id', 'induk_jantan', 'induk_betina', 'penyilang', 'keterangan']);
        foreach (['induk_jantan', 'induk_betina', 'penyilang', 'keterangan'] as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = null;
            }
        }
        $data['uploader_id'] = Auth::id();

        if (!empty($data['induk_jantan']) && !PlantSubmission::where('plant_id', $data['induk_jantan'])->exists()) {
            PlantSubmission::create([
                'plant_id' => $data['induk_jantan'],
                'induk_jantan' => '',
                'induk_betina' => '',
                'penyilang' => '',
                'uploader_id' => Auth::id(),
                'keterangan' => '',
                'image' => null,
                'status_review' => 'approved',
            ]);
        }
        if (!empty($data['induk_betina']) && !PlantSubmission::where('plant_id', $data['induk_betina'])->exists()) {
            PlantSubmission::create([
                'plant_id' => $data['induk_betina'],
                'induk_jantan' => '',
                'induk_betina' => '',
                'penyilang' => '',
                'uploader_id' => Auth::id(),
                'keterangan' => '',
                'image' => null,
                'status_review' => 'approved',
            ]);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('plant_images', 'public');
        }

        PlantSubmission::create($data);
        return redirect()->route('admin.plant-submissions.index')->with('success', 'Plant added successfully!');
    }

    public function show(PlantSubmission $plantSubmission)
    {
        $pedigree = null; // if your logic computes pedigree, keep working here or rely on existing service
        return view('admin.plant_submissions.show', compact('plantSubmission', 'pedigree'));
    }

    public function edit(PlantSubmission $plantSubmission)
    {
        $this->authorize('update', $plantSubmission);
        $parentSubmissions = PlantSubmission::select('plant_id', 'induk_jantan', 'induk_betina')->get();
        $users = \App\Models\User::select('name')->get();
        return view('admin.plant_submissions.edit', compact('plantSubmission', 'parentSubmissions', 'users'));
    }

    public function update(Request $request, PlantSubmission $plantSubmission)
    {
        $this->authorize('update', $plantSubmission);
        $request->validate([
            'plant_id' => 'required|string|max:255',
            'induk_jantan' => 'nullable|string|max:255',
            'induk_betina' => 'nullable|string|max:255',
            'penyilang' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status_review' => 'required|in:pending,approved,rejected',
            'rejection_reason' => 'nullable|string|required_if:status_review,rejected',
        ]);

        $data = $request->only(['plant_id', 'induk_jantan', 'induk_betina', 'penyilang', 'status_review', 'keterangan', 'rejection_reason']);
        foreach (['induk_jantan', 'induk_betina', 'penyilang', 'keterangan', 'status_review', 'rejection_reason'] as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = null;
            }
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('plant_images', 'public');
        }

        if (Auth::id() !== $plantSubmission->uploader_id) {
            $data['uploader_approval'] = false;
        }

        $plantSubmission->update($data);
        return redirect()->route('admin.plant-submissions.index')->with('success', 'Plant updated successfully!');
    }

    public function review(Request $request, PlantSubmission $plantSubmission)
    {
        $this->authorize('review', $plantSubmission);
        $request->validate([
            'status_review' => 'required|in:approved,rejected',
        ]);
        $plantSubmission->update([
            'status_review' => $request->status_review,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);
        return redirect()->route('admin.plant-submissions.index')->with('success', 'Status updated successfully!');
    }

public function search(Request $request)
{
    //$this->authorize('viewAny', PlantSubmission::class);

    $query = $request->q;

    $submissions = PlantSubmission::with('uploader')
        ->when($query, function ($q) use ($query) {
            $q->where(function ($subQuery) use ($query) {

                // cari berdasarkan primary ID
                $subQuery->where('id', $query)

                    // cari berdasarkan plant_id
                    ->orWhere('plant_id', 'like', "%{$query}%")

                    // cari berdasarkan nama uploader
                    ->orWhereHas('uploader', function ($userQuery) use ($query) {
                        $userQuery->where('name', 'like', "%{$query}%");
                    });
            });
        })
        ->latest()
        ->get();

    return response()->json($submissions);
}

}
