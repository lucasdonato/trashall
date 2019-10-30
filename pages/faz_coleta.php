<?php
    session_start();
    require 'init.php';

    $id_solicitacao =  $_POST['id_solicitacao'];
    echo "id da solicitacao => ". $id_solicitacao;

    /*USA O ID DA SOLICITACAO PARA
    CRIAR UMA COLETA EM ANDAMENTO*/

?>