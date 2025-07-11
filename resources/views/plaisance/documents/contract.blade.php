<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrat - {{ $demande->titre ?? 'Sans titre' }}</title>
    <style>
        @page {
            margin: 2cm;
            size: A4;
            @top-center {
                content: "Contrat N° {{ $demande->id }}";
                font-size: 10px;
                color: #666;
            }
            @bottom-center {
                content: "Page " counter(page) " sur " counter(pages);
                font-size: 10px;
                color: #666;
            }
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #fff;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 20px;
        }

        .header h1 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header h2 {
            margin: 0;
            color: #34495e;
            font-size: 14px;
            font-weight: normal;
        }

        .reference-info {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .reference-info .left {
            font-weight: bold;
            color: #2c3e50;
        }

        .reference-info .right {
            text-align: right;
            color: #666;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section h3 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            border: 1px solid #e9ecef;
        }

        .info-table th,
        .info-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
            vertical-align: top;
        }

        .info-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 35%;
            color: #2c3e50;
        }

        .info-table td {
            word-wrap: break-word;
        }

        .highlight {
            background-color: #fff3cd;
            padding: 4px 8px;
            border-radius: 3px;
            border: 1px solid #ffeaa7;
            font-weight: bold;
        }

        .monetary {
            color: #27ae60;
            font-weight: bold;
            font-size: 12px;
        }

        .conditions {
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 20px;
            margin: 20px 0;
        }

        .conditions h4 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .conditions p {
            margin-bottom: 15px;
            text-align: justify;
        }

        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 30px;
        }

        .signature-box {
            text-align: center;
            border: 1px solid #e9ecef;
            padding: 20px;
            border-radius: 5px;
        }

        .signature-box h4 {
            margin: 0 0 20px 0;
            color: #2c3e50;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .signature-line {
            border-bottom: 1px solid #333;
            height: 50px;
            margin-bottom: 10px;
        }

        .signature-info {
            font-size: 10px;
            color: #666;
            margin-top: 10px;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 48px;
            color: rgba(0, 0, 0, 0.05);
            z-index: -1;
            font-weight: bold;
        }

        .footer-info {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
            font-size: 9px;
            color: #666;
            text-align: center;
        }

        .no-data {
            color: #999;
            font-style: italic;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-accepted {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Watermark -->
        <div class="watermark">CONTRAT</div>

        <!-- Header -->
        <div class="header">
            <h1>Contrat de Vente</h1>
            <h2>{{ $demande->titre ?? 'Document contractuel' }}</h2>
        </div>

        <!-- Reference Information -->
        <div class="reference-info">
            <div class="left">
                <div>Référence: <span class="highlight">{{ $demande->id }}</span></div>
                <div>Statut:
                    @php
                        $statusClass = 'status-pending';
                        $statusText = 'En attente';

                        if (isset($demande->statut)) {
                            switch(strtolower($demande->statut)) {
                                case 'accepté':
                                case 'accepted':
                                case 'approuvé':
                                    $statusClass = 'status-accepted';
                                    $statusText = 'Accepté';
                                    break;
                                case 'rejeté':
                                case 'rejected':
                                case 'refusé':
                                    $statusClass = 'status-rejected';
                                    $statusText = 'Rejeté';
                                    break;
                                default:
                                    $statusText = ucfirst($demande->statut);
                            }
                        }
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                </div>
            </div>
            <div class="right">
                <div>Date d'édition: {{ $metadata['date_generation'] ?? now()->format('d/m/Y H:i') }}</div>
                <div>Généré par: {{ $metadata['generated_by'] ?? 'System' }}</div>
            </div>
        </div>

        <!-- General Information -->
        <div class="section">
            <h3>Informations Générales</h3>
            <table class="info-table">
                <tr>
                    <th>Numéro de demande</th>
                    <td class="highlight">{{ $demande->id }}</td>
                </tr>
                <tr>
                    <th>Titre</th>
                    <td>{{ $demande->titre ?? 'Non spécifié' }}</td>
                </tr>
                @if($demande->description)
                <tr>
                    <th>Description</th>
                    <td>{{ $demande->description }}</td>
                </tr>
                @endif
                @if($demande->type_economique)
                <tr>
                    <th>Type économique</th>
                    <td>{{ ucfirst($demande->type_economique) }}</td>
                </tr>
                @endif
                @if($demande->montant)
                <tr>
                    <th>Montant</th>
                    <td class="monetary">{{ number_format($demande->montant, 2, ',', ' ') }} DH</td>
                </tr>
                @endif
                <tr>
                    <th>Date de création</th>
                    <td>{{ $demande->created_at ? $demande->created_at->format('d/m/Y H:i') : 'Non disponible' }}</td>
                </tr>
            </table>
        </div>

        <!-- Contract Details from JSON fields -->
        @if(isset($champsRemplis) && !empty($champsRemplis))
        <div class="section">
            <h3>Détails du Contrat</h3>
            <table class="info-table">
                @foreach($champsRemplis as $key => $champ)
                    <tr>
                        <th>{{ $champ['label'] ?? ucfirst(str_replace('_', ' ', $key)) }}</th>
                        <td>
                            @if(is_array($champ['value']))
                                {{ implode(', ', $champ['value']) }}
                            @else
                                {{ $champ['value'] }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        @endif

        <!-- General Conditions -->
        <div class="section">
            <h3>Conditions Générales</h3>
            <div class="conditions">
                <h4>Article 1 - Objet du contrat</h4>
                <p>Le présent contrat a pour objet la vente de <strong>{{ $demande->titre ?? 'produit/service' }}</strong> selon les modalités et conditions définies ci-après.</p>

                <h4>Article 2 - Prix et modalités de paiement</h4>
                <p>Le prix total convenu s'élève à <strong>{{ $demande->montant ? number_format($demande->montant, 2, ',', ' ') . ' DH' : 'montant à définir' }}</strong> TTC. Le paiement s'effectuera selon les modalités convenues entre les parties contractantes.</p>

                <h4>Article 3 - Livraison et exécution</h4>
                <p>La livraison ou l'exécution du service s'effectuera conformément aux spécifications techniques et aux délais convenus dans le présent contrat.</p>

                <h4>Article 4 - Garanties</h4>
                <p>Le vendeur garantit la conformité du produit ou service aux spécifications décrites dans le présent contrat et s'engage à remédier à tout défaut de conformité dans les conditions légales.</p>

                <h4>Article 5 - Responsabilité</h4>
                <p>Les parties s'engagent à respecter leurs obligations respectives telles que définies dans le présent contrat. En cas de litige, les parties s'efforceront de trouver une solution amiable.</p>

                <h4>Article 6 - Droit applicable</h4>
                <p>Le présent contrat est régi par le droit marocain. Tout litige relatif à l'interprétation ou à l'exécution du présent contrat sera soumis à la compétence des tribunaux compétents.</p>
            </div>
        </div>

        <!-- Signatures -->
        <div class="signature-section">
            <h3>Signatures</h3>
            <div class="signature-grid">
                <div class="signature-box">
                    <h4>Le Vendeur</h4>
                    <div class="signature-line"></div>
                    <div class="signature-info">
                        <p><strong>Nom:</strong> _________________________</p>
                        <p><strong>Signature:</strong></p>
                        <p><strong>Date:</strong> _________________________</p>
                    </div>
                </div>

                <div class="signature-box">
                    <h4>L'Acheteur</h4>
                    <div class="signature-line"></div>
                    <div class="signature-info">
                        <p><strong>Nom:</strong> _________________________</p>
                        <p><strong>Signature:</strong></p>
                        <p><strong>Date:</strong> _________________________</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-info">
            <p>Document généré automatiquement le {{ $metadata['date_generation'] ?? now()->format('d/m/Y H:i') }}</p>
            <p>Référence: {{ $demande->id }} | Version: {{ $metadata['version'] ?? '1.0' }}</p>
        </div>
    </div>
</body>
</html>
