<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Commande - {{ $demande->titre }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            margin: 15px;
            background-color: #ffffff;
            color: #333;
            line-height: 1.3;
        }

        .container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            padding: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
            position: relative;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header p {
            margin: 5px 0 0 0;
            font-size: 11px;
            color: #666;
        }

        .reference-box {
            position: absolute;
            top: 0;
            right: 0;
            width: 120px;
            border: 1px solid #2c3e50;
            padding: 8px;
            background-color: #f8f9fa;
            text-align: center;
        }

        .reference-box .ref-label {
            font-weight: 600;
            font-size: 9px;
            margin-bottom: 3px;
            color: #2c3e50;
        }

        .reference-box .ref-value {
            font-size: 12px;
            font-weight: bold;
            padding: 3px;
            background-color: white;
            border: 1px solid #ddd;
            margin-bottom: 8px;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            background-color: #28a745;
            color: #fff;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 3px;
        }

        .form-section {
            margin-bottom: 12px;
            border: 1px solid #e0e0e0;
        }

        .section-title {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 6px 12px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
        }

        .form-table {
            width: 100%;
            border-collapse: collapse;
        }

        .form-table td {
            border: 1px solid #e0e0e0;
            padding: 6px 8px;
            vertical-align: top;
        }

        .form-table .label {
            background-color: #f8f9fa;
            font-weight: 600;
            width: 22%;
            font-size: 10px;
            color: #2c3e50;
        }

        .form-table .value {
            width: 28%;
            min-height: 18px;
            font-size: 10px;
        }

        .form-table .full-width {
            width: 100%;
        }

        .highlight-field {
            background-color: #fff3cd;
            font-weight: 600;
            color: #856404;
        }

        .date-field {
            background-color: #d1ecf1;
            font-weight: 600;
            color: #0c5460;
        }

        .checkbox-section {
            margin: 5px 0;
        }

        .checkbox-section label {
            margin-right: 15px;
            font-size: 10px;
        }

        .checkbox {
            width: 10px;
            height: 10px;
            border: 1px solid #333;
            display: inline-block;
            margin-right: 4px;
            vertical-align: middle;
        }

        .checkbox.checked {
            background-color: #2c3e50;
        }
                .titre-global {
            background-color: #e8f5e8;

            padding: 10px;
            margin-bottom: 15px;
            text-align: center;
        }

        .titre-global h3 {
            margin: 0;
            color: #155724;
            font-size: 14px;
            font-weight: bold;
        }

        .signature-section {
            margin-top: 15px;
            border: 1px solid #e0e0e0;
            padding: 10px;
            background-color: #f8f9fa;
        }

        .signature-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .signature-box {
            flex: 1;
            text-align: center;
            border: 1px solid #e0e0e0;
            padding: 8px;
            background-color: white;
        }

        .signature-box .title {
            font-weight: 600;
            font-size: 9px;
            margin-bottom: 8px;
            color: #2c3e50;
            text-transform: uppercase;
        }

        .signature-line {
            border-bottom: 1px solid #666;
            height: 25px;
            margin-bottom: 4px;
        }

        .date-field-signature {
            font-size: 8px;
            text-align: center;
            color: #666;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        /* Styles spécifiques pour le bon de commande */
        .bon-commande-info {
            background-color: #e8f5e8;
            border-left: 4px solid #28a745;
            padding: 10px;
            margin-bottom: 15px;
        }

        .bon-commande-info h2 {
            margin: 0 0 5px 0;
            color: #155724;
            font-size: 14px;
        }

        .bon-commande-info p {
            margin: 0;
            font-size: 10px;
            color: #155724;
        }

        /* Table des articles/produits */
        .articles-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .articles-table th {
            background-color: #2c3e50;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
        }

        .articles-table td {
            border: 1px solid #e0e0e0;
            padding: 6px 8px;
            font-size: 10px;
        }

        .articles-table .quantity {
            text-align: center;
            width: 10%;
        }

        .articles-table .price {
            text-align: right;
            width: 15%;
        }

        .articles-table .total {
            text-align: right;
            width: 15%;
            font-weight: 600;
        }

        .total-section {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #e0e0e0;
            margin-top: 10px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 10px;
        }

        .total-row.final {
            font-weight: 600;
            font-size: 12px;
            border-top: 2px solid #2c3e50;
            padding-top: 5px;
            margin-top: 10px;
        }

        /* Optimisation pour l'impression */
        @media print {
            body {
                margin: 0;
                background-color: white;
                font-size: 10px;
            }

            .container {
                border: none;
                padding: 10px;
                box-shadow: none;
            }

            .form-section {
                margin-bottom: 8px;
            }

            .form-table td {
                padding: 4px 6px;
            }

            .signature-line {
                height: 20px;
            }
        }

        /* Responsive pour mobile */
        @media (max-width: 768px) {
            .reference-box {
                position: static;
                width: 100%;
                margin-bottom: 10px;
            }

            .signature-row {
                flex-direction: column;
            }

            .signature-box {
                margin-bottom: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="titre-global">
            <h3>Bon de commande</h3>
        </div>


        <div class="form-section">
            <table class="form-table">
                <tr>
                    <td class="label">N° Demande</td>
                    <td class="value highlight-field">{{ $demande->id }}</td>
                    <td class="label">Date de Création</td>
                    <td class="value date-field">{{ $demande->created_at ? $demande->created_at->format('d/m/Y H:i') : 'Non disponible' }}</td>
                </tr>
                <tr>
                    <td class="label">Titre</td>
                    <td class="value full-width" colspan="3">{{ $demande->titre ?? 'Non spécifié' }}</td>
                </tr>
                <tr>
                    <td class="label">Montant Total (DH)</td>
                    <td class="value highlight-field">{{ $demande->montant ? number_format($demande->montant, 2, ',', ' ') : 'Non spécifié' }}</td>
                    <td class="label">Date du Bon</td>
                    <td class="value date-field">{{ now()->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Type Économique</td>
                    <td class="value">{{ ucfirst($demande->type_economique ?? 'Non spécifié') }}</td>
                    <td class="label">Statut</td>
                    <td class="value">
                        <span class="status-badge">{{ ucfirst($demande->statut ?? 'En cours') }}</span>
                    </td>
                </tr>
            </table>
        </div>

        @if(!empty($bonCommandeChamps))
        <div class="form-section">
            <table class="form-table">
                @php $counter = 0; @endphp
                @foreach($bonCommandeChamps as $key => $champ)
                    @if(isset($champ['value']) && $champ['value'] !== null && $champ['value'] !== '')
                        @if($counter % 2 == 0)
                            <tr>
                        @endif
                                <td class="label">{{ $champ['label'] ?? ucfirst(str_replace(['_', '-'], ' ', $key)) }}</td>
                                <td class="value">
                                    @if(is_array($champ['value']))
                                        {{ implode(', ', $champ['value']) }}
                                    @elseif(is_numeric($champ['value']) && (strpos($key, 'montant') !== false || strpos($key, 'prix') !== false || strpos($key, 'cout') !== false))
                                        {{ number_format($champ['value'], 2, ',', ' ') }} DH
                                    @elseif(preg_match('/\d{4}-\d{2}-\d{2}/', $champ['value']))
                                        <span class="date-field">{{ date('d/m/Y', strtotime($champ['value'])) }}</span>
                                    @else
                                        {{ $champ['value'] }}
                                    @endif
                                </td>
                        @if($counter % 2 == 1 || $loop->last)
                            @if($counter % 2 == 0 && $loop->last)
                                <td class="label"></td>
                                <td class="value"></td>
                            @endif
                            </tr>
                        @endif
                        @php $counter++; @endphp
                    @endif
                @endforeach
            </table>
        </div>
        @endif

        @if(isset($articles) && !empty($articles))
        <div class="form-section">
            <div class="section-title">Articles Commandés</div>
            <table class="articles-table">
                <thead>
                    <tr>
                        <th>Désignation</th>
                        <th>Référence</th>
                        <th class="quantity">Quantité</th>
                        <th class="price">Prix Unitaire</th>
                        <th class="total">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                    <tr>
                        <td>{{ $article['designation'] ?? 'Non spécifié' }}</td>
                        <td>{{ $article['reference'] ?? '-' }}</td>
                        <td class="quantity">{{ $article['quantite'] ?? 1 }}</td>
                        <td class="price">{{ number_format($article['prix_unitaire'] ?? 0, 2, ',', ' ') }} DH</td>
                        <td class="total">{{ number_format(($article['quantite'] ?? 1) * ($article['prix_unitaire'] ?? 0), 2, ',', ' ') }} DH</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Section Totaux -->
        <div class="total-section">
            <div class="total-row">
                <span>Sous-total HT:</span>
                <span>{{ number_format($demande->montant ?? 0, 2, ',', ' ') }} DH</span>
            </div>
            <div class="total-row">
                <span>TVA (20%):</span>
                <span>{{ number_format(($demande->montant ?? 0) * 0.20, 2, ',', ' ') }} DH</span>
            </div>
            <div class="total-row final">
                <span>Total TTC:</span>
                <span>{{ number_format(($demande->montant ?? 0) * 1.20, 2, ',', ' ') }} DH</span>
            </div>
        </div>

        <!-- Section Signatures -->
        <div class="signature-section">
            <div class="signature-row">
                <div class="signature-box">
                    <div class="title">Signature du Demandeur</div>
                    <div class="signature-line"></div>
                    <div class="date-field-signature">Date: _______________</div>
                    <div class="date-field-signature">Nom et Prénom: _______________</div>
                </div>
                <div class="signature-box">
                    <div class="title">Signature du Fournisseur</div>
                    <div class="signature-line"></div>
                    <div class="date-field-signature">Date: _______________</div>
                    <div class="date-field-signature">Nom et Fonction: _______________</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
