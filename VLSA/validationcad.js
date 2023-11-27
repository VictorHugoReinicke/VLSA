// const cadForm = document.getElementById("cadForm");

// if (cadForm) {
//   cadForm.addEventListener("submit", async (e) => {
//     e.preventDefault();

//     const dadosForm = new FormData(cadForm);

//     const dados = await fetch("acao_util.php", {
//       method: "POST",
//       body: dadosForm
//     });

//     const resposta = await dados.json();
    
//   });
// }

// function alerta(){
//   Swal.fire({
//   icon: 'success',
//   title: 'Your work has been saved',
//   showConfirmButton: false,
//   timer: 1500
// })
// };





function alerta(){
  Swal.fire({
    position: 'center',
    icon: 'success',
    title: 'Cadastro realizado com sucesso!!',
    showConfirmButton: false,
    timer: 15000
  });
}
alerta()