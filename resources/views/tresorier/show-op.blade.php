<style>
    *{
        /* padding: 0; */
        /* margin: 0; */
        
        
    }
    body{
       
    }
</style>
<x-app-layout>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-file-invoice-dollar"></i>
                        Détails de l'Ordre de Paiement
                    </h3>
                    <!-- Button Group aligned to right -->
<div class="flex justify-end space-x-3 pt-4">
    <!-- Générer PDF Button -->
    <button type="button"
        onclick="generatePDF()"
        class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow transition duration-200">
        Générer PDF
        <i class="fas fa-file-pdf"></i>
    </button>

    <!-- Retour Button -->
    <a href="{{ route('tresorier.op') }}"
        class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow transition duration-200">
        Retour
        <i class="fas fa-arrow-left"></i>
    </a>
</div>

                </div>
                
                <div class="card-body" id="op-content">
                    <!-- EXACT BOUREGREG PAYMENT ORDER FORM -->
                    <div class="bouregreg-form">
                        <style>
                            .bouregreg-form {
                                max-width: 650px;
                                margin: 0 auto;
                                background-color: white;
                                padding: 0;
                                /* border: 1px solid #000; */
                                font-family: Arial, sans-serif;
                            }

                            .logo {
  text-align: center;
}
.logo img {
  height: 80px;
}


                            
                            /* .bouregreg-logo-wave {
                                position: absolute;
                                top: 10px;
                                right: 20px;
                                width: 80px;
                                height: 15px;
                                background: linear-gradient(45deg, #4A90E2, #87CEEB);
                                border-radius: 20px;
                            } */

                            .bouregreg-title-bar {
                                color: black;
                                text-align: center;
                                padding: 5px;
                                font-weight: bold;
                                font-size: 16px;
                                margin: 0;
                            }
                            .p-black {
                                color: white;
                                background-color: #000;
                                width: 50%;
                                text-align: center;
                                margin: 0 auto; 
                                border-radius:2px;
                            }

                            .bouregreg-subtitle {
                                text-align: center;
                                padding: 8px;
                                font-size: 11px;
                                color: #333;
                                background-color: #f9f9f9;
                                border-bottom: 1px solid #000;
                            }

                            .bouregreg-section-header {
                                background-color: #000;
                                color: white;
                                text-align: center;
                                padding: 8px;
                                font-weight: bold;
                                font-size: 14px;
                                margin: 0;
                            }

                            .bouregreg-table {
                                width: 100%;
                                border-collapse: collapse;
                                font-size: 11px;
                            }

                            .bouregreg-table td {
                                border: 1px solid #000;
                                border-bottom: none;
                                padding: 5px 8px;
                                vertical-align: top;
                            }

                            .bouregreg-label-cell {
                                background-color: #f8f8f8;
                                font-weight: bold;
                                white-space: nowrap;
                            }

                            .bouregreg-input-cell {
                                background-color: white;
                            }

                            .bouregreg-ordonnancement-table td {
                                height: 25px;
                            }

                            .bouregreg-description-row td {
                                height: 50px;
                            }

                            .bouregreg-amount-row td {
                                height: 30px;
                            }

                            .bouregreg-payment-table td {
                                height: 25px;
                            }

                            .bouregreg-observations-row td {
                                height: 70px;
                            }

                            .bouregreg-accounting-header {
                                text-align: center;
                                font-weight: bold;
                                font-size: 10px;
                                background-color: #f8f8f8;
                                padding: 3px;
                            }

                            .bouregreg-accounting-row td {
                                height: 50px;
                            }

                            .bouregreg-signature-section {
                                height: 120px;
                                text-align: center;
                                vertical-align: middle;
                                font-weight: bold;
                            }

                            .bouregreg-footer {
                                text-align: center;
                                font-size: 9px;
                                color: #666;
                                padding: 15px;
                                line-height: 1.4;
                                /* border-top: 1px solid #ccc; */
                                background-color: #f9f9f9;
                            }

                            .bouregreg-w-20 { width: 20%; }
                            .bouregreg-w-25 { width: 25%; }
                            .bouregreg-w-30 { width: 30%; }
                            .bouregreg-w-15 { width: 15%; }
                            .bouregreg-w-35 { width: 35%; }
                        </style>

                        <div class="logo flex justify-center items-center">
                            <img src="{{ asset('build/assets/images/marina-logo-black.png') }}" alt="logo" class="h-20">
                        </div>

                        <div class="bouregreg-title-bar">
                           <p class="p-black">ORDRE DE PAIEMENT</p>
                          <p> N° {{ $order->reference }}</p>
                        </div>

                        <div class="bouregreg-subtitle">
                            Monsieur le Directeur Général Délégué est prié de procéder au paiement ci-dessous :
                        </div>

                        <div class="bouregreg-section-header">ORDONNANCEMENT</div>
                        <table class="bouregreg-table bouregreg-ordonnancement-table">
                            <tr>
                                <td class="bouregreg-label-cell bouregreg-w-25">Entité ordonnance :</td>
                                <td class="bouregreg-input-cell bouregreg-w-25">{{ $order->entite_ordonnatrice }}</td>
                                <td class="bouregreg-label-cell bouregreg-w-20">Marché/BC n° :</td>
                                <td class="bouregreg-input-cell bouregreg-w-30">{{ $order->marche_bc ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="bouregreg-label-cell">Fournisseur/Prestataire :</td>
                                <td class="bouregreg-input-cell">{{ $order->fournisseur ?? '' }}</td>
                                <td class="bouregreg-label-cell">Période de facturation :</td>
                                <td class="bouregreg-input-cell">{{ $order->periode_facturation ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="bouregreg-input-cell" colspan="2"></td>
                                <td class="bouregreg-label-cell">Date de la facture :</td>
                                <td class="bouregreg-input-cell">{{ $order->facture ? \Carbon\Carbon::parse($order->facture->date_facture)->format('d/m/Y') : '' }}</td>
                            </tr>
                            <tr class="bouregreg-description-row">
                                <td class="bouregreg-label-cell">Description de l'opération :</td>
                                <td class="bouregreg-input-cell" colspan="2">{{ $order->description_operation }}</td>
                                <td class="bouregreg-label-cell">Pièces justificatives jointes :</td>
                            </tr>
                            <tr class="bouregreg-description-row">
                                <td class="bouregreg-input-cell" colspan="3"></td>
                                <td class="bouregreg-input-cell">{{ $order->pieces_justificatives ?? '' }}</td>
                            </tr>
                            <tr class="bouregreg-amount-row">
                                <td class="bouregreg-label-cell">Montant de l'opération :</td>
                                <td class="bouregreg-label-cell">En chiffres</td>
                                <td class="bouregreg-input-cell">{{ number_format($order->montant_chiffres, 2) }} DH</td>
                                <td class="bouregreg-input-cell"></td>
                            </tr>
                            <tr class="bouregreg-amount-row">
                                <td class="bouregreg-input-cell"></td>
                                <td class="bouregreg-label-cell">En lettres</td>
                                <td class="bouregreg-input-cell" colspan="2">{{ $order->montant_lettres ?? '' }}</td>
                            </tr>
                        </table>

                        <!-- MISE EN PAIEMENT Section -->
                        <div class="bouregreg-section-header">MISE EN PAIEMENT</div>
                        <table class="bouregreg-table bouregreg-payment-table">
                            <tr>
                                <td class="bouregreg-label-cell bouregreg-w-25">Date de mise en paiement :</td>
                                <td class="bouregreg-input-cell bouregreg-w-25">{{ $order->date_mise_paiement ? \Carbon\Carbon::parse($order->date_mise_paiement)->format('d/m/Y') : '' }}</td>
                                <td class="bouregreg-label-cell bouregreg-w-20">Mode de paiement :</td>
                                <td class="bouregreg-input-cell bouregreg-w-30">{{ $order->mode_paiement }}</td>
                            </tr>
                            <tr>
                                <td class="bouregreg-input-cell" colspan="2"></td>
                                <td class="bouregreg-label-cell">Référence</td>
                                <td class="bouregreg-input-cell">{{ $order->reference }}</td>
                            </tr>
                            <tr class="bouregreg-observations-row">
                                <td class="bouregreg-label-cell">Observations :</td>
                                <td class="bouregreg-input-cell" colspan="2">{{ $order->observations ?? '' }}</td>
                                <td class="bouregreg-label-cell">Visa et contrôle :</td>
                            </tr>
                            <tr class="bouregreg-observations-row">
                                <td class="bouregreg-input-cell" colspan="3"></td>
                                <td class="bouregreg-input-cell">{{ $order->visa_controle ?? '' }}</td>
                            </tr>
                        </table>

                        <!-- COMPTABILISATION Section -->
                        <div class="bouregreg-section-header">COMPTABILISATION</div>
                        <table class="bouregreg-table">
                            <tr>
                                <td class="bouregreg-label-cell bouregreg-w-25">Imputation comptable :</td>
                                <td class="bouregreg-accounting-header bouregreg-w-15">Métier</td>
                                <td class="bouregreg-accounting-header bouregreg-w-20">Section<br>analytique</td>
                                <td class="bouregreg-accounting-header bouregreg-w-15">Produit</td>
                                <td class="bouregreg-accounting-header bouregreg-w-25">Extension<br>Analytique</td>
                            </tr>
                            <tr class="bouregreg-accounting-row">
                                <td class="bouregreg-input-cell">{{ $order->imputation_comptable ?? '' }}</td>
                                <td class="bouregreg-input-cell">{{ $order->metier ?? '' }}</td>
                                <td class="bouregreg-input-cell">{{ $order->section_analytique ?? '' }}</td>
                                <td class="bouregreg-input-cell">{{ $order->produit ?? '' }}</td>
                                <td class="bouregreg-input-cell">{{ $order->extension_analytique ?? '' }}</td>
                            </tr>
                        </table>

                        <!-- Signature Section -->
                        <div class="bouregreg-section-header">Directeur Général Délégué</div>
                        <table class="bouregreg-table">
                            <tr>
                                <td class="bouregreg-signature-section"></td>
                            </tr>
                        </table>

                        <!-- Footer -->
                        <div class="bouregreg-footer">
                            Bouregreg Marina SA, sis Avenue de Fès Quartier Rmîl, Bab Lamrissa Salé<br>
                            ICE N° 000117000004 - Patente n°28726711-IF N°03360237 RC 26785<br>
                            Tél : 0537 84 99 00 Fax : 0537 78 96 58
                        </div>
                    </div>
                    <!-- END EXACT BOUREGREG PAYMENT ORDER FORM -->

                    <!-- Original Laravel Details Section (Hidden for PDF) -->
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour la génération PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function generatePDF() {
    // Hide the original details section and show only the Bouregreg form
    const originalDetails = document.querySelector('.original-details');
    const bouregreg = document.querySelector('.bouregreg-form');
    
    if (originalDetails) originalDetails.style.display = 'none';
    
    const element = document.getElementById('op-content');
    const opt = {
        margin: 0.5,
        filename: 'ordre_paiement_{{ $order->reference }}.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
    };

    // Masquer les boutons d'action pendant la génération
    const buttons = document.querySelector('.btn-group');
    buttons.style.display = 'none';

    html2pdf().set(opt).from(element).save().then(function() {
        // Remettre les boutons après génération
        buttons.style.display = 'block';
        // Show the original details section again
        if (originalDetails) originalDetails.style.display = 'block';
    });
}
</script>
</x-app-layout>