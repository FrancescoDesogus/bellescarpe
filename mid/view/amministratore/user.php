<h2 class="icon-title" id="h-dip">Utenti</h2>

<div class="input-form">
    <h3>Nuovo Utente</h3>
    <form method="post" action="amministratore/user">
        <label for="nome">Nome</label>
        <input name="nome" id="nome" type="text"/>
        <label for="cognome">Cognome</label>
        <input name="cognome" id="cognome" type="text"/>
        <label for="user">Username</label>
        <input name="user" id="user" type="text"/>
        <label for="password">Password</label>
        <input name="password" id="password" type="password"/>
        <label for="ruolo">Ruolo</label>
        <select name="dipartimento" id="insegnamento">
            <option value="studente">Studente</option>
            <option value="docente">Docente</option>
            <option value="amministratore">Amministratore</option>
        </select>
        <label for="dipartimento">Dipartimento</label>
        <select name="dipartimento" id="insegnamento">
            <option value="-1">Nessun dipartimento</option>
            <?php foreach ($el_dipartimenti as $dipartimento) { ?>

                <option value="<?= $dipartimento->getId() ?>" ><?= $dipartimento->getNome() ?></option>
            <?php } ?>
        </select>
        <label for="cdl">Corso di Laurea</label>
        <select name="cdl" id="insegnamento">
            <option value="-1">Nessun Corso di Laurea</option>
            <?php foreach ($el_cdl as $cdl) { ?>
                <option value="<?= $cdl->getId() ?>" ><?= $cdl->getNome() ?></option>
            <?php } ?>
        </select>
        <br/>
        <button type="submit" name="cmd" value="cdl_crea">Aggiungi</button>
    </form>
</div>
