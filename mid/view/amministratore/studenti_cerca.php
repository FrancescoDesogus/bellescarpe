<h2 class="icon-title" id="h-cerca">Ricerca Studente</h2>

<div class="input-form">
    <h3>Filtro</h3>
    <form method="post" action="amministratore/studenti_cerca">
        <label for="matricola">Matricola</label>
        <input name="matricola" id="matricola" type="text"/>
        <br/>
        <label for="nome">Cognome</label>
        <input name="nome" id="cognome" type="text"/>
        <br/>
        <label for="nome">Nome</label>
        <input name="nome" id="nome" type="text"/>
        <br/>
        <button type="submit" name="cmd" value="s_cerca">Filtra</button>
    </form>
</div>



<h3>Elenco Studenti</h3>
<?php if (count($el_studenti) == 0) { ?>
    <p>Nessun esame trovato</p>
<? } else { ?>
    <table>
        <thead>
            <tr>
                <th>Matricola</th>
                <th>Cognome</th>
                <th>Nome</th>
                <th>CdL</th>
                <th>Modifica</th>
                <th>Elimina</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($el_studenti as $studente) {
                ?>
                <tr <?= $i % 2 == 0 ? 'class="alt-row"' : '' ?>>
                    <td><?= $studente->getMatricola() ?></td>
                    <td><?= $studente->getCognome() ?></td>
                    <td><?= $studente->getNome() ?></td>
                    <td><?= $studente->getCorsoDiLaurea()->getNome() ?></td>
                    <td>
                        <a href="<?= $url ?>?cmd=s_mod&_imp=obj<?= $studente->getId() ?>" title="Modifica i dati">
                            <img  src="../images/edit-action.png" alt="Modifica">
                        </a>
                    </td>
                    <td>
                        <a href="<?= $url ?>?cmd=s_del&_imp=obj<?= $studente->getId() ?>" title="Elimina l'account">
                            <img  src="../images/delete-action.png" alt="Elimina">
                        </a>
                    </td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
<?php } ?>