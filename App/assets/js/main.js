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

async function getCityAPI(city){
    const where = encodeURIComponent(JSON.stringify({
        "name": city
      }));

      const AppID = '';
      const RestAPIKey = '';

      const response = await fetch(
        `https://parseapi.back4app.com/classes/Estadoscidadesbrasil_City?limit=10&keys=name&where=${where}`,
        {
          headers: {
            'X-Parse-Application-Id': AppID, // This is your app's application id
            'X-Parse-REST-API-Key': RestAPIKey, // This is your app's REST API key
          }
        }
      );
      const data = await response.json(); // Here you have the data that you need
      const found = data.results[0]?.name;
      return (found?true:false);
}

async function extractInfo(e){
    e.preventDefault();

    const imovelTipo = document.querySelector("#imovel-tipo");
    const imovelCidade = document.querySelector("#imovel-cidade");
    const imovelBairro = document.querySelector("#imovel-bairro");
    const backendsqlquery = document.querySelector('#backend-sqlquery');

    const infolink = document.querySelector("#info-link").value;
    // TODO: validação do link

    const tipo = infolink.slice(infolink.indexOf("/imovel/") + 8, infolink.indexOf("-com-"));
    const bairroCidade = infolink.slice(infolink.indexOf("-em-")+4, infolink.indexOf("/",infolink.indexOf("-em-")));
    const bairroCidadeArray = bairroCidade.split("-");

    let prevElement = "";
    let cidade = "";
    for(let i = bairroCidadeArray.length-1; i>=0; i--){
        const element = bairroCidadeArray[i];

        const city = element.charAt(0).toUpperCase() + element.slice(1) + ' ' + prevElement;
        if(await getCityAPI(city.trim())){
            cidade = city.trim().toLowerCase().replace(" ","-");
            break;
        }else{
        }
        prevElement = city;
    }

    let bairro = bairroCidade.replace(cidade,"").slice(0, -1);

    imovelTipo.innerHTML = tipo;
    imovelCidade.innerHTML = cidade;
    imovelBairro.innerHTML = bairro;
    backendsqlquery.innerHTML = `<span>Backend:</span> <span class="sql-query">SELECT * FROM</span> imoveis <span class="sql-query">WHERE cidade = </span> ${cidade} <span class="sql-query"> AND bairro = </span>${bairro} <span class="sql-query">AND tipo = </span>${tipo}</span> <span class="sql-query"> LIMIT 3</span>`
}