
<!-- Add Announcement Modal -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Post Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addAnnouncementForm">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="admin_email" value="<?php echo $_SESSION['login_user_email']; ?>">
                    <div class="mb-3">
                        <label>Company</label>
                        <select name="company_id" class="form-control" required>
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
                        <input type="date" name="date_of_visit" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>venue</label>
                        <input type="text" name="venue" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Eligible Criteria</label>
                        <select name="eligible_criteria[]" class="form-control" id="choices-multiple" data-live-search="true" multiple required>
                            <option value="all" selected>All Department</option>
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
                        <input type="text" name="job_role" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Salary Package</label>
                        <input type="text" name="salary_pkg" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Other Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>
        </div>
    </div>
</div>