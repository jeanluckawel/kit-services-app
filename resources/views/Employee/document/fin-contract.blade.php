@extends('layoutsddd.app')

@section('title', 'Notification de fin de contrat')

@section('content')

    <div class="container my-4">

        <!-- ================= DOCUMENT ================= -->
        <div id="end-contract"
             class="bg-white shadow rounded mx-auto"
             style="padding:1.5cm; font-size:13px; width:21cm; height:29.7cm;">

            <style>
                /* Empêche coupure */
                #end-contract{
                    page-break-inside: avoid;
                    break-inside: avoid;
                    overflow: hidden;
                }

                /* Cache boutons dans PDF */
                .no-print{
                    display:none !important;
                }

                @media print{
                    body{
                        margin:0;
                        padding:0;
                    }
                }
            </style>

            <!-- HEADER -->
            <div class="row border-bottom pb-2 mb-4 align-items-center">
                <div class="col-8">
                    <h4 class="fw-bold text-warning mb-1">KIT SERVICE Sarl</h4>
                    <small class="text-muted">
                        Lualaba, Kolwezi, Avenue Kamina n°1627B, Commune de Manika <br>
                        Email : kitservice17@gmail.com
                    </small>
                </div>

                <div class="col-4 text-end">
                    <img src="{{ asset('logo/img.png') }}" height="70">
                </div>
            </div>

            <!-- EMPLOYEE INFO -->
            <p class="fw-bold mb-1">
                {{ $employee->first_name }} {{ $employee->last_name }} {{ $employee->middle_name }}
            </p>

            <p><strong>Employee ID :</strong> {{ $employee->employee_id ?? 'N/A' }}</p>

            <p>
                <strong>Adresse :</strong>
                {{ $employee->address1 ?? '' }}
                {{ $employee->address2 ?? '' }}
                {{ $employee->city ?? '' }}
            </p>

            <p><strong>Téléphone :</strong> {{ $employee->address->phone ?? 'N/A' }}</p>

            <!-- TITLE -->
            <h5 class="text-center fw-bold my-4 text-uppercase border-bottom pb-2">
                Notification de fin de contrat à durée déterminée
            </h5>

            @php
                if ($employee->gender === 'Male') $salutation = 'Cher';
                elseif ($employee->gender === 'Female') $salutation = 'Chère';
                else $salutation = 'Cher(e)';
            @endphp

                <!-- BODY -->
            <p>{{ $salutation }} {{ $employee->first_name }} {{ $employee->last_name }},</p>

            <p>
                Conformément au contrat de travail à durée déterminée signé le
                <strong>{{ \Carbon\Carbon::parse($employee->created_at)->translatedFormat('d F Y') }}</strong>,
                arrivé à échéance le
                <strong>{{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</strong>,
                nous vous notifions que votre contrat prendra fin à cette date,
                conformément au Code du Travail de la RDC.
            </p>

            <p>Nous vous remercions pour les services rendus au sein de <strong>KIT SERVICE Sarl</strong>.</p>

            <p>Nous vous invitons à contacter les Ressources Humaines pour les formalités de sortie et la remise des biens.</p>

            <p>En vous souhaitant plein succès dans vos projets futurs,</p>

            <p class="mb-5">
                Veuillez agréer, Madame/Monsieur, l’expression de nos salutations distinguées.
            </p>

            <!-- SIGNATURE -->
            <div class="text-end mb-5">
                <p class="fw-bold mb-0">Madame KUZO Nelly</p>
                <small>MANAGER Général</small>
            </div>

            <hr>

            <h6 class="text-center fw-bold mt-4">
                ACCUSÉ DE RÉCEPTION PAR LE TRAVAILLEUR
            </h6>

            <div class="form-check my-3">
                <input class="form-check-input" type="checkbox">
                <label class="form-check-label">
                    J’accuse réception de la présente lettre.
                </label>
            </div>

            <p>Le <strong>{{ now()->translatedFormat('d F Y') }}</strong></p>

            <p>
                Nom complet :
                <strong>
                    {{ $employee->first_name }}
                    {{ $employee->middle_name }}
                    {{ $employee->last_name }}
                </strong>
            </p>

            <p class="mt-4">Signature : ______________________________</p>

            <p class="fst-italic text-muted mt-3">
                Faire précéder la signature de la mention manuscrite « Pour réception ».
            </p>

        </div>
        <!-- ================= END DOCUMENT ================= -->

        <!-- BUTTONS -->
        <div class="mt-4 d-flex gap-2 justify-content-center no-print">
            <a href="{{ route('employee.list') }}" class="btn btn-danger btn-sm">
                Retour
            </a>

            <button onclick="downloadPDF()" class="btn btn-dark btn-sm">
                Télécharger PDF
            </button>
        </div>

    </div>

    <!-- PDF LIB -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        function downloadPDF(){

            const element = document.body;

            html2pdf().set({
                margin: 0,
                filename: "fin_contrat_{{ $employee->first_name }}.pdf",
                image: { type: "jpeg", quality: 0.98 },
                html2canvas: {
                    scale: 2,
                    windowWidth: document.body.scrollWidth
                },
                jsPDF: { unit: "cm", format: "a4", orientation: "portrait" },
                pagebreak: { mode: ['avoid-all'] }
            })
                .from(element)
                .save();
        }
    </script>

@endsection
