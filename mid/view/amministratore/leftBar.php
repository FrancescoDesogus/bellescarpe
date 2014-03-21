<h2 class="icon-title">Amministratore</h2>
<ul>
    <li ><a  href="amministratore">Home</a></li>
    <li ><a href="amministratore/docenti_cerca" >Docenti</a></li>
    <li ><a href="amministratore/studenti_cerca" >Studenti</a></li>
    <li ><a  href="amministratore/dipartimenti">Dipartimenti</a></li>
    <li ><a  href="amministratore/cdl">CdL</a></li>
    <li ><a href="amministratore/user">Nuovo Utente</a></li>
    <li ><a  href="amministratore/esami">Elenco Esami</a></li>

</ul>

<?php
switch ($user->getRuolo()) {
    case User::Studente:
        include_once 'view/studente/leftBar.php';
        break;
    case User::Docente:
        include_once 'view/docente/leftBar.php';
        break;
}
?>


