<x-app-layout>
    <x-slot name="title">
        Uploads de {{ $user->name }} - Demande #{{ $demande->id }}
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <div class="mb-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                    Uploads de {{ $user->name }} {{ $user->prenom ?? '' }}
                </h2>
                <p class="text-gray-600 dark:text-gray-300 text-sm">
                    Demande : <strong>{{ $demande->titre }}</strong>
                    <span class="ml-2 inline-block bg-gray-200 dark:bg-gray-700 text-xs px-2 py-1 rounded text-gray-700 dark:text-gray-300">#{{ $demande->id }}</span>
                </p>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Liste des uploads</h3>

            @if($fichiers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-800 dark:text-gray-200">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="text-left py-2 px-4">Fichier</th>
                                <th class="text-left py-2 px-4">Type</th>
                                <th class="text-left py-2 px-4">Taille</th>
                                <th class="text-left py-2 px-4">Date</th>
                                <th class="text-left py-2 px-4">Téléchargement</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fichiers as $fichier)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-2 px-4">
                                        <strong>{{ $fichier->file_name }}</strong>
                                    </td>
                                    <td class="py-2 px-4">
                                        <span class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-0.5 text-xs rounded">
                                            {{ strtoupper(pathinfo($fichier->file_name, PATHINFO_EXTENSION)) }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4">
                                        {{ $fichier->file_size ? number_format($fichier->file_size / 1024, 2) . ' KB' : 'N/A' }}
                                    </td>
                                    <td class="py-2 px-4">
                                        {{ \Carbon\Carbon::parse($fichier->created_at)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="py-2 px-4">
                                        @if(Storage::disk('public')->exists($fichier->file_path))
                                            <a class="inline-flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-xs font-medium rounded-md hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors duration-200"  
                                                href="#" 
                                                onclick="downloadFile('{{ route('admin.download.file', ['demande' => $demande->id, 'user' => $user->id, 'fichier' => $fichier->id]) }}'); return false;">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Télécharger
                                            </a>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500 text-xs">Fichier manquant</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-6 text-gray-500 dark:text-gray-400">
                    <i class="fas fa-upload fa-2x mb-2"></i>
                    <p>Aucun fichier uploadé pour cette demande.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function downloadFile(url) {
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', '');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</x-app-layout>
