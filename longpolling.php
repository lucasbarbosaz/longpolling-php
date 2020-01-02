<?php
    // Created by Lucas
    $timestart = time(); // tempo que inicia o codigo
    $pdo = new PDO('mysql:host=localhost;dbname=testes', 'root', '');

    if(isset($_POST['timestamp'])){
        $timestamp = $_POST['timestamp'];
    }else{
        $pega_time = $pdo->prepare("SELECT NOW() as now"); // pegando tempo real do sql
        $pega_time->execute();
        $row = $pega_time->fetchObject();

        $timestamp = $row->now;
    }

    $sql = $pdo->prepare("SELECT * FROM `notificacoes` WHERE timestamp > '$timestamp'");


    $newData = false;
    $notificacoes = array();

    while(!$newData && (time()-$timestart)<20){ // se nao existir dados novos e o tempo nao terminou ainda
        $sql->execute();

        while($row = $sql->fetchAll(PDO::FETCH_ASSOC)){ // enquanto existir um registro
            $notificacoes = $row;
            $newData = true;
        }

        usleep(500000); // equivale a 0.5 segundos, a cada meio segundo o servidor vai "descansar"
                        // para o servidor nao se sobrecarregar
    }
    // Caso o tempo de 20 segundos tiver acabado:
    $pega_time = $pdo->prepare("SELECT NOW() as now");
    $pega_time->execute();
    $row = $pega_time->fetchObject();

    $timestamp = $row->now;
    $data = array('notificacoes' => $notificacoes, 'timestamp' => $timestamp);
    echo json_encode($data);
    exit;
?>
