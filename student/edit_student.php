<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm">
                    <input type="hidden" name="action" value="edit">
                    <div class="mb-3">
                        <label class="form-label">Roll Number</label>
                        <input type="text" class="form-control" name="rollno" id="editRollno" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="editName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-control" id="editDepartment" required>
                            <option value="">Select Department</option>
                            <?php
                            $dept_query = "SELECT * FROM department";
                            $dept_result = $conn->query($dept_query);
                            while ($dept = $dept_result->fetch_assoc()) {
                                echo "<option value='{$dept['dept_id']}'>{$dept['dept_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Section</label>
                        <select name="section" class="form-control" id="editSection" required>
                            <option value="">Select Section</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="editEmail" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="editPhone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" id="editDob" required>
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
                        <label>Address</label>
                        <textarea name="address" class="form-control" id="editAddress" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Year of Study(Batch)</label>
                        <input type="number" name="year_of_study" class="form-control" id="editYearOfStudy" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">UG or PG &nbsp;&nbsp;</label>
                        <label class="form-label">
                            <input type="radio" name="ug_or_pg" value="UG" class="form-radio" required>
                            UG&nbsp;
                        </label>
                        <label class="form-label">
                            <input type="radio" name="ug_or_pg" value="PG" class="form-radio" required>
                            PG
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <!-- <div id="editMessageBox" class="mt-2"></div> -->
                </form>
            </div>
        </div>
    </div>
</div>
