<div class="modal fade" id="deletePerceptionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Delete Perception
                </h5>
            </div>

            <div class="modal-body">
                <p class="fw-bold">Are you sure you want to delete this perception?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deletePerceptionForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    const deleteModal = document.getElementById('deletePerceptionModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const perceptionId = button.getAttribute('data-perception-id');
        const form = document.getElementById('deletePerceptionForm');
        form.action = `/perceptions/${perceptionId}`;
    });
</script>
