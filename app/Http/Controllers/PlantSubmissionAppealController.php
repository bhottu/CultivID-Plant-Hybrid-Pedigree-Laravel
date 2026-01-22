<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantSubmissionAppeal;
use App\Models\PlantSubmission;
use Illuminate\Support\Facades\Auth;

class PlantSubmissionAppealController extends Controller
{
    public function create(PlantSubmission $plantSubmission)
    {
        $submission = $plantSubmission;
        return view('plant_submissions.appeal', compact('submission'));
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
        return redirect()->route('plant-submissions.index')->with('success', 'Appeal has been successfully submitted!');
    }
}
