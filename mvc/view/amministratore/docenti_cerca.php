<h2 class="icon-title" id="h-cerca">Ricerca Docente</h2>

<div class="input-form">
    <h3>Filtro</h3>
    <form method="post" action="amministratore/docenti_cerca">
        <label for="nome">Cognome</label>
        <input name="nome" id="cognome" type="text"/>
        <br/>
        <label for="nome">Nome</label>
        <input name="nome" id="nome" type="text"/>
        <br/>
        <button type="submit" name="cmd" value="d_cerca">Filtra</button>
    </form>
</div>



<h3>Elenco Studenti</h3>
<?php if (count($el_docenti) == 0) { ?>
    <p>Nessun esame trovato</p>
<? } else { ?>
    <table>
        <thead>
            <tr>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Dipartimento</th>
                <th>Modifica</th>
                <th>Elimina</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($el_docenti as $docente) {
                ?>
                <tr <?= $i % 2 == 0 ? 'class="alt-row"' : '' ?>>
                    <td><?= $docente->getCognome() ?></td>
                    <td><?= $docente->getNome() ?></td>
                    <td><?= $docente->getDipartimento()->getNome() ?></td>
                    <td>
                        <a href="<?=$url?>?cmd=d_mod&_imp=obj<?=$docente->getId()?>" title="Modifica i dati">
                            <img  src="../images/edit-action.png" alt="Modifica">
                        </a>
                    </td>
                    <td>
                        <a href="<?=$url?>?cmd=d_del&_imp=obj<?=$docente->getId()?>" title="Elimina l'account">
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