<div class="input-form">
    <h2 class="icon-title" id="h-login">Login</h2>

    <form method="post" action="index.php?page=guest&subpage=prova2&cmd=login">
        <input type="hidden" name="cmd" value="login"/>
    
        <br>
        <label for="user"><strong>Username o email: </strong></label>
        <input class="inputBar" type="text" name="user" id="user"/>
        <br>
        <br>
        <label for="password"><strong>Password: </strong></label>
        <input class="inputBar" type="password" name="password" id="password"/> 
        <br>
        
        <div class="buttonCenter">
            <input class="buttonBigger saveChangesButton" type="submit" value="Login"/>
        </div>
    </form>
</div>




<a href="index.php?page=guest&subpage=registration">Registrati al sito, biach</a>

<br>
<br>

<a href="<?= $loginUrl ?>">Accedi con Facebook, bitch</a>