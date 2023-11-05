<?php

/**
 * Endpoint FinanceManager.php
 * Created in 2023-11-02 by Luan Fernando
 * HTTP : GET /POST /DELETE / UPDATE
 * */ 

include_once('../connection.php');

 if($_SERVER['REQUEST_METHOD'] === 'GET'){

    if($_GET['action'] == 'infoMensalidade'){
        $idAluno = $_GET['idAluno'];

        if($idAluno > 0){
             
            try {
                    # Lista todos os anos que o aluno tem mensalidades no sistema
                    // Preparar a declaração SQL
                    $stmt = $conn->prepare("SELECT DISTINCT DATE_FORMAT(dataVencimento, '%Y') As year 
                    FROM monthly_payment 
                    WHERE idAluno = ?
                    ORDER BY year DESC ");
            
                    // Vincular os parâmetros
                    $stmt->bind_param("i", $idAluno);

                    // Executar a consulta
                    $stmt->execute();
                
                } catch (\Exception $e) {
                    echo $e;
                }

                // Obter resultados
                $result = $stmt->get_result();
                
                if($result != null){
                    $pago = 0;
                    $pendente = 0;
                    $desconto = 0;

                    # option de anos que contem mensalidades do aluno
                    $optionYear = "<option value=''></option>";
                    while ($row = $result->fetch_assoc()) {
                        $optionYear .= "<option value='{$row['year']}'>{$row['year']}</option>";
                    }
    
                    # Valores Pagos/Pendentes do aluno
                    $queryConsult2 = "SELECT * FROM monthly_payment WHERE idAluno = ?";
                    $stmt2 = $conn->prepare($queryConsult2);
                    $stmt2->bind_param("i", $idAluno);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
    
                    if($result2->num_rows > 0){
                        while ($row = $result2->fetch_assoc()) {
                            
                            if($row['dataPagamento'] != null && $row['idUsuarioBaixa'] != null && $row['status_pagamento'] == 'pago'){
                                $pago += $row['valor'];
                            } else if($row['dataPagamento'] == null && $row['idUsuarioBaixa'] == null && $row['status_pagamento'] == 'pendente'){
                                $pendente += $row['valor'];
                            }
                        }
                    }
                
                    $response = [
                        'warning' => 0, 
                        'error' => 0, 
                        'success' => 1, 
                        'message' => null,
                        'optionYear' => $optionYear, 
                        'pago' => 'R$ '.number_format($pago, 2 , ',' , '.'),
                        'pendente' => 'R$ '.number_format($pendente, 2 , ',' , '.'),
                        'desconto' => 'R$ '.number_format($desconto, 2 , ',' , '.')
                    ];
                    echo json_encode($response);
                } else{
                    $optionYear = "<option value=''></option>";
    
                    // Aluno não tem nenhuma ,mensalidade no sistema
                    $response = [
                        'warning' => 0, 
                        'error' => 0, 
                        'success' => 1, 
                        'message' => null,
                        'optionYear' => $optionYear,
                        'pago' => 0,
                        'pendente' => 0,
                        'desconto' => 0
                    ];
                    echo json_encode($response);
                }

        } else {
            $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => 'Não foi possivel identificar o ID do usuário!'];
            echo json_encode($response);
        }
    } else if($_GET['action'] == 'mensalidadePorAno'){
        $idAluno = $_GET['idAluno'];
        $ano = $_GET['ano'];
        $table = ""; 

        if($idAluno > 0){

            try {
                // Preparar a declaração SQL
                $stmt = $conn->prepare("SELECT 
                mp.id ,
                mp.valor As Valor,
                DATE_FORMAT(mp.dataVencimento ,'%d/%m/%Y') As DataVencimento,
                DATE_FORMAT(mp.dataPagamento ,'%d/%m/%Y') As DataPagamento,
                mp.formaPagamento As FormaPagamento,
                COALESCE((SELECT u.name FROM user u WHERE u.id = mp.idUsuarioBaixa), '') As UsuarioBaixa,
                mp.observacoes As Observacaoes,
                mp.status_pagamento As Status 
                FROM monthly_payment mp
                WHERE mp.idAluno = ? AND DATE_FORMAT(mp.dataVencimento,'%Y') = ?
                ORDER BY mp.id ASC");
        
                // Vincular os parâmetros
                $stmt->bind_param("ii", $idAluno , $ano);

                // Executar a consulta
                $stmt->execute();
            
            } catch (\Exception $e) {
                echo $e;
            }

             // Obter resultados
             $result = $stmt->get_result();
                
             if($result != null){

                $table .= "<table class='table' id='tableMensalidades'>";
                $table .= "<thead>";
                $table .= "<tr>";
                $table .= "<th width='6%'>Data Vencimento</th>";
                $table .= "<th width='6%'>Data Pagamento</th>";
                $table .= "<th width='6%'>Valor (R$)</th>";
                $table .= "<th width='6%'>Forma Pagamento</th>";
                $table .= "<th width='20%'>Usuário Baixa</th>";
                $table .= "<th width='10%'>Observações</th>";
                $table .= "<th width='6%'>Status</th>";
                $table .= "<th width='30%'>Opções</th>";
                $table .= "</tr>";
                $table .= "</thead>";

                $table .= "<tbody>";
                
                while ($row = $result->fetch_assoc()) {

                    $valor = number_format($row['Valor'], 2 , ',' , '.');

                    $table .= "<tr>";
                    $table .= "<td>{$row['DataVencimento']}</td>";
                    $table .= "<td>{$row['DataPagamento']}</td>";
                    $table .= "<td>{$valor}</td>";
                    $table .= "<td>{$row['FormaPagamento']}</td>";
                    $table .= "<td>{$row['UsuarioBaixa']}</td>";
                    $table .= "<td>{$row['Observacaoes']}</td>";
                    $table .= "<td>{$row['Status']}</td>";
                    $table .= "<td class='td-actions'>";
                        $table .= "<a href='#' data-id='{$row['id']}' onclick='pagarMensalidade({$row['id']})' class='btn-mensalidade-pagar'>Pagar</a>";
                        $table .= "<a href='#' data-id='{$row['id']}' onclick='cancelarMensalidade({$row['id']})' class='btn-mensalidade-cancelar'>Cancelar</a>";
                    $table .= "</td>";
                    $table .= "</tr>"; 
                }

                $table .= "</tbody>";
                $table .= "</table>";
             }

             $response = ['warning' => 0, 'success' => 1, 'error' => 0 ,'message' => null , 'table' => $table , 'script' => null];
             echo json_encode($response);

        } else{
            $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => 'Não foi possivel identificar o ID do usuário!'];
            echo json_encode($response);
        }
    } else if($_GET['action'] == 'alertaPendencia'){
        $idAluno = $_GET['idAluno'];
        $dataAtual = date('Y-m-d');
        if($idAluno > 0){

            try {
                // Preparar a declaração SQL
                $stmt = $conn->prepare("SELECT COUNT(mp.id) As qtPendencias
                FROM monthly_payment mp
                WHERE mp.idAluno = ? AND mp.dataVencimento < ? AND mp.status_pagamento = 'pendente' ");
        
                // Vincular os parâmetros
                $stmt->bind_param("is", $idAluno , $dataAtual);

                // Executar a consulta
                $stmt->execute();
            
            } catch (\Exception $e) {
                echo $e;
            }

             // Obter resultados
             $result = $stmt->get_result();

             if($result != null){
                $srcImg = '';

                while ($row = $result->fetch_assoc()) {
                    if($row['qtPendencias'] > 0){
                        if($_GET['pagina'] == 'resumo'){
                            $srcImg = "<img src='../../img/atencao.png' style='width:24px;' title='Mensalidades Pendentes!'>";
                        } else {
                            $srcImg = "<img src='../img/atencao.png' style='width:24px;' title='Mensalidades Pendentes!'>";
                        }    
                    }
               }
            }

             $response = ['warning' => 0, 'success' => 1, 'error' => 0 ,'message' => null ,'srcImg' => $srcImg];
             echo json_encode($response);

        } else {
            $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => 'Não foi possivel identificar o ID do usuário'];
            echo json_encode($response);
        }
    }

 } else if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    // Obtem o corpo da solicitação JSON
    $dataJson = json_decode(file_get_contents("php://input"), true);

    // Verifica se o JSON foi recebido com sucesso
    if($dataJson === false){
        http_response_code(400);//Método erro
        $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => ''];
        echo json_encode($response); 
    }

    if($dataJson['action'] == 'gerarMensalidadeAluno'){
        $numerMensalidade  = $dataJson['numMensalidade']; 
        $valorMensalidade  = $dataJson['valorMensalidade'];
        $dataVencimento    = $dataJson['dataVencimentoBase'];
        $idAluno           = $dataJson['idAluno']; 

        if(empty($numerMensalidade) || empty($valorMensalidade) || empty($dataVencimento) || empty($idAluno) ){
            $response = ['warning' => 1, 'error' => 0, 'success' => 0, 'message' => 'Não foi possivel gerar novas mensalidades, verifique o formulário!'];
            echo json_encode($response);
            
        }else{

            # valida os valores de entrada
            if($numerMensalidade == 0 || $numerMensalidade > 12 || $numerMensalidade == null){
                $response = ['warning' => 1, 'error' => 0, 'success' => 0, 'message' => 'Número de parcelas é inválido!'];
                echo json_encode($response);
                
            }

            # valida data da primeira mensalidade.
            $dataISO1 = $dataVencimento;
            $dataISO2 = date('c'); // data atual
            $timestamp1 = strtotime($dataISO1);
            $timestamp2 = strtotime($dataISO2);

            if($dataVencimento == '' || $dataVencimento == null){
                $response = ['warning' => 1, 'error' => 0, 'success' => 0, 'message' => 'A data fornecida é inválida!'];
                echo json_encode($response);
                
            }

            if($timestamp1 < $timestamp2){
                $response = ['warning' => 1, 'error' => 0, 'success' => 0, 'message' => 'A data fornecida é inválida (data antiga)!'];
                echo json_encode($response);
                
            }

            # valor 
            $valorFormatoSave = str_replace(',' , '.', $valorMensalidade);
            if(floatval($valorFormatoSave) <= 0 ||  floatval($valorFormatoSave) >= 100000){
                $response = ['warning' => 1, 'error' => 0, 'success' => 0, 'message' => "O valor R$ {$valorMensalidade} da mensalidade informado é inválido!"];
                echo json_encode($response);
                
            }

            # resgata a última data de vencimento gereda para o aluno.

            try {
                $stmt = $conn->prepare("SELECT DATE_FORMAT(dataVencimento, '%Y-%m-%d') AS ultimaDataVencimento, id
                                        FROM monthly_payment
                                        WHERE idAluno = ?
                                        ORDER BY id DESC
                                        LIMIT 1;
                                        ");

                // Vincular os parâmetros
                $stmt->bind_param("i", $idAluno);

                // Executar a consulta
                $stmt->execute();
            
            } catch (\Exception $e) {
                echo $e;
            }

            // Obter resultados
            $ultimaDataVencimento = "";
            $result = $stmt->get_result();
            if($result != null){
                while ($row = $result->fetch_assoc()) {
                    $ultimaDataVencimento = $row['ultimaDataVencimento'];
                }
            }

            $totalMensalidadesGeradas = 0;
            $totalMensalidadesNaoGeradas = 0;
            $dataAtualAux2 = date('Y-m-d');
            $timestamp3 = strtotime($dataAtualAux2);
            $timestamp4 = strtotime($ultimaDataVencimento);

            if($ultimaDataVencimento == "" || ($timestamp3 < $timestamp4)){
                // Gera as parcelas normais usando a data selecionada pelo usuario.
                $nMes = 0;
                for ($i=0; $i < $numerMensalidade ; $i++) { 
                    $nMes++;
                    try {
                        $dataAux =  new Datetime("{$dataVencimento}");
                        $dataAux->add(new DateInterval("P{$nMes}M"));
                        $dataVencimentoMensalidade = $dataAux->format('Y-m-d H:i:s');

                        $stmt =  $conn->prepare("INSERT INTO monthly_payment(idAluno,valor,dataVencimento,status_pagamento) 
                        VALUES(? , ?, ?,'pendente')");
                        $stmt->bind_param("iis", $idAluno, $valorFormatoSave, $dataVencimentoMensalidade);
            
                        if($stmt->execute()){
                            $totalMensalidadesGeradas++;
                        }else{
                            $totalMensalidadesNaoGeradas++;
                        }

                    } catch (\Exception $e) {
                        echo $e;
                    }
                }

                $response = [
                'warning' => 0, 
                'error' => 0, 
                'success' => 1, 
                'message' => "Mensalidades geradas com sucesso. Geradas: {$totalMensalidadesGeradas} Não Geradas: {$totalMensalidadesNaoGeradas}"];
                echo json_encode($response);
               

            } else if($ultimaDataVencimento != "" && ($timestamp4 < $timestamp3)){
                // Data atual é menor que a ultima data de vencimento gerada para o aluno

                $quantidadeMensalidadePendentes = 0;

                # valida quantas mensalidades podem ser geradas para não passar o limite de 12 pendentes.
                # quantas mensalidades tem data de vencimento superior a data atual.
                try {
                    $stmt3 = $conn->prepare("SELECT COUNT(id) AS totalRegistros
                    FROM monthly_payment
                    WHERE idAluno = ? AND dataVencimento > CURDATE() AND status_pagamento = 'pendente';
                    ");
    
                    // Vincular os parâmetros
                    $stmt3->bind_param("i", $idAluno);
    
                    // Executar a consulta
                    $stmt3->execute();
                
                } catch (\Exception $e) {
                    echo $e;
                }
               
                $result3 = $stmt3->get_result();
                if($result3 != null){
                    while ($row = $result3->fetch_assoc()) {
                        $quantidadeMensalidadePendentes = $row['totalRegistros'];
                    }
                }
                
                // Gera as parcelas apos a ultima data de vencimento.
                $nMes = 0;
                $somaMensalidades = ($quantidadeMensalidadePendentes + $numerMensalidade);

                if($somaMensalidades > 12){
                    // retorna a diferença que deve ser gerada as mensalidades.
                    $numerMensalidade = (12 - $numerMensalidade);    
                }
                
                for ($i=0; $i < $numerMensalidade ; $i++) { 
                    $nMes++;
                    try {
                        $dataAux =  new Datetime("{$ultimaDataVencimento} 00:00:00");
                        $dataAux->add(new DateInterval("P{$nMes}M"));
                        $dataVencimentoMensalidade = $dataAux->format('Y-m-d H:i:s');

                        $stmt =  $conn->prepare("INSERT INTO monthly_payment(idAluno,valor,dataVencimento,status_pagamento) 
                        VALUES(? , ?, ?,'pendente')");
                        $stmt->bind_param("iis", $idAluno, $valorFormatoSave, $dataVencimentoMensalidade);
            
                        if($stmt->execute()){
                            $totalMensalidadesGeradas++;
                        }else{
                            $totalMensalidadesNaoGeradas++;
                        }

                    } catch (\Exception $e) {
                        echo $e;
                    }
                }

                $response = [
                'warning' => 0, 
                'error' => 0, 
                'success' => 1, 
                'message' => "Mensalidades geradas com sucesso. Geradas: {$totalMensalidadesGeradas} Não Geradas: {$totalMensalidadesNaoGeradas}"];
                echo json_encode($response);
                
            }
                      
        }

    }

 }