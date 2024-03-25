<link rel="stylesheet" href="css/usu.css">
<?php

function desenhar_tabela_usuario()
{
  define('USUARIO', 'root');
  define('SENHA', '');
  define('HOST', 'localhost');
  define('PORT', '3306');
  define('DB', 'mydb');
  define('DSN', 'mysql:host=' . HOST . ';port=' . PORT . ';dbname=' . DB . ';charset=UTF8');
  $conexao  = new PDO(DSN, USUARIO, SENHA);
  $idUsuarios = $_SESSION['user'];
  $sql = "SELECT * from usuarios WHERE idUsuarios = :idUsuarios ";

  $comando = $conexao->prepare($sql);
  $comando->bindValue(':idUsuarios', $idUsuarios);

  // $dados = json_decode(file_get_contents('usu.json'), true);

  $comando->execute();
  if ($comando->rowCount() > 0) {
    $lista = $comando->fetchAll();
    foreach ($lista as $key) {
      if (isset($key['idUsuarios']))
        if ($key['Imagem'] != null)


          echo "<div class='row'><section class='col-6 order-0'><div class='row ms-3'>
    <div class='col-6'>
    <h6>Nome de Usuário</h6>
    <p>{$key['Nome_usuario']}</p>
    </div>
    <div class='col-6'>
    <h6>Nome</h6>
   <p>{$key['Nome']}</p>
    </div>
    <div class='col-6'>
    </div>
    </div> 
    <div class='row mt-3 ms-3'>
    <div class='col-6'>
    <h6>CPF</h6>
    <p>{$key['CPF']}</p>
    </div>
    <div class='col-6'>
    <h6>RG</h6>
    <p>{$key['RG']}</p>
    </div>
    <div>
    <div class='row mt-3'>
    <div class='col-6'>
    <h6>Email</h6>
    <p>{$key['Email']}</p>
    </div>
    </div>

    <div class='row'>
    <div class='col-6'>
    <button type='submit' class='btn btn-outline-primary'>Adicionar Conta</button>
  </div>
  <div class='col-6'>
  <button type='button' class='btn btn-outline-primary'><a class='icon' style='text-decoration:none' href='cad.php?id=" . $key['idUsuarios'] . "'>Alterar Dados</a></button>
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
    <div class='col-8'>

    <label class='picture' for='foto' tabIndex='0'>
    <span class='picture__image '><img src='imgs/{$key['Imagem']}' alt='PERFIL' style='width: 300px; height: 300px; object-fit:cover ' class='img-thumbnail roudend-1 border-1 border-dark '></span>
  </label>

    
    </div>
    <div class='row justify-content-end me-4 mt-2'>
    <div class='col-6 mb-5'>
    <button type='submit' class='btn btn-outline-primary' name='acao' id='acao' value='fotos'>Adicionar foto</button>
    <input type='text' class='form-control inputs required' id='id' name='id' placeholder='' hidden value=" . $key['idUsuarios'] . ">

    <input type='file' name='foto' id='foto' accept='image/*' hidden>
     </div>
    </div>   
</form>
    </section>
    ";

        else

          echo "
        <div class='row'>
          <section class='col-6 order-0'>
            <div class='row ms-3'>
              <div class='col-6'>
                   <h6>Nome de Usuário</h6>
                   <p>{$key['Nome_usuario']}</p>
               </div>
              <div class='col-6'>
                    <h6>Nome</h6>
                    <p>{$key['Nome']}</p>
              </div>
              <div class='col-6'>
              </div>
              </div> 
              <div class='row mt-3 ms-3'>
                <div class='col-6'>
                    <h6>CPF</h6>
                    <p>{$key['CPF']}</p>
                </div>
                <div class='col-6'>
                    <h6>RG</h6>
                    <p>{$key['RG']}</p>
                </div>
                <div>
              <div class='row mt-3'>
                  <div class='col-6'>
                  <h6>Email</h6>
                  <p>{$key['Email']}</p>
                  </div>
              </div>
              <div class='row mt-4'>
              <div class='col-6'>
              <button type='submit' class='btn btn-outline-primary'>Adicionar Conta</button>
            </div>
            <div class='col-6'>
              <button type='button' class='btn btn-outline-primary'><a class='icon' style='text-decoration:none' href='cad.php?id=" . $key['idUsuarios'] . "'>Alterar Dados</a></button>
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
                  
                  <label class='picture' for='foto' tabIndex='0'>
                  <span class='picture__image'>
                  <i class='bi bi-person-plus-fill' alt='foto de perfil' style='font-size:170px'></i>
                  </span>
                 
                </label>
                
               
                  
                  </div>
              </div>
              <div class='row justify-content-end'><div class='col-6 '>
    <form action='usuario_acao.php' method='post' enctype='multipart/form-data'>

        <input type='text' class='form-control inputs required' id='id' name='id' placeholder='' hidden value=" . $key['idUsuarios'] . ">

        <input type='file' name='foto' id='foto' accept='image/*' hidden>
        
        <button type='submit' class='btn btn-outline-primary' name='acao' id='acao' value='fotos'>Adicionar foto</button>
    </form></div>
                  </div>
                  </section>
                  </div>
              
    ";
    }
  }
}
?>
<script>
  const inputFile = document.querySelector(".foto");
  const pictureImage = document.querySelector(".picture__image");
  const pictureImageTxt = "Choose an image";
  pictureImage.innerHTML = pictureImageTxt;

  inputFile.addEventListener("change", function(e) {
    const inputTarget = e.target;
    const file = inputTarget.files[0];

    if (file) {
      const reader = new FileReader();

      reader.addEventListener("load", function(e) {
        const readerTarget = e.target;

        const img = document.createElement("img");
        img.src = readerTarget.result;
        img.classList.add("picture__img");

        pictureImage.innerHTML = "";
        pictureImage.appendChild(img);
      });

      reader.readAsDataURL(file);
    } else {
      pictureImage.innerHTML = pictureImageTxt;
    }
  });
</script>