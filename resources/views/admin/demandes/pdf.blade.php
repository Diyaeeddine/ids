<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Détails de la demande #{{ $demande->id }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px;
            line-height: 1.4;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .section { 
            margin-bottom: 25px; 
        }
        .section-title { 
            font-size: 16px; 
            font-weight: bold; 
            margin-bottom: 15px;
            color: #333;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 15px;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left;
            vertical-align: top;
        }
        th { 
            background-color: #f8f9fa; 
            font-weight: bold;
        }
        .info-table td:first-child {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 30%;
        }
        .qr-section {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .qr-code {
            margin: 15px 0;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
            padding: 20px;
        }
        .uploads-link {
            display: inline-block;
            padding: 4px 8px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            font-size: 10px;
        }
        .uploads-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Détails de la demande #{{ $demande->id }}</h1>
    </div>

    <!-- Section Informations générales -->
    <div class="section">
        <div class="section-title">Informations générales</div>
        <table class="info-table">
            <tr>
                <td>Titre</td>
                <td>{{ $demande->titre }}</td>
            </tr>
            <tr>
                <td>Date de création</td>
                <td>
                    {{ $demande->created_at 
                        ? $demande->created_at->setTimezone(config('app.timezone'))->format('d/m/Y à H:i') 
                        : 'Non disponible' }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Section Utilisateurs affectés -->
    <div class="section">
        <div class="section-title">Utilisateurs affectés et durée de complétion</div>

        @if(count($usersDurations) === 0)
            <div class="no-data">
                Aucun utilisateur affecté
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Date affectation</th>
                        <th>Date fin tâche</th>
                        <th>Durée prise</th>
                        <th>Uploads</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usersDurations as $ud)
                        <tr>
                            <td>{{ $ud['user']->name }} {{ $ud['user']->prenom ?? '' }}</td>
                            <td>{{ $ud['assigned_at']->format('d/m/Y H:i') }}</td>
                            <td>{{ $ud['completed_at']->format('d/m/Y H:i') }}</td>
                            <td>{{ $ud['duration'] }}</td>
                            <td>
                                <a href="{{ route('admin.demande.user.uploads', ['demande' => $demande->id, 'user' => $ud['user']->id]) }}" 
                                   class="uploads-link" 
                                   target="_blank">
                                    Voir uploads
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Section QR Code -->
    <div class="qr-section">
        <div class="section-title">Suivez votre demande via ce QR code :</div>
        <div class="qr-code">
            <img src="data:image/png;base64,{{ $qrcode }}" alt="QR Code">
        </div>
        <p>Ce QR code permet à l'admin de suivre le temps de complétion de chaque user   sa partie du formulaire.</p>
    </div>
</body>
</html>
