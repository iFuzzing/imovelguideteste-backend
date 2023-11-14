<?php

    require 'App/Controllers/Corretor.php';
    require 'App/Models/Corretor.php';

    use App\Models\CorretorModel;
    use App\Controllers\CorretorController;

    session_start();
    $_SESSION['form-response'] = "";

    if(isset($_POST['nome']) && isset($_POST['cpf']) && isset($_POST['creci'])){
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $creci = filter_input(INPUT_POST, 'creci', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(isset($_POST['novo-corretor']) ){
            if(empty($nome) || empty($cpf) || empty($creci)){
                $_SESSION['form-response'] = "Falha ao cadastrar! Preencha todos os campos";
            }else{
                $corretorModel = new CorretorModel();
    
                try{
                    $corretorModel->setName($nome);
                    $corretorModel->setCpf($cpf);
                    $corretorModel->setCreci($creci);
                    CorretorController::create($corretorModel); 
    
                    $_SESSION['form-response'] = "Novo corretor cadastrado";
                }catch(Exception $e){
                    //echo $e->getMessage();
                    if(strstr($e->getMessage(), "Duplicate entry")){
                        $_SESSION['form-response'] = "Já existe um cadastro com pelos menos um dos dados que você preencheu.";
                    }else{
                        $_SESSION['form-response'] = "Não foi possível cadastrar o novo corretor";
                    }
                }
            }
        }else if(isset($_POST['editar-corretor']) && isset($_POST['corretor-id'])){
            $corretorid = filter_input(INPUT_POST, "corretor-id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if(empty($nome) || empty($cpf) || empty($creci) || empty($corretorid)){
                $_SESSION['form-response'] = "Falha ao editar corretor! Os campos precisam estar preechidos";
            }else{
                $corretorModel = new CorretorModel();
    
                try{
                    $corretorModel->setId($corretorid);
                    $corretorModel->setName($nome);
                    $corretorModel->setCpf($cpf);
                    $corretorModel->setCreci($creci);
                    CorretorController::update($corretorModel); 
    
                    $_SESSION['form-response'] = "Edição realizada";
                }catch(Exception $e){
                    //echo $e->getMessage();
                    if(strstr($e->getMessage(), "Duplicate entry")){
                        $_SESSION['form-response'] = "Já existe um cadastro com pelos menos um dos dados que você preencheu.";
                    }else{
                        $_SESSION['form-response'] = "Não foi possível editar este corretor";
                    }
                }
            }

        }
    }

    if(isset($_GET['delete']) && !empty($_GET['delete'])){
        $id = filter_input(INPUT_GET, "delete", FILTER_SANITIZE_NUMBER_INT);
        
        try{
            CorretorController::delete($id);
            $_SESSION['form-response'] = "Corretor deletado";
        }catch(Exception $e){
            //echo $e->getMessage();
            $_SESSION['form-response'] = "Não foi possível deletar esse corretor";
        }
    
    }

    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imóvel Guide Teste Técnico Backend</title>

    <link rel="stylesheet" href="/App/assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="/App/assets/js/main.js"></script>
</head>
<body>
   <main class="main-container">
        <form class="main-form" method="POST" action="/">
            <h2 id="form-title">Cadastro de Corretor</h2>    
            <?php
                if(!empty($_SESSION['form-response']))
                    echo "<span id='form-response'> {$_SESSION['form-response']} </span>";
                
                    $_SESSION['form-response'] = '';
            ?>

            <div class="form-row">
                <input required minlength="14" maxlength="14" onkeydown="cpfMask(event);" class=""  type="text" name="cpf" id="cpf" placeholder="Digite seu CPF">
                <input required minlength="2" class="" maxlength="8"  type="text" name="creci" id="creci" placeholder="Digite seu Creci">
            </div>
            <input required minlength="2" maxlength="64" class=""  type="text" name="nome" id="nome" placeholder="Digite seu nome">
            <input type="hidden" name="corretor-id" id="corretorid" value="">
            <button id="btn-form-action" name="novo-corretor">Enviar</button>
            <button class="hidden" id="btn-form-cancel" onclick="toggleFormMode(event);">Cancelar</button>
        </form>
   </main> 
   <section class="sec-table">
        <table class="view-table">
            <tr class="table-header">
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Creci</th>
                <th>Ação</th>
            </tr>
            <?php foreach(CorretorController::read() as $item => $corretor){ ?>
            <tr>
                <td><?php echo htmlspecialchars($corretor['id']); ?></td>
                <td><?php echo htmlspecialchars($corretor['name']); ?></td>
                <td><?php echo htmlspecialchars($corretor['cpf']); ?></td>
                <td><?php echo htmlspecialchars($corretor['creci']); ?></td>
                <td>
                    <a onclick="toggleFormMode(event, {id: '<?php echo htmlspecialchars($corretor['id'])?>', cpf: '<?php echo htmlspecialchars($corretor['cpf']);?>', creci: '<?php echo htmlspecialchars($corretor['creci'])?>', nome: '<?php echo htmlspecialchars($corretor['name']); ?>'});" class="action-edit" href="#"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a class="action-delete" href="?delete=<?php echo htmlspecialchars($corretor['id'])?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>
            <?php }?>
        </table>
   </section>
   <section class="logic-container">
    <h2>Teste de Lógica</h2>
    <form class="form-logic">
        <div class="info-extract">
            <h4>Extração e consulta</h4>
            <label for="">Link:</label>
            <input type="text" name="info-link" id="info-link" placeholder="https://imovelguide.com.br/imovel/apartamento-com-3-quartos-a-venda-110-m2-em-vila-andrade-sao-paulo/1317073">
            <button onclick="extractInfo(event);">Extrair</button>
            <ul>
                <li><span>Tipo do imóvel:</span> <i id="imovel-tipo"></i></li>
                <li><span>Cidade:</span> <i id="imovel-cidade"></i></li>
                <li><span>Bairro:</span> <i id="imovel-bairro"></i></li>
                <li id="backend-sqlquery"><span>Backend:</span></li>
            </ul>
            
        </div>
    </form>
   </section>
</body>
</html>