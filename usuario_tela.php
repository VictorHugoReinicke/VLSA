
  
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

    <div class='row'>
    <div class='col-6'>
    <button type='submit' class='btn btn-outline-primary'>Adicionar Conta</button>
  </div>
  <div class='col-6'>
  <button type='button' class='btn btn-outline-primary'><a class='icon' style='text-decoration:none' href='cad.php?id=" . $key['id'] . "'>Alterar Dados</a></button>
</div>
  </div>
  <div class='row mt-5'>
  <div class='col-1 ms-3'>
    <a style=' color: #000;' href='usuario_acao.php?acao=logout' style='text-decoration:none'><i class='bi bi-box-arrow-left'></i></a>
  </div>
  <div class='col-2'>
    <p>Sair</p>
  </div>
</div>
    </section>

    <section class='col-6 order-1'>
    
    
    <div class='row justify-content-center'>
    <form action='usuario_acao.php' method='post' enctype='multipart/form-data'>
    <div class='col-8'><img src='imgs/{$key['foto']}' alt='PERFIL' width='320px'></div>
    <div class='col-4'>
        <input type='text' class='form-control inputs required' id='id' name='id' placeholder='' hidden value=" . $key['id'] . "'>

        <input type='file' name='foto' id='foto' accept='image/*'>
        </div>
        <div class='col-4'>
        <button type='submit' class='btn btn-outline-primary' name='acao' id='acao' value='fotos'>Adicionar foto</button>
        </div>
        
    </form></div>
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
              <div class='col-6'>
              <button type='submit' class='btn btn-outline-primary'>Adicionar Conta</button>
            </div>
            <div class='col-6'>
              <button type='button' class='btn btn-outline-primary'><a class='icon' style='text-decoration:none' href='cad.php?id=" . $key['id'] . "'>Alterar Dados</a></button>
          </div>
            </div>
            <div class='row mt-5'>
            <div class='col-1 ms-3'>
              <a  style=' color: #000;' href='usuario_acao.php?acao=logout' ><i class='bi bi-box-arrow-left'></i></a>
            </div>
            <div class='col-2'>
              <p>Sair</p>
            </div>
          </div>
              
              </section>
              <section class='col-6 order-1'>
              <div class='row justify-content-center'>
                  <div class='col-8'>
                  <i class='bi bi-person-plus-fill' alt='foto de perfil' style='font-size:170px'></i>
                  </div>
              </div>
              <div class=''><div class='col-6 '>
    <form action='usuario_acao.php' method='post' enctype='multipart/form-data'>

        <input type='text' class='form-control inputs required' id='id' name='id' placeholder='' hidden value=" . $key['id'] . ">

        <input type='file' name='foto' id='foto' accept='image/*'>
        <br>
        <button type='submit' class='btn btn-outline-primary' name='acao' id='acao' value='fotos'>Adicionar foto</button>
    </form></div>
                  </div>
                  </section>
                  </div>
              
    ";
  }
}
?>