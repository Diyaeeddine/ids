<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Détails de la Facture : {{ $facture->numero_facture }}
            </h2>
            
            <button id="download-pdf-btn" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <i class="fas fa-download mr-2"></i>
                Télécharger en PDF
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/50 border-l-4 border-green-500 text-green-700 dark:text-green-300 rounded-r-lg">
                    {{ session('status') }}
                </div>
            @endif

            <div id="invoiceToPrint">
                @include('plaisance.factures._invoice_template')
            </div>

        </div>
    </div>

    {{-- Script section for html2pdf.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const downloadButton = document.getElementById('download-pdf-btn');

            downloadButton.addEventListener('click', function() {
                const invoiceElement = document.getElementById('invoiceToPrint');
                const invoiceNumber = "{{ $facture->numero_facture }}";
                const cleanFilename = "Facture-" + invoiceNumber.replace(/\//g, '-');

                const options = {
                    margin: 0,
                    padding: 0,
                    filename:     cleanFilename + '.pdf',
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { 
                        scale: 3, 
                        useCORS: true 
                    },
                    jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
                };
                
                html2pdf().set(options).from(invoiceElement).save();
            });
        });
    </script>
</x-app-layout>