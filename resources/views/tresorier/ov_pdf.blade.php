<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ordre de Virement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 20px;
            line-height: 1.3;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            height: 60px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            font-size: 12px;
        }
        .header div {
            margin-bottom: 2px;
        }
        .section-title {
            background-color: #000;
            color: white;
            text-align: center;
            font-weight: bold;
            padding: 8px;
            font-size: 13px;
            margin-bottom: 0;
        }
        .section {
            border: 2px solid #000;
            border-top: none;
            padding: 15px;
            margin-bottom: 3px;
            min-height: 50px;
        }
        .ordre-section {
            min-height: 70px;
        }
        .beneficiaire-section {
            min-height: 80px;
        }
        .objet-section {
            min-height: 120px;
        }
        .flex-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .montant-line {
            margin-top: 20px;
            font-size: 12px;
        }
        .amount {
            font-size: 16px;
            font-weight: bold;
            margin-top: 8px;
        }
        .signature {
            text-align: center;
            margin-top: 60px;
            font-size: 12px;
            font-weight: bold;
        }
        .beneficiaire-line {
            margin-bottom: 8px;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ public_path('build/assets/images/marina-logo-black.png') }}" alt="Logo Marina">
    </div>

    <div class="header">
        <div>Le Directeur Général Délégué</div>
        <div>de la Société BOUREGREG MARINA</div>
        <div>Au</div>
    </div>

    <div class="section-title">Ordre de Virement</div>
    <div class="section ordre-section">
        <div class="flex-row">
            <div>Par le débit de notre compte n°</div>
            <div>Rabat, le {{ \Carbon\Carbon::parse($ordre->date_virement)->format('d/m/Y') }}</div>
        </div>
        <div class="montant-line">
            Veuillez virer la somme de
            <div class="amount">{{ number_format($ordre->montant, 2, ',', ' ') }} DH</div>
        </div>
    </div>

    <div class="section-title">Bénéficiaire</div>
    <div class="section beneficiaire-section">
        <div class="beneficiaire-line">Au profit de : {{ $ordre->beneficiaire_nom }}</div>
        <div class="beneficiaire-line">Titulaire du RIB : {{ $ordre->beneficiaire_rib }}</div>
        <div class="beneficiaire-line">Banque : {{ $ordre->beneficiaire_banque }}</div>
        <div class="beneficiaire-line">Agence : {{ $ordre->beneficiaire_agence }}</div>
    </div>

    <div class="section-title">Objet</div>
    <div class="section objet-section">
        {{ $ordre->objet }}
    </div>

    <div class="signature">
        Directeur Général Délégué
    </div>

    <div class="footer">
        <div>Bouregreg Marina SA, site Avenue de Fès Quartier Rmel, Bab Lamrissa Salé</div>
        <div>ICE N° 000018256041- Patente n°28726211 I.F N°03380237 RC 25766</div>
        <div>Tél.: 0537 84 99 00/ Fax : 0537 78 58 58</div>
    </div>
</body>
</html>