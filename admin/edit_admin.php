<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAdminModalLabel">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAdminForm">
                    <input type="hidden" name="action" value="edit">
                    <!-- <div class="mb-3">
                        <label class="form-label">Admin ID</label> -->
                        <input type="hidden" class="form-control" name="id" id="editID" readonly>
                    <!-- </div> -->
                    <div class="mb-3">
                        <label class="form-label">Admin Name</label>
                        <input type="text" class="form-control" name="name" id="editName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date Of Birth</label>
                        <input type="date" class="form-control" name="dob" id="editDob" required>
                    </div>
                    <div class="mb-3">
                        <label>Gender &nbsp;&nbsp;</label>
                        <label>
                            <input type="radio" name="gender" value="Male" class="form-radio" required>
                            &nbsp;Male
                        </label>
                        <label>
                            <input type="radio" name="gender" value="Female" class="form-radio" required>
                            &nbsp;Female
                        </label>
                        <label>
                            <input type="radio" name="gender" value="Others" class="form-radio" required>
                            &nbsp;Others
                        </label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="editEmail" required>
                    </div>

                    <div class="mb-3">
                        <label>Phone No</label>
                        <input type="number" name="phone" class="form-control" id="editPhone" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
