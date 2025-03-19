
<!-- Add Admin Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addAdminForm">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" class="form-control" required>
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
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Phone No</label>
                        <input type="number" name="phone" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Admin</button>
                </form>
            </div>
        </div>
    </div>
</div>