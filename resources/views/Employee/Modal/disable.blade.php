<!-- CSS style carré type SweetAlert2 sans arrondis -->
<style>
    /* Modal carré */
    #disableEmployeeModal .modal-dialog {
        max-width: 380px;  /* carré */
        margin: 0 auto;
    }

    #disableEmployeeModal .modal-content {
        border-radius: 0; /* plus d'arrondi */
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        text-align: center;
        padding: 2rem 1.5rem;
        animation: popIn 0.3s ease-out;
    }

    /* Animation pop */
    @keyframes popIn {
        0% { transform: scale(0.7); opacity: 0; }
        80% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(1); }
    }

    #disableEmployeeModal .modal-header {
        border-bottom: none;
        justify-content: center;
        padding-bottom: 0.5rem;
    }

    #disableEmployeeModal .modal-title {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-weight: 700;
        font-size: 1.3rem;
        color: #FF3300;
    }

    #disableEmployeeModal .modal-body p {
        font-size: 1rem;
        margin: 0.5rem 0;
        color: #333;
    }

    #disableEmployeeModal .btn-secondary,
    #disableEmployeeModal .btn-danger {
        border-radius: 0;  /* plus d'arrondi */
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        min-width: 100px;
    }

    #disableEmployeeModal .btn-secondary {
        background-color: #f0f0f0;
        color: #333;
        border: none;
    }

    #disableEmployeeModal .btn-secondary:hover {
        background-color: #e0e0e0;
    }

    #disableEmployeeModal .btn-danger {
        background-color: #FF3300;
        border: none;
        color: #fff;
    }

    #disableEmployeeModal .btn-danger:hover {
        background-color: #e62e00;
    }

    #disableEmployeeModal .modal-footer {
        justify-content: center;
        border-top: none;
        padding-top: 1rem;
        gap: 0.5rem;
        display: flex;
        flex-wrap: wrap;
    }
</style>

<!-- Modal HTML -->
<div class="modal fade" id="disableEmployeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Disable Employee
                </h5>
            </div>

            <div class="modal-body">
                <p class="fw-bold">Are you sure you want to disable this employee?</p>
                <p class="text-muted mb-0">This action will deactivate the employee.<br>No data will be permanently deleted.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="disableEmployeeForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Yes, Disable</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- JS pour remplir action du formulaire -->
<script>
    const disableModal = document.getElementById('disableEmployeeModal');

    disableModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const employeeId = button.getAttribute('data-employee-id');
        const form = document.getElementById('disableEmployeeForm');
        form.action = `/employees/${employeeId}/disable`;
    });
</script>
