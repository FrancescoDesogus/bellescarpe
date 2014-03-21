<h2 class="icon-title" id="h-dip">Dipartimenti</h2>

<div class="input-form">
    <h3>Nuovo Corso di Laurea</h3>
    <form method="post" action="amministratore/cdl">
        <label for="nome">Nome</label>
        <input name="nome" id="nome" type="text"/>
        <label for="dipartimento">Dipartimento</label>
        <select name="dipartimento" id="insegnamento">
            <?php foreach ($el_dipartimenti as $dipartimento) { ?>
                <option value="<?= $dipartimento->getId() ?>" ><?= $dipartimento->getNome() ?></option>
            <?php } ?>
        </select>
        <br/>
        <br/>
        <button type="submit" name="cmd" value="cdl_crea">Aggiungi</button>
        <br/>
    </form>
</div>



<h3>Elenco Corsi di Laurea</h3>
<?php if (count($el_cdl) == 0) { ?>
    <p>Nessun Corso di Laurea trovato</p>
<? } else { ?>
    <table>
        <thead>
            <tr>
                <th>Codice</th>
                <th>Nome</th>
                <th>Elimina</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($el_cdl as $cdl) {
                ?>
                <tr <?= $i % 2 == 0 ? 'class="alt-row"' : '' ?>>
                    <td><?= $cdl->getCodice() ?></td>
                    <td><?= $cdl->getNome() ?></td>
                    <td>
                        <a href="amministratore/cdl?cmd=dip_del&_imp=obj<?=$cdl->getId()?>" title="Elimina l'account">
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