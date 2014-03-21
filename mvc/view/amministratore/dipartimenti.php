<h2 class="icon-title" id="h-dip">Dipartimenti</h2>

<div class="input-form">
    <h3>Nuovo Dipartimento</h3>
    <form method="post" action="amministratore/dipartimenti">
        <label for="nome">Nome</label>
        <input name="nome" id="nome" type="text"/>
        <br/>
        <button type="submit" name="cmd" value="dip_crea">Aggiungi</button>
    </form>
</div>



<h3>Elenco Diparitmenti</h3>
<?php if (count($el_dipartimenti) == 0) { ?>
    <p>Nessun dipartimento trovato</p>
<? } else { ?>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Elimina</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($el_dipartimenti as $dipartimento) {
                ?>
                <tr <?= $i % 2 == 0 ? 'class="alt-row"' : '' ?>>
                    <td><?= $dipartimento->getNome() ?></td>
                    <td>
                        <a href="amministratore/dipartimenti?cmd=dip_del&_imp=obj<?=$dipartimento->getId()?>" title="Elimina l'account">
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