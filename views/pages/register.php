<?php
    if(!isset($_SESSION['user'])){
?>
<!-- register -->
<div class="container">
        <p class="h1 text-center">Register</p>
        <form>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" />
                <div id="msgname">
                    <p class="text-danger"> Please provide a valid name.</p>
                </div>
            </div>
            <div class="col-lg-3">
                <label for="lastname" class="form-label">Last name</label>
                <input type="text" class="form-control" id="lastname" />
                <div id="msglastname">
                <p class="text-danger"> Please provide a valid last name.</p>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" />
                <div id="msgusername">
                <p class="text-danger"> Please provide a valid username.</p>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" />
                <div id="msgemail">
                <p class="text-danger"> Please provide a valid email.</p>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" />
                <div id="msgpassword">
                <p class="text-danger"> Please provide a valid password.</p>
                </div>
            </div>
            <div class="col-lg-3">
                <label for="confpassword" class="form-label">Confirm password</label>
                <input type="password" class="form-control" id="confpassword" />
                <div id="msgconfpassword">
                <p class="text-danger"> Passwords do not match.</p>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center mt-4">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary" id="register">Register</button>
            </div>
            <div id="message"></div>
        </div>
    </form>
</div>
<!-- endregister -->

<?php
}else{
    header('Location: index.php?page=home');
}
?>