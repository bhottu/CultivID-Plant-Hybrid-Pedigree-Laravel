<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantSubmission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PlantSubmissionPublicController extends Controller
{
    public function show(PlantSubmission $plantSubmission)
    {
        $plantSubmission->load('uploader.plantSubmissions', 'uploader.posts', 'uploader.products');

        // Fungsi rekursif untuk mengambil silsilah
        $maxDepth = 5;
        $getPedigree = function($plant_id, $depth = 0) use (&$getPedigree, $maxDepth) {
            if ($depth >= $maxDepth) return null;
            $node = PlantSubmission::where('plant_id', $plant_id)->first();
            if (!$node) return null;
            return [
                'plant_id' => $node->plant_id,
                'induk_jantan' => $node->induk_jantan,
                'induk_betina' => $node->induk_betina,
                'children' => [
                    'jantan' => $node->induk_jantan ? $getPedigree($node->induk_jantan, $depth+1) : null,
                    'betina' => $node->induk_betina ? $getPedigree($node->induk_betina, $depth+1) : null,
                ]
            ];
        };

        
       // $pedigree = $getPedigree($plantSubmission->plant_id);
        $pedigree = $this->buildPedigree($plantSubmission, 0, 3);
        return view('plant_submissions.show', compact('plantSubmission', 'pedigree'));
    }

    private function buildPedigree($plant, $level = 0, $maxLevel = 3)
    {
        if (!$plant || $level >= $maxLevel) {
            return null;
        }

        $betina = !empty($plant->induk_betina)
            ? PlantSubmission::where('plant_id', trim($plant->induk_betina))->first()
            : null;

        $jantan = !empty($plant->induk_jantan)
            ? PlantSubmission::where('plant_id', trim($plant->induk_jantan))->first()
            : null;

        return [
            'plant_id'     => $plant->plant_id,
             'plant_id_var'     => $plant->plant_id_var,
            'induk_betina' => $plant->induk_betina,
            'induk_betina_var' => $plant->induk_betina_var,
            'induk_jantan' => $plant->induk_jantan,
            'induk_jantan_var' => $plant->induk_jantan_var,
            'betina_node'  => $betina ? $this->buildPedigree($betina, $level + 1, $maxLevel) : null,
            'jantan_node'  => $jantan ? $this->buildPedigree($jantan, $level + 1, $maxLevel) : null,
        ];
    }

 public function previewPedigree(PlantSubmission $plantSubmission)
{
    $this->authorizeAccess($plantSubmission);
    return $this->renderPedigreePdf($plantSubmission, 'stream');
}

public function downloadPedigreePdf(PlantSubmission $plantSubmission)
{
    $this->authorizeAccess($plantSubmission);
    return $this->renderPedigreePdf($plantSubmission, 'download');
}

private function authorizeAccess(PlantSubmission $plantSubmission)
{
    $user = auth()->user();

    // 1. Jika tidak login, langsung tolak
    if (!$user) {
        return redirect()->back()->with('error', 'Please log in first.')->send();
    }

    // 2. Jika Admin, izinkan lewat
    if ($user->is_admin) {
        return true;
    }

    // 3. Cek apakah ini pemilik tanaman
    // (Gunakan uploader_id sesuai dengan logika buy di UserTransactionController Anda)
    $isOwner = $user->id === $plantSubmission->uploader_id;

   if (!$isOwner) {
        // Alihkan kembali dengan pesan error
        return redirect()->back()->with('error', 'The certificate can only be purchased and accessed by the owner of this plant. If this is your plant, please appeal.')->send();
    }

    // 4. Jika pemilik, cek apakah sudah bayar
    $hasPaid = \App\Models\UserTransaction::where('user_id', $user->id)
        ->where('plant_id', $plantSubmission->id)
        ->where('type', 'certificate')
        ->where('status', 'completed')
        ->exists();

   if (!$hasPaid) {
        return redirect()->back()->with('error', 'You have not made payment for this certificate.')->send();
    }

    return true;
}

/**
 * Shared PDF renderer (preview & download)
 */
private function renderPedigreePdf(PlantSubmission $plantSubmission, string $mode)
{
    // =============================
    // ENSURE CERTIFICATE NUMBER
    // =============================
    $certificateNumber = $this->ensureCertificateNumber($plantSubmission);

    // =============================
    // PEDIGREE DATA
    // =============================
    $pedigree = $this->buildPedigree($plantSubmission, 0, 4);

    $detailUrl = route('plant-submissions.show', $plantSubmission->plant_id);

    // =============================
    // GENERATE QR TEMP FILE
    // =============================
    // $tmpDir = public_path('tmp');
    $tmpDir = storage_path('app/tmp/pedigree');
    File::ensureDirectoryExists($tmpDir);

    $qrPath = $tmpDir.'/qr-'.$plantSubmission->id.'.png';

    file_put_contents(
        $qrPath,
        file_get_contents(
            'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='
            . urlencode($detailUrl)
        )
    );

    // =============================
    // GENERATE PDF
    // =============================
    $pdf = Pdf::loadView(
        'plant_submissions.pedigree_pdf',
        [
            'plantSubmission'   => $plantSubmission,
            'pedigree'          => $pedigree,
            'qrPath'            => $qrPath,
            'certificateNumber' => $certificateNumber,
        ]
    )->setPaper('a4', 'landscape');

    $response = $mode === 'download'
        ? $pdf->download('pedigree-'.$certificateNumber.'.pdf')
        : $pdf->stream('pedigree-preview.pdf');

    // =============================
    // CLEANUP TEMP FILE
    // =============================
    File::delete($qrPath);

    return $response;
}


private function ensureCertificateNumber(PlantSubmission $plantSubmission): string
{
    if ($plantSubmission->certificate_number) {
        return $plantSubmission->certificate_number;
    }

    $prefix    = 'PCP-PLT';
    $plantPart = str_pad($plantSubmission->id, 4, '0', STR_PAD_LEFT);
    $datePart  = now()->format('Ymd');
    $random    = strtoupper(Str::random(4));

    $certificate = "{$prefix}-{$plantPart}-{$datePart}-{$random}";

    $plantSubmission->update([
        'certificate_number'    => $certificate,
        'certificate_issued_at' => now(),
    ]);

    return $certificate;
}

}
