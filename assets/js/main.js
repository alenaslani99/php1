$(document).ready(function(){
    $("#register").click(registration);
    $("#login").click(login);
    $("#insertarticle").click(insertArticle);
    $("#postcomment").click(postComment);
    $("#updateartical").click(updateArtical);
    $("#deleteartical").click(deleteArtical);
    $("#deletecomment").click(deleteComment);
    $("#sendmessage").click(contact);
    $("#deletemessage").click(deletemessage);
    $("#save").click(survey);
    $("#newcategory").click(insertCategory);
});

function ajaxCallBack(url,method,data,file,result,err){
    if(file == "da"){
        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: "json",
            contentType: false,
            processData: false,
            success: result,
            error: err
        });
    }else{
        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: "json",
            success: result,
            error: err
        });
    }
}

function registration(){
    var name, lastname, username, email, password, confpassword;

    name = $("#name");
    lastname = $("#lastname");
    username = $("#username");
    email = $("#email");
    password = $("#password");
    confpassword = $("#confpassword");

    errors = 0;
    regName = /^[A-ZŠĐČĆŽ][a-zšđžčć]{2,}/; 
    regEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    regPass = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    regUsername = /^[0-9A-Za-z]{6,16}$/;

    if(!regName.test(name.val())){
        errors++;
        name.addClass("border border-danger");
        $("#msgname").css("display", "block");
    }else{
        name.removeClass("border border-danger");
        $("#msgname").css("display", "none");
    }

    if(!regName.test(lastname.val())){
        errors++;
        lastname.addClass("border border-danger");
        $("#msglastname").css("display", "block");
    }else{
        lastname.removeClass("border border-danger");
        $("#msglastname").css("display", "none");
    }

    if(!regUsername.test(username.val())){
        errors++;
        username.addClass("border border-danger");
        $("#msgusername").css("display", "block");
    }else{
        username.removeClass("border border-danger");
        $("#msgusername").css("display", "none");
    }

    if(!regEmail.test(email.val())){
        errors++;
        email.addClass("border border-danger");
        $("#msgemail").css("display", "block");
    }else{
        email.removeClass("border border-danger");
        $("#msgemail").css("display", "none");
    }

    if(!regPass.test(password.val())){
        errors++;
        password.addClass("border border-danger");
        $("#msgpassword").css("display", "block");
    }else{
        password.removeClass("border border-danger");
        $("#msgpassword").css("display", "none");
    }
    
    if(password.val() != confpassword.val()){
        errors++;
        password.addClass("border border-danger");
        confpassword.addClass("border border-danger");
        $("#msgconfpassword").css("display", "block");        
    }else{
        password.removeClass("border border-danger");
        confpassword.removeClass("border border-danger");
        $("#msgconfpassword").css("display", "none");
    }

    if(errors == 0){
        data = {
            fname:name.val(),
            lname:lastname.val(),
            user:username.val(),
            mail:email.val(),
            pass:password.val(),
            confirmpassword:confpassword.val()
        }

        ajaxCallBack("model/doregister.php","POST",data,"0",function(result){
            $("#message").html(`<p class="alert alert-success" role="alert">${result.msg} <p>`);
        },function(err){
            console.log(err);
            $("#message").html(`<p class="alert alert-danger" role="alert">${err.msg} <p>`);
        });
    }

}

function login(){
    var loguser,logpass;

    loguser = $("#logusername");
    logpass = $("#logpassword");

    errors = 0;
    regPass = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    regUsername = /^[0-9A-Za-z]{6,16}$/;

    if(!regPass.test(logpass.val())){
        errors++;
    }
    if(!regUsername.test(loguser.val())){
        errors++;
    }

    if(errors == 0){
        data = {
            loginuser:loguser.val(),
            loginpassword:logpass.val()
        }

        ajaxCallBack("model/dologin.php","POST",data,"0",function(result){
            if(result.msg == "admin"){
                
                    window.location.href = "http://localhost/blogphp1/index.php?page=admin";
            }
            if(result.msg == "user"){
                window.location.href = "http://localhost/blogphp1/index.php";
            }
        }); 
    }else{
        document.getElementById("msssss").innerHTML = `<div class="alert alert-danger" role="alert">    
                                                            Couldn't find your account!
                                                            </div>`;
    }
}

function insertArticle(){
    var title, category, text, image;

    title = $("#title");
    category = $("#category");
    text = $("#text");
    image = $("#image")[0].files[0];

    errors = 0;
    
    if(title.val() == ""){
        errors++;
        title.addClass("border border-danger");
        $("#msgtitle").css("display", "block");
    }else{
        title.removeClass("border border-danger");
        $("#msgtitle").css("display", "none");
    }
    if(text.val() == ""){
        errors++;
        text.addClass("border border-danger");
        $("#msgtext").css("display", "block");
    }else{
        text.removeClass("border border-danger");
        $("#msgtext").css("display", "none");
    }
    if(category.val() == "0"){
        errors++;
        category.addClass("border border-danger");
        $("#msgcategory").css("display", "block");
    }else{
        category.removeClass("border border-danger");
        $("#msgcategory").css("display", "none");
    }
    if(image == null){
        errors++;
        $("#msgimage").css("display", "block");
    }else{
        $("#msgimage").css("display", "none");
    }
    if(errors == 0){
        data = new FormData();
        data.append("title", title.val());
        data.append("category", category.val());
        data.append("text", text.val());
        data.append("image", image);

        // console.log(data);
            ajaxCallBack("model/insertarticle.php","POST",data,"da",function(result){
                $("#msginsertarticle").html(`<p class="alert alert-success" role="alert">${result.msg} <p>`);
            },function(err){
                $("#msginsertarticle").html(`<p class="danger alert-danger" role="alert">${err.msg} <p>`);
            });
    }    
}

function postComment(){
    let comment,user,article;

    comment = $('#comment');
    user = $('#userid');
    article = $('#articleid');

    let errors = 0;

    if(comment.val() == ""){
        errors++;
        comment.addClass('border border-danger');
    }
    if(user.val() == ""){
        errors++;
    }
    if(article.val() == ""){
        errors++;
    }

    if(errors == 0){
        data = {
            comm:comment.val(),
            id:user.val(),
            artid:article.val()
        }

        ajaxCallBack("model/insertcomment.php","POST",data,"0",function(result){
            $('#commess').html(`<p class="alert alert-success" role="alert">${result.msg} <p>`);
        },function(err){
            $('#commess').html(`<p class="alert alert-danger" role="alert">${err.msg} <p>`);
        });
    }
}

function updateArtical(){
    var title, category, text, id, img;

    title = $("#title");
    category = $("#category");
    text = $("#text");
    id = $("#id");
    img = $("#image")[0].files[0];
    imgprev = $("#imgprev");
    errors = 0;
    if(id.val() == 0){
        errors++;
    }
    if(title.val() == ""){
        errors++;
        title.addClass("border border-danger");
        $("#msgtitle").css("display", "block");
    }else{
        title.removeClass("border border-danger");
        $("#msgtitle").css("display", "none");
    }
    if(text.val() == ""){
        errors++;
        text.addClass("border border-danger");
        $("#msgtext").css("display", "block");
    }else{
        text.removeClass("border border-danger");
        $("#msgtext").css("display", "none");
    }
    if(category.val() == "0"){
        errors++;
        category.addClass("border border-danger");
        $("#msgcategory").css("display", "block");
    }else{
        category.removeClass("border border-danger");
        $("#msgcategory").css("display", "none");
    }

    if(id == ""){
        errors++;
    }

    if(errors == 0){
        if(img){
            data = new FormData();
            data.append("title", title.val());
            data.append("category", category.val());
            data.append("text", text.val());
            data.append("image", img);
            data.append("id", id.val());
            data.append("imgprev",imgprev.val());
            ajaxCallBack("model/editartical.php","POST",data,"da",function(result){
                document.getElementById("msgupdate").innerHTML = `<p class="alert alert-success" role="alert">${result.msg} <p>`;
                // $("#msgupdate").html(`<p class="alert alert-success" role="alert">${result.msg} <p>`);
            },function(err){
                document.getElementById("msgupdate").innerHTML = `<p class="alert alert-danger" role="alert">${err.msg} <p>`;
                // $("#msgupdate").html(`<p class="danger alert-danger" role="alert">${err.msg} <p>`);
            });
        }else{
            data = {
                title:title.val(),
                id:id.val(),
                category:category.val(),
                text:text.val()
            }
            ajaxCallBack("model/editartical.php","POST",data,"0",function(result){
                document.getElementById("msgupdate").innerHTML = `<p class="alert alert-success" role="alert">${result.msg} <p>`;
            },function(err){
                document.getElementById("msgupdate").innerHTML = `<p class="alert alert-danger" role="alert">${err.msg} <p>`;
            });
        }
        
    }    
}

function deleteArtical(){
    let art = $("#articalid");
    console.log("asdasdssd");
    errors = 0;
    if(art.val() == ""){
        errors++;
    }

    if(errors == 0){
        data = {
            id:art.val()
        }

        ajaxCallBack("model/deleteartical.php","POST",data,"0",function(result){
            window.location.href = "http://localhost/blogphp1/index.php?page=admin";
            $('#msg').html(`<p class="alert alert-success" role="alert">${result.msg} <p>`);
        },function(err){
            $('#msgdeleteartical').html(`<p class="alert alert-danger" role="alert">${err.msg} <p>`);
        });
    }
}

function deleteComment(){
    let comment = $("#commid");

    errors = 0;

    if(comment.val() == ""){
        errors++;
    }

    if(errors == 0){
        data = {
            id:comment.val()
        }

        ajaxCallBack("model/deletecomment.php","POST",data,"0",function(result){
            $('#deletecomm').html(`<p class="alert alert-success" role="alert">${result.msg} <p>`);
        },function(err){
            $('#deletecomm').html(`<p class="alert alert-danger" role="alert">${err.msg} <p>`);
        });
    }
}

function contact(){
    let fname, lname, email, message, errors, regname, regemail;

    fname = $("#fname");
    lname = $("#lname");
    email = $("#email");
    message = $("#message");

    errors = 0;
    regname = /^[A-ZŠĐČĆŽ][a-zšđžčć]{2,}/; 
    regemail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if(!regname.test(fname.val())){
        errors++;
        fname.addClass("border border-danger");
        $("#msgname").css("display", "block");
    }else{
        fname.removeClass("border border-danger");
        $("#msgname").css("display", "none");
    }
    if(!regname.test(lname.val())){
        errors++;
        lname.addClass("border border-danger");
        $("#msglname").css("display", "block");
    }else{
        lname.removeClass("border border-danger");
        $("#msglname").css("display", "none");
    }
    if(!regemail.test(email.val())){
        errors++;
        email.addClass("border border-danger");
        $("#msgemail").css("display", "block");
    }else{
        email.removeClass("border border-danger");
        $("#msgemail").css("display", "none");
    }
    if(message.val() == ""){
        errors++;
        message.addClass("border border-danger");
        $("#msgmsg").css("display", "block");
    }else{
        message.removeClass("border border-danger");
        $("#msgmsg").css("display", "none");
    }

    if(errors == 0){
        data = {
            fname:fname.val(),
            lname:lname.val(),
            email:email.val(),
            message:message.val()
        }

        ajaxCallBack("model/sendmessage.php","POST",data,"0",function(result){
            document.getElementById("msg").innerHTML = `<p class="alert alert-success" role="alert">${result.msg} <p>`;
            // $('#msg').html(`<p class="alert alert-success" role="alert">${result.msg} <p>`);
        },function(err){
            document.getElementById("msg").innerHTML = `<p class="alert alert-success" role="alert">${err.msg} <p>`;
            // $('#msg').html(`<p class="alert alert-danger" role="alert">${err.msg} <p>`);
        });
    }
    
}

function deletemessage(){
    let id = $("#deletemessage");
    let errors = 0;
    console.log("aaaaaaaaaaaaaa");
    if(id.val() == ""){
        errors++;
    }

    if(errors == 0){
        data = {
            id:id.val()
        }

        ajaxCallBack("model/deletemessage.php","POST",data,"0",function(result){
            window.location.href = "http://localhost/blogphp1/index.php?page=admin";
        },function(err){
            $('#msgmessagedelete').html(`<p class="alert alert-danger" role="alert">${err.msg} <p>`);
        });  

    }
}

function survey(){
    let ss = $("input[type='radio'][name=question]:checked").val(); 

        data = {
            answer:ss
        }
        ajaxCallBack("model/savesurvey.php","POST",data,"0",function(result){
            document.getElementById("msgquestion").innerHTML = `<p class="alert alert-success" role="alert">${result.msg} <p>`;
        },function(err){
            document.getElementById("msgquestion").innerHTML = `<p class="alert alert-danger" role="alert">${err.msg} <p>`;
        });
    
}

function insertCategory(){
    let categoryy, errors;
    categoryy = $("#insertcat");
    errors = 0;
    if(categoryy.val() == ""){
        errors++;
        categoryy.addClass("border border-danger");
    }else{
        categoryy.removeClass("border border-danger");
    }

    if(errors == 0){
        data = {
            category:categoryy.val()
        }
        console.log("asasasas");
        ajaxCallBack("model/insertcategory.php","POST",data,"0",function(result){
            document.getElementById("msgnewcat").innerHTML = `<p class="alert alert-success" role="alert">${result.msg} <p>`;
        },function(err){
            document.getElementById("msgnewcat").innerHTML = `<p class="alert alert-danger" role="alert">${err.msg} <p>`;
        });
    }
    
}