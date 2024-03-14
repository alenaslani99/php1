<?php
    if(!isset($_SESSION['user'])){
?>
<!-- login -->
<div class="container">
        <p class="h1 text-center">Login</p>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-4">
                <form>
                <div class="mb-3">
                    <label for="logusername" class="form-label">Username</label>
                    <input type="username" class="form-control" id="logusername">
                    <div id="msgusername">

                    </div>
                </div>
                <div class="mb-3">
                    <label for="logpassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="logpassword">
                    <div id="msgpassword">
                        
                    </div>
                </div>
                <button type="button" class="btn btn-primary" id="login">LogIn</button>
                </form>
                <div id="msssss"></div>
                <div id="msglogin">
                    <?php
                    if(isset($_SESSION['msgregister'])):
                        $msg = $_SESSION['msg'];
                        unset($_SESSION['msgregister']);
                    ?>
                    <div class="alert alert-success" role="alert">
                    <?= $msg?>
                    </div>

                    <?php
                    endif;
                    ?>
                </div>
            </div>
        </div>
</div>
<!-- endlogin -->
<?php
}else{
    header('Location: index.php?page=home');
}
?>