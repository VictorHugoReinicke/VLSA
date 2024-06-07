function showSwal(message, redirect) {
  Swal.fire({
    title: message,
    icon: message.includes('Erro') ? 'error' : 'success', // Set icon based on message
    confirmButtonColor: '#3085d6',
    text: message.includes('Erro') ? 'Verifique suas informações e tente novamente' : 'Prossiga para a próxima página',
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = redirect;
    }
  });
}

function mostrars() {
  var y = document.getElementById("senhaCAD");

  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }

}


function mostrarC() {
  var x = document.getElementById("confirmasenhaCAD");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function mostrarp() {
  var x = document.getElementById('pass');
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}