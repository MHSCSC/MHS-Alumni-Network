<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="signup-form">
    <div class="container">
        <div class="row">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <h2>Create Account</h2>
                <p>Which type of account do you want to <b>create</b>?</p>
                <input class="w-25 m-2" type="submit" id="studentButton" name="studentButton" value="Student">
                <input class="w-25 m-2" type="submit" id="alumniButton" name="alumniButton" value="Alumni">
            </div>
        </div>
    </div>
</form>