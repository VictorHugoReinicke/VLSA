
  
<?php

function desenhar_tabela_usuario()
{

  $dados = json_decode(file_get_contents('usu.json'), true);

  foreach ($dados as $key) {
    if (isset($key['id']))
      if ($key['id'] === $_SESSION['user'])
        if ($key['foto'] != null)


          echo "<div class='row'><section class='col-6 order-0'><div class='row ms-3'>
    <div class='col-6'>
    <h6>Nome de Usuário</h6>
    <p>{$key['usuario']}</p>
    </div>
    <div class='col-6'>
    <h6>Nome</h6>
   <p>{$key['nome']}</p>
    </div>
    <div class='col-6'>
    </div>
    </div> 
    <div class='row mt-3 ms-3'>
    <div class='col-6'>
    <h6>CPF</h6>
    <p>{$key['cpf']}</p>
    </div>
    <div class='col-6'>
    <h6>RG</h6>
    <p>{$key['rg']}</p>
    </div>
    <div>
    <div class='row mt-3'>
    <div class='col-6'>
    <h6>Email</h6>
    <p>{$key['email']}</p>
    </div>
    </div>
    <div class='row mt-4'>
    <div class='col-5'>
    <button type='submit' class='btn btn-outline-primary'>Adicionar Conta</button>
  </div>
  <div class='col-5'>
    <button type='button' class='btn btn-outline-primary'><a style='text-decoration:none' href='cad.php?id=" . $key['id'] . "'>Alterar Dados</a></button>
</div>
  </div>
  <div class='row mt-5'>
  <div class='col-3 ms-3'>
    <a href='usuario_acao.php?acao=logout' style='text-decoration:none'><i class='bi bi-box-arrow-left'></i></a>
  </div>
  <div class='col-2'>
    <p>Sair</p>
  </div>
</div>
    </section>

    <section class='col-6 order-1'>
    <div class='row'><div class='col-6'>
    <img src='imgs/{$key['foto']}' alt='PERFIL' width='320px'></div></div>
    <div class='row'><div class='col-6'><a role='button' class='btn btn-outline-primary' href='pagfoto.php?id=" . $key['id'] . "'> Adicionar Foto    
    </a></div></div>
    </section>
    ";

        else

          echo "
        <div class='row'>
          <section class='col-6 order-0'>
            <div class='row ms-3'>
              <div class='col-6'>
                   <h6>Nome de Usuário</h6>
                   <p>{$key['usuario']}</p>
               </div>
              <div class='col-6'>
                    <h6>Nome</h6>
                    <p>{$key['nome']}</p>
              </div>
              <div class='col-6'>
              </div>
              </div> 
              <div class='row mt-3 ms-3'>
                <div class='col-6'>
                    <h6>CPF</h6>
                    <p>{$key['cpf']}</p>
                </div>
                <div class='col-6'>
                    <h6>RG</h6>
                    <p>{$key['rg']}</p>
                </div>
                <div>
              <div class='row mt-3'>
                  <div class='col-6'>
                  <h6>Email</h6>
                  <p>{$key['email']}</p>
                  </div>
              </div>
              <div class='row mt-4'>
              <div class='col-5'>
              <button type='submit' class='btn btn-outline-primary'>Adicionar Conta</button>
            </div>
            <div class='col-5'>
              <button type='button' class='btn btn-outline-primary'><a class='icon' href='cad.php?id=" . $key['id'] . "'>Alterar Dados</a></button>
          </div>
            </div>
            <div class='row mt-5'>
            <div class='col-3 ms-3'>
              <a href='usuario_acao.php?acao=logout' style='text-decoration:none'><i class='bi bi-box-arrow-left'></i></a>
            </div>
            <div class='col-2'>
              <p>Sair</p>
            </div>
          </div>
              
              </section>
              <section class='col-6 order-1'>
              <div class='row justify-content-center'>
                  <div class='col-8'>
                  <i class='bi bi-person-plus-fill' alt='foto de perfil' style='font-size:230px'></i>
                  </div>
              </div>
              <div class='row justify-content-center'>
                  <div class='col-6'><a role='button' class='btn btn-outline-primary' href='pagfoto.php?id=" . $key['id'] . "'> Adicionar Foto  </a>  
                  </a>
                  </div>
                  </div>
                  </section>
                  </div>
              
    ";



    //         echo " <img class='border border-dark border-3' src='imgs/{$key['foto']}' alt='PERFIL' width='320px'>";
    // echo "<a role='button' href='cad.php?id=" . $key['id'] . "';>A</a>";
    // echo "<a role='button' href=javascript:excluirRegistro('usuario_acao.php?acao=excluir&id=" . $key['id'] . "');>E</a>";





    //             echo "

    //                      <p>Nome de Usuário<p>
    //                     <p>{$key['usuario']}</p>
    //                     <p>E-mail</p>
    //                       <p>{$key['email']}</p>
    //                       <p>CPF</p>
    //                       <p>{$key['cpf']}</p>
    //                       <p>RG</p>
    //                       <p>{$key['rg']}</p>
    //                       <p>Excluir</p>
    //                       <p><img src='imgs/{$key['foto']}' alt='PERFIL' width='50%'></p>
    //                       <p align='center'><a role='button' href='cad.php?id=" . $key['id'] . "';>A</a></p>

    //                       <p align='center'><a role='button' href=javascript:excluirRegistro('usuario_acao.php?acao=excluir&id=" . $key['id'] . "');>E</a></p>
    //                       <p align='center'><a role='button' href='pagfoto.php?id=" . $key['id'] . "';>PáginaFoto</a></p>
    //                   </tr>";
    //             // else
    //             echo "<tr><p>{$key['nome']}</p>
    //             <p>{$key['usuario']}</p>
    //             <p>{$key['email']}</p>
    //             <p>{$key['cpf']}</p>
    //             <p>{$key['rg']}</p>
    //             <p>Não adicionada</p>
    //             <p align='center'><a role='button' href='cad.php?id=" . $key['id'] . "';>A</a></p>

    //            <a role='button' href=javascript:excluirRegistro('usuario_acao.php?acao=excluir&id=" . $key['id'] . "');>E</a>
    //            <a role='button' href='pagfoto.php?id=" . $key['id'] . "';>PáginaFoto</a>
    //         </tr>";
  }
}
