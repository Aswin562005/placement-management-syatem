
<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addStudentForm">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="mb-3">
                        <label>Roll No</label>
                        <input type="text" name="rollno" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Department</label>
                        <select name="department_id" class="form-control" required>
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
                        <label>Section</label>
                        <select name="section" class="form-control" required>
                            <option value="">Select Section</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
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
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Address</label>
                        <textarea name="address" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Year of Study(Batch)</label>
                        <input type="number" name="year_of_study" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>UG or PG &nbsp;&nbsp;</label>
                        <label>
                            <input type="radio" name="ug_or_pg" value="UG" class="form-radio" required>
                            &nbsp;UG
                        </label>
                        <label>
                            <input type="radio" name="ug_or_pg" value="PG" class="form-radio" required>
                            &nbsp;PG
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Student</button>
                </form>
            </div>
        </div>
    </div>
</div>