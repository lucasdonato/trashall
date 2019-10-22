<?php
    session_start();

    require 'init.php';
    if (isset($_POST['txtPesoAproximado'])) {

        $id_coletor = $_POST['txtIdCondominio'];
        echo "aquiiiiiiiiii".$id_coletor;
        $material = $_POST['checkMaterial'];
        $material_solicitacao =  json_encode($material);
        
        $PDO = db_connect();

       /*RECUPERA O ID DO CONDOMINIO PARA REALIZAR A
       SOLICITAÇÃO DA COLETA*/
        $sql_consulta_login_email = "SELECT id_condominio FROM condominio
                                     WHERE login_usuario = :login_usuario";

        $stmt = $PDO->prepare($sql_consulta_login_email);
        $stmt->bindParam(':login_usuario', $_SESSION['email']);
        $stmt->execute();
    
        if($stmt->execute()){ //se encontrou o id, vamos inserir na tabela de solicitações
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $id_condominio =  $users[0]['id_condominio'];

            $sql = "INSERT INTO solicitacoes(materiais_coletados,id_coletor,id_condominio,data_solicitacao,peso) 
                VALUES(:id_coletor,:id_empresa,NOW(),:peso)";
            $stmt = $PDO->prepare($sql);
            
            /*define os parametros que serão enviados*/
            $stmt->bindParam(':materiais_coletados', $material_solicitacao);
            $stmt->bindParam(':id_coletor', $id_coletor);
            $stmt->bindParam(':id_condominio', $id_condominio );
            $stmt->bindParam(':peso', $peso_aproximado );
            $stmt->execute();

            if($stmt->execute()){

                echo "execou essa merda";
            }else{
                echo "nao executou";
            }

        }
        
    }

?>