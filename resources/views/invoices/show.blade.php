


@extends('layoutsddd.app')

@section('title', 'Facture')

@section('content')

    <div class="d-flex justify-content-center my-5">
        <div id="invoice-content" class="shadow p-5 bg-white"
             style="max-width: 21cm; min-height: 29.7cm; font-size: 14px; box-sizing: border-box;">

            <!-- HEADER -->
            <div class="row border-bottom pb-3 mb-4">
                <div class="col-md-4">
                    <h4 class="text-orange fw-bold">KIT SERVICE SARL</h4>
                    <p class="mb-1">1627 B Avenue Kamina, Q/ Mutoshi Kolwezi</p>
                    <p class="mb-1">LUALABA RDC</p>
                    <p class="mb-1">00243 977 333 977</p>
                    <p class="mb-1"><a href="mailto:kitservice17@gmail.com">kitservice17@gmail.com</a></p>
                    <p class="mb-1"><a href="http://www.kitservice.net">www.kitservice.net</a></p>
                    <p class="mb-1">ID NAT: 05-H5300-N876458R</p>
                    <p class="mb-1">RCCM: CD/LSH/RCCM/20-B-00584</p>
                </div>

                <div class="col-md-4">
                    <h4 class="fw-semibold">To : {{ $customer->name ?? '' }}</h4>
                    @if($customer && $customer->name === 'KAMOA COPPER SA')
                        <p class="mb-1">Appartements 3 et 4, Bâtiment 2404, 999, RN 39</p>
                    @endif
                    <p class="mb-1">{{ $customer->numero ?? '' }}, {{ $customer->avenue  ?? '' }}, {{ $customer->quartier  ?? '' }}</p>
                    <p class="mb-1">Commune de {{ $customer->commune ?? '' }}, Ville de {{ $customer->ville ?? '' }}</p>
                    <p class="mb-1">Province du {{ $customer->province ?? '' }}, RDC</p>
                    <p class="mb-1">ID NAT : {{ $customer->id_nat ?? '' }}</p>
                    <p class="mb-1">RCCM : {{ $customer->rccm ?? '' }}</p>
                    <p class="mb-1">NIF : {{ $customer->nif ?? '' }}</p>
                </div>

                <div class="col-md-4 text-end">
                    <img src="{{ asset('logo/img.png') }}" alt="Kit Service Logo" class="img-fluid mb-2" style="max-height:100px;">
                    <h4 class="fw-bold text-dark">INVOICE</h4>
                    <p class="mb-1">No. {{ $invoices->first()->numero_invoice ?? '' }}</p>
                    <p class="mb-1">Date: {{ \Carbon\Carbon::parse($invoices->first()->created_at ?? now())->format('j/n/Y') }}</p>
                    <p class="mb-1">Order No: {{ $invoices->first()->po ?? '' }}</p>
                </div>
            </div>

            <!-- TABLE DES LIGNES -->
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                    <tr>
                        <th>N°</th>
                        <th>Description</th>
                        <th class="text-center">Unité</th>
                        <th class="text-center">Quantité</th>
                        <th class="text-end">PU</th>
                        <th class="text-end">PT/Mois</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $total = 0; @endphp
                    @foreach($invoices as $key => $line)
                        @php $total += $line->pt_mois; @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $line->description }}</td>
                            <td class="text-center">{{ $line->unite }}</td>
                            <td class="text-center">{{ $line->quantity }}</td>
                            <td class="text-end">$ {{ number_format($line->pu, 2) }}</td>
                            <td class="text-end">$ {{ number_format($line->pt_mois, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totaux -->
            @php
                $tva = $total * 0.16;
                $totalTTC = $total + $tva;
            @endphp
            <div class="row justify-content-end mt-3">
                <div class="col-md-4">
                    <table class="table table-sm">
                        <tr>
                            <td class="text-end fw-semibold">SOUS-TOTAL :</td>
                            <td class="text-end">$ {{ number_format($total, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-end fw-semibold">TVA 16% :</td>
                            <td class="text-end">$ {{ number_format($tva, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-end fw-bold border-top">TOTAL TTC :</td>
                            <td class="text-end fw-bold border-top">$ {{ number_format($totalTTC, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Bank details -->
            <div class="mt-5">
                <h6 class="fw-semibold text-decoration-underline">Bank details</h6>
                <p>Nom de la banque : RAWBANK</p>
                <p>N° compte : 05100 - 05139 - 00703347001-87</p>
                <p>Intitulé du compte : KIT SERVICE SARL</p>
                <p>Swift code : RAWBCDRC</p>
            </div>

            <!-- Footer -->
            <div class="mt-4 text-muted">
                <p>Thank you for your business!</p>
                <p>For any inquiries, please contact us at <a href="mailto:kitservice17@gmail.com" class="text-decoration-underline">kitservice17@gmail.com</a></p>
            </div>

        </div>
    </div>

    <!-- Boutons -->
    <div class="d-flex justify-content-center mt-4 gap-2">
        <a href="{{ route('invoice.statement') }}">
            <button class="btn btn-danger btn-sm">Retour</button>
        </a>


        <button onclick="downloadPDF()" class="btn btn-dark btn-sm">Télécharger PDF</button>
    </div>

    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.min.js"></script>
    <script>
        function goBackSmooth() {
            if (document.referrer && document.referrer !== window.location.href) {
                window.location.replace(document.referrer);
            } else {
                history.back();
            }
        }

        function downloadPDF() {
            const element = document.getElementById('invoice-content');
            const options = {
                filename: 'Facture_KIT_SERVICE_{{ $customer->name ?? "client" }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 3 },
                jsPDF: { unit: 'cm', format: 'a4', orientation: 'portrait' },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
            };
            html2pdf().set(options).from(element).save();
        }
    </script>

    <style>
        #invoice-content {
            margin-left: auto;
            margin-right: auto;
        }
        #invoice-content p,
        #invoice-content td,
        #invoice-content th,
        #invoice-content h4,
        #invoice-content h5,
        #invoice-content h6 {
            font-size: 14px;
        }
        table {
            table-layout: auto;
            word-wrap: break-word;
        }
    </style>

@endsection

