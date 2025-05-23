<?php

$resposta_random = true;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../vida/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Teste de Personalidae</title>
</head>
<body>
<div class="container">
        <nav class="nav-menu">
            <div class="logo">
                <img src="../vida/gggggg.png" alt="Logo">
            </div>
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="menu-content">
                <ul class="nav-list">
                    <li><a href="../vida/index.html">Início</a></li>
                    <li><a href="../vida/profissao.html">Profissão</a></li>
                    <li><a href="teste-de-personalidade-base/index.php">Teste de Personalidade</a></li>
                    <li><a href="../vida/soueu.html">Quem sou eu?</a></li>
                    
                </ul>
            </div>
        </nav>
        <script src="../vida/script.js"></script>
    <?php
        $raw_questions = file_get_contents("http://localhost:14140/api/personality/questions");
        $questions = json_decode($raw_questions, true);
    ?>

    <form class="teste-de-personalidade" action="process_answer.php" method="POST">
        <h3>Selecione seu genero</h3>    
        <div style="display:flex; gap:2rem">
            <div style="display:flex">
                <input type="radio" required name="gender" value="Male">
                <p>Homem</p>
            </div>
            <div style="display:flex">
                <input type="radio" required name="gender" value="Female">
                <p>Mulher</p>
            </div>
            <div style="display:flex">
                <input type="radio" required name="gender" value="Other">
                <p>Outro</p>
            </div>
        </div>

        <?php foreach ($questions as $question): ?>
            <h3><?=$question['text']?></h3>
            <div style="display:flex; gap:2rem; flex-direction: column;">
                <?php 
                $random = rand(-3,3);
                foreach ($question['options'] as $option): ?>
                <div style="display:flex">
                <input required type="radio" name="<?=$question['id']?>" value="<?=$option['value']?>" <?php if($random==$option['value'] && $resposta_random == true){echo "checked";}?>>
                <!-- <?php $number = -3;?>
                <input required type="radio" name="<?=$question['id']?>" value="<?=$option['value']?>" <?php if($number==$option['value']){echo "checked";}?>> -->
                <p><?=$option['text']?></p>
                </div>
                <?php endforeach;?>
            </div>
        <?php endforeach;?>

        <button type="submit">finalizar teste</button>
    </form>

</body>
</html>