{{-- resources/views/plaisance/documents/bon-commande.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Commande - {{ $demande->titre }}</title>
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
            border-bottom: 2px solid #28a745;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #28a745;
            font-size: 26px;
        }
        .header h2 {
            margin: 5px 0;
            color: #6c757d;
            font-size: 16px;
        }
        .company-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .company-box {
            width: 48%;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .company-box h3 {
            color: #28a745;
            margin-top: 0;
            margin-bottom: 10px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section h3 {
            color: #28a745;
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
            background-color: #28a745;
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
            background-color: #28a745;
            color: white;
            font-weight: bold;
        }
        .date-field {
            text-align: right;
            margin-bottom: 20px;
        }
        .highlight {
            background-color: #d4edda;
            padding: 2px 4px;
            border-radius: 3px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
        }
        .conditions-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #28a745;
            margin-top: 20px;
        }
        .urgent {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .urgent h4 {
            color: #856404;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BON DE COMMANDE</h1>
        <h2>N° {{ $demande->id }}-{{ date('Y') }}</h2>
    </div>

    <div class="date-field">
        <strong>Date de commande : </strong>{{ date('d/m/Y') }}
    </div>

    <div class="company-info">
        <div class="company-box">
            <h3>DONNEUR D'ORDRE</h3>
            <p>
                <strong>Nom de la société</strong><br>
                Service Plaisance<br>
                Adresse de la société<br>
                Code postal, Ville<br>
                Téléphone : +212 XXX XXX XXX<br>
                Email : plaisance@societe.com
            </p>
        </div>
        <div class="company-box">
            <h3>FOURNISSEUR</h3>
            <p>
                <strong>{{ $champs['nom_fournisseur']['value'] ?? 'À compléter' }}</strong><br>
                {{ $champs['adresse_fournisseur']['value'] ?? 'Adresse à compléter' }}<br>
                {{ $champs['code_postal_fournisseur']['value'] ?? '' }} {{ $champs['ville_fournisseur']['value'] ?? '' }}<br>
                Téléphone : {{ $champs['telephone_fournisseur']['value'] ?? 'À compléter' }}<br>
                Email : {{ $champs['email_fournisseur']['value'] ?? 'À compléter' }}
            </p>
        </div>
    </div>

    @if(isset($champs['urgent']) && $champs['urgent']['value'] == 'oui')
    <div class="urgent">
        <h4>⚠️ COMMANDE URGENTE</h4>
        <p>Cette commande nécessite un traitement prioritaire.</p>
    </div>
    @endif

    <div class="section">
        <h3>INFORMATIONS DE LA COMMANDE</h3>
        <table class="info-table">
            <tr>
                <th style="width: 30%;">Référence demande :</th>
                <td class="highlight">{{ $demande->id }}</td>
            </tr>
            <tr>
                <th>Objet :</th>
                <td>{{ $demande->titre }}</td>
            </tr>
            <tr>
                <th>Description :</th>
                <td>{{ $demande->description ?? 'Non spécifiée' }}</td>
            </tr>
            <tr>
                <th>Service demandeur :</th>
                <td>{{ $champs['service_demandeur']['value'] ?? 'Service Plaisance' }}</td>
            </tr>
            <tr>
                <th>Responsable :</th>
                <td>{{ $champs['responsable']['value'] ?? 'Non spécifié' }}</td>
            </tr>
            <tr>
                <th>Date limite de livraison :</th>
                <td class="highlight">{{ $champs['date_livraison']['value'] ?? 'À définir' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>DÉTAILS DE LA COMMANDE</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th style="width: 100px;">Quantité</th>
                    <th style="width: 120px;">Prix unitaire</th>
                    <th style="width: 120px;">Total HT</th>
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
                        @if(str_contains($key, 'article_') || str_contains($key, 'produit_'))
                            <tr>
                                <td>{{ $champ['designation'] ?? $champ['label'] ?? $key }}</td>
                                <td class="number">{{ $champ['quantite'] ?? '1' }}</td>
                                <td class="number">{{ $champ['prix_unitaire'] ?? '0' }} DH</td>
                                <td class="number">{{ ($champ['quantite'] ?? 1) * ($champ['prix_unitaire'] ?? 0) }} DH</td>
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
                <th>Total HT :</th>
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

    <div class="section">
        <h3>CONDITIONS DE LIVRAISON</h3>
        <table class="info-table">
            <tr>
                <th style="width: 30%;">Adresse de livraison :</th>
                <td>{{ $champs['adresse_livraison']['value'] ?? 'Adresse de la société' }}</td>
            </tr>
            <tr>
                <th>Mode de livraison :</th>
                <td>{{ $champs['mode_livraison']['value'] ?? 'À définir' }}</td>
            </tr>
            <tr>
                <th>Délai de livraison :</th>
                <td>{{ $champs['delai_livraison']['value'] ?? 'Selon disponibilité' }}</td>
            </tr>
            <tr>
                <th>Contact réception :</th>
                <td>{{ $champs['contact_reception']['value'] ?? 'Service Plaisance' }}</td>
            </tr>
        </table>
    </div>

    @if(!empty($champs))
    <div class="section">
        <h3>SPÉCIFICATIONS TECHNIQUES</h3>
        <table class="info-table">
            @foreach($champs as $key => $champ)
                @if(!in_array($key, ['nom_fournisseur', 'adresse_fournisseur', 'telephone_fournisseur', 'email_fournisseur', 'quantite', 'prix_unitaire', 'adresse_livraison', 'mode_livraison', 'delai_livraison', 'contact_reception']) && !str_contains($key, 'article_') && !str_contains($key, 'produit_'))
                    <tr>
                        <th>{{ $champ['label'] ?? $key }} :</th>
                        <td>{{ $champ['value'] ?? 'Non renseigné' }}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
    @endif

    <div class="conditions-box">
        <h3>CONDITIONS GÉNÉRALES</h3>
        <p>
            <strong>• Conditions de paiement :</strong> {{ $champs['conditions_paiement']['value'] ?? '30 jours net' }}<br>
            <strong>• Garantie :</strong> {{ $champs['garantie']['value'] ?? 'Selon conditions du fournisseur' }}<br>
            <strong>• Retour :</strong> Tout retour doit être autorisé préalablement<br>
            <strong>• Conformité :</strong> Les produits doivent être conformes aux spécifications<br>
            <strong>• Facturation :</strong> Joindre une copie de ce bon de commande à la facture
        </p>
    </div>

    <div class="section">
        <h3>VALIDATION</h3>
        <table class="info-table">
            <tr>
                <th style="width: 30%;">Validé par :</th>
                <td>{{ $champs['validateur']['value'] ?? 'Responsable Service Plaisance' }}</td>
            </tr>
            <tr>
                <th>Date de validation :</th>
                <td>{{ date('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Signature :</th>
                <td style="height: 50px; vertical-align: bottom;">_________________________</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>
            <strong>IMPORTANT :</strong> Ce bon de commande doit être retourné signé et tamponné pour acceptation.<br>
            En cas de modification, veuillez nous contacter avant exécution.<br>
            Généré automatiquement par le système de gestion - {{ date('d/m/Y H:i') }}
        </p>
    </div>
</body>
</html>
