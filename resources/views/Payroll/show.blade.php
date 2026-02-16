@php use Carbon\Carbon; @endphp
@extends('layoutsddd.app')

@section('title', 'Bulletin de Paie | Kit Service')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

@section('content')
    <style>
        /* Wrapper général */
        .fiche-wrapper {
            display: flex;
            justify-content: center;
            padding-top: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        /* Fiche principale */
        .fiche {
            width: 100%;
            max-width: 21cm;
            padding: 1.5cm;
            font-size: 11px;
            line-height: 1.4;
            background-color: #fff;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
            color: #333;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h1 { color: #FF6600; margin: 0; font-size: 1.3rem; }
        .header h2 { margin: 0; font-size: 1.1rem; color: #555; }

        /* Titres de section */
        .section-title {
            font-weight: 600;
            border-bottom: 1px solid #ddd;
            margin-bottom: 8px;
            padding-bottom: 4px;
            text-transform: uppercase;
            font-size: 12px;
            color: #222;
        }

        /* Flex pour infos */
        .info-flex {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
        }

        .info-item {
            width: 48%;
            display: flex;
            margin-bottom: 4px;
        }

        .info-item span.label {
            width: 140px;
            font-weight: 600;
            color: #555;
        }

        /* Totaux */
        .totals-box {
            background:#fff3cd;
            border:1px solid #ffeeba;
            padding:12px;
            border-radius:6px;
            margin-bottom:1rem;
            font-weight: 600;
        }

        /* Boutons PDF */
        .btn-pdf {
            background-color: #FF6600;
            border: none;
            color: #fff;
            padding: 0.4rem 0.8rem;
            font-size: 0.95rem;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 0.5rem;
        }
        .btn-pdf:hover { background-color: #e65c00; }

        /* Signatures */
        .alert-signatures-wrapper { font-size: 10px; margin-top: 20px; }
        .signature-box { min-height: 70px; padding: 6px; }

        /* Responsive */
        @media (max-width:768px){
            .fiche { font-size: 10px; padding: 1rem; }
            .info-item { width: 100%; }
            .header { flex-direction: column; gap: 10px; }
        }
    </style>

    <!-- Boutons PDF -->
    <div class="mb-3 text-end" style="width: 100%; max-width: 21cm; margin: auto;">
        <button id="viewPdfBtn" class="btn-pdf"><i class="bi bi-eye"></i> Voir PDF</button>
        <button id="downloadPdfBtn" class="btn-pdf"><i class="bi bi-download"></i> Télécharger PDF</button>
    </div>

    <div class="fiche-wrapper">
        <div class="fiche">

            <!-- HEADER -->
            <div class="header">
                <h1>Kit Service Sarl</h1>
                <h2>Bulletin de Paie</h2>
                <div style="width:150px; height:150px;">
                    <img src="{{ asset('logo/img.png') }}" alt="Logo" style="width:100%;height:100%;object-fit:contain;">
                </div>
            </div>

            <!-- Informations Employé / Employeur -->
            <div class="section-title">Informations Employé / Employeur</div>
            <div class="info-flex">
                <div class="info-item"><span class="label">Matricule:</span> {{ $payroll->employee->employee_id ?? '' }}</div>
                <div class="info-item"><span class="label">Raison sociale:</span> Kit Service SARL</div>
                <div class="info-item"><span class="label">Nom:</span> {{ $payroll->employee->first_name ?? '' }} {{ $payroll->employee->middle_name ?? '' }} {{ $payroll->employee->last_name ?? '' }}</div>
                <div class="info-item"><span class="label">Adresse:</span> N°1627 B Av. Kamina</div>
                <div class="info-item"><span class="label">Fonction:</span> {{ $payroll->employee->company->job_title ?? '---' }}</div>
                <div class="info-item"><span class="label">Quartier:</span> Mutoshi</div>
                <div class="info-item"><span class="label">Département:</span> {{ $payroll->employee->company->department ?? '1' }}</div>
                <div class="info-item"><span class="label">Commune:</span> Manika</div>
                <div class="info-item"><span class="label">Date Embauche:</span> {{ $payroll->employee->company->hire_date ? Carbon::parse($payroll->employee->company->hire_date)->format('d/m/Y') : '' }}</div>
                <div class="info-item"><span class="label">Ville:</span> Kolwezi</div>
                <div class="info-item"><span class="label">Point de paie:</span> KAMOA</div>
                <div class="info-item"><span class="label">Téléphone:</span> 050302727C1</div>
                <div class="info-item"><span class="label">Enfants:</span> {{ $payroll->employee->children->count() ?? 1 }}</div>
                <div class="info-item"><span class="label">N° CNSS:</span> 002439773339977</div>
            </div>

            <!-- Salaire -->
            <div class="section-title">Détails Salaire</div>
            <div class="info-flex">
                <div class="info-item"><span class="label">Jours prestés:</span> {{ $payroll->worked_days }}</div>
                <div class="info-item"><span class="label">Salaire Brut:</span> {{ $payroll->basic_usd }} $</div>
                <div class="info-item"><span class="label">Congé annuel:</span> 0</div>
                <div class="info-item"><span class="label">Congé maladie:</span> {{ $payroll->sick_days }}</div>
                <div class="info-item"><span class="label">Logement:</span> {{ $payroll->accommodation_allowance }} $</div>
            </div>

            <!-- Déductions -->
            <div class="section-title">Déductions</div>
            <div class="info-flex">
                <div class="info-item"><span class="label">INSS 5%:</span> {{ $payroll->inss_5 }} CDF</div>
                <div class="info-item"><span class="label">IPR:</span> {{ $payroll->ipr_rate }} CDF</div>
            </div>

            <!-- Totaux -->
            <div class="totals-box">
                <div class="info-flex">
                    <div class="info-item"><span class="label">Total Brut:</span> {{ $payroll->total_brut }} CDF</div>
                    <div class="info-item"><span class="label">Total Déductions:</span> {{ $payroll->total_deductions }} CDF</div>
                    <div class="info-item"><span class="label">Net USD:</span> {{ $payroll->net_usd }} $</div>
                    <div class="info-item"><span class="label">Net CDF:</span> {{ $payroll->net_cdf }} CDF</div>
                </div>
            </div>

            <!-- Signatures -->
            <div class="alert-signatures-wrapper">
                <div class="row text-center mt-3">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <div class="border p-2 signature-box">
                            <p class="fw-bold mb-2">Date et signature du représentant légal de l'entreprise</p>
                            <div class="border-top mt-1" style="height:50px;"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border p-2 signature-box">
                            <p class="fw-bold mb-2">Date et signature de l'agent</p>
                            <div class="border-top mt-1" style="height:50px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-2" style="font-size:10px;">
                Réf : {{ $payroll->reference ?? '---' }} | Généré le {{ now()->format('d/m/Y H:i') }}
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        const element = document.querySelector(".fiche");
        const opt = {
            margin: [0.5,0.5,0.5,0.5],
            filename: '{{ $payroll->employee->employee_id ?? "bulletin" }}_paie.pdf',
            image: { type:'jpeg', quality:0.98 },
            html2canvas:{ scale:2, logging:true, letterRendering:true },
            jsPDF:{ unit:'cm', format:'a4', orientation:'portrait' }
        };

        document.getElementById("viewPdfBtn").addEventListener("click", ()=> {
            html2pdf().set(opt).from(element).outputPdf('blob').then(function(pdfBlob){
                window.open(URL.createObjectURL(pdfBlob), '_blank');
            });
        });

        document.getElementById("downloadPdfBtn").addEventListener("click", ()=> {
            html2pdf().set(opt).from(element).save();
        });
    </script>
@endsection
