<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Exporter - Table Budgetaire</title>
    <meta charset="UTF-8">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid black;
            padding: 6px;
        }
        th {
            background-color: #e5e7eb;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">{{ $table->title }}</h2>
    <h4 style="text-align: center;">{{ $table->prevision_label }}</h4>

    <table>
        <thead>
            <tr>
                <th>Imputation</th>
                <th>Intitulé</th>
                <th>Prévisionnel</th>
                <th>Atterrissage</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($table->entries as $entry)
                @if ($entry->b_title)
                    <tr>
                        <td colspan="4" style="background-color: #cbd5e1; font-weight: bold; text-align: center;">
                            {{ $entry->b_title }}
                        </td>
                    </tr>
                @else
                    <tr style="{{ $entry->is_header ? 'font-weight:bold;background-color:#f1f5f9;' : '' }}">
                        <td>{{ $entry->imputation_comptable }}</td>
                        <td>{{ $entry->intitule }}</td>
                        <td>{{ $entry->budget_previsionnel }}</td>
                        <td>{{ $entry->atterrissage }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 40px; text-align: center;">
        <p>Voir en ligne: <a href="{{ $url }}">ici</a></p>
        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
    </div>
</body>
</html>