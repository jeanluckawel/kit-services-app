@extends('layoutsddd.app')

@section('title', 'Certificat de Travail')

<script src="https://cdn.tailwindcss.com"></script>

@section('content')
    <div class="flex justify-center mt-6">
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
                if($employee->gender === 'Male'){
                   $title = 'Monsieur';
                } elseif($employee->gender === 'Female'){
                   $title = 'Madame';
                } else {
                   $title = 'Monsieur/Madame';
                }
            @endphp

                <!-- Corps du certificat -->
            <div class="text-center text-sm text-gray-800 space-y-5" style="font-family: 'Times New Roman', serif;">
                <p class="text-lg">
                    {{$title}} <strong>{{ $employee->first_name ?? 'Nom' }} {{ $employee->last_name ?? '' }}</strong>,
                    titulaire du numéro matricule <strong>{{ $employee->employee_id ?? 'XXXX' }}</strong>.
                </p>
                <p class="text-lg">
                    A été employé(e) au sein de notre entreprise du <strong>{{ $employee->created_at ?? 'JJ-MM-AAAA' }}</strong>
                    au <strong>{{ $employee->end_contract_date ?? 'JJ-MM-AAAA' }}</strong>, en qualité de
                    <strong>{{ $employee->function ?? 'Poste' }}</strong>.
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
            <div class="absolute bottom-19 w-[calc(100%-6rem)]">

                <div class="flex justify-between mt-4 items-center">
                    <!-- Human Resources -->
                    <div class="text-center">
                        <p class="font-bold text-gray-700 uppercase">HUMAN RESOURCES</p>
                        <p class="text-gray-600">BANZA GLORY</p>
                    </div>

                    <!-- Logo + Timbre -->
                    <!-- Logo + timbre -->
                    <div class="text-center relative">
                        <!-- Logo principal -->
                        <img src="{{ asset('logo/img.png') }}" alt="Logo" class="h-16 mx-auto relative z-10">

                        <!-- Timbre centré et proportionnel -->
                        <img src="{{ asset('logo/trimbre.png') }}" alt="Timbre"
                             class="absolute top-1/2 left-1/2 z-0 opacity-30"
                             style="max-height: 200px; max-width: 200px; width: auto; height: auto; transform: translate(-50%, -50%);">
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

    <!-- Bouton Télécharger PDF -->
    <div class="mt-4 text-center">
        <button onclick="downloadPDF()"
                class="px-6 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">
            Télécharger PDF
        </button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadPDF() {
            const element = document.getElementById('certificate');
            const opt = {
                margin: 0,
                filename: 'certificat_{{ $employee->first_name ?? "employee" }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, scrollY: -window.scrollY }, // centrer l'élément
                jsPDF: { unit: 'cm', format: 'a4', orientation: 'landscape' }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
@endsection
