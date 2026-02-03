<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantSubmission;

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
            'induk_betina' => $plant->induk_betina,
            'induk_jantan' => $plant->induk_jantan,
            'betina_node'  => $betina ? $this->buildPedigree($betina, $level + 1, $maxLevel) : null,
            'jantan_node'  => $jantan ? $this->buildPedigree($jantan, $level + 1, $maxLevel) : null,
        ];
    }

}
