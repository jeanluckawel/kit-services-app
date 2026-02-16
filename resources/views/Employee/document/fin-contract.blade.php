@php use Carbon\Carbon; @endphp
@extends('layoutsddd.app')

@section('title', 'Notification de fin de contrat | Kit Service')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

@section('content')

    <style>
        body{
            background:#f8f9fa;
        }

        .doc-wrapper{
            display:flex;
            justify-content:center;
            padding:20px;
            min-height:100vh;
        }

        #end-contract{
            width:21cm;
            min-height:29.7cm;
            background:#fff;
            padding:1.5cm;
            font-size:13px;
            box-shadow:0 0.5rem 1rem rgba(0,0,0,.1);
            color:#333;
            page-break-inside:avoid;
        }

        .btn-pdf{
            background:#FF6600;
            color:#fff;
            border:none;
            padding:6px 12px;
            border-radius:4px;
            font-size:14px;
            cursor:pointer;
        }
        .btn-pdf:hover{ background:#e65c00; }

        /* TELEPHONE SUR UNE SEULE LIGNE */
        .nowrap{
            white-space:nowrap;
            word-break:keep-all;
        }

        @media print{
            body{ margin:0; padding:0; }
            .no-print{ display:none!important; }
        }
    </style>

    <!-- ================= BUTTONS ================= -->
    <div class="mb-3 text-end no-print" style="max-width:21cm;margin:auto;">
        <button id="viewPdfBtn" class="btn-pdf">
            <i class="bi bi-eye"></i> Voir PDF
        </button>

        <button id="downloadPdfBtn" class="btn-pdf ms-2">
            <i class="bi bi-download"></i> Télécharger PDF
        </button>
    </div>

    <!-- ================= DOCUMENT ================= -->
    <div class="doc-wrapper">
        <div id="end-contract">

            <!-- HEADER -->
            <div class="row border-bottom pb-2 mb-4 align-items-center">
                <div class="col-8">
                    <h4 class="fw-bold mb-1" style="color: orangered">KIT SERVICE Sarl</h4>
                    <small class="text-muted">
                        Lualaba, Kolwezi, Avenue Kamina n°1627B<br>
                        Email : kitservice17@gmail.com
                    </small>
                </div>
                <div class="col-4 text-end">
                    <img src="{{ asset('logo/img.png') }}" height="70" alt="logo kit services">
                </div>
            </div>

            <!-- EMPLOYEE INFO -->
            <p class="fw-bold mb-1">
                {{ $employee->first_name }}
                {{ $employee->middle_name }}
                {{ $employee->last_name }}
            </p>

            <p><strong>Matricule :</strong> {{ $employee->employee_id }}</p>

            <p>
                <strong>Adresse :</strong>
                {{ $employee->address1 ?? '' }}
                {{ $employee->address2 ?? '' }}
                {{ $employee->city ?? '' }}
            </p>

            <!-- TELEPHONE (UNE LIGNE) -->
            <p class="nowrap">
                <strong>Téléphone :</strong>
                {{ $employee->address->phone ?? 'N/A' }}
            </p>

            <!-- TITLE -->
            <h5 class="text-center fw-bold my-4 text-uppercase border-bottom pb-2">
                Notification de fin de contrat à durée déterminée
            </h5>

            @php
                $salutation = $employee->gender === 'Male' ? 'Cher' :
                              ($employee->gender === 'Female' ? 'Chère' : 'Cher(e)');
            @endphp

                <!-- BODY -->
            <p>{{ $salutation }} {{ $employee->first_name }} {{ $employee->last_name }},</p>

            <p>
                Conformément au contrat de travail à durée déterminée signé le
                <strong>{{ Carbon::parse($employee->created_at)->translatedFormat('d F Y') }}</strong>,
                arrivé à échéance le
                <strong>{{ Carbon::parse($endDate)->translatedFormat('d F Y') }}</strong>,
                nous vous notifions que votre contrat prendra fin à cette date,
                conformément au Code du Travail de la RDC.
            </p>

            <p>
                Nous vous remercions pour les services rendus au sein de
                <strong>KIT SERVICE Sarl</strong>.
            </p>

            <p>
                Nous vous invitons à contacter les Ressources Humaines pour les formalités
                de sortie et la remise des biens.
            </p>

            <p>Veuillez agréer, Madame/Monsieur, l’expression de nos salutations distinguées.</p>

            <!-- SIGNATURE -->
            <div class="text-end mt-5">
                <p class="fw-bold mb-0">Madame KUZO Nelly</p>
                <small>Manager Général</small>
            </div>

            <hr>

            <!-- ACKNOWLEDGEMENT -->
            <h6 class="text-center fw-bold mt-4">
                ACCUSÉ DE RÉCEPTION PAR LE TRAVAILLEUR
            </h6>

            <p>Le {{ now()->translatedFormat('d F Y') }}</p>

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
    </div>

    <!-- ================= PDF SCRIPT ================= -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        const element = document.getElementById("end-contract");

        const opt = {
            margin:[0.5,0.5,0.5,0.5],
            filename:"fin_contrat_{{ $employee->employee_id }}.pdf",
            image:{ type:'jpeg', quality:0.98 },
            html2canvas:{ scale:2 },
            jsPDF:{ unit:'cm', format:'a4', orientation:'portrait' }
        };

        document.getElementById("viewPdfBtn").addEventListener("click", ()=>{
            html2pdf().set(opt).from(element).outputPdf('blob')
                .then(pdf => window.open(URL.createObjectURL(pdf),'_blank'));
        });

        document.getElementById("downloadPdfBtn").addEventListener("click", ()=>{
            html2pdf().set(opt).from(element).save();
        });
    </script>

@endsection
