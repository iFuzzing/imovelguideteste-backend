function cpfMask(e){
    const leftArrow = 37;
    const rigthArrow = 39;

    if(e.keyCode  == 8 || e.keyCode == leftArrow || e.keyCode == rigthArrow)
        return;

    if(e.keyCode < 48 || e.keyCode > 57){
        e.preventDefault();
    }

    if(e.target.value.length == 3 || e.target.value.length == 7)
        e.target.value += '.';
    else if(e.target.value.length == 11)
        e.target.value += '-';

}

function toggleFormMode(e, corretor = {id: '', cpf: "", creci: "", nome: ""}){
    e.preventDefault();

    const bntFormAction = document.querySelector("#btn-form-action");
    const btnFormCancel = document.querySelector("#btn-form-cancel");
    const formTitle = document.querySelector("#form-title");
    const formReponse = document.querySelector('#form-response');

    if(formReponse){
        formReponse.remove();
    }

    const cpf = document.querySelector("#cpf");
    const creci = document.querySelector("#creci");
    const nome = document.querySelector("#nome");
    const corretorid = document.querySelector("#corretorid");

    let formMode = bntFormAction.getAttribute("name");
    if(formMode == "novo-corretor" || corretor.id){
        formMode = "editar-corretor";
        bntFormAction.innerHTML = "Salvar edição";
        bntFormAction.setAttribute("name","editar-corretor");
        formTitle.innerHTML = "Edição de corretor";

        if(corretor.id != '' && corretor.cpf != "" && corretor.creci != "" && corretor.nome != ""){
            cpf.value = corretor.cpf;
            creci.value = corretor.creci;
            nome.value = corretor.nome;
            corretorid.value = corretor.id;
        }

        btnFormCancel.classList.remove("hidden");

    }else if(formMode == 'editar-corretor' && !corretor.id){
        formMode = "novo-corretor";
        bntFormAction.innerHTML = "Enviar";
        bntFormAction.setAttribute("name","novo-corretor");
        formTitle.innerHTML = "Cadastro de Corretor";

        cpf.value = "";
        creci.value = "";
        nome.value = "";
        
        btnFormCancel.classList.add("hidden");
    }
}