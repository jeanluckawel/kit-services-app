@extends('layoutsddd.app')

@section('title', 'Certificat de Travail')

<script src="https://cdn.tailwindcss.com"></script>

@section('content')
    <div class="flex justify-center mt-6 flex-col items-center">

        <!-- ================= BUTTONS ================= -->
        <div class="mb-4 text-center">
            <button id="viewPdfBtn"
                    class="px-6 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">
                Voir PDF
            </button>

            <button id="downloadPdfBtn"
                    class="px-6 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 ml-2">
                Télécharger PDF
            </button>
        </div>

        <!-- ================= CERTIFICAT ================= -->
        <div id="certificate"
             class="relative bg-[#fffdf5] border-8 border-orange-500 rounded-xl shadow-inner w-[90%] h-[80vh] p-12 overflow-hidden font-serif">

            <!-- Bordures décoratives supplémentaires -->
            <div class="absolute top-0 left-0 w-full h-4 bg-gradient-to-r from-transparent via-orange-500 to-transparent"></div>
            <div class="absolute bottom-0 left-0 w-full h-4 bg-gradient-to-r from-transparent via-orange-500 to-transparent"></div>
            <div class="absolute top-0 left-0 w-4 h-full bg-gradient-to-b from-transparent via-orange-500 to-transparent"></div>
            <div class="absolute top-0 right-0 w-4 h-full bg-gradient-to-b from-transparent via-orange-500 to-transparent"></div>

            <!-- Coins décoratifs -->
            <div class="absolute top-6 left-6 w-16 h-16 border-t-4 border-l-4 border-orange-500 rounded-tr-xl"></div>
            <div class="absolute top-6 right-6 w-16 h-16 border-t-4 border-r-4 border-orange-500 rounded-tl-xl"></div>
            <div class="absolute bottom-6 left-6 w-16 h-16 border-b-4 border-l-4 border-orange-500 rounded-br-xl"></div>
            <div class="absolute bottom-6 right-6 w-16 h-16 border-b-4 border-r-4 border-orange-500 rounded-bl-xl"></div>

            <!-- Titre -->
            <div class="text-center mt-4">
                <h1 class="text-4xl font-extrabold uppercase tracking-widest text-orange-600 font-cursive">CERTIFICATE</h1>
                <h2 class="text-2xl font-semibold uppercase tracking-wide mt-1 text-gray-700 italic">OF ACHIEVEMENT</h2>
                <div class="mx-auto mt-4 mb-6 h-1 w-3/4 bg-gradient-to-r from-transparent via-orange-500 to-transparent"></div>
            </div>

            <!-- Sous-titre -->
            <div class="text-center mt-4">
                <p class="text-lg italic text-gray-600">THIS CERTIFICATE IS PROUDLY PRESENTED TO</p>
                <hr class="my-3 w-1/3 border-gray-400 mx-auto">
            </div>

            @php
                if($employee->gender === 'M'){
                   $title = 'Monsieur';
                } elseif($employee->gender === 'F'){
                   $title = 'Madame';
                } else {
                   $title = 'Monsieur/Madame';
                }

                use Carbon\Carbon;

                $hireDate = $employee->company->hire_date
                            ? Carbon::parse($employee->company->hire_date)->locale('fr')->translatedFormat('d F Y')
                            : 'JJ-MM-AAAA';

                $endDate = $employee->company->end_contract_date
                            ? Carbon::parse($employee->company->end_contract_date)->locale('fr')->translatedFormat('d F Y')
                            : 'JJ-MM-AAAA';

                $jobTitle = $employee->company->jobTitleRelation->name ?? 'Poste';
                $firstLetter = mb_strtoupper(mb_substr($jobTitle, 0, 1, 'UTF-8'));
                $preposition = in_array($firstLetter, ['A','E','I','O','U','Y']) ? "d’" : "de ";
            @endphp

                <!-- Corps du certificat -->
            <div class="text-center text-sm text-gray-800 space-y-5" style="font-family: 'Times New Roman', serif;">
                <p class="text-lg">
                    {{$title}} <strong>{{ $employee->first_name ?? 'Nom' }} {{ $employee->last_name ?? '' }}</strong>,
                    titulaire du numéro matricule <strong>{{ $employee->employee_id ?? 'XXXX' }}</strong>.
                </p>
                <p class="text-lg">
                    {{ $employee->gender === 'F' ? 'A été employée' : 'A été employé' }}
                    au sein de notre entreprise du <strong>{{ $hireDate }}</strong>
                    au <strong>{{ $endDate }}</strong>, en qualité {{ $preposition }}<strong>{{ $jobTitle }}</strong>
                </p>
                <p class="text-lg">
                    Pendant toute la durée de son contrat, {{$title}} <strong>{{ $employee->first_name ?? 'Nom' }}</strong>
                    a fait preuve de <strong>{{ $employee->remarks ?? 'professionnalisme' }}</strong>.
                </p>
                <p class="text-lg">
                    Ce certificat est délivré à sa demande ou à l'initiative de l'entreprise, afin de faire valoir ce que de droit,
                    suite à l'expiration du contrat à durée déterminée signé entre les deux parties.
                </p>
            </div>

            <div class="border-t-2 mt-6 border-orange-500 w-2/3 mx-auto"></div>

            <!-- Footer -->
            <div class="absolute bottom-12 w-[calc(100%-6rem)]">
                <div class="flex justify-between mt-4 items-center">
                    <!-- Human Resources -->
                    <div class="text-center">
                        <p class="font-bold text-gray-700 uppercase">HUMAN RESOURCES</p>
                    </div>

                    <!-- Logo + Timbre -->
                    <div class="text-center relative">
                        <img src="{{ asset('logo/img.png') }}" alt="Logo" class="h-16 mx-auto relative z-10">
                        <img src="{{ asset('logo/trimbre.png') }}" alt="Timbre"
                             class="absolute top-1/2 left-1/2 z-0 opacity-30"
                             style="max-height: 200px; max-width: 200px; transform: translate(-50%, -50%);">
                    </div>

                    <!-- Manager -->
                    <div class="text-center">
                        <p class="font-bold text-gray-700 uppercase">MANAGER</p>
                        <p class="text-gray-600">KUZO NELLY</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= PDF SCRIPT ================= -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        const element = document.getElementById('certificate');

        const options = {
            margin: 0,
            filename: 'certificat_{{ $employee->first_name ?? "employee" }}.pdf',
            image: { type: 'jpeg', quality: 1 },
            html2canvas: { scale: 1, scrollY: 0 }, // 🔴 scale 1 = 1 page
            jsPDF: { unit: 'cm', format: 'a4', orientation: 'landscape' },
            pagebreak: { mode: ['avoid-all'] }     // empêche 2 pages
        };

        document.getElementById("viewPdfBtn").addEventListener("click", () => {
            html2pdf().set(options).from(element).outputPdf('blob')
                .then(pdf => window.open(URL.createObjectURL(pdf), '_blank'));
        });

        document.getElementById("downloadPdfBtn").addEventListener("click", () => {
            html2pdf().set(options).from(element).save();
        });
    </script>
@endsection
