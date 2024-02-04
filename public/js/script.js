$('#valor, #aquis_servicos, #obras_eng_man_vei').keyup(function () {
    var v = $(this).val();
    v = v.replace(/\D/g, '');
    v = v.replace(/(\d{1,2})$/, ',$1');
    v = v.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    v = v != '' ? 'R$ ' + v : '';
    $(this).val(v);
});

function mask(o, f) {
    setTimeout(function () {
        var v = mphone(o.value);
        if (v != o.value) {
            o.value = v;
        }
    }, 1);
}

function mphone(v) {
    var r = v.replace(/\D/g, "");
    r = r.replace(/^0/, "");
    if (r.length > 10) {
        r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
    }
    else if (r.length > 5) {
        r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
    }
    else if (r.length > 2) {
        r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
    }
    else {
        r = r.replace(/^(\d*)/, "($1");
    }
    return r;
}


function encontrarCnae() {
    clearTimeout(this.interval);
    this.interval = setTimeout(apiCnae, 400);
}

async function apiCnae() {

    const listDropDown = document.querySelector('#listDropDownCnae');

    while (listDropDown.firstChild) {
        listDropDown.removeChild(listDropDown.firstChild)
    }

    const filterCnae = document.querySelector("#sub_classe_cnae").value;

    if (filterCnae.length >= 3) {

        const urlSubClasseCnae = "http://127.0.0.1:8000/api/v1/subclasse?atividade=" + filterCnae
        const responseSub = await fetch(urlSubClasseCnae);
        const dataSubCnae = await responseSub.json();

        if (dataSubCnae.length > 0) {

            dataSubCnae.map((subClasse) => {

                var stringAtividade = new String(subClasse.atividade);

                if (stringAtividade.includes(';')) {
                    var splitAtividade = stringAtividade.split(";");
                    var atividade = splitAtividade[1] + " " + splitAtividade[0];
                } else if (stringAtividade.includes(',')) {
                    var splitAtividade = stringAtividade.split(",");
                    var atividade = splitAtividade[1] + " " + splitAtividade[0];
                } else {
                    var atividade = stringAtividade;
                }

                var ca = "\n\n" + subClasse.compreende_ainda;
                var nc = "\n\n" + subClasse.nao_compreende;

                var observacoes = subClasse.compreende + ca + nc;


                const div = document.createElement("div");
                div.className = "item";
                div.title = observacoes;
                div.id = subClasse.id;
                if (subClasse.compreende != "") {
                    div.dataset.compreende = subClasse.compreende;
                }
                if (subClasse.compreende_ainda != "") {
                    div.dataset.compreende_ainda = subClasse.compreende_ainda;
                }
                if (subClasse.nao_compreende != "") {
                    div.dataset.nao_compreende = subClasse.nao_compreende;
                }
                div.setAttribute("onMouseDown", "select(" + subClasse.id + ")");
                const value = document.createTextNode(subClasse.subclasse + " ·" + atividade);

                div.appendChild(value);

                listDropDown.appendChild(div);
            })

            dropDownCnae(0);
            var w = document.getElementById('sub_classe_cnae').offsetWidth;

            document.getElementById('dropDownCnae').style.width = w + "px";
        } else {
            dropDownCnae(1);
        }

    } else {
        dropDownCnae(1);
    }
}