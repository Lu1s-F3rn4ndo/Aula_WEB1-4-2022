<?php
    session_start();

    include 'cox/parametros.php';
    include 'cox/conexao.php';

//    include 'home.php';
?>

<?php                    
                    
                    $sql = "SELECT * FROM meu_commerce.categorias WHERE categoria_pai is null";
                    $consulta = $conexao->prepare($sql);
                    $consulta->execute();

                    foreach($consulta as $linha){?>
                    <a href="?categoria=<?php echo $linha['id'];?>">
                        <div class="item-menu"><?php echo $linha['descricao'];?></div>
                    </a>
                    <?php
                        //listar as sub-categorias
                        $sql_itens = "SELECT * FROM meu_commerce.categorias WHERE categoria_pai = ".$linha['id'];
                        $subitens = $conexao->prepare($sql_itens);
                        $subitens->execute();
                        foreach($subitens as $item){?>
                    - <a href="?categoria=<?php echo $item['id'];?>"><?php echo $item['descricao'];?></a><br>
                    <?php
                        }
                    }
                    ?>

                    <?php
                    if(isset($_GET['categoria'])){
                        $sql = "SELECT p.id as id_produto, p.categoria_id, p.imagem, p.descricao, p.resumo, c.categoria_pai, c.id as  id_categoria
                        FROM produtos p
                        INNER JOIN categorias c
                        ON p.categoria_id = c.categoria_pai OR p.categoria_id = c.id
                        WHERE p.categoria_id = {$_GET['categoria']} OR c.categoria_pai = {$_GET['categoria']}
                        ORDER BY RAND()";
                    }
                    else {
                        $sql = "SELECT p.id as id_produto, p.categoria_id, p.imagem, p.descricao, p.resumo FROM produtos p ORDER BY RAND()";
                    }
                    $consulta = $conexao->prepare($sql);
                    $consulta->execute();
                   
                    foreach($consulta as $linha){?>

                    <div class="card" style="width: 18rem;">
                        <img src="<?php echo $linha['imagem'];?>" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $linha['descricao'];?></h5>
                            <p class="card-text"><?php echo $linha['resumo']?></p>

                        </div>
                    </div>
                    <?php
                    }
                ?>

                <?php
$sql_produto = 'SELECT * from produtos where id = :id';
$produto = $conn->prepare($sql_produto);
$produto->execute(['id' => $_GET['id']]);
$produto_detalhes = $produto->fetch();
?>
<h1><?php echo $produto_detalhes['descricao']; ?></h1>

<a class="btn btn-success" href="?pagina=sacola">
    Sacola

    <?php if (isset($_SESSION['sacola'])) {
        echo '(' . count($_SESSION['sacola']) . ')';
    } ?>
</a>
<?php if (isset($_SESSION['autenticado'])) { ?>
<a class="btn btn-info" href="?pagina=meus_pedidos">Meus pedidos</a>
<?php }
?>