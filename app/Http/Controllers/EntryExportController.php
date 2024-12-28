<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\Entry;

class EntryExportController extends Controller
{
    public function __invoke()
    {
        $entries = Auth::user()->entries()
            ->orderBy('date', 'desc')
            ->get(['date', 'story', 'mood']);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="entries.csv"',
        ];

        $callback = function () use ($entries) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, ['Date', 'Story', 'Mood']);

            // Add entries
            foreach ($entries as $entry) {
                fputcsv($file, [
                    $entry->date->format('Y-m-d'),
                    $entry->story,
                    $entry->mood,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
