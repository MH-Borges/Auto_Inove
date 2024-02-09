<div class="blockContent produtosCategorias">

    <button class="produtos_Btn_CriacaoCateg" type="button" data-toggle="modal" data-target="#ModalLogout">
        <p>Nova categoria</p>
        <img src="../../assets/icons/add.svg" >
    </button>
    <button class="produtos_Btn_CriacaoSubcateg" type="button" data-toggle="modal" data-target="#ModalLogout">
        <p>Nova Sub-categoria</p>
        <img src="../../assets/icons/add.svg" >
    </button>
    <button class="produtos_Btn_ListSubcateg" type="button" data-toggle="modal" data-target="#ModalLogout">
        <p>Listagem de Sub-categorias</p>
        <img src="../../assets/icons/list.svg" >
    </button>

    <h2>Tabela de categorias</h2>

    <table id="CategoriasTable">
        <thead>
            <tr>
                <th>Imgs</th>
                <th>Nome da categoria</th>
                <th>Sub-Categorias atreladas</th>
                <th>Data criação / Ultima alteração</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
                $dados = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i=0; $i < count($dados); $i++) { 
                    
                    $nomeUser = $dados[$i]['nome_Completo'];
                    $temaUser = $dados[$i]['tema'];
                    $emailUser = $dados[$i]['email'];
                    $telUser = $dados[$i]['telefone'];

                    echo "
                        <tr>
                            <td class='imgsCateg'>
                                ".$nomeUser."
                            </td>
                            <td class='nomeCateg'>
                                ".$temaUser."
                            </td>
                            <td class='subCategsCateg'>
                                ".$emailUser."
                            </td>
                            <td class='datasCateg'>
                                ".$telUser."
                            </td>
                            <td class='statusCateg'>
                                ".$telUser."
                            </td>
                            <td class='acoesCateg'>
                                ".$telUser."
                            </td>
                        </tr>
                    ";
                }
            ?>
        </tbody>
    </table>
</div>

<script>
    

</script>