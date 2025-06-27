<?php include("includes/header.php"); ?>

<div class="admin-link">
    <a href="./admin/admin.php">👤 Admin Login</a>
</div>

<div class="form">
    <div id="header">Undergraduate Course Application</div>
    <form action="form_submit.php" method="POST" enctype="multipart/form-data">
        <label>First Name</label>
        <input type="text" name="first" required>

        <label>Last Name</label>
        <input type="text" name="last" required>

        <label>Gender</label>
        <input type="radio" name="gender" value="male" required> Male
        <input type="radio" name="gender" value="female"> Female
        <input type="radio" name="gender" value="other"> Other

        <label>Date of Birth</label>
        <input type="date" name="dob" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Phone Number</label>
        <input type="tel" name="number" required>

        <label>Address</label>
        <textarea name="address" rows="4" required></textarea>

        <label>Select Group</label>
        <select name="group" required>
            <option value="">--Select Group--</option>
            <option value="cs">Computer Science</option>
            <option value="biomaths">Bio Maths</option>
            <option value="commerce">Commerce</option>
        </select>

        <label>Total Marks (out of 600)</label>
        <input type="number" name="marks" max="600" required>

        <label>Select Course</label>
        <select name="course" required>
            <option value="">--Select Course--</option>
            <option value="IT">Information Technology</option>
            <option value="Mech">Mechanical</option>
            <option value="civil">Civil</option>
            <option value="ece">Electronics and Communication</option>
            <option value="cs">Computer Science</option>
        </select>

        <label>12th Marksheet (PDF only)</label>
        <input type="file" name="marksheet" accept=".pdf" required>
        <h6>Max file size: 2MB</h6>

        <label>Passport Size Photo</label>
        <input type="file" name="photo" accept="image/*" required>
        <h6>JPG/PNG only, Max 500KB</h6>

        <label><input type="checkbox" name="check" required> I confirm all information provided is correct</label>

        <div class="form-buttons">
            <input type="submit" name="submit" value="Submit Application">
            <input type="reset" value="Reset Form">
        </div>
    </form>
</div>

<?php include("includes/footer.php"); ?>
