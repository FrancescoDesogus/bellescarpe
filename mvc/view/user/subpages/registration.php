<?php 
$myURL = 'http://bellescarpecod.altervista.org/mvc/index.php?page=guest&subpage=registration';
?>

<div class="input-form">
    <h2 class="icon-title h-registration">Registrazione</h2>

    <form method="post" action="visitor/registration_customer">
        <input type="hidden" name="cmd" value="register"/>
    
        <label for="form_username"><strong>Username: </strong></label>
        <input class="inputBar" type="text" name="username" id="form_username" value="<?= $username ?>"/>
        
        <br>
        
        <label for="form_password"><strong>Password: </strong></label>
        <input class="inputBar" type="password" name="password" id="form_password"/> 
        
        <br>
        
        <label for="form_password2"><strong>Ripeti password: </strong></label>
        <input class="inputBar" type="password" name="password2" id="form_password2"/> 
        
        <br>
        
        <label for="form_email"><strong>Email: </strong></label>
        <input class="inputBar" type="email" name="email" id="form_email" value="<?= $email ?>"/> 
        

        <div class="buttonCenter">
            <input class="buttonBigger saveChangesButton" type="submit" value="Registrati"/>
        </div>
    </form>
</div>
