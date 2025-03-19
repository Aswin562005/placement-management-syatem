<div class="modal fade" id="editCompanyModal" tabindex="-1" aria-labelledby="editCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCompanyModalLabel">Edit Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCompanyForm">
                    <input type="hidden" name="action" value="edit">
                    <!-- <div class="mb-3">
                        <label class="form-label">Company ID</label> -->
                        <input type="hidden" class="form-control" name="id" id="editID" readonly>
                    <!-- </div> -->
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="name" id="editName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Industry</label>
                        <input type="text" class="form-control" name="industry" id="editIndustry" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="editEmail" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company Location(city)</label>
                        <input type="text" class="form-control" name="location" id="editLocation" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company Website</label>
                        <input type="url" class="form-control" name="website" id="editWebsite">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
