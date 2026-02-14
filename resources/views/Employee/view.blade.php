@php use Carbon\Carbon; @endphp
@extends('layoutsddd.app')

@section('title', 'Kit Service | Profil')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

@section('content')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .fiche-wrapper {
            display: flex;
            justify-content: center;
            padding-top: 10px; /* réduit la marge haute */
            position: relative;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .fiche {
            width: 100%;
            max-width: 20cm; /* réduit légèrement la largeur */
            padding: 1cm; /* padding réduit */
            font-size: 10px; /* taille de police réduite */
            box-sizing: border-box;
            background-color: #fff;
            box-shadow: 0 0.3rem 0.6rem rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .table td, .table th {
            vertical-align: middle;
            border-radius: 0 !important;
        }

        .photo-box, .signature-box, .alert {
            border-radius: 0 !important;
        }

        .header-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .no-print {
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .fiche {
                padding: 0.8rem;
                font-size: 9px;
            }
            .fiche .row > [class*="col-"] {
                margin-bottom: 0.5rem;
            }
        }
    </style>

    <div class="container">
        <!-- Bouton Download -->
        <div class="text-end no-print">
            <button id="downloadPdfBtn" class="btn btn-danger" style="border-radius:0;">
                <i class="bi bi-file-earmark-pdf"></i> Télécharger PDF
            </button>
        </div>
    </div>

    <div class="fiche-wrapper">
        <!-- Fiche principale -->
        <div class="fiche">

            <!-- En-tête -->
            <div class="d-flex align-items-center justify-content-between border-bottom mb-2">
                <div style="flex:1;">
                    <h1 class="h5 fw-bold" style="color:#FF6600; margin:0;">Kit Service Sarl</h1>
                </div>
                <div class="text-center" style="flex:2;">
                    <h2 class="h6 fw-bold text-dark" style="margin:0;">Fiche de Renseignement du Salarié</h2>
                </div>
                <div style="width:100px; height:100px; flex:none;" class="header-logo">
                    <img src="{{ asset('logo/img.png') }}" alt="Logo">
                </div>
            </div>

            <!-- Photo et tableau -->
            <div class="row mb-2">
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    <div class="border bg-light d-flex align-items-center justify-content-center photo-box"
                         style="width:120px; height:150px; font-size:9px; overflow:hidden;">
                        @if($employee->photo)
                            <img src="{{ asset('storage/' . $employee->photo) }}"
                                 alt="Photo de {{ $employee->full_name ?? '' }}"
                                 style="width:100%; height:100%; object-fit:cover;">
                        @else
                            Photo
                        @endif
                    </div>
                </div>

                <div class="col-md-10 table-responsive">
                    <table class="table table-bordered table-sm mb-0" style="font-size:10px;">
                        <tbody>
                        <!-- Informations personnelles -->
                        <tr class="table-secondary">
                            <th colspan="4">Informations Personnelles</th>
                        </tr>
                        <tr>
                            <td>Entreprise</td>
                            <td>Kit Service Sarl</td>
                            <td>Nom</td>
                            <td>{{ $employee->first_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Prénom</td>
                            <td>{{ $employee->last_name ?? 'N/A' }}</td>
                            <td>Situation familiale</td>
                            <td>{{ $employee->marital_status ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Post nom</td>
                            <td>{{ $employee->middle_name ?? 'N/A' }}</td>
                            <td>Nombre d'enfants à charge</td>
                            <td>{{ $employee->children->count() ?? '0' }}</td>
                        </tr>
                        <tr>
                            <td>Nombre de personnes à charge</td>
                            <td>{{ $employee->last_name ?? 'N/A' }}</td>
                            <td>Date de naissance</td>
                            <td>{{ $employee->date_of_birth ? Carbon::parse($employee->date_of_birth)->format('d M Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Département</td>
                            <td>{{ $employee->company?->departmentRelation?->name ?? 'N/A' }}</td>
                            <td>Pays</td>
                            <td>{{ $employee->pays ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>N° carte CNSS</td>
                            <td>________________________</td>
                            <td>N° pièce d'identité</td>
                            <td>{{ $employee->number_card ?? 'N/A' }}</td>
                        </tr>

                        <!-- Informations familiales -->
                        <tr class="table-secondary">
                            <th colspan="4">Informations Familiales</th>
                        </tr>
                        @forelse($employee->dependants as $dependant)
                            @if(strtolower($dependant->relationship) !== 'spouse')
                                <tr>
                                    <td>{{ $dependant->relationship ?? 'N/A' }}</td>
                                    <td>{{ $dependant->full_name ?? 'N/A' }}</td>
                                    <td>{{ $dependant->phone ?? 'N/A' }}</td>
                                    <td>{{ $dependant->address ?? 'N/A' }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Aucun dépendant enregistré</td>
                            </tr>
                        @endforelse

                        <!-- Informations professionnelles -->
                        <tr class="table-secondary">
                            <th colspan="4">Informations Professionnelles</th>
                        </tr>
                        <tr>
                            <td>Adresse complète</td>
                            <td colspan="3">
                                {{
                                    ($employee->address->number ? 'N)' . $employee->address->number : '')
                                    . ',' .
                                    ($employee->address->city ? ' Avenue ' . $employee->address->city : '')
                                    . ',' .
                                    ($employee->address->province ? ' quartier ' . $employee->address->province : '')
                                    . ',' .
                                    ($employee->address->emergency_phone ? ' province ' . $employee->address->emergency_phone : '')
                                    . ',' .
                                    ($employee->pays ? ' ' . $employee->pays : '')
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td>Emploi / Poste</td>
                            <td colspan="3">{{ $employee->company->jobTitleRelation->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Section</td>
                            <td>{{ $employee->company?->DepartmentRelation?->name ?? 'N/A' }}</td>
                            <td>Position</td>
                            <td>{{ $employee->company?->jobTitleRelation?->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Niveau</td>
                            <td>{{ $employee->salaries->category ?? 'N/A' }}</td>
                            <td>Coefficient</td>
                            <td>{{ number_format($employee->salaries->base_salary ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Échelon</td>
                            <td>{{ $employee->salaries->echelon ?? 'N/A' }}</td>
                            <td>Taux horaire brut (FC)</td>
                            <td>FC 600</td>
                        </tr>
                        <tr>
                            <td>Salaire mensuel brut</td>
                            <td>{{ $employee->salaries->currency ?? '' }} {{ number_format($employee->salaries->base_salary ?? 0, 2) }}</td>
                            @php
                                $currency = $employee->salaries->currency ?? '';
                                $salary   = $employee->salaries->base_salary ?? 0;
                                $contractType = strtolower($employee->company->contract_type ?? 'full time');
                                $hoursPerDay = $contractType == 'part time' ? 4 : 8;
                                $daysPerWeek = 5;
                                $weeksPerMonth = 4;
                                $monthlyHours = $hoursPerDay * $daysPerWeek * $weeksPerMonth;
                                $hourlySalary = $monthlyHours > 0 ? $salary / $monthlyHours : 0;
                            @endphp
                            <td>Horaire hebdomadaire</td>
                            <td>{{ $currency }} {{ number_format($hourlySalary, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Date d'embauche</td>
                            <td>{{ Carbon::parse($employee->company->hire_date)->translatedFormat('d F Y') }}</td>
                            <td>Numéro matricule</td>
                            <td>{{ $employee->employee_id }}</td>
                        </tr>
                        <tr>
                            <td>Type de contrat</td>
                            <td>{{ $employee->company->contract_type ?? 'N/A'}}</td>
                            <td>Lieu de travail</td>
                            <td>{{ $employee->company->work_location ?? 'N/A'}}</td>
                        </tr>

                        <!-- Conjoint & Enfants -->
                        <tr class="table-secondary">
                            <th colspan="4">Conjoint(e) et Enfants</th>
                        </tr>
                        <tr>
                            <td>Nom du conjoint(e)</td>
                            @forelse($employee->dependants as $dependant)
                                @if(strtolower($dependant->relationship) === 'spouse')
                                    <td colspan="3">
                                        {{ $dependant->full_name ?? 'N/A' }} -
                                        {{ $dependant->phone ?? 'N/A' }} -
                                        {{ $dependant->address ?? 'N/A' }}
                                    </td>
                                @endif
                            @empty
                                <td colspan="3" class="text-center">Aucun conjoint enregistré</td>
                            @endforelse
                        </tr>

                        <!-- Personne à contacter -->
                        <tr class="table-secondary">
                            <th colspan="4">Personne à contacter en cas d'urgence</th>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm mb-0" style="font-size:9px;">
                                        <thead class="table-light">
                                        <tr>
                                            <th>N°</th>
                                            <th>Nom Complet</th>
                                            <th>Adresse</th>
                                            <th>Numéro Téléphone</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>{{ $employee->emergencies->full_name ?? '' }}</td>
                                            <td>{{ $employee->emergencies->address ?? '' }}</td>
                                            <td>{{ $employee->emergencies->phone ?? '' }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="alert alert-warning p-2 mb-3" role="alert" style="font-size:9px;">
                <strong>Attention :</strong>
                <ul class="mb-0">
                    <li>Aucun de ceux du salaire ne pourra être établi après retour de cette fiche dûment complétée.</li>
                    <li>Les champs signalés par un calendrier sont obligatoires pour établir la déclaration annuelle des salaires.</li>
                </ul>
            </div>

            <div class="row mt-3 text-center" style="font-size:9px;">
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
    </div>

    <!-- Scripts pour PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById("downloadPdfBtn").addEventListener("click", () => {
            const element = document.querySelector(".fiche");
            const opt = {
                margin: 0.4,
                filename: '{{ $employee->employee_id ?? "fiche-agent" }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, logging: true, dpi: 192, letterRendering: true },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        });
    </script>

@endsection
