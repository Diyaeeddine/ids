<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Contrat d'usage de navire</title>
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
  font-weight: 700; /* Use proper weight for bold */
  font-style: normal;
}
@font-face {
  font-family: 'Nunito';
  src: url('/fonts/Nunito-Regular.ttf') format('truetype');
  font-weight: 300; /* Use proper weight for bold */
  font-style: normal;
} 
@page {
      size: A4;
      margin: 1cm;
    }

    *{
      
      font-family: 'Nunito', sans-serif !important;

    }

    body {
      font-family: 'Nunito', sans-serif !important;
      font-weight: 600;
      margin: 0px 40px 0px 40px;
    }

     p {
      text-align: left;
      margin-left: 50px;

    }
    #sous-titre{
      margin-left: 55px;
      padding: 0px;

    }
    .logo {
      text-align: center;
      margin-bottom: 10px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 15px;
    }
    #eng{
        font-weight:bold !important;
    }
    .logo-reglements{
      text-align: center;
      margin: 5px;
      
    }
    .logo img {
        width: 340px;
      height:70px;
    }
    .logo-reglements img{
      /* width: 200px;
      height: auto; */
      width: 240px;
      height:auto;
    }
    th {
      border: 1px solid #000;
      padding: 2px 0px;
      vertical-align: center;
      font-size: 10px;
    }
    td{
      border: 1px solid #000;
      padding: 0px 0px 0px 5px;
      vertical-align: center;
      font-size: 10px;

    }
    th{
      background: #eee;
      font-weight: 600;
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
      margin-top: 30px;
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
            margin: 10px 0 0 0;
        }

        .para {
            font-weight: bold;
            margin: 15px 0px 8px 0px !important;
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
  font-weight:bold !important;
  font-size: 8px !important;
  text-align: start !important;


}
.keep-first-page {
  page-break-after: always;
  min-height: calc(100vh - 2cm);
  display: flex;
  flex-direction: column;
}

.keep-first-page .footer {
  margin-top: auto;
}
a{
  text-decoration: none;
}
.reglements-container {
  page-break-inside: avoid;
}

.footer:last-of-type {
  margin-top: auto;
  page-break-inside: avoid;
}
  </style>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script> --}}

</head>
<body>
  <div class="keep-first-page">
      <div class="logo">
        <img src=" {{ asset('build/assets/images/logo-colorer.png') }}" alt="Marina Bouregreg">
      </div>

      <p>Contrat d'usage de navire à titre commercial N° {{$contrat->mouvements['num_abonn']}}
          <br><span id="sous-titre">Commercial purposes ship contract</span>
      </p>

      <table>
        <tr><td colspan="4" style="padding:1px 0px 1px 5px;">Nom & Prénom du demandeur: {{ $contrat->demandeur->nom }}
          <br><span id="eng">First & last name of the person in charge</span></td></tr>
        <tr>
          <td colspan="2" style="padding:1px 0px 1px 5px;">N° CIN : (ou / or) : {{ $contrat->demandeur->cin_pass }}
              <br>
            <b>Passeport</b>
          </td>
          <td colspan="2" style="padding:1px 0px 1px 5px;">Numéro de téléphone mobile : {{ $contrat->demandeur->tel }}
              <br> <em>Mobile phone number</em></td>
        </tr>
        <tr>
          <td colspan="2" style="padding:1px 0px 1px 5px;">Adresse / Address : {{ $contrat->demandeur->adresse }}</td>
          <td style="padding:1px 0px 1px 5px;">Email : {{ $contrat->demandeur->email }}</td>
        </tr> 
      </table>

      <table>
        <tr><th colspan="6" class="section-title" style="padding:1px 0px 1px 5px;">Informations sur le propriétaire / <em>Ship’s owner informations</em></th></tr>
        <tr>
          <th colspan="3">Personne physique / <em>Physical person</em></th>
          <th colspan="3">Personne morale / <em>Corporation</em></th>
        </tr>
        <tr>
          <th colspan="2">Nom & Prénom du propriétaire :
              <br>First & last name of the owner
          </th>
          <th>Numéro de tel : <br><em>Phone number</em></th>
          <th>Nom de la société : <br><em>Corporation name</em></th>
          <th colspan="2"><em>ICE :</em></th>
        </tr>
        <tr>
          <td colspan="2">{{ $contrat->proprietaire->nom }}</td>
          <td>{{ $contrat->proprietaire->tel }}</td>
          <td>{{ $contrat->proprietaire->nom_societe }}</td>
          <td>{{ $contrat->proprietaire->ice }}</td>
        </tr>

        <tr>
          <th>Nationalité : <br>Nationality</th>
          <th>N° CIN : (ou / or) <br> Passeport</th>
          <th>Validité jusqu’à : <br>Valid until</th>
          <th>Caution personnelle solidaire : <br>Solidarity personal guarantee</th>
          <th colspan="2">N° CIN : (ou / or) <br> Passeport</th>
        </tr>
        <tr>
          <td>{{ $contrat->proprietaire->nationalite }}</td>
          <td>{{ $contrat->proprietaire->cin_pass_phy }}</td>
          <td>{{ $contrat->proprietaire->validite_cin }}</td>
          <td>{{ $contrat->proprietaire->caution_solidaire }}</td>
          <td>{{ $contrat->proprietaire->cin_pass_mor }}</td>
        </tr>
        <tr>
          <th colspan="3">Compagnie d'Assurance / Insurance Company :</th>
          <th>N° de Police / Policy N° :</th>
          <th>Échéance / Deadline :</th>
        </tr>
        <tr>
          <td colspan="3">{{$contrat->mouvements['com_assurance']}}</td>
          <td>{{$contrat->mouvements['num_police']}}</td>
          <td>{{$contrat->mouvements['echeance']}}</td>
        </tr>
      </table>

      <table style="border-collapse: collapse; width: 100%; text-align: center;">
          <!-- Titre -->
          <tr>
            <th colspan="7" style="border: 1px solid #000; font-weight: bold; text-align: left; padding:1px 0px 1px 5px;">
              Informations sur le navire / <em>Ship's informations</em>
            </th>
          </tr>
        
          <tr>
            <th rowspan="2">
              Nom :<br><em>Name</em>
            </th>
            <th rowspan="2">
            Type :<br><em>Type</em>
            </th>
            <th colspan="2">
            Immatriculation / <em>Registration</em>
            </th>
            <th colspan="3" rowspan="2" >
            Pavillon :<br><em>Flag</em>
            </th>
          </tr>

          <tr>
            <th>
              Port / <em>Harbor</em>
            </th>
            <th>
              Numéro / <em>Number</em>
            </th>
          </tr>
          <tr>
              
                  <td>{{ $contrat->navire->nom }}</td>
                  <td>{{ $contrat->navire->type }}</td>
                  <td>{{ $contrat->navire->port }}</td>
                  <td >{{ $contrat->navire->numero_immatriculation }}</td>
                  <td colspan="3">{{ $contrat->navire->pavillon }}</td>
          </tr>
        

          <tr>
            <th >Longueur :<br><em>Length</em></th>
            <th >Largeur :<br><em>Width</em></th>
            <th >Tirant d’eau :<br><em>Draft</em></th>
            <th >Tirant d’air :<br><em>Air draft</em></th>
            <th >Jauge brute :<br><em>Gross tonnage</em></th>
            <th colspan="2">Année de construction :<br><em>Year of construction</em></th>
          </tr>
          <tr>
            <td >{{ $contrat->navire->longueur }}</td>
            <td >{{ $contrat->navire->largeur }}</td>
            <td >{{ $contrat->navire->tirant_eau }}</td>
            <td >{{ $contrat->navire->tirant_air }}</td>
            <td >{{ $contrat->navire->jauge_brute }}</td>
            <td colspan="2">{{ $contrat->navire->annee_construction }}</td>

          </tr>
        
          <!-- Moteur -->
          <tr>
            <th rowspan="2">Moteur<br><em>Engine</em></th>
            <th>Marque :<br><em>Mark</em></th>
            <th>Type : <br> <em>Type</em></th>
            <th colspan="2">Numéro de série :<br><em>Serial number</em></th>
            <th colspan="2">Puissance :<br><em>Power</em></th>
          </tr>
          <tr>
            <td >{{ $contrat->navire->marque_moteur }}</td>
            <td >{{ $contrat->navire->type_moteur }}</td>
            <td colspan="2">{{ $contrat->navire->numero_serie_moteur }}</td>
            <td colspan="2">{{ $contrat->navire->puissance_moteur }}</td>
          </tr>
        
          <!-- Mouvements -->
          <tr>
              <th colspan="2" rowspan="3" style="text-align: left;">
                Autres prestations : <br><em> Other services <br>(*) </em>
              </th>
              <th>Guidage <br><em> Guidance</em></th>
              <th>Gardiennage <br><em> Boatcare</em></th>
              <th>Eau <br><em> Water</em></th>
              <th>Electricité <br><em> Electricity</em></th>
              <th>Douche <br><em> Shower </em></th>
            </tr>

            @php
            $prestations = $contrat->mouvements['autres_prestations'] ?? [];
          @endphp
            <tr>
              <td><input type="checkbox" name="autres_prestations[]" value="Guidage" {{ in_array('Guidage', $prestations) ? 'checked' : '' }}></td>
              <td><input type="checkbox" name="autres_prestations[]" value="Gardiennage" {{ in_array('Gardiennage', $prestations) ? 'checked' : '' }}></td>
              <td><input type="checkbox" name="autres_prestations[]" value="Eau" {{ in_array('Eau', $prestations) ? 'checked' : '' }}></td>
              <td><input type="checkbox" name="autres_prestations[]" value="Electricité" {{ in_array('Electricité', $prestations) ? 'checked' : '' }}></td>
              <td><input type="checkbox" name="autres_prestations[]" value="Douche" {{ in_array('Douche', $prestations) ? 'checked' : '' }}></td>
            </tr>
        
        </table>
        

      <table>
        <tr>
          <th colspan="5" class="text-center">Emplacement et période facturé / <em>Billing place and period :</em></th>

        </tr>
        <tr>
          <th colspan="2">Ponton / <em> Pontoon :</em></th>
          <th>N° Poste / <em> Dock n° :</em></th>
          <th>Date Début / <em>Start Date :</em></th>
          <th>Date Fin / <em>End Date</em> :</th>
        </tr>
        <tr>
      <td colspan="2" style="padding:1px 0px 1px 5px;">{{ $contrat->mouvements['ponton'] }}</td>
      <td style="padding:1px 0px 1px 5px;">{{ $contrat->mouvements['num_poste'] }}</td>
      <td style="padding:1px 0px 1px 5px;">{{ $contrat->date_debut }}</td>
      <td style="padding:1px 0px 1px 5px;">{{ $contrat->date_fin }}</td>
        </tr>
        <tr>
          <th rowspan="2" style="text-align: left; vertical-align:center; padding:1px 0px 1px 5px;" >Le marin / Gardien / <em>Skipper / Watchman</em></th>
          <td colspan="4" style="padding:1px 0px 1px 5px;">Nom & Prénom : {{$contrat->gardien->nom}} <br> <em> First & last name</em></td>
          
        </tr>
        <tr>
          <td colspan="2" style="padding:1px 0px 1px 5px;">N° de téléphone : {{$contrat->gardien->tel}}<br><em>Phone n°</em></td>
          <td colspan="2" style="padding:1px 0px 1px 5px;">CIN : {{$contrat->gardien->cin_pass}} <br> <em>Passeport</em></td>
        </tr>
      </table>

      <p style="font-size: 12px">
        <span class="checkbox" style="vertical-align: bottom;"></span>J'accepte de me conformer aux clauses du présent contrat et aux règlements en vigueur relatifs à Bouregreg Marina<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I agree to comply with the terms of this contract and the regulations in force relating to Bouregreg Marina </span>
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
        

      <p class="small" style="text-align: center;">(*) : Conformément au cahier des tarifs en vigueur / <em>In accordance with the tariff book in force</em></p>

      <div class="footer" style="margin-bottom: 50px">
          Bouregreg Marina, siège social : Avenue de Fès Quartier Rmel Bab Lamrissa, Salé <br>
          Société Anonyme au capital de 20 000 000,00 dhs. ICE :1709000004 Patente N°25198370 <br>
          IF : N°03380237 - RC N°25785 à Salé, N° de compte :007 810 0001512000002340 79 Code Swift :BCMAMAMC <br>
          <a href="www.bouregregmarina.com" style="color: rgb(5, 99, 193);">www.bouregregmarina.com</a> Tél : 05 37 84 99 00 Fax : 05 37 78 58 58 - V04_20230105</div>
      </div>
    </div>
    <div class="logo-reglements" style="margin-bottom:0px;">
  
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
      1-05146&nbsp;du 20 chaoual 1426 (23 novembre 2005) telle qu'elle a été modifiée
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
  1.2 Renouvellement du contrat : un préavis d’un mois pour l’abonnement annuel
  ou semestriel, une semaine pour l’abonnement mensuel ou forfaitaire , 48h
  pour l’abonnement journalier. Le renouvellement peut être objet de révision
  des clauses du contrat et sera basé éventuellement sur la nouvelle
  tarification en vigueur ;
  <br>
  1.3 Expiration du contrat : L’Usager est tenu d’évacuer son bateau hors de BM
  avant l’expiration du contrat, à défaut BM aura le plein droit de prendre toutes
  les dispositions règlementaires qui s’imposent ;
  <br>

  1.4 Si le bateau quitte la BM, aucune indemnisation ou révision de la durée
  restante du contrat ne sera acceptée. Pendant l’absence du bateau pour une
  durée supérieur à 48h, BM pourra exploiter le poste du bateau. Si l’Usager
  compte faire retourner son bateau à BM il doit aviser la Capitainerie en avance
  d’un préavis de 24h pour récupérer son poste, à défaut un autre poste
  provisoire lui sera affecté ;
  <br>

  1.5 Le changement de poste peut être accordé moyennant le paiement d’une
  somme de 2000dh ;
  <p class="para"> 2. Obligations de l'Usager:</p>
  2.1 Se conformer aux règlements et lois en vigueur ou tel qu’ils seront modifiés,
  notamment ceux cités en Référence règlementaire, à défaut le présent contrat
  est résilié ;
  <br>

  2.2 Le présent contrat est réservé pour le bateau décrit dans le formulaire, appuyé
  avec la présentation des papiers originaux justifiants les dimensions et
  caractéristiques du bateau ;
  <br>
  2.3 Maintenir le bateau propre et en très bon état de navigabilité et de flottabilité ;
  <br>
  2.4 L’usage du bateau à but lucratif est soumis à la disposition d’un contrat
  d’exploitation spécifique avec BM et au cahier des charges du ministère chargé
  du transport ;
  <br>
  2.5 Designer un gardien pour assurer la surveillance du bateau, ce gardien doit être
  en mesure d’effectuer toutes les manoeuvres et opérations de sécurité
  nécessaires pour répondre aux injonctions des agents en charge de la police
  portuaire conformément à la règlementation en vigueur. En cas d’absence du
  gardien, BM peut intervenir dans le bateau, le déplacer aux frais, risque et péril
  de l’Usager ;
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
  l’eau douce ;
  <br>
  2.10 Respecter les dispositions de sécurité et de protection de l’environnement,
  respecter les autres Usagers.
  <br>

  <p class="para"> 3. Services rendus par BM :</p>

  3.1 Un poste d’accostage adapté au bateau objet du présent contrat ;
  <br>
  3.2 Service de guidage du bateau suivant la disponibilité du moyen nautique de
  guidage, aucune responsabilité n’est engagée par BM en cas d’erreur de
  manoeuvre du bateau ;
  <br>
  3.3 Des douches, blocs sanitaires, bacs d’ordure ;
  <br>
  3.4 Branchement eau électricité pour les bateaux sous conditions et tarifications
  spécifiques.
  <br>
  <p style="margin-left:0px;">Le présent contrat n’est valable qu’après paiement à l’avance par l’<span class="spv">Usager</span> des
    redevances relatives à la période de facturation souhaitée, et signature par<span class="spv"> BM</span></p>
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

    <p class="para">1. General clauses:  </p>
  1.1 Consistency: Consistency: rental of a berth for a fee paid in advance in accordance with the
  tariffs e schedule in force between the owner of the boat covered by this
  contract (<span class="spv">User</span>) and the company Bouregreg Marina (<span class="spv">BM</span> ) ;
  <br>

  1.2 Renewal of the contract: one month's notice for the annual or semi-annual
  subscription, one week for the monthly or flat-rate subscription, 48 hours for
  the daily subscription. The renewal may be subject to revision of the clauses of
  the contract and will possibly be based on the new pricing in force ;
  <br>
  1.3 Expiry of the contract: The User is required to evacuate his boat from BM
  before the expiry of the contract, failing which BM will be allowed to take all
  the necessary regulatory measures;
  <br>
  1.4 If the boat leaves the BM, no compensation or revision of the remaining term
  of the contract will be accepted. During the boat's absence for more than 48
  hours, BM may operate the boat's berth. If the User intends to return his boat
  to BM, he must notify the Harbor Master's Office in advance of a 24-hour
  notice to recover his berth, failing which another temporary berth will be
  assigned to him;
  <br>
  1.5 The change of position can be granted for a fee of 2000dh.
  <br>
  <br>
  <p class="para">2. Obligations of the User:</p>

  2.1 Comply with the regulations and laws in force or as they will be modified, in
  particular those cited in the Regulatory Reference, failing this contract is
  terminated;
  <br>

  2.2 This contract is reserved for the boat described in the form, supported by the
  presentation of the original paper justifying the ship’s particular of the boat ;
  <br>
  2.3 Keep the boat clean and in very good seaworthy and buoyant condition ;
  <br>
  2.4 The use of the boat for profit is subject to the provision of a specific operating
  contract with BM and to the specifications of the ministry responsible for
  transport;
  <br>
  2.5 Designate a guard to ensure the surveillance of the boat, this guard must be
  able to carry out all the maneuvers and security operations necessary to
  respond to the orders of the agents in charge of the port police in accordance
  with the regulations in force. In the event of the guardian's absence, BM may
  intervene in the boat, move it at the cost, risk and peril of the User;
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
<br><br><br><br><br>
<p class="para">3. Services provided by BM:</p>
3.1 A berth adapted to the boat covered by this contract;
<br>
3.2 Guidance of the boat according to the availability of the nautical means of
guidance, no responsibility is engaged by BM in case of error of maneuver of
the boat;
<br>
3.3 Showers, toilet blocks, garbage bin;
<br>
3.4 Water and electricity connection for boats under specific conditions and tariffs.
<br><br>
  <p style="margin-left:0px;">This contract is only valid after payment in advance by the <span class="spv">User</span> of the fees relating to
    the desired billing period, and signed by <span class="spv">BM.</span></p>
  </div>

  </div>
</div>
  <div class="footer" style="margin-top: 10px; margin-bottom:0px;">
    Bouregreg Marina, siège social : Avenue de Fès Quartier Rmel Bab Lamrissa, Salé<br>
  Société Anonyme au capital de 20 000 000,00 dhs. ICE :1709000004 Patente N°25198370 <br>
  IF : N°03380237 - RC N°25785 à Salé, N° de compte :007 810 0001512000002340 79 Code Swift :BCMAMAMC <br>
  <a href="www.bouregregmarina.com" style="color: rgb(5, 99, 193);">www.bouregregmarina.com</a> Tél : 05 37 84 99 00 Fax : 05 37 78 58 58 - V04_20230105</div>
  </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
 window.onload = () => {
        const element = document.body;
        const opt = {
            margin: 0.3,
            filename: 'contrat_{{ $type }}_{{ $contrat->demandeur->nom }}_{{ \Carbon\Carbon::parse($contrat->date_signature)->format("Ymd") }}_ID{{ $contrat->id }}.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
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
