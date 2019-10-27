<?php
        session_start();
        require 'init.php';
        
        if (isset($_POST['txtIdCondominio'])) {
            $id_coletor = $_POST['txtIdCondominio'];
        }      

        /*acontece undefined index somente se não selecionar nenhum material,
        mas, o campo será required no form;*/
        $material = $_POST['checkMaterial'];
        $material_solicitacao =  json_encode($material);   
        $peso_aproximado = $_POST['txtPesoAproximado']; 
        
        $PDO = db_connect();

            $sql = "INSERT INTO solicitacoes(materiais_coletados,id_coletor,id_condominio,data_solicitacao,peso,situacao) 
                VALUES(:materiais_coletados,:id_coletor,:id_condominio,NOW(),:peso,'EM ABERTO')";
            $stmt = $PDO->prepare($sql);
            
            /*define os parametros que serão enviados*/
            $stmt->bindParam(':materiais_coletados', $material_solicitacao);
            $stmt->bindParam(':id_coletor', $id_coletor);
            $stmt->bindParam(':id_condominio', $_SESSION['id_condominio']);
            $stmt->bindParam(':peso', $peso_aproximado );
            if($stmt->execute()){
                /*retorna 1 para que seja tratado o 
                response do ajax*/
                echo "1";
            }else{
                var_dump($stmt->errorInfo());
            }

?>