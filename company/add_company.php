
<!-- Add Company Modal -->
<div class="modal fade" id="addCompanyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addCompanyForm">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="mb-3">
                        <label>Comapany Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Comapany Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Industry</label>
                        <input type="text" name="industry" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Comapany Location(city)</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Company</button>
                </form>
            </div>
        </div>
    </div>
</div>