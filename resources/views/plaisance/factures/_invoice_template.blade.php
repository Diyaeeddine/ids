<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture {{ $facture->numero_facture }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background-color: white; line-height: 1.5; color: #333; }
        .invoice-container { max-width: 800px; margin: 0 auto; background-color: white; padding: 40px; position: relative; overflow: hidden; }
        
        .invoice-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('{{ asset('build/assets/images/watermark_page.png') }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 60%;
            opacity: 0.03;
            pointer-events: none;
            z-index: 0;
            transform: rotate(-15deg);
        }

        .invoice-container::after {
            content: 'MARINA DE BOUREGREG';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 4rem;
            font-weight: 100;
            color: rgba(0, 0, 0, 0.02);
            white-space: nowrap;
            pointer-events: none;
            z-index: 0;
            letter-spacing: 0.3em;
            font-family: 'Poppins', sans-serif;
        }

        .content { position: relative; z-index: 1; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; }
        .logo { height: 70px; }
        .customer-info { background-color: #000; color: white; padding: 8px 16px; font-weight: 600; font-size: 14px; }
        .invoice-title { color: #2563eb; font-size: 28px; font-weight: 500; margin-bottom: 30px; }
        .date-section { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 40px; margin-bottom: 30px; font-size: 14px; }
        .date-item .label { color: #df9842; font-weight: 600; margin-bottom: 5px; }
        .invoice-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 14px; }
        .invoice-table th { background-color: #f9fafb; padding: 12px 8px; text-align: left; font-weight: 600; }
        .invoice-table td { padding: 15px 8px; border-bottom: 1px solid #e5e7eb; }
        .invoice-table .text-center { text-align: center; }
        .invoice-table .text-right { text-align: right; }
        .totals-section { display: flex; justify-content: flex-end;  }
        .totals-table { width: 350px; font-size: 14px; }
        .totals-row { display: flex; justify-content: space-between; padding: 8px 0; }
        .totals-row.border-top { border-top: 1px solid #e5e7eb; }
        .totals-row.bold { font-weight: 600; }
        .summary-text { font-size: 14px; margin-bottom: 25px; }
        .summary-text .orange-amount { color: #df9842; font-weight: 600; }
        .details-section { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; }
        .reservation-details .detail-item { margin-bottom: 6px; }
        .reservation-details .label { color: #df9842; font-weight: 600; }
        .qr-code {margin-top:50px; width: 80px; height: 80px;}
        .footer { border-top: 2px solid #666; padding-top: 20px; text-align: center; font-size: 12px; color: #666; line-height: 1.6; }
        
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="content">
            <div class="header">
                <div><img src="{{ asset('build/assets/images/logo-marina-dark1.png') }}" alt="Logo" class="logo"></div>
                <div class="customer-info">{{ optional($facture->contrat?->demandeur)->nom ?? 'N/A' }}</div>
            </div>
            <h1 class="invoice-title">Facture {{ $facture->numero_facture }}</h1>
            <div class="date-section">
                <div class="date-item"><div class="label">Date de la facture :</div><div class="value">{{ \Carbon\Carbon::parse($facture->date_facture)->format('d/m/Y') }}</div></div>
                <div class="date-item"><div class="label">Date d'échéance :</div><div class="value">{{ \Carbon\Carbon::parse($facture->date_echeance)->format('d/m/Y') }}</div></div>
                <div class="date-item"><div class="label">Origine :</div><div class="value">{{ optional($facture->contrat)->id ?? 'N/A' }}</div></div>
            </div>
            <hr style="border-color: #eee; margin-bottom: 20px;">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th style="background:#faeded; border-radius:10px 0px 0px 10px;">Description</th>
                        <th style="background:#faeded;" class="text-center">Quantité</th>
                        <th style="background:#faeded;" class="text-center">Prix Unitaire</th>
                        <th style="background:#faeded; border-radius:0px 10px 10px 0px;" class="text-right">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($facture->items as $item)
                        <tr>
                            <td>{{ $item->description }}</td>
                            <td class="text-center">{{ number_format($item->quantite, 2, ',', ' ') }}</td>
                            <td class="text-center">{{ number_format($item->prix_unitaire, 2, ',', ' ') }} DH</td>
                            <td class="text-right">{{ number_format($item->montant_ht, 2, ',', ' ') }} DH</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="totals-section">
                <div class="totals-table">
                    <div class="totals-row bold"><span>Total HT</span><span>{{ number_format($facture->total_ht, 2, ',', ' ') }} DH</span></div>
                    <div class="totals-row border-top"><span>Taxe régionale 5%</span><span>{{ number_format($facture->taxe_regionale, 2, ',', ' ') }} DH</span></div>
                    <div class="totals-row border-top"><span>TVA 20%</span><span>{{ number_format($facture->total_tva, 2, ',', ' ') }} DH</span></div>
                    <div class="totals-row border-top bold" style="font-size: 16px;"><span>Total TTC</span><span>{{ number_format($facture->total_ttc, 2, ',', ' ') }} DH</span></div>
                    <div class="totals-row border-top bold"><span>Montant dû</span><span>0,00 DH</span></div>
                </div>
            </div>
            <div class="summary-text" style="clear: both; padding-top: 20px;">
                <p><strong>Arrêté la présente facture en toutes taxes comprises à la somme de :</strong> <span class="orange-amount">(montant en lettres)</span></p>
                <p style="margin-top: 15px;"><strong>Les éléments de référence du paiement de votre facture :</strong> {{ $facture->numero_facture }}</p>
            </div>
            <div class="details-section">
                <div class="reservation-details" style="width: 70%;">
                    <div class="detail-item"><span class="label"><span style="color:black;">•</span> N° réservation :</span> N/A</div>
                    <div class="detail-item"><span class="label"><span style="color:black;">•</span> Nom du Bateau :</span> {{ optional($facture->contrat?->navire)->nom ?? 'N/A' }}</div>
                    <div class="detail-item"><span class="label"><span style="color:black;">•</span> Immatriculation :</span> {{ optional($facture->contrat?->navire)->numero_immatriculation ?? 'N/A' }}</div>
                    <div class="detail-item"><span class="label"><span style="color:black;">•</span> Dimensions :</span> {{ optional($facture->contrat?->navire)->longueur ?? '0' }} m × {{ optional($facture->contrat?->navire)->largeur ?? '0' }} m</div>
                    <div class="detail-item"><span class="label"><span style="color:black;">•</span> Type Passage :</span> N/A</div>
                    <div class="detail-item"><span class="label"><span style="color:black;">•</span> Période :</span> Du {{ optional($facture->contrat)->date_debut ? \Carbon\Carbon::parse($facture->contrat->date_debut)->format('d/m/Y') : 'N/A' }} <span style="color: #df9842; font-weight: bold;">Au</span> {{ optional($facture->contrat)->date_fin ? \Carbon\Carbon::parse($facture->contrat->date_fin)->format('d/m/Y') : 'N/A' }}</div>
                </div>

                <div class="qr-code" style="width: 30%; text-align: right;">
                    @isset($qrCode)
                        {!! $qrCode !!}
                    @endisset
                </div>
            </div>
            <div class="footer">
                <div class="footer-line bold">Siège Social : La Marina de Bouregreg Avenue de Fès Quartier Rmel Bab Lamrissa, Salé</div>
                <div class="footer-line">Société Anonyme au Capital de 20 000 000,00 dhs | Patente n°25198370 | IF N°03380237 | RC N°25785 | ICE 000017097000004 Tel : 05 37 84 99 00 Fax : 05 37 78 58 58</div>
            </div>
        </div>
    </div>
</body>
</html>