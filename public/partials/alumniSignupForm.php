<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="signup-form">
    <div class="container-fluid">
        <div class="row">
            <div class="mb-3">
                <label class="form-label" for="displayName">Display Name</label>
                <input class="form-control w-25" type="text" id="displayName" name="displayName" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input class="form-control w-25" type="text" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="graduationYear">High School Graduation Year</label>
                <input class="form-control w-25" type="text" id="graduationYear" name="graduationYear" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="college">College Attended(blank if N/A)</label>
                <input class="form-control w-25" type="text" id="college" name="college">
            </div>
            <div class="mb-3">
                <label class="form-label" for="job">Job(blank if N/A)</label>
                <input class="form-control w-25" type="text" id="job" name="job">
            </div>
            <div class="mb-3">
                <label class="form-label" for="areaOfExpertise">Area of Interest</label>
                <select class="w-25" id="areaOfExpertise" name="areaOfExpertise" style="display: block">
                    <option value="Sciences">Sciences</option>
                    <option value="Arts">Arts</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Humanities">Humanities</option>
                    <option value="Skilled Trades">Skilled Trades</option>
                    <option value="Athletics">Athletics</option>
                    <option value="Other">Other</option>
                    <option value="Undecided">Undecided</option>
                </select>
            </div>
            <br>
            <div class="mb-3">
                <input class="w-10" type="submit" name="submitAlumniSignupForm" value="Submit">
            </div>
        </div>
    </div>
</form>