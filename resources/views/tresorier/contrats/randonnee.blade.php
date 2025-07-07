<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Contrat d'usage de navire</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

  <style>
@font-face {
  font-family: 'Nunito';
  src: url('/fonts/Nunito-SemiBold.ttf') format('truetype');
  font-weight: 600;
  font-style: normal;
}

@font-face {
  font-family: 'Nunito';
  src: url('/fonts/Nunito-Bold.ttf') format('truetype');
  font-weight: 700; 
  font-style: normal;
}
@font-face {
  font-family: 'Nunito';
  src: url('/fonts/Nunito-Regular.ttf') format('truetype');
  font-weight: 300;
  font-style: normal;
} 
*{
      font-family: 'Nunito', sans-serif !important;

    }

    body {
      font-family: 'Nunito', sans-serif !important;

      font-weight: 600;
      margin: 0px 40px 30px 40px;
    }

     p {
      text-align: left;
    }
    #sous-titre{
      margin-left: 55px;
      padding: 0px;

    }
    .logo {
      text-align: center;
      margin-bottom: 10px;
    }
    .logo-reglements{
      text-align: center;
      margin: 5px;
      
    }
    .logo img, .logo-reglements img {
        width: 340px;
      height:70px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 15px;
    }
    #eng{
        font-weight:bold !important;
    }
    td, th {
      border: 1px solid #000;
      padding: 2px;
      vertical-align: top;
      font-size: 10px;
    }
    th{
      background: #eee;

    }
    .section-title {
      background: #eee;
      font-weight: bold;
      text-align: left;
    }
    .small {
      font-size: 11px;
      font-style: italic;
    }
    .checkbox {
      display: inline-block;
      width: 12px;
      height: 12px;
      border: 1px solid #000;
      margin-right: 5px;
    }

    .footer {
      color:rgb(35, 32, 96);
      font-size: 11px;
      text-align: center;
      margin-top: 70px;
      margin-bottom:10px;
    }
    
    table{
        margin: 0;
    }
    .no-border-table {
      border-collapse: collapse;
      width: 100%;
    }
    .no-border-td {
      border: none;
      padding: 8px;
    }
    .reglements-container {
            display: flex;
            width: 100%;
            background-color:  rgb(242, 242, 242);
            border: 1px solid #000;
          }

        .section {
            flex: 1;
            padding: 10px;
            border-right: 1px solid #333;
        }

        .section:last-child {
            border-right: none;
        }

        .big-title {
            font-size: 14px;
            font-weight: bolder;
            text-align: left;
            margin: 20px 0 0 0;
        }

        .para {
            font-weight: bold;
            margin-top: 15px;
            font-size: 8px;
        }

        .reglementsfr, .reglementseng {
            font-size: 8px;
            line-height: 1.4;
            text-align: justify;
        }

        .reglementsfr ul, .reglementseng ul {
            margin: 10px 0 15px 20px;
        }

        .contract-validity {
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
            font-size: 12px;
        }

    ul {
      list-style-position: inside;
      margin: 0;
      padding-left: 0;
    }

    ul li {
      padding-left: 0;
      margin-left: 0;
      text-indent: -1em;
    }
    em{
      font-weight:bold;
    }
.accept-para{
  font: 10px bold;

}
.spv{
  font-weight:bold;
  font-size: 8px;


}
  </style>
</head>
<body>
<div id="content">
<div class="logo">
  <img src="{{ asset('build/assets/images/logo-colorer.png') }}" alt="Marina Bouregreg">
</div>

<p>
  Contrat d’usage de navire à titre commercial N° 
  {{ $contrat->mouvements['num_titre_com'] ?? '__________' }}
  <br><span id="sous-titre">Commercial purposes ship contract</span>
</p>


<table>
  <tr><td colspan="4" class="section-title">Nom & Prénom du demandeur: {{ $contrat->demandeur->nom }}
    <br><span id="eng">First & last name of the person in charge</span></td></tr>
  <tr>
    <td colspan="2">N° CIN : (ou / or) : {{ $contrat->demandeur->cin_pass }}
        <br>
       <b>Passeport</b>
    </td>
    <td colspan="2">Numéro de téléphone mobile : {{ $contrat->demandeur->tel }}
        <br> <em>Mobile phone number</em></td>
  </tr>
  <tr>
    <td colspan="2">Adresse / Address : {{ $contrat->demandeur->adresse }}</td>
    <td >Email : {{ $contrat->demandeur->email }}</td>
  </tr>
</table>

<table>
  <tr><td colspan="6" class="section-title">Informations sur le propriétaire / <em>Ship’s owner informations</em></td></tr>
  <tr>
    <td colspan="3">Personne physique / <em>Physical person</em></td>
    <td colspan="3">Personne morale / <em>Corporation</em></td>
  </tr>
  <tr>
    <td colspan="2">Nom & Prénom du propriétaire :
        <br>First & last name of the owner
    </td>
    <th>Numéro de tel : <br>Phone number</th>
    <th>Nom de la société : <br>Corporation name</th>
    <td colspan="2">ICE : </td>
  </tr>
  <tr>
    <td colspan="2">{{ $contrat->proprietaire->nom }}</td>
    <td>{{ $contrat->proprietaire->tel }}</td>
    <td>{{ $contrat->proprietaire->nom_societe }}</td>
    <td>{{ $contrat->proprietaire->ice }}</td>
  </tr>
  <tr>
    <td>Nationalité : <br>Nationality</td>
    <td>N° CIN : (ou / or) <br> Passeport</td>
    <td>Validité jusqu’à : <br>Valid until</td>
    <td>Caution personnelle solidaire : <br>Solidarity personal guarantee</td>
    <td colspan="2">N° CIN : (ou / or) <br> Passeport</td>
  </tr>
  <tr>
    <td>{{ $contrat->proprietaire->nationalite }}</td>
    <td>{{ $contrat->proprietaire->cin_pass_phy }}</td>
    <td>{{ $contrat->proprietaire->validite_cin }}</td>
    <td>{{ $contrat->proprietaire->caution_solidaire }}</td>
    <td>{{ $contrat->proprietaire->cin_pass_mor }}</td>
  </tr>
</table>

<table style="border-collapse: collapse; width: 100%; text-align: center; font-family: Arial, sans-serif;">
    <tr>
      <td colspan="6" style="border: 1px solid #000; font-weight: bold; text-align: left;">
        Informations sur le navire / <em>Ship's informations</em>
      </td>
    </tr>
  
    <tr>
      <td rowspan="2">
        <strong>Nom :</strong><br><em>Name</em>
      </td>
      <td rowspan="2">
        <strong>Type :</strong><br><em>Type</em>
      </td>
      <td colspan="2">
        <strong>Immatriculation / <em>Registration</em></strong>
      </td>
      <td colspan="2" rowspan="2" >
        <strong>Pavillon :</strong><br><em>Flag</em>
      </td>
    </tr>

    <tr>
      <td>
        Port / <em>Harbor</em>
      </td>
      <td>
        Numéro / <em>Number</em>
      </td>
    </tr>
    <tr>
        
            <td>{{ $contrat->navire->nom }}</td>
            <td>{{ $contrat->navire->type }}</td>
            <td>{{ $contrat->navire->port }}</td>
            <td >{{ $contrat->navire->numero_immatriculation }}</td>
            <td colspan="2">{{ $contrat->navire->pavillon }}</td>
    </tr>
  

    <tr>
      <td >Longueur :<br><em>Length</em></td>
      <td >Largeur :<br><em>Width</em></td>
      <td >Tirant d’eau :<br><em>Draft</em></td>
      <td >Tirant d’air :<br><em>Air draft</em></td>
      <td >Jauge brute :<br><em>Gross tonnage</em></td>
      <td >Année de construction :<br><em>Year of construction</em></td>
    </tr>
    <tr>
      <td >{{ $contrat->navire->longueur }}</td>
      <td >{{ $contrat->navire->largeur }}</td>
      <td >{{ $contrat->navire->tirant_eau }}</td>
      <td >{{ $contrat->navire->tirant_air }}</td>
      <td >{{ $contrat->navire->jauge_brute }}</td>
      <td >{{ $contrat->navire->annee_construction }}</td>

    </tr>
  
    <tr>
      <td rowspan="2">Moteur<br><em>Engine</em></td>
      <td>Marque :<br><em>Mark</em></td>
      <td>Type :</td>
      <td colspan="2">Numéro de série :<br><em>Serial number</em></td>
      <td>Puissance :<br><em>Power</em></td>
    </tr>
    <tr>
      <td >{{ $contrat->navire->marque_moteur }}</td>
      <td >{{ $contrat->navire->type_moteur }}</td>
      <td colspan="2">{{ $contrat->navire->numero_serie_moteur }}</td>
      <td >{{ $contrat->navire->puissance_moteur }}</td>
    </tr>
  
    <tr>
      <td colspan="2" rowspan="3" style="text-align: left;">
        Mouvements par marée / <em>Movements per tide</em><br>
        Majoration des frais de stationnement /<br>
        <em>Increased docking fee</em> (*)
      </td>
      <td>1 seul mouvement</td>
      <td>2 mouvements</td>
      <td colspan="2">Mouvements pleine journée</td>
    </tr>
    <tr>
      <td>+25%</td>
      <td>+50%</td>
      <td colspan="2">+100%</td>
    </tr>
    <tr>
      <td>

          <input type="checkbox" 
                 {{ in_array($contrat->mouvements['majoration_stationnement'] ?? '___________', [25]) ? 'checked' : '' }}>
      </td>
      <td>
          <input type="checkbox" 
                 {{ in_array($contrat->mouvements['majoration_stationnement'] ?? '___________', [50]) ? 'checked' : '' }}>
      </td>
      <td colspan="2">
          <input type="checkbox" 
                 {{ in_array($contrat->mouvements['majoration_stationnement'] ?? '___________', [100]) ? 'checked' : '' }}>
      </td>
  </tr>
  
  </table>
  

<table>
  <tr>
    <td colspan="3">Nombre de personnes / <em>Number of persons</em> :</td>
    <td colspan="2">Période facturée / <em>Billing place and period</em> :</td>

  </tr>
  <tr>
    <td>Équipage / <em>Crew</em> :</td>
    <td>Passagers / <em>Passengers</em> :</td>
    <td>Total :</td>
    <td>Date Début / <em>Start Date</em> :</td>
    <td>Date Fin / <em>End Date</em> :</td>
  </tr>
  <tr>
    <td>{{$contrat->mouvements['equipage'] ?? '' }}</td>
    <td>{{$contrat->mouvements['passagers'] ?? ''}}</td>
    <td>{{$contrat->mouvements['total_personnes'] ?? ''}}</td>
    <td>{{$contrat->date_debut }}</td>
    <td>{{$contrat->date_fin}}</td>
  </tr>
  <tr>
    <td rowspan="2">Le marin / Gardien : <br> <em>Skipper / Watchman</em></td>
    <td colspan="4">Nom & Prénom : {{$contrat->gardien->nom}} <br> First & last name</td>
    
  </tr>
  <tr>
    {{-- <td colspan="2"></td> --}}
    <td colspan="2">N° de téléphone : {{$contrat->gardien->tel}}<br>Phone n°</td>
    <td colspan="2">CIN : {{$contrat->gardien->cin_pass}} <br> Passeport</td>
  </tr>
</table>

<p class="accept-para">
  <span class="checkbox"></span> J’accepte de me conformer aux clauses du présent contrat et aux règlements en vigueur relatifs à Bouregreg Marina<br>
  <span>&nbsp; &nbsp; &nbsp;</span> I agree to comply with the terms of this contract and the regulations in force relating to Bouregreg Marina
</p>

<table class="no-border-table">
  <tr class="no-border-tr">
    <td class="no-border-td">Signé par le propriétaire / demandeur :<br><em>Signed by the Owner / person in charge</em></td>
    <td class="no-border-td">Accepté par Bouregreg Marina<br><em>Accepted by Bouregreg Marina</em></td>
  </tr>
  <tr class="no-border-tr">
    <td class="no-border-td">À Salé / <em>At Salé</em> le : {{$contrat->date_signature}}</td>
    <td class="no-border-td">Le / <em>The</em> : {{$contrat->accepte_le}}</td>

  </tr>
  <tr class="no-border-tr">
    <td class="no-border-td">Par / <em>By</em> : {{$contrat->signe_par}}</td>
    <td class="no-border-td"></td>
  </tr>
</table>
  

<p class="small">(*) : Conformément au cahier des tarifs en vigueur / <em>In accordance with the tariff book in force</em></p>

<div class="footer" style="margin-bottom: 140px">
    Bouregreg Marina, siège social : Avenue de Fès Quartier Rmel Bab Lamrissa, Salé <br>
    Société Anonyme au capital de 20 000 000,00 dhs. ICE :1709000004 Patente N°25198370 <br>
    IF : N°03380237 - RC N°25785 à Salé, N° de compte :007 810 0001512000002340 79 Code Swift :BCMAMAMC <br>
    <a href="www.bouregregmarina.com" style="color: rgb(5, 99, 193);">www.bouregregmarina.com</a> Tél : 05 37 84 99 00 Fax : 05 37 78 58 58 - V04_20230105</div>


    <div class="logo-reglements">
      <img src="{{ asset('build/assets/images/logo-colorer.png') }}" alt="Marina Bouregreg">
    </div>
    <div class="reglements-container">
      <div class="section">
          <p class="big-title">REGLEMENTS ET CLAUSES</p>
          <p class="para">Référence réglementaire :</p>
          <div class="reglementsfr">
      <ul>
        <li>  La loi n° 15-02 relative aux ports et portant creation de l'Agence nationale
          des Ports et de la Societe d'exploitation des ports promulguee par le Dahir n°
          1-05146 du 20 chaoual 1426 (23 novembre 2005) telle qu'elle a été modifiée
          et completee par la loi 20-10 promulguee par le dahir n° 1-11-145 du 16
          ramadan 1432 (17 août 2011) ;</li>
        <li>la loi 71-18 sur la Police Portuaire promulguee par le Dahir n° 1-21-49 du 14
          Chaoual 1442 (26 Mai 2021). (Bulletin Officiel n° 6995 du 14 Juin 2021).</li>
        <li>
          La convention de concession de gestion du Port de Plaisance de Bouregreg
          signée en date du 13 mai 2008 entre l'Agence Nationale des Ports et la
          Société Bouregreg Marina ;</li>
        <li>Le Règlement d'Exploitation de Bouregreg Marina ;</li>
        <li>
          Le Cahier des Tarifs de Bouregreg Marina.</li>
      </ul>
      <p class="para">1. Clauses générales :</p>
      1.1 Consistance : autorisation pour l'usage du navire à titre commercial moyennant
      une redevance payée à l'avance pour la durée d'un an conformément au cahier
      des tarifs en vigueur entre le propriétaire du bateau objet du présent contrat
      (Usager) et la société Bouregreg Marina (BM) ;
      <br>
      1.2 Renouvellement du contrat : un preavis d'un mois pour l'abonnement annuel.
      Le renouvellement peut être objet de revision des clauses du contrat et sera
      basé éventuellement sur la nouvelle tarification en vigueur ;
      <br>
      1.3 Expiration du contrat : L'Usager est tenu de cesser toute activité commerciale
      de l'usage de son navire, a defaut BM aura le plein droit de prendre toutes les
      dispositions règlementaires qui s'imposent ;
      <br>

      1.4 Si le bateau quitte la BM, aucune indemnisation ou révision de la durée
      restante du contrat ne sera acceptée. Pendant l'absence du bateau pour une
      durée supérieur à 48h, BM pourra exploiter le poste du bateau. ;
      <p class="para"> 2. Obligations de l'Usager:</p>
      2.1 Se conformer aux règlements et lois en vigueur ou tel qu'ils seront modifiés,
      notamment ceux cités en Référence règlementaire, à défaut le présent contrat
      est résilié ;
      <br>

      2.2 Le présent contrat est réservé pour le bateau décrit dans le formulaire, appuyé
      avec la presentation des papiers originaux justifiants les dimensions et
      caractéristiques du bateau ;
      <br>
      2.3 Maintenir le bateau propre et en très bon état de navigabilité et de flottabilité ;
      <br>
      2.4 L'usage du bateau a but lucratif necessite la conclusion du cahier des charges
      avec le ministère chargé du transport ;
      <br>
      2.5 Demander l'autorisation d'entree ou de sortie du bassin de la Marina pour
      chaque mouvement, et rester en veille et contact permanent avec la
      Capitainerie.
      <br>
      2.6 Déposer une déclaration de sortie avec liste des membres à embarquer pour
      balade en mer/fleuve à la Capitainerie/Police avant de quitter le bassin ;
      <br>
      2.7 Ne pas naviguer dans le port entre le coucher et le lever du soleil ;
      <br>
      2.8 Embarquer le carburant, débarquer les déchets / eaux usées / huiles dans les
      endroits désignés à cet effet ;
      <br>
      2.9 Ne pas utiliser des produits de lavage pendant le nettoyage à flot du bateau à
      l'eau douce ;
      <br>
      2.10 Respecter les dispositions de sécurité et de protection de l'environnement,
      respecter les autres Usagers.
      <br>
      2.11 Sensibiliser les passagers sur les normes de sécurité et de protection de
      l'environnement avant chaque sortie en mer.
      <br>
      <p></p>
      <p>Le présent contrat n'est valable qu'après signature par <span class="spv"> BM</span></p>
      </div>
      </div>
      <div class="section"><p class="big-title">REGULATIONS AND CLAUSES</p>
      <p class="para">Regulatory reference:</p>
      <div class="reglementseng">
      <ul>
        <li>Law No. 15-02 relating to ports and establishing the National Ports Agency
          and the Ports Operating Company promulgated by Dahir No. 1-05146 of 20
          chaoual 1426 (23 November 2005) as it was modified and supplemented by
          Law 20-10 promulgated by Dahir No. 1-11-145 of Ramadan 16, 1432 (August
          17, 2011);</li>
        <li>Law 71-18 on Port Police promulgated by Dahir No. 1-21-49 of 14 Chaoual
          1442 (26 May 2021). (Official Bulletin n° 6995 of June 14, 2021);</li>
        <li>The Bouregreg Marina management concession agreement signed on May
          13, 2008 between the National Ports Agency and the Bouregreg Marina
          Company;</li>
        <li>The Bouregreg Marina Operating Regulation;</li>
        <li>The Bouregreg Marina tariffs Book.</li>
      </ul>
<br>
        <p class="para">1. General clauses:  </p>
      1.1 Consistency: authorization for the use of the ship on a commercial basis in
      return for a fee paid in advance for the duration of one year in accordance with
      the price schedule in force between the owner of the ship covered by this
      contract User) and the company Bouregreg Marina (BM) ;
      <br>

      1.2 Renewal of the contract: one month's notice for the annual subscription. The
      renewal may be subject to revision of the clauses of the contract and will
      possibly be based on the new pricing in force ;
      <br>
      1.3 Expiry of the contract: The User is required to cease all commercial activity in
      the use of his ship, failing which BM will have the full right to take all the
      necessary regulatory measures .;
      <br>
      1.4 If the boat leaves the BM, no compensation or revision of the remaining term
      of the contract will be accepted. During the boat's absence for more than 48
      hours, BM may operate the boat's berth.  

      <p class="para">2. Obligations of the User:</p>

      2.1 Comply with the regulations and laws in force or as they will be modified, in
      particular those cited in the Regulatory Reference, failing this contract is
      terminated;
      <br>

      2.2 This contract is reserved for the boat described in the form, supported by the
      presentation of the original paper justifying the ship's particular of the boat ;
      <br>
      2.3 Keep the boat clean and in very good seaworthy and buoyant condition ;
      <br>
      2.4 The use of the boat for profit is subject to the provision of specifications of the
      ministry responsible for transport;
      <br>
      2.5 Request authorization to enter or leave the Marina basin for each movement,
      and remain on standby and in permanent contact with the Harbor Master's
      Office.
      <br>
      2.6 Submit a declaration for each outing to the Harbor Master's Office/Police with
      a list of members on board;
      <br>

      2.7 Do not sail in the harbor between sunset and sunrise;

      <br>
      2.8 Load fuel, unload waste / wastewater / oil in places designated for this
      purpose;
      <br>
      2.9 Do not use washing products while cleaning the afloat boat with fresh water;
      <br>
      2.10 Comply with safety and environmental protection provisions, respect other
      Users.
      <br>
      2.11 Make passengers aware of safety and environmental protection standards
      before each sea trip.
      <br><br><br><br><br>
      <p>This contract is only valid being signed by <span class="spv">BM.</p>


      </div>


      </div>
    </div>
    <div class="footer">
      Bouregreg Marina, siège social : Avenue de Fès Quartier Rmel Bab Lamrissa, Salé <br>
      Société Anonyme au capital de 20 000 000,00 dhs. ICE :1709000004 Patente N°25198370 <br>
      IF : N°03380237 - RC N°25785 à Salé, N° de compte :007 810 0001512000002340 79 Code Swift :BCMAMAMC <br>
      <a href="www.bouregregmarina.com" style="color: rgb(5, 99, 193);">www.bouregregmarina.com</a> Tél : 05 37 84 99 00 Fax : 05 37 78 58 58 - V04_20230105</div>
  </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
      
    <script>
      window.onload = () => {
        const element = document.body;
          const opt = {
            margin:       0.15,
            filename:     'contrat_{{ $type }}_{{ $contrat->demandeur->nom }}_{{ \Carbon\Carbon::parse($contrat->date_signature)->format("Ymd") }}_ID{{ $contrat->id }}.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2},
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
          };
    
          html2pdf().set(opt).from(element).save().then(() => {
            window.close();
        });
      };
      fetch("{{ route('admin.contrats.marquerImprime', $contrat->id) }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        }
    }).then(response => response.json())
      .then(data => console.log("Réponse fetch :", data))
      .catch(error => console.error("Erreur fetch :", error));

    </script>
    
</body>
</html>
