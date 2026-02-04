@php use Carbon\Carbon; @endphp
@extends('layoutsddd.app')

@section('title', 'Bulletin de Paie')

@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body{font-size:14px;color:#333;}
        p{margin-bottom:5px;}
        .section-title{font-weight:600;border-bottom:1px solid #ddd;margin-bottom:8px;padding-bottom:4px;text-transform:uppercase;font-size:14px;}
        .label{width:160px;display:inline-block;font-weight:600;}
        .totals-box{background:#f8f9fa;padding:14px;border-radius:6px;}
        .footer-ref{font-size:12px;color:#777;border-top:1px dashed #ccc;margin-top:30px;padding-top:8px;display:flex;justify-content:space-between;}
        img{max-height:60px;}
        /* bouton download */
        .download-btn{
            display:inline-block;
            margin:20px auto;
            padding:8px 16px;
            background:#0d6efd;
            color:#fff;
            border:none;
            border-radius:4px;
            cursor:pointer;
            font-size:16px;
        }
        .download-btn:hover{background:#0056b3;}
    </style>

    <!-- BOUTON DOWNLOAD -->
    <div class="text-center">
        <button class="download-btn" onclick="downloadPDF()">Télécharger le Bulletin</button>
    </div>

    <!-- BULLETIN -->
    <div class="container my-3" style="max-width:800px;" id="bulletin-container">
        <div class="bg-white p-4">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">KIT SERVICE SARL</h4>
                    <small class="text-muted">Bulletin de Paie</small>
                </div>
                <img src="{{ asset('logo/img.png') }}" alt="Logo">
            </div>

            <!-- EMPLOYE / EMPLOYEUR -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="section-title">Informations Employé</div>
                    <p><span class="label">Matricule</span>: {{ $payroll->employee->employee_id ?? '' }}</p>
                    <p><span class="label">Nom</span>: {{ $payroll->employee->first_name ?? '' }} {{ $payroll->employee->last_name ?? '' }} {{ $payroll->employee->middle_name ?? '' }}</p>
                    <p><span class="label">Fonction</span>: {{ $payroll->employee->company->job_title ?? '' }}</p>
                    <p><span class="label">Département</span>: {{ $payroll->employee->company->department ?? '' }}</p>
                    <p><span class="label">Date Embauche</span>: {{ $payroll->employee->company->hire_date ? Carbon::parse($payroll->employee->company->hire_date)->format('d/m/Y') : '' }}</p>
                    <p><span class="label">Point de paie</span>: KAMOA</p>
                    <p><span class="label">Enfants</span>: {{ $payroll->employee->children->count() ?? 0 }}</p>
                    <p><span class="label">N° CNSS</span>: ....................</p>
                </div>
                <div class="col-md-6">
                    <div class="section-title">Employeur</div>
                    <p><span class="label">Raison sociale</span>: Kit Service SARL</p>
                    <p><span class="label">Adresse</span>: N°1627 B Av. Kamina</p>
                    <p><span class="label">Quartier</span>: Mutoshi</p>
                    <p><span class="label">Commune</span>: Manika</p>
                    <p><span class="label">Ville</span>: Kolwezi</p>
                    <p><span class="label">Téléphone</span>: 002439773339977</p>
                    <p><span class="label">CNSS</span>: 050302727C1</p>
                </div>
            </div>

            <!-- SALAIRE -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="section-title">Détails Salaire</div>
                    <p><span class="label">Jours prestés</span>: {{ $payroll->worked_days }}</p>
                    <p><span class="label">Salaire Brut</span>: {{ $payroll->basic_usd }} $</p>
                    <p><span class="label">Congé annuel</span>: 0</p>
                    <p><span class="label">Congé maladie</span>: {{ $payroll->sick_days }}</p>
                    <p><span class="label">Logement</span>: {{ $payroll->accommodation_allowance }} $</p>
                </div>
                <div class="col-md-6">
                    <div class="section-title">Déductions</div>
                    <p><span class="label">INSS 5%</span>: {{ $payroll->inss_5 }} CDF</p>
                    <p><span class="label">IPR</span>: {{ $payroll->ipr_rate }} CDF</p>
                </div>
            </div>

            <!-- TOTALS -->
            <div class="totals-box mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <p><span class="label">Total Brut</span>: {{ $payroll->total_brut }} CDF</p>
                        <p><span class="label">Total Déductions</span>: {{ $payroll->total_deductions }} CDF</p>
                    </div>
                    <div class="col-md-6 fw-bold">
                        <p><span class="label">Net USD</span>: {{ $payroll->net_usd }} $</p>
                        <p><span class="label">Net CDF</span>: {{ $payroll->net_cdf }} CDF</p>
                    </div>
                </div>
            </div>

            <!-- SIGNATURE -->
            <div class="text-end mt-5">
                <p>Signature & Cachet</p>
                <div style="width:220px;border-top:1px solid #000;margin-left:auto;margin-top:40px;"></div>
            </div>

            <!-- FOOTER -->
            <div class="footer-ref">
                <span>Généré le {{ now()->format('d/m/Y H:i') }}</span>
                <span>Réf : {{ $payroll->reference }}</span>
            </div>

        </div>
    </div>

    <!-- SCRIPT HTML2PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadPDF(){
            const element = document.getElementById('bulletin-container');
            const opt = {
                margin:       10,
                filename:     '{{ $payroll->employee->employee_id ?? 'bulletin' }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, logging: false, useCORS: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>

@endsection
