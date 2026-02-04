<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {

        // === SUCCESS en vert ===
        @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            iconColor: '#28a745',          // vert
            background: '#fff',
            color: '#333',
            confirmButtonColor: '#28a745', // vert
            confirmButtonText: 'Ok',
            customClass: {
                popup: 'shadow-lg',         // carré si tu veux
                title: 'fw-bold fs-5',
                content: 'fs-6'
            },
            timer: 3000,
            timerProgressBar: true,
        });
        @endif

        // === ERROR ===
        @if(session('error'))
        Swal.fire({
            title: 'Error!',
            text: "{{ session('error') }}",
            icon: 'error',
            iconColor: '#FF3300',          // rouge
            background: '#fff',
            color: '#333',
            confirmButtonColor: '#FF3300', // rouge
            confirmButtonText: 'Ok',
            customClass: {
                popup: 'shadow-lg',
                title: 'fw-bold fs-5',
                content: 'fs-6'
            },
        });
        @endif

        // === VALIDATION ERRORS ===
        @if($errors->any())
        let errorMessages = `
    @foreach ($errors->all() as $error)
        • {{ $error }} <br>
    @endforeach
        `;
        Swal.fire({
            title: 'Validation Errors!',
            html: errorMessages,
            icon: 'error',
            iconColor: '#FF3300',          // rouge
            background: '#fff',
            color: '#333',
            confirmButtonColor: '#FF3300', // rouge
            confirmButtonText: 'Ok',
            customClass: {
                popup: 'shadow-lg',
                title: 'fw-bold fs-5',
                content: 'fs-6'
            },
        });
        @endif

    });
</script>
