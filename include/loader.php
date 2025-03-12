<style>
    #loadingContainer {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
</style>
<div id="loadingContainer" class="d-none">
    <div class="spinner-grow text-primary" role="status">
    <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-secondary" role="status">
    <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-success" role="status">
    <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-danger" role="status">
    <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-warning" role="status">
    <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-info" role="status">
    <span class="visually-hidden">Loading...</span>
    </div>
</div>

<script>
    function startLoader() {
        document.getElementById('loadingContainer').classList.remove('d-none');
    }
    function stopLoader() {
        document.getElementById('loadingContainer').classList.add('d-none');
    }
</script>