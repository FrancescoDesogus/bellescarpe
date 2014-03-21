<h1>EsAMMi</h1>
<p>Super User - <?= $_SESSION[BaseController::user]->getNome().' '.$_SESSION[BaseController::user]->getCognome() ?></p>
<p class="logout">
    <a href="amministratore?cmd=logout">Logout</a>
</p>