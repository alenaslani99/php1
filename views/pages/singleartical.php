<?php
    if(isset($_GET['id'])):
    $id = $_GET['id'];
    $artical = getArticles($id);
?>

<!-- article -->
<div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-lg-12">
                        <img src="assets/images/<?= $artical->src?>" class="img-fluid border border-dark border-2" alt="car1"/>
                    </div>
                    <div class="col-lg-12">   
                        <?php
                        if(isset($_SESSION['user']) && $_SESSION['user']->role_name == "Admin"):
                        ?>
                        <div class="container mt-2">
                        <a href="index.php?page=editarticle&id=<?= $id?>" class="btn btn-primary">Edit</a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletearticalmodal">Delete</button>
                        <div class="modal fade " id="deletearticalmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete artical</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete artical?
                                    <div id="msgdeleteartical"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" href="func/deleteartical.php" id="deleteartical" class="btn btn-danger">Delete</button>
                                    <input type="hidden" id="articalid" value="<?= $id?>"/>
                                </div>
                                </div>
                            </div>
                        </div>

                        </div>
                        
                        <?php
                        endif;
                        ?>
                        <p class="fw-light m-0"><?= $artical->created_at?></p>
                        <p class="fw-normal m-0"><?= $artical->name?> <?= $artical->last_name?></p>
                        <p class="fs-4 fw-bold"><?= $artical->title?></p>
                        <hr/>
                        <p class="lh-sm"><?= $artical->article_text?></p>
                        <hr/>
                    </div>
                    <div class="col-lg-12">
                        <p class="h3">Comments</p>
                        <div class="form-floating">
                        <?php
                        if(isset($_SESSION['user'])):
                            if($_SESSION['user']->role_name == 'User'):
                        ?>
                        <textarea class="form-control" placeholder="Leave a comment here" id="comment"></textarea>
                        <label for="floatingTextarea">Comments</label>
                        <input type="hidden" id="articleid" value="<?= $artical->id_article?>"/>
                        <input type="hidden" id="userid" value="<?= $_SESSION['user']->id_user?>" />
                        <button type="submit" id="postcomment" class="btn btn-warning mt-2">Post comment</button>
                        <?php
                        endif;
                        endif;
                        ?>
                        <div id="commess"></div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-2">
                        <?php
                        $comments = getComments($id);
                        if(count($comments) == 0):
                        ?>
                        <p class="fs-5 text-success-emphasis">Be the first to comment.</p>
                        <?php
                        endif;
                        foreach($comments as $c):
                        ?>
                        
                        <?php
                        if(isset($_SESSION['user'])):
                        if($_SESSION['user']->role_name == 'Admin' || $_SESSION['user']->username == $c->username):
                        ?>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletecomment">Delete comment</button>
                        <div class="modal fade " id="deletecomment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete comment</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete comment?
                                    <div id="deletecomm"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" href="" id="deletecomment" class="btn btn-danger">Delete</button>
                                    <input type="hidden" id="commid" value="<?= $c->id_comment?>"/>
                                </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        endif;
                        endif;
                        ?>
                        <p class="fw-normal m-0"><strong><?= $c->username?>:</strong> <?= $c->comment?></p>
                        <hr>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
            
    </div>
    <!-- endarticle -->
<?php
endif;
?>