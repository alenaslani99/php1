<div class="container">
    <h1 class="text-center ">Contact us</h1>
    <div class="row d-flex justify-content-center">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <?php 
                        if(isset($_SESSION['user'])):
                        ?>
                        <input type="text" class="form-control" id="fname" value="<?= $_SESSION['user']->name?>"/>
                        <?php
                        else:
                        ?>
                        <input type="text" class="form-control" id="fname"/>
                        <?php
                        endif;
                        ?>
                    </div>
                    <div id="msgname">

                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <?php 
                        if(isset($_SESSION['user'])):
                        ?>
                        <input type="text" class="form-control" id="lname" value="<?= $_SESSION['user']->last_name?>"/>
                        <?php
                        else:
                        ?>
                        <input type="text" class="form-control" id="lname"/>
                         <?php
                        endif;
                        ?>
                    </div>
                    <div id="msglname">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <?php 
                        if(isset($_SESSION['user'])):
                        ?>
                        <input type="email" class="form-control" id="email" value="<?= $_SESSION['user']->email?>"/>
                        <?php
                        else:
                        ?>
                        <input type="email" class="form-control" id="email"/>
                         <?php
                        endif;
                        ?>
                    </div>
                    <div id="msgemail">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="form-floating">
                        <textarea class="form-control" id="message" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                        <label for="message">Message</label>
                    </div>
                </div>
                <div id="msgmsg">

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-3 d-flex justify-content-end">
                     <input type="submit" id="sendmessage" class="btn btn-primary" value="Send message"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="msg"></div>
                </div>
            </div>
        </div>
    </div>
</div>