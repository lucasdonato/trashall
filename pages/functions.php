<?php
 
        function db_connect()
        {
            $PDO = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS)or die(mysql_error());
        
            return $PDO;
        }

        function make_hash($str)
        {
            return sha1(md5($str));
        }

        function inserirContatoCondominio($contato,$id_condominio){
                $PDO = db_connect();
                //insere contato
                $sql = "INSERT INTO contato(tipo,descricao,id_condominio) 
                VALUES('EMAIL',:descricao,:id_condominio)";
                $stmt = $PDO->prepare($sql);
                $stmt->bindParam(':descricao', $contato);
                $stmt->bindParam(':id_condominio', $id_condominio); 

                if(!$stmt->execute()){
                    echo($stmt->errorInfo());
                }
        }

        function inserirEnderecoCondominio($cep,$logradouro,$numero,$bairro,$cidade,$estado,$id_condominio){
            $PDO = db_connect();
            $sql = "INSERT INTO endereco(logradouro,bairro,cidade,estado,numero,cep,id_condominio)
            VALUES(:logradouro,:bairro,:cidade,:estado,:numero,:cep,:id_condominio)";

            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':logradouro', $logradouro);
            $stmt->bindParam(':bairro', $bairro);
            $stmt->bindParam(':cidade', $cidade);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':numero', $numero);  
            $stmt->bindParam(':cep', $cep);
            $stmt->bindParam(':id_condominio', $id_condominio);  

            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
        }

        function inserirContatoColetor($contato,$id_coletor){
            $PDO = db_connect();
            //insere contato
            $sql = "INSERT INTO contato(tipo,descricao,id_coletor) 
            VALUES('EMAIL',:descricao,:id_coletor)";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':descricao', $contato);
            $stmt->bindParam(':id_coletor', $id_coletor); 

            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
    }

        function inserirEnderecoColetor($cep,$logradouro,$numero,$bairro,$cidade,$estado,$id_coletor){
            $PDO = db_connect();
            $sql = "INSERT INTO endereco(logradouro,bairro,cidade,estado,numero,cep,id_coletor)
            VALUES(:logradouro,:bairro,:cidade,:estado,:numero,:cep,:id_coletor)";

            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':logradouro', $logradouro);
            $stmt->bindParam(':bairro', $bairro);
            $stmt->bindParam(':cidade', $cidade);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':numero', $numero);  
            $stmt->bindParam(':cep', $cep);
            $stmt->bindParam(':id_coletor', $id_coletor);  

            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
        }

        function desativaUsuario($email_usuario){
            $PDO = db_connect();
            $sql = "UPDATE login SET ativo = '0' WHERE usuario = :email_usuario";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':email_usuario', $email_usuario);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
        }

        function recupera_id_endereco_condominio($id_condominio){
            $PDO = db_connect();
            $sql = "SELECT id_endereco FROM endereco WHERE id_condominio = :id_condominio";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_condominio', $id_condominio);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $dados[0]['id_endereco'];
        }

        function confirma_solicitacao($id_solicitacao){
            $PDO = db_connect();
            $sql = "UPDATE solicitacoes SET situacao = 'CONFIRMADA' WHERE id_solicitacao = :id_solicitacao";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_solicitacao', $id_solicitacao);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
        }


        //dashboard admin
        function total_coletores_dashboard_admin(){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletor FROM coletor_empresa";
            $stmt = $PDO->prepare($sql);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletor'];
        }

        function total_condominio_dashboard_admin(){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_condominio FROM condominio";
            $stmt = $PDO->prepare($sql);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_condominio'];
        }

        function total_solicitacao_rejeitadas_dashboard_admin(){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_solicitacao_rejeitadas FROM solicitacoes WHERE situacao ='REJEITADA'";
            $stmt = $PDO->prepare($sql);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_solicitacao_rejeitadas'];
        }

        function total_solicitacao_emaberto_dashboard_admin(){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_solicitacao_aberto FROM solicitacoes WHERE situacao ='EM ABERTO'";
            $stmt = $PDO->prepare($sql);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_solicitacao_aberto'];
        }

        function total_solicitacoes_dashboard_admin(){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_solicitacao FROM solicitacoes";
            $stmt = $PDO->prepare($sql);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_solicitacao'];
        }

        function total_solicitacoes_confirmadas_dashboard_admin(){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_solicitacao_confirmadas FROM solicitacoes WHERE situacao = 'CONFIRMADA'";
            $stmt = $PDO->prepare($sql);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_solicitacao_confirmadas'];
        }

        function total_coletas_dashboard_admin(){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas FROM coleta_andamento";
            $stmt = $PDO->prepare($sql);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas'];
        }

        function total_coletasConcluidas_dashboard_admin(){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_concluidas FROM coleta_andamento WHERE status='FINALIZADA'";
            $stmt = $PDO->prepare($sql);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_concluidas'];
        }

        function total_coletasCanceladas_dashboard_admin(){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_canceladas FROM coleta_andamento WHERE status='CANCELADA'";
            $stmt = $PDO->prepare($sql);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_canceladas'];
        }

        function total_coletas_andamento_dashboard_admin(){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_andamento FROM coleta_andamento WHERE status='EM ANDAMENTO'";
            $stmt = $PDO->prepare($sql);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_andamento'];
        }



        //dashboard coletor
        function total_coletas_dashboard_coletor($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_coletor FROM coleta_andamento WHERE id_coletor = :id_coletor";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_coletor', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_coletor'];
        }

        function total_coletasFinalizadas_dashboard_coletor($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_coletor FROM coleta_andamento WHERE id_coletor = :id_coletor AND STATUS = 'FINALIZADA'";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_coletor', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_coletor'];
        }

        function total_coletas_andamento_dashboard_coletor($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_coletor FROM coleta_andamento WHERE id_coletor = :id_coletor AND STATUS = 'EM ANDAMENTO'";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_coletor', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_coletor'];
        }
        

        function total_coletasCanceladas_dashboard_coletor($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_coletor FROM coleta_andamento WHERE id_coletor = :id_coletor AND STATUS = 'CANCELADA'";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_coletor', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_coletor'];
        }

        function total_solicitacoes_dashboard_coletor($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_coletor FROM solicitacoes WHERE id_coletor = :id_coletor";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_coletor', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_coletor'];
        }

        function total_solicitacao_emaberto_dashboard_coletor($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_coletor FROM solicitacoes WHERE id_coletor = :id_coletor AND situacao = 'EM ABERTO'";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_coletor', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_coletor'];
        }


        function total_solicitacoes_confirmadas_dashboard_coletor($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_coletor FROM solicitacoes WHERE id_coletor = :id_coletor AND situacao = 'CONFIRMADA'";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_coletor', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_coletor'];
        }

        
        function total_solicitacoes_rejeitadas_dashboard_coletor($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_coletor FROM solicitacoes WHERE id_coletor = :id_coletor AND situacao = 'REJEITADA'";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_coletor', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_coletor'];
        }



        //dashboard condominio

        function total_coletas_dashboard_condominio($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_condominio FROM coleta_andamento WHERE id_condominio = :id_condominio";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_condominio', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_condominio'];
        }

        function total_coletasFinalizadas_dashboard_condominio($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_condominio FROM coleta_andamento WHERE id_condominio = :id_condominio AND STATUS = 'FINALIZADA'";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_condominio', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_condominio'];
        }

        function total_coletas_andamento_dashboard_condominio($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_condominio FROM coleta_andamento WHERE id_condominio = :id_condominio AND STATUS = 'EM ANDAMENTO'";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_condominio', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_condominio'];
        }
        

        function total_coletas_canceladas_dashboard_condominio($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_condominio FROM coleta_andamento WHERE id_condominio = :id_condominio AND STATUS = 'CANCELADA'";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_condominio', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_condominio'];
        }

        function total_solicitacoes_dashboard_condominio($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_condominio FROM solicitacoes WHERE id_condominio = :id_condominio";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_condominio', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_condominio'];
        }

        function total_solicitacao_emaberto_dashboard_condominio($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_condominio FROM solicitacoes WHERE id_condominio = :id_condominio AND situacao = 'EM ABERTO'";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_condominio', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_condominio'];
        }


        function total_solicitacoes_confirmadas_dashboard_condominio($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_condominio FROM solicitacoes WHERE id_condominio = :id_condominio AND situacao = 'CONFIRMADA'";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_condominio', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_condominio'];
        }

        
        function total_solicitacoes_rejeitadas_dashboard_condominio($id){
            $PDO = db_connect();
            $sql = "SELECT COUNT(1) as total_coletas_condominio FROM solicitacoes WHERE id_condominio = :id_condominio AND situacao = 'REJEITADA'";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id_condominio', $id);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_coletas_condominio'];
        }     
?>