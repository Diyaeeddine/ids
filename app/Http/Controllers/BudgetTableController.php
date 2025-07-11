<?php

namespace App\Http\Controllers;

use App\Models\BudgetTable;
use App\Models\BudgetEntry;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;



class BudgetTableController extends Controller
{
    public function create()
    {
        return view('admin.budgetaire.create-budgetaire');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'prevision' => 'required|integer',
            'rows' => 'required|array',
            'rows.*.imputation' => 'nullable|string|max:255',
            'rows.*.intitule' => 'nullable|string|max:255',
            'rows.*.is_header' => 'nullable|boolean',
            'rows.*.previsionnel' => 'nullable|numeric',
            'rows.*.atterrissage' => 'nullable|numeric',
            'rows.*.b_title' => 'nullable|string|max:255',
        ]);

        $table = BudgetTable::create([
            'title' => $validated['title'],
            'prevision_label' => 'Prévisions Budgétaires "' . $validated['prevision'] . '"',
        ]);

        foreach ($validated['rows'] as $index => $row) {
            BudgetEntry::create([
                'budget_table_id' => $table->id,
                'imputation_comptable' => $row['imputation'] ?? null,
                'intitule' => $row['intitule'] ?? null,
                'is_header' => isset($row['is_header']) && $row['is_header'] == 1,
                'budget_previsionnel' => $row['previsionnel'] ?? null,
                'atterrissage' => $row['atterrissage'] ?? null,
                'b_title' => $row['b_title'] ?? null,
                'position' => $index,
            ]);
        }

        return redirect()->back()->with('success', 'Table budgétaire créée avec succès !');
    }

    public function index()
    {
        $tables = BudgetTable::all(); 
        $firstTable = $tables->first();

        return view('admin.budgetaire.tables-budgetaires', [
            'tables' => $tables,
            'selectedTable' => $firstTable,
        ]);
    }

    public function show($id)
    {
        $tables = BudgetTable::all(); 
        $selectedTable = BudgetTable::with('entries')->findOrFail($id);

        return view('admin.budgetaire.tables-budgetaires', [
            'tables' => $tables,
            'selectedTable' => $selectedTable,
        ]);
    }

    public function exportPdf($id)
    {
        $table = BudgetTable::with('entries')->findOrFail($id);
        $url = url("/admin/tables-budgetaires/{$id}");

        $qrCode = base64_encode(
            QrCode::format('png')->size(100)->generate($url)
        );

        $safeTitle = Str::slug($table->title);
        $filename = "{$safeTitle}_{$table->id}.pdf";

        $pdf = Pdf::loadView('admin.budgetaire.export-pdf', [
            'table' => $table,
            'qrCode' => $qrCode,
            'url' => $url,
        ]);

        return $pdf->download($filename);
    }

public function edit($id)
    {
        $budgetTable = BudgetTable::with('entries')->findOrFail($id);
        return view('admin.budgetaire.edit-budget-table', compact('budgetTable'));
    }

    public function updateEntries(Request $request, $id)
    {
        $table = BudgetTable::findOrFail($id);
        $table->update([
            'title' => $request->title,
            'prevision_label' => $request->prevision_label,
        ]);

        $existingIds = [];
        $position = 1;

        foreach ($request->entries as $key => $entryData) {
            $data = [
                'budget_table_id' => $id,
                'imputation_comptable' => $entryData['imputation_comptable'] ?? null,
                'intitule' => $entryData['intitule'] ?? null,
                'budget_previsionnel' => $entryData['budget_previsionnel'] ?? null,
                'atterrissage' => $entryData['atterrissage'] ?? null,
                'b_title' => $entryData['b_title'] ?? null,
                'is_header' => $entryData['is_header'] ?? 0,
                'position' => $position++,
            ];

            if (str_starts_with($key, 'new_')) {
                BudgetEntry::create($data);
            } else {
                $entry = BudgetEntry::find($entryData['id']);
                if ($entry) {
                    $entry->update($data);
                    $existingIds[] = $entry->id;
                }
            }
        }

        BudgetEntry::where('budget_table_id', $id)->whereNotIn('id', $existingIds)->delete();

        return redirect()->route('budget-tables.index')->with('success', 'Table mise à jour avec succès.');
    }
}
