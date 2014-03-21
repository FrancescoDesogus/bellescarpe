<ul>
    <li class="<?= strpos($vd->getPagina(), 'amministratore') !== false && 
        ($vd->getSottoPagina() == null ||
         $vd->getSottoPagina() == 'home') ? 'current_page_item' : '' ?>"><a  href="amministratore">Home</a></li>
    <li class="<?= strpos($vd->getSottoPagina(),'docenti_cerca') !== false || 
        strpos($vd->getPagina(),'docente') !== false ? 'current_page_item' : ''?>"><a href="amministratore/docenti_cerca" >Docenti</a></li>
    <li class="<?= strpos($vd->getSottoPagina(),'studenti_cerca') !== false || 
        strpos($vd->getPagina(),'studente') !== false ? 'current_page_item' : ''?>"><a href="amministratore/studenti_cerca" >Studenti</a></li>
    <li class="<?= strpos($vd->getPagina(),'amministratore') !== false && 
        strpos($vd->getSottoPagina(),'dipartimenti') !== false ? 'current_page_item' : ''?>"><a  href="amministratore/dipartimenti">Dipartimenti</a></li>
    <li class="<?= strpos($vd->getPagina(),'amministratore') !== false &&
        strpos($vd->getSottoPagina(), 'cdl') !== false ? 'current_page_item' : ''?>"><a  href="amministratore/cdl">CdL</a></li>
    <li class="<?= strpos($vd->getPagina(),'amministratore') !== false &&
        strpos($vd->getSottoPagina(), 'user') !== false ? 'current_page_item' : ''?>"><a  href="amministratore/user">Utenti</a></li>
    <li class="<?= strpos($vd->getPagina(),'amministratore') !== false && 
        strpos($vd->getSottoPagina(), 'esami') !== false ? 'current_page_item' : ''?>"><a  href="amministratore/esami">Elenco Esami</a></li>
    
</ul>