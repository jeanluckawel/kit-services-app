<footer class="app-footer">

    <div id="current-time" class=" float-end d-none d-sm-inline"></div>

    <strong>
        Copyright   &copy; 2025- {{ now()->year }}&nbsp;
        <a href="https://kit-services.org/" class="text-decoration-none ">KIT SERVICES SARL</a> .
    </strong>
    All rights reserved.
</footer>




<script>
    function updateDateTime() {
        const timeDiv = document.getElementById('current-time');

        if (timeDiv) {
            const now = new Date();

            const day = String(now.getDate()).padStart(2, '0');
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const year = now.getFullYear();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            timeDiv.textContent = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
        }
    }
    updateDateTime();

    setInterval(updateDateTime, 1000);
</script>

