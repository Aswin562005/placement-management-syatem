<div class="modal fade" id="editAnnouncementModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAnnouncementModalLabel">Edit Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAnnouncementForm">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" class="form-control" name="id" id="editID">
                    <input type="hidden" class="form-control" name="admin_id" id="editAdminID">
                    <div class="mb-3">
                        <label>Company</label>
                        <select name="company_id" class="form-control" id="editCompany" required>
                            <option value="">Select Company</option>
                            <?php
                                $cmp_query = "SELECT * FROM company";
                                $cmp_result = $conn->query($cmp_query);
                                while ($cmp = $cmp_result->fetch_assoc()) {
                                    echo "<option value='{$cmp['cmp_id']}'>{$cmp['cmp_name']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Date of visit</label>
                        <input type="date" name="date_of_visit" class="form-control" id="editDateOfVisit" required>
                    </div>
                    <div class="mb-3">
                        <label>venue</label>
                        <input type="text" name="venue" class="form-control" id="editVenue" required>
                    </div>

                    <div class="mb-3">
                        <label>Eligible Criteria</label>
                        <select name="eligible_criteria[]" class="form-control" id="editEligibleCriteria" data-live-search="true" multiple required>
                            <option value="all">All Department</option>
                            <?php
                                $dept_query = "SELECT * FROM department";
                                $dept_result = $conn->query($dept_query);
                                while ($dept = $dept_result->fetch_assoc()) {
                                   echo "<option value='{$dept['dept_name']}'>{$dept['dept_name']}</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Job Role</label>
                        <input type="text" name="job_role" class="form-control" id="editJobRole">
                    </div>
                    <div class="mb-3">
                        <label>Salary Package</label>
                        <input type="text" name="salary_pkg" class="form-control" id="editSalaryPkg">
                    </div>
                    <div class="mb-3">
                        <label>Other Description</label>
                        <textarea name="description" class="form-control" id="editDescription"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
