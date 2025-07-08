<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-file-contract text-primary-600 mr-3"></i>
            {{ __('Créer un contrat') }}   
        </h2>

    </x-slot>
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-RXf+QSDCUQs6FSqoD5GkHa***"
      crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div id="success-message" class="pr-6 hidden mb-6 p-4 bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-400 rounded-r-lg">
                        <i class="fas fa-check-circle mr-2"></i>
                        Contrat créé avec succès !
                    </div>
    
                    <form class="space-y-8" action="{{ route('contrat.store') }}" method="POST">
                        @csrf
                        <div class="border-l-4 pr-6 border-blue-500 pl-6 py-4 bg-blue-50/50 dark:bg-blue-900/20 rounded-r-lg">
{{-- 
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center space-x-2">
                            <i class="fa-solid fa-file-contract text-blue-500"></i>
                            <span>Type de de demande</span>
                        </h3><div>
                        <select name="type_form" id="type_form"
                            class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900/50 transition-all duration-200"
                            required onchange="typeContrat()">
                            <option value="0" selected>-- Selectionner le type de contrat --</option>
                            <option value="produit">Produit</option>
                            <option value="charge">Charge</option>     
                        </select> --}}
                        </div> 
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center space-x-2">
                            <i class="fa-solid fa-file-contract text-blue-500"></i>
                            <span>Type de contrat</span>
                        </h3><div>
                        <select name="type_contrat" id="type_contrat"
                            class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900/50 transition-all duration-200"
                            required onchange="typeContrat()">
                            <option value="0" selected>-- Selectionner le type de contrat --</option>
                            <option value="randonnee">Contrat Randonnee</option>
                            <option value="accostage">Contrat Accostage</option>
                        </select> 
                        </div>

                        <div class="randonnee-section mt-1 mb-1 hidden">
                            <label for="num_titre_com">N° titre commercial</label>
                            <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="num_titre_com" placeholder="N° titre commercial">
                        </div>
                        <div class="accostage-section mt-1 mb-1 hidden">
                            <label for="num_abonn">N° d'Abonnement à l'Accostage</label>
                            <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="num_abonn" placeholder="N° d'Abonnement à l'Accostage">
                        </div>
                        </div>
                        
                        <div class="border-l-4 pr-6 border-blue-500 pl-6 py-4 bg-blue-50/50 dark:bg-blue-900/20 rounded-r-lg">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                                <i class="fas fa-user text-blue-600 mr-3"></i>
                                Informations du Demandeur
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label for="nom_demandeur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom du demandeur</label>
                                        <input id="nom_demandeur" name="nom_demandeur" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Entrez le nom complet" />
                                    </div>
                                    <div>
                                        <label for="cin_pass_demandeur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CIN / Passport</label>
                                        <input id="cin_pass_demandeur" name="cin_pass_demandeur" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Numéro CIN" />
                                    </div>
                                    <div>
                                        <label for="tel_demandeur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Téléphone</label>
                                        <input id="tel_demandeur" name="tel_demandeur" type="tel" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="+212 6XX XXX XXX" />
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label for="adresse_demandeur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse</label>
                                        <input id="adresse_demandeur" name="adresse_demandeur" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Adresse complète" />
                                    </div>
                                    <div>
                                        <label for="email_demandeur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                                        <input id="email_demandeur" name="email_demandeur" type="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="exemple@email.com" />
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="border-l-4 border-green-500 pr-6 pl-6 py-4 bg-green-50/50 dark:bg-green-900/20 rounded-r-lg">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                                <i class="fas fa-building text-green-600 mr-3"></i>
                                Informations du Propriétaire
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div>
                                    <h2 class="text-center text-xl font-bold text-gray-700 dark:text-gray-300 mb-6">Propriétaire Physique</h2>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="nom_proprietaire" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom & Prénom du propriétaire</label>
                                            <input id="nom_proprietaire" name="nom_proprietaire" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Nom du propriétaire" />
                                        </div>
                                        <div>
                                            <label for="tel_proprietaire" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Numéro de téléphone</label>
                                            <input id="tel_proprietaire" name="tel_proprietaire" type="tel" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="+212 6XX XXX XXX" />
                                        </div>
                                        <div>
                                            <label for="nationalite_proprietaire" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nationalité</label>
                                            <input id="nationalite_proprietaire" name="nationalite_proprietaire" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Nationalité" />
                                        </div>
                                        <div>
                                            <label for="cin_pass_proprietaire_phy" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">N° CIN (ou Passeport)</label>
                                            <input id="cin_pass_proprietaire_phy" name="cin_pass_proprietaire_phy" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Numéro CIN" />
                                        </div>
                                        <div>
                                            <label for="validite_cin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Validité jusqu'à</label>
                                            <input id="validite_cin" name="validite_cin" type="date" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h2 class="text-center text-xl font-bold text-gray-700 dark:text-gray-300 mb-6">Propriétaire Morale</h2>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="nom_societe" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom de la société</label>
                                            <input id="nom_societe" name="nom_societe" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Nom de la société (si applicable)" />
                                        </div>
                                        <div>
                                            <label for="ice" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ICE</label>
                                            <input id="ice" name="ice" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Identifiant Commun de l'Entreprise" />
                                        </div>
                                        <div>
                                            <label for="caution_solidaire" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Caution personnelle solidaire</label>
                                            <input id="caution_solidaire" name="caution_solidaire" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Caution solidaire" />
                                        </div>
                                        <div>
                                            <label for="cin_pass_proprietaire_mor" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">N° CIN (ou Passeport)</label>
                                            <input id="cin_pass_proprietaire_mor" name="cin_pass_proprietaire_mor" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Numéro de passeport" />
                                        </div>
                                        <div>
                                            <label for="num_police" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">N° de Police</label>
                                            <input id="num_police" name="num_police" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Numéro de police" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accostage-section hidden mt-6 space-y-4">
                                <div>
                                    <label for="com_assurance" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Compagnie d'Assurance</label>
                                    <input id="com_assurance" name="com_assurance" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Compagnie d'Assurance" />
                                </div>
                                <div>
                                    <label for="num_police_assurance" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">N° de Police</label>
                                    <input id="num_police_assurance" name="num_police_assurance" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Numéro de police" />
                                </div>
                                <div>                   
                                    <label for="echeance" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Échéance</label>
                                    <input id="echeance" name="echeance" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Échéance" />
                                </div>
                            </div>
                        </div>
    
                        <div class="border-l-4 pr-6 border-purple-500 pl-6 py-4 bg-purple-50/50 dark:bg-purple-900/20 rounded-r-lg">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                                <i class="fas fa-ship text-purple-600 mr-3"></i>
                                Informations du Navire
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label for="nom_navire" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom du navire</label>
                                        <input id="nom_navire" name="nom_navire" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Nom du navire" />
                                    </div>
                                    <div>
                                        <label for="type_navire" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type de navire</label>
                                        <input id="type_navire" name="type_navire" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Type de navire" />
                                    </div>
                                    <div>
                                        <label for="pavillon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pavillon</label>
                                        <input id="pavillon" name="pavillon" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Pavillon" />
                                    </div>
                                    <div>
                                        <label for="longueur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Longueur (m)</label>
                                        <input id="longueur" name="longueur" type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Longueur en mètres" step="0.01" />
                                    </div>
                                    <div>
                                        <label for="largeur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Largeur (m)</label>
                                        <input id="largeur" name="largeur" type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Largeur en mètres" step="0.01" />
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label for="tirant_eau" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tirant d'eau (m)</label>
                                        <input id="tirant_eau" name="tirant_eau" type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Tirant d'eau" step="0.01" />
                                    </div>
                                    <div>
                                        <label for="tirant_air" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tirant d'air (m)</label>
                                        <input id="tirant_air" name="tirant_air" type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Tirant d'air" step="0.01" />
                                    </div>
                                    <div>
                                        <label for="jauge_brute" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jauge brute</label>
                                        <input id="jauge_brute" name="jauge_brute" type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Jauge brute" />
                                    </div>
                                    <div>
                                        <label for="annee_construction" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Année de construction</label>
                                        <input id="annee_construction" name="annee_construction" type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Année" min="1900" max="2024" />
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <h2 class="text-center text-xl font-bold text-gray-700 dark:text-gray-300 mb-6">Immatriculation</h2>
                                    </div>
                                    <div>
                                        <label for="port" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Port</label>
                                        <input id="port" name="port" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Port d'attache" />
                                    </div>
                                    <div>
                                        <label for="numero_immatriculation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Numéro d'immatriculation</label>
                                        <input id="numero_immatriculation" name="numero_immatriculation" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Numéro d'immatriculation" />
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="border-l-4 pr-6 border-orange-500 pl-6 py-4 bg-orange-50/50 dark:bg-orange-900/20 rounded-r-lg">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                                <i class="fas fa-cog text-orange-600 mr-3"></i>
                                Informations du Moteur
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="marque_moteur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Marque moteur</label>
                                    <input id="marque_moteur" name="marque_moteur" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Marque du moteur" />
                                </div>
                                <div>
                                    <label for="type_moteur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type moteur</label>
                                    <input id="type_moteur" name="type_moteur" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Type de moteur" />
                                </div>
                                <div>
                                    <label for="numero_serie_moteur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Numéro de série moteur</label>
                                    <input id="numero_serie_moteur" name="numero_serie_moteur" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Numéro de série" />
                                </div>
                                <div>
                                    <label for="puissance_moteur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Puissance moteur (CV)</label>
                                    <input id="puissance_moteur" name="puissance_moteur" type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Puissance en CV" />
                                </div>
                            </div>
                        </div>
    
                        <div class="accostage-section hidden pr-6 border-l-4 border-slate-600 dark:border-slate-400 pl-6 py-4 bg-slate-50/50 dark:bg-slate-800/50 rounded-r-lg">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                                <i class="fa-solid fa-check-double text-slate-600 dark:text-slate-400 mr-3"></i>
                                Autres prestations
                            </h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full border border-gray-300 dark:border-gray-600 text-center">
                                    <thead>
                                        <tr class="bg-gray-100 dark:bg-gray-700 text-sm">
                                            <th rowspan="2" class="border border-gray-300 dark:border-gray-600 px-4 py-2 w-1/3"> 
                                                <span class="text-xs italic text-gray-600 dark:text-gray-400">Autres prestations :</span><br/>    
                                            </th>
                                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-800 dark:text-gray-200">Guidage</th>
                                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-800 dark:text-gray-200">Gardiennage</th>
                                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-800 dark:text-gray-200">Eau</th>
                                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-800 dark:text-gray-200">Electricité</th>
                                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-800 dark:text-gray-200">Douche</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 font-medium text-left text-gray-800 dark:text-gray-200">Choisir une option :</td>
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                                <input type="checkbox" name="autres_prestations[]" value="Guidage" class="w-6 h-6 text-blue-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2" checked />
                                            </td>
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                                <input type="checkbox" name="autres_prestations[]" value="Gardiennage" class="w-6 h-6 text-blue-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2" />
                                            </td>
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                                <input type="checkbox" name="autres_prestations[]" value="Eau" class="w-6 h-6 text-blue-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2" />
                                            </td>
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                                <input type="checkbox" name="autres_prestations[]" value="Electricité" class="w-6 h-6 text-blue-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2" />
                                            </td>
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                                <input type="checkbox" name="autres_prestations[]" value="Douche" class="w-6 h-6 text-blue-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="randonnee-section hidden pr-6 border-l-4 border-teal-500 dark:border-teal-400 pl-6 py-4 bg-teal-50/50 dark:bg-teal-900/20 rounded-r-lg">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                                <i class="fas fa-route text-teal-600 dark:text-teal-400 mr-3"></i>
                                Mouvements et Tarification
                            </h3>

                            <div class="overflow-x-auto">
                                <table class="min-w-full border border-gray-300 dark:border-gray-600 text-center">
                                    <thead>
                                        <tr class="bg-gray-100 dark:bg-gray-700 text-sm">
                                            <th rowspan="2" class="border border-gray-300 dark:border-gray-600 px-4 py-2 w-1/3 text-gray-800 dark:text-gray-200">
                                                Mouvements par marée<br/>
                                                <span class="text-xs italic text-gray-600 dark:text-gray-400">Movements per tide</span><br/><br/>
                                                Majoration des frais de stationnement<br/>
                                                <span class="text-xs italic text-gray-600 dark:text-gray-400">Increased docking fee (*)</span>
                                            </th>
                                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-800 dark:text-gray-200">1 seul mouvement</th>
                                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-800 dark:text-gray-200">2 mouvements</th>
                                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-800 dark:text-gray-200">Mouvements pleine journée</th>
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-gray-600 text-sm">
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-800 dark:text-gray-200">+25%</td>
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-800 dark:text-gray-200">+50%</td>
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-800 dark:text-gray-200">+100%</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 font-medium text-left text-gray-800 dark:text-gray-200">Choisir une option :</td>
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                                <input type="radio" name="majoration_stationnement" value="25" class="w-6 h-6 text-blue-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2" checked />
                                            </td>
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                                <input type="radio" name="majoration_stationnement" value="50" class="w-6 h-6 text-blue-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2" />
                                            </td>
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                                <input type="radio" name="majoration_stationnement" value="100" class="w-6 h-6 text-blue-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="accostage-section hidden pr-6 border-l-4 border-red-500 dark:border-red-400 pl-6 py-4 bg-red-50/50 dark:bg-red-900/20 rounded-r-lg">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                                <i class="fa-solid fa-location-dot text-red-600 dark:text-red-400 mr-3"></i>
                                Emplacement
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="ponton" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Ponton</label>
                                    <input id="ponton" name="ponton" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Ponton" />
                                </div>
                                <div>
                                    <label for="num_poste" class="block font-medium text-sm text-gray-700 dark:text-gray-300">N° Poste</label>
                                    <input id="num_poste" name="num_poste" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="N° Poste" />
                                </div>
                            </div>
                        </div>

                        <div class="randonnee-section hidden pr-6 border-l-4 border-red-500 dark:border-red-400 pl-6 py-4 bg-red-50/50 dark:bg-red-900/20 rounded-r-lg">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                                <i class="fas fa-users text-red-600 dark:text-red-400 mr-3"></i>
                                Équipage et Passagers
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="equipage" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Équipage</label>
                                    <input id="equipage" name="equipage" type="number" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Nombre d'équipiers" min="0" />
                                </div>
                                <div>
                                    <label for="passagers" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Passagers</label>
                                    <input id="passagers" name="passagers" type="number" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Nombre de passagers" min="0" />
                                </div>
                                <div>
                                    <label for="total_personnes" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Total personnes</label>
                                    <input id="total_personnes" name="total_personnes" type="number" class="mt-1 block w-full bg-gray-50 dark:bg-gray-800 border-gray-300 dark:border-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Total automatique" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="border-l-4 pr-6 border-indigo-500 dark:border-indigo-400 pl-6 py-4 bg-indigo-50/50 dark:bg-indigo-900/20 rounded-r-lg">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                                <i class="fas fa-calendar-alt text-indigo-600 dark:text-indigo-400 mr-3"></i>
                                Période facturé
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="date_debut" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Date de début</label>
                                    <input id="date_debut" name="date_debut" type="date" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                                </div>
                                <div>
                                    <label for="date_fin" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Date de fin</label>
                                    <input id="date_fin" name="date_fin" type="date" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                                </div>
                            </div>
                        </div>

                        <div class="border-l-4 pr-6 border-yellow-500 dark:border-yellow-400 pl-6 py-4 bg-yellow-50/50 dark:bg-yellow-900/20 rounded-r-lg">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                                <i class="fas fa-shield-alt text-yellow-600 dark:text-yellow-400 mr-3"></i>
                                Informations du Gardien
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <div>
                                        <label for="nom_gardien" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nom & Prénom</label>
                                        <input id="nom_gardien" name="nom_gardien" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Nom complet du gardien" />
                                    </div>
                                    <div>
                                        <label for="num_tele_gardien" class="block font-medium text-sm text-gray-700 dark:text-gray-300">N° de téléphone</label>
                                        <input id="num_tele_gardien" name="num_tele_gardien" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="N° de téléphone" />
                                    </div>

                                </div>
                                <div class="space-y-1">
                                    <div>
                                        <label for="cin_pass_gardien" class="block font-medium text-sm text-gray-700 dark:text-gray-300">CIN / Passport</label>
                                        <input id="cin_pass_gardien" name="cin_pass_gardien" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Numéro CIN / Passport" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-l-4 border-pink-500 dark:border-pink-400 pl-6 py-4 bg-pink-50/50 dark:bg-pink-900/20 rounded-r-lg">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                                <i class="fas fa-pen-fancy text-pink-600 dark:text-pink-400 mr-3"></i>
                                Validation et Signature
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Signé par</label>
                                        <select name="signe_par" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-lg focus:border-blue-500 dark:focus:border-blue-400 focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900 transition-all duration-200">
                                            <option value="">Sélectionnez le signataire</option>
                                            <option value="demandeur">M. Admin</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Date de signature</label>
                                        <input type="date" name="date_signature" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-lg focus:border-blue-500 dark:focus:border-blue-400 focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900 transition-all duration-200">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" pr-6 border-l-4 border-green-600 dark:border-green-400 pl-6 py-4 bg-green-50/50 dark:bg-green-900/20 rounded-r-lg">
                            <div class="space-y-4">
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                                    <i class="fa-solid fa-check text-green-600 dark:text-green-400 mr-3"></i>
                                    Acceptation
                                </h3>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Accepté le</label>
                            <input type="date" name="accepte_le" placeholder="Date d'acceptation" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-lg focus:border-blue-500 dark:focus:border-blue-400 focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900 transition-all duration-200">    
                        </div>         
                      </div>
                        <div class="mt-8 flex justify-end space-x-4">
                            
                            <a href="{{route('plaisance.contrats')}}" type="button" class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-200">
                                <i class="fas fa-times mr-2"></i>
                                Annuler
                            </a>
                            <button type="submit" disabled class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed" id="btnsubmit">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Créer le contrat
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

    <script>
        function typeContrat() {
        const contratType = document.getElementById("type_contrat").value;
        const accostageSections = document.querySelectorAll(".accostage-section");
        const randonneeSections = document.querySelectorAll(".randonnee-section");
        const btnsubmit = document.getElementById('btnsubmit');

        const hideSection = (sections) => {
        sections.forEach(section => {
        section.classList.add('hidden');
        section.querySelectorAll("input, select, textarea").forEach(field => {
        field.disabled = true;
        });
        });
        };

        const showSection = (sections) => {
        sections.forEach(section => {
        section.classList.remove('hidden');
        section.querySelectorAll("input, select, textarea").forEach(field => {
        field.disabled = false;
        });
        });
        };

        hideSection(accostageSections);
        hideSection(randonneeSections);
        btnsubmit.disabled = true;

        if (contratType === "accostage") {
        showSection(accostageSections);
        btnsubmit.disabled = false;
        } else if (contratType === "randonnee") {
        showSection(randonneeSections);
        btnsubmit.disabled = false;
        }
        }

        document.addEventListener('DOMContentLoaded', function() {
        const equipageInput = document.querySelector('input[name="equipage"]');
        const passagersInput = document.querySelector('input[name="passagers"]');
        const totalInput = document.querySelector('input[name="total_personnes"]');

        function updateTotal() {
        const equipage = parseInt(equipageInput.value) || 0;
        const passagers = parseInt(passagersInput.value) || 0;
        totalInput.value = equipage + passagers;
        }

        if (equipageInput && passagersInput && totalInput) {
        equipageInput.addEventListener('input', updateTotal);
        passagersInput.addEventListener('input', updateTotal);
        }
        });
    </script>
</x-app-layout>