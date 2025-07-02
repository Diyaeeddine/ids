<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails de la Facture : {{ $facture->numero_facture }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    {{-- Success Message --}}
                    @if (session('status'))
                        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-bold text-gray-800">Facture #{{ $facture->numero_facture }}</h3>
                        {{-- THIS IS THE NEW DOWNLOAD BUTTON --}}
                        <a href="{{ route('factures.downloadPDF', $facture) }}" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700">
                            <i class="fas fa-download mr-2"></i>
                            Télécharger en PDF
                        </a>
                    </div>

                    <div class="mt-6 border-t pt-6">
                        <p><span class="font-bold">Date de Facture:</span> {{ \Carbon\Carbon::parse($facture->date_facture)->format('d/m/Y') }}</p>
                        <p><span class="font-bold">Client:</span> {{ $facture->contrat->demandeur->nom }}</p>
                        <p><span class="font-bold">Bateau:</span> {{ $facture->contrat->navire->nom }}</p>
                        <h4 class="font-bold mt-4">Détails:</h4>
                        <ul class="list-disc pl-5">
                            @foreach($facture->items as $item)
                                <li>{{ $item->description }} - {{ $item->quantite }} x {{ $item->prix_unitaire }} DH</li>
                            @endforeach
                        </ul>
                        <p class="font-bold text-xl mt-4 text-right">Total TTC: {{ $facture->total_ttc }} DH</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>