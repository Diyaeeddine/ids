{{-- resources/views/plaisance/documents/facture.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture - {{ $demande->titre }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #007bff;
            font-size: 28px;
        }
        .header h2 {
            margin: 5px 0;
            color: #6c757d;
            font-size: 16px;
        }
        .company-info {
            margin-bottom: 30px;
        }
        .company-info h3 {
            color: #007bff;
            margin-bottom: 10px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section h3 {
            color: #007bff;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th, .info-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dee2e6;
        }
        .info-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th, .items-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #dee2e6;
        }
        .items-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .items-table .number {
            text-align: right;
        }
        .total-section {
            margin-top: 30px;
            text-align: right;
        }
        .total-table {
            width: 300px;
            margin-left: auto;
            border-collapse: collapse;
        }
        .total-table th, .total-table td {
            padding: 8px 12px;
            border: 1px solid #dee2e6;
        }
        .total-table th {
            background-color: #f8f9fa;
            text-align: left;
        }
        .total-table .final-total {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .date-field {
            text-align: right;
            margin-bottom: 20px;
        }
        .highlight {
            background-color: #fff3cd;
            padding: 2px 4px;
            border-radius: 3px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURE</h1>
        <h2>N° {{ $demande->id }}-{{ date('Y') }}</h2>
    </div>

    <div class="company-info">
        <h3>INFORMATIONS SOCIÉTÉ</h3>
        <p>
            <strong>Nom de la société</strong><br>
            Adresse de la société<br>
            Code postal, Ville<br>
            Téléphone : +212 XXX XXX XXX<br>
            Email : contact@societe.com
        </p>
    </div>

    <div class="date-field">
        <strong>Date de facturation : </strong>{{ date('d/m/Y') }}
    </div>

    <div class="section">
        <h3>INFORMATIONS CLIENT</h3>
        <table class="info-table">
            <tr>
                <th style="width: 30%;">Nom du client :</th>
                <td>
                    @if(isset($champs['nom_client']))
                        {{ $champs['nom_client']['value'] }}
                    @else
                        {{ $champs['nom']['value'] ?? 'Non spécifié' }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>Adresse :</th>
                <td>{{ $champs['adresse']['value'] ?? 'Non spécifiée' }}</td>
            </tr>
            <tr>
                <th>Téléphone :</th>
                <td>{{ $champs['telephone']['value'] ?? 'Non spécifié' }}</td>
            </tr>
            <tr>
                <th>Email :</th>
                <td>{{ $champs['email']['value'] ?? 'Non spécifié' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>DÉTAILS DE LA FACTURE</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="width: 100px;">Quantité</th>
                    <th style="width: 120px;">Prix unitaire</th>
                    <th style="width: 120px;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $demande->titre }}</td>
                    <td class="number">{{ $champs['quantite']['value'] ?? '1' }}</td>
                    <td class="number">{{ $champs['prix_unitaire']['value'] ?? $demande->montant ?? '0' }} DH</td>
                    <td class="number">{{ $demande->montant ?? '0' }} DH</td>
                </tr>
                @if(!empty($champs))
                    @foreach($champs as $key => $champ)
                        @if(str_contains($key, 'produit_') || str_contains($key, 'service_'))
                            <tr>
                                <td>{{ $champ['label'] ?? $key }}</td>
                                <td class="number">{{ $champ['quantite'] ?? '1' }}</td>
                                <td class="number">{{ $champ['prix'] ?? '0' }} DH</td>
                                <td class="number">{{ $champ['prix'] ?? '0' }} DH</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="total-section">
        <table class="total-table">
            <tr>
                <th>Sous-total :</th>
                <td class="number">{{ $demande->montant ?? '0' }} DH</td>
            </tr>
            <tr>
                <th>TVA (20%) :</th>
                <td class="number">{{ ($demande->montant ?? 0) * 0.20 }} DH</td>
            </tr>
            <tr class="final-total">
                <th>Total TTC :</th>
                <td class="number">{{ ($demande->montant ?? 0) * 1.20 }} DH</td>
            </tr>
        </table>
    </div>

    @if(!empty($champs))
    <div class="section">
        <h3>INFORMATIONS COMPLÉMENTAIRES</h3>
        <table class="info-table">
            @foreach($champs as $key => $champ)
                @if(!in_array($key, ['nom', 'nom_client', 'adresse', 'telephone', 'email', 'quantite', 'prix_unitaire']) && !str_contains($key, 'produit_') && !str_contains($key, 'service_'))
                    <tr>
                        <th>{{ $champ['label'] ?? $key }} :</th>
                        <td>{{ $champ['value'] ?? 'Non renseigné' }}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
    @endif

    <div class="section">
        <h3>CONDITIONS DE PAIEMENT</h3>
        <p>
            <strong>Mode de paiement :</strong> {{ $champs['mode_paiement']['value'] ?? 'À définir' }}<br>
            <strong>Échéance :</strong> {{ $champs['echeance']['value'] ?? '30 jours' }}<br>
            <strong>Conditions :</strong> Paiement à réception de facture
        </p>
    </div>

    <div class="footer">
        <p>
            Cette facture est générée automatiquement par le système de gestion des demandes.<br>
            Pour toute question, veuillez contacter le service comptabilité.
        </p>
    </div>
</body>
</html>
