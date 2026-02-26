@extends('layoutsddd.app')

@section('title', 'Bulletin de Paie | Kit Service')

@php use Carbon\Carbon; @endphp

@section('content')
    <style>
        /* Styles identiques à ton template précédent */
        .fiche-wrapper { display:flex; justify-content:center; padding-top:20px; background:#f8f9fa; min-height:100vh; font-family:Arial,sans-serif; }
        .fiche { width:100%; max-width:21cm; padding:1.5cm; font-size:11px; line-height:1.4; background:#fff; box-shadow:0 0.5rem 1rem rgba(0,0,0,0.1); color:#333; }
        .header { display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #ddd; padding-bottom:10px; margin-bottom:15px; }
        .header h1 { color:#FF6600; margin:0; font-size:1.3rem; }
        .header h2 { margin:0; font-size:1.1rem; color:#555; }
        .section-title { font-weight:600; border-bottom:1px solid #ddd; margin-bottom:8px; padding-bottom:4px; text-transform:uppercase; font-size:12px; color:#222; }
        .info-flex { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:10px; }
        .info-item { width:48%; display:flex; margin-bottom:4px; }
        .info-item span.label { width:140px; font-weight:600; color:#555; }
        .totals-box { background:#fff3cd; border:1px solid #ffeeba; padding:12px; border-radius:6px; margin-bottom:1rem; font-weight:600; }
        .btn-pdf { background:#FF6600; border:none; color:#fff; padding:0.4rem 0.8rem; font-size:0.95rem; border-radius:4px; cursor:pointer; margin-left:0.5rem; }
        .btn-pdf:hover { background:#e65c00; }
        .alert-signatures-wrapper { font-size:10px; margin-top:20px; }
        .signature-box { min-height:70px; padding:6px; }
        @media (max-width:768px){ .fiche { font-size:10px; padding:1rem; } .info-item { width:100%; } .header { flex-direction:column; gap:10px; } }
    </style>


    <div class="mb-3 text-end" style="width:100%; max-width:21cm; margin:auto;">

        <a href="{{ route('quick_pay') }}" class="btn-pdf">
            <i class="bi bi-plus-circle"></i> New Pay
        </a>


        <button id="viewPdfBtn" class="btn-pdf">
            <i class="bi bi-file-earmark-pdf"></i> Voir PDF
        </button>


        <button id="downloadPdfBtn" class="btn-pdf">
            <i class="bi bi-download"></i> Télécharger PDF
        </button>
    </div>

    <div class="fiche-wrapper">
        <div class="fiche">


            <div class="header">
                <h1>Kit Service Sarl</h1>
                <h2>Bulletin de Paie</h2>
                <div style="width:150px; height:150px;">
                    <img src="{{ asset('logo/img.png') }}" alt="Logo" style="width:100%;height:100%;object-fit:contain;">
                </div>
            </div>


            <div class="section-title">Informations Employé / Employeur</div>
            <div class="info-flex">
                <div class="info-item"><span class="label">Matricule:</span> {{ $payroll->employee->employee_id ?? '' }}</div>
                <div class="info-item"><span class="label">Raison sociale:</span> Kit Service SARL</div>
                <div class="info-item"><span class="label">Nom:</span> {{ $payroll->employee->first_name ?? '' }} {{ $payroll->employee->middle_name ?? '' }} {{ $payroll->employee->last_name ?? '' }}</div>
                <div class="info-item"><span class="label">Adresse:</span> N°1627 B Av. Kamina</div>
                <div class="info-item"><span class="label">Fonction:</span> {{ $employee->company->departmentRelation->name ?? '' }}</div>
                <div class="info-item"><span class="label">Quartier:</span> Mutoshi</div>
                <div class="info-item"><span class="label">Département:</span> {{ $employee->company->jobTitleRelation->name ?? '' }}</div>
                <div class="info-item"><span class="label">Commune:</span> Manika</div>
                <div class="info-item"><span class="label">Date Embauche:</span> {{ $payroll->employee->company->hire_date ?? 0 ? Carbon::parse($payroll->employee->company->hire_date)->format('d/m/Y') : '' }}</div>
{{--                <div class="info-item"><span class="label">Date Embauche:</span> {{ $payroll->employee->company->hire_date ?? 0 ? Carbon::parse($payroll->employee->company->hire_date)->format('d/m/Y') : '' }}</div>--}}
                <div class="info-item"><span class="label">Ville:</span> Kolwezi</div>
                <div class="info-item"><span class="label">Point de paie:</span> KAMOA</div>

                <div class="info-item"><span class="label">Taux:</span> {{ $payroll->exchange_rate . ' CDF' ?? '' }}</div>
                <div class="info-item"><span class="label">Salaire de base:</span> {{ '$ '. $payroll->employee->salaries->base_salary ?? '' }}</div>
                <div class="info-item"><span class="label">N° CNSS:</span> 050302727C1</div>
                <div class="info-item"><span class="label">Enfants:</span> {{ $payroll->employee->children->count() ?? 0 }}</div>
                <div class="info-item"><span class="label">Téléphone:</span> 002439773339977</div>
            </div>


            <div class="section-title">Détails Salaire</div>
            <div class="info-flex">
                <div class="info-item"><span class="label">Jours prestés:</span> {{ $payroll->day_work }}</div>
                <div class="info-item"><span class="label">Salaire Travail:</span> {{ $payroll->work }} $</div>
                <div class="info-item"><span class="label">Congé Maladie:</span> {{ $payroll->day_sick }} jours - {{ $payroll->sick }} $</div>
                <div class="info-item"><span class="label">Heures Supplémentaires:</span> {{ $payroll->day_overtime }} jours - {{ $payroll->overtime }} $</div>
            </div>


            <div class="section-title">Total</div>
{{--            <div class="info-flex">--}}
{{--                <div class="info-item"><span class="label">INSS 5%:</span> {{ $inss }} $</div>--}}
{{--                <div class="info-item"><span class="label">IPR 10%:</span> {{ $ipr }} $</div>--}}
{{--            </div>--}}


            <div class="totals-box">
                <div class="info-flex">
{{--                    <div class="info-item"><span class="label">Total Brut:</span> {{ $total_brut }} $</div>--}}
{{--                    <div class="info-item"><span class="label">Total Déductions:</span> {{ $total_deductions }} $</div>--}}
                    <div class="info-item"><span class="label">Net USD:</span> {{ (round(number_format($payroll->work))) }} $</div>
                    <div class="info-item"><span class="label">Net CDF:</span> {{ number_format($net_cdf) }} CDF</div>
                </div>
            </div>


            <div class="alert-signatures-wrapper">
                <div class="row text-center mt-3">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <div class="border p-2 signature-box">
                            <p class="fw-bold mb-2">Date et signature du représentant légal</p>
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
                Réf : {{ $payroll->id }} | Date le, {{ now()->format('d/m/Y H:i') }}
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
