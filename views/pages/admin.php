<?php
if(isset($_SESSION['user']) && $_SESSION['user']->role_name == 'Admin'){
    $categories = getOneTable("categories");
    $messages = getOneTable("messages");
    $survey = getOneTable("survey");
    $usersnumber = count($survey);
    $query = "SELECT * FROM survey WHERE answer = 'yes'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $yes = count($result);
    $no = $usersnumber - $yes;
    $yespercentage = round(($yes/$usersnumber)*100);
    $nopercentage = round(($no/$usersnumber)*100);
?>
<!-- adminpanel -->
<div class="container">
        <form>
        <p class="h1 text-center">Admin panel</p>
        <?php
        if(isset($_SESSION['msg'])):
            $msg = $_SESSION['msg'];
            unset($_SESSION['msg']);
        ?>
        <div id="msg" class="alert alert-success" role="alert"><?= $msg?></div>
        <?php
        endif;
        ?>
        <div class="row">
            <p class="h3">Insert new article:</p>
            
            <div class="col-lg-4">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="title" placeholder=""/>
                    <label for="title">Title</label>
                    <div id="msgtitle">
                <p class="text-danger"> Please provide a valid title.</p>
                </div>
                </div>
                
            </div>
            <div class="col-lg-4 mb-3">
                <div class="form-floating">
                    <select class="form-select" id="category" aria-label="Floating label select example">
                        <option value="0" selected>Choose</option>
                        <?php
                        foreach($categories as $cat):
                        ?>
                        <option value="<?= $cat->id_category?>"><?= $cat->category_name?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                    <label for="category">Category</label>
                </div>
            <div id="msgcategory">
            <p class="text-danger"> Please select a category.</p>
            </div>
            </div>
            <div class="col-lg-4 mb-3">
                <input class="form-control form-control-lg" id="image" type="file">
                <div id="msgimage">
            <p class="text-danger"> Please upload image.</p>
            </div>
            </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="text"></textarea>
                        <label for="text">Text</label>
                    </div>
                    <div id="msgtext"><p class="text-danger"> Please select a category.</p></div>
                </div>
            </div>
        </div>
        <div class="row mt-4 d-flex justify-content-center">
            <div class="col-lg-8">
                <button type="button" id="insertarticle" class="btn btn-outline-primary">Insert article</button>
            </div>
        </div>
        
        <div id="msginsertarticle"></div>
        
</div>
<!-- endadminpanel -->
<hr/>
<!-- insert category -->
<div class="container p-3">
    <div class="h2 text-center m-3">Insert new category</div>
    <div class="row d-flex justify-content-center">
        <div class="col-lg-4">
        <div class="mb-3">
            <input type="text" class="form-control" id="insertcat" />
        </div>
        <button type="button" id="newcategory" class="btn btn-primary">Insert</button>
        </div>
        <div id="msgnewcat">

        </div>
    </div>
</div>
<!-- endinsert -->
<hr/>
<!-- survey -->
<div class="container">
    <div class="h1 text-center m-3">Survey</div>
    <div class="h3 text-center m-3 ">Question:<br/>Do you follow Formula 1?</div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                <th scope="col" class="text-primary fs-1">Number of users</th>
                <th scope="col" class="text-success fs-1">Yes</th>
                <th scope="col" class="text-danger fs-1">No</th>
                </tr>
            </thead>
            <tbody>
                <th scope="row" class="text-primary fs-2"><?= $usersnumber?></th>
                <td class="text-success fs-2"><?= $yespercentage?>%</td>
                <td class="text-danger fs-2"><?= $nopercentage?>%</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
<!-- endsurvey -->
<hr/>
<!-- messages -->
<div class="container p-4">
    <div class="h1 text-center">Messages from users</div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">First name</th>
                <th scope="col">Last name</th>
                <th scope="col">Email</th>
                <th scope="col">Message</th>
                <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $br = 0;
                foreach($messages as $m):
                    $br++;
                ?>
                <tr>
                <th scope="row"><?= $br?></th>
                <td><?= $m->first_name_mess?></td>
                <td><?= $m->last_name_mess?></td>
                <td><?= $m->email_mess?></td>
                <td><?= $m->message?></td>
                <td><button type="button" id="deletemessage" value="<?= $m->id_message?>" class="btn btn-danger">Delete</button> <div id="msgmessagedelete"></div></td>
                </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- endmessages -->
<?php
}else{
    header('Location: index.php?page=home');
}
?>