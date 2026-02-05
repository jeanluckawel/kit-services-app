@extends('layoutsddd.app')

@section('title', 'Bon de dépense')

@section('content')

    <div class="d-flex justify-content-center my-5">
        <div id="expense-content" class="shadow p-5 bg-white"
             style="max-width: 21cm; min-height: 29.7cm; font-size: 14px; box-sizing: border-box;">


            <div class="row border-bottom pb-3 mb-4">
                <div class="col-md-4">
                    <h4 class="text-orange fw-bold">KIT SERVICE SARL</h4>
                    <p class="mb-1">1627 B Avenue Kamina, Q/ Mutoshi Kolwezi</p>
                    <p class="mb-1">LUALABA RDC</p>
                    <p class="mb-1">00243 977 333 977</p>
                    <p class="mb-1"><a href="mailto:kitservice17@gmail.com">kitservice17@gmail.com</a></p>
                    <p class="mb-1"><a href="http://www.kitservice.net">www.kitservice.net</a></p>
                </div>

                <div class="col-md-4">
                    <h4 class="fw-semibold">À : {{ $expense->user ?? 'System' }}</h4>
                    <p class="mb-1">Type dépense : {{ $expense->type->name ?? '' }}</p>
                    <p class="mb-1">Description : {{ $expense->description }}</p>
                </div>

                <div class="col-md-4 text-end">
                    <img src="{{ asset('logo/img.png') }}" alt="Kit Service Logo" class="img-fluid mb-2" style="max-height:100px;">
                    <h4 class="fw-bold text-dark">BON DE DÉPENSE</h4>
                    <p class="mb-1">Code : {{ $expense->code }}</p>
                    <p class="mb-1">Date : {{ \Carbon\Carbon::parse($expense->created_at)->format('j/n/Y') }}</p>
                    <p class="mb-1">Devise : {{ $expense->currency }}</p>
                </div>
            </div>

            <!-- DÉTAIL MONTANT -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                    <tr>
                        <th>N°</th>
                        <th>Description</th>
                        <th class="text-end">Montant ({{ $expense->currency }})</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $expense->description }}</td>
                        <td class="text-end">{{ number_format($expense->amount,2) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer / Bank -->
            <div class="mt-5">
                <h6 class="fw-semibold text-decoration-underline">Bank details</h6>
                <p>Nom de la banque : RAWBANK</p>
                <p>N° compte : 05100 - 05139 - 00703347001-87</p>
                <p>Intitulé du compte : KIT SERVICE SARL</p>
                <p>Swift code : RAWBCDRC</p>
            </div>

            <div class="mt-4 text-muted">
                <p>Merci pour votre attention !</p>
            </div>

        </div>
    </div>

    <!-- Boutons -->
    <div class="d-flex justify-content-center mt-4 gap-2">
        <a href="{{ route('expenses.history') }}">
            <button class="btn btn-danger btn-sm">Retour</button>
        </a>

        <button onclick="downloadPDF()" class="btn btn-dark btn-sm">Télécharger PDF</button>
    </div>

    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.min.js"></script>
    <script>
        function downloadPDF() {
            const element = document.getElementById('expense-content');
            const options = {
                filename: 'Bon_Depense_{{ $expense->code }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 3 },
                jsPDF: { unit: 'cm', format: 'a4', orientation: 'portrait' },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
            };
            html2pdf().set(options).from(element).save();
        }
    </script>

    <style>
        #expense-content {
            margin-left: auto;
            margin-right: auto;
        }
        #expense-content p,
        #expense-content td,
        #expense-content th,
        #expense-content h4,
        #expense-content h5,
        #expense-content h6 {
            font-size: 14px;
        }
        table {
            table-layout: auto;
            word-wrap: break-word;
        }
    </style>

@endsection
