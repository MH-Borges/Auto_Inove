$(document).ready(function () {
    let codigo = Cookies.get('Cookie_Codigo');
    if(codigo !== ''){ $('#selected_val_Codigos').text(codigo); }
});

//FUNÇÃO DE SELETORES CUSTOMIZADOS
function OptionSelection(selectedValueId, optionsButtonId, optionInputsClass) {
    let selectedValue = document.getElementById(selectedValueId),
        optionsViewButton = document.getElementById(optionsButtonId),
        inputsOptions = document.querySelectorAll('.' + optionInputsClass + ' input');

    inputsOptions.forEach(input => { 
        input.addEventListener('click', event => {
            selectedValue.textContent = input.dataset.label;
            optionsViewButton.click();
        });
    });
}

//////// PENSAR COM CARINHO EM TODA A LOGICA DE CODIGOS E RESULTADO DE PESQUISA
function codigoRedirect(codigo){
    Cookies.set('Cookie_Codigo', codigo, {
        expires: 1
    });
    window.location.href = `./produtos`;
}

//BARRA DE PESQUISA
const filter = document.getElementById('filter');
const listItems = [];
getData();
filter.addEventListener('input', (e) => {
    filterData(e.target.value);
    document.querySelector('.search').addEventListener('click', () =>{
        if (filter.value != "") {
            filter.value = "";
            filterData(e.target.value);
        }
    });
});

function getData() {
    document.querySelectorAll('.hidelist').forEach(e => {
        const img = e.children[0].innerHTML;
        const nome = e.children[1].innerHTML;
        const nome_url = e.children[2].innerHTML;
        const tipo = e.children[3].innerHTML;

        listItems.push({
            img: img,
            nome: nome,
            nome_url: nome_url,
            tipo: tipo
        });
    });
}

function filterData(searchTerm) {
    document.querySelectorAll('.searchResult').forEach(e => { e.remove(); });
    
    listItems.forEach(item => {
        if(item.nome.toLowerCase().includes(searchTerm.toLowerCase())) {
            $('.Search_resultBox').removeClass('hide');

            if(item.tipo === "sub_categorias"){
                $(".Search_resultBox").append(`<a class='searchResult SubcategResult' href='produtos_${item.nome_url}'><p>${item.nome}</p><span>${item.tipo}</span></a>`);
            }
            if(item.tipo === "categorias"){
                if(item.img === 'placeholder.svg'){
                    $(".Search_resultBox").append(`<a class='searchResult categoriasResult' href='produtos_${item.nome_url}'><p>${item.nome}</p><img src='assets/icons/${item.img}'><span>${item.tipo}</span></a>`);
                }
                else{
                    $(".Search_resultBox").append(`<a class='searchResult categoriasResult' href='produtos_${item.nome_url}'><p>${item.nome}</p><img src='assets/categorias/${item.img}'><span>${item.tipo}</span></a>`);
                }
            }
            if(item.tipo === "produtos"){
                $(".Search_resultBox").append(`<a class='searchResult produtoResult' href='produto_${item.nome_url}'><p>${item.nome}</p><img src='assets/produtos/${item.img}'><span>${item.tipo}</span></a>`);
            }
        }
    });

    if( $(".Search_resultBox").html() === ""){
        $(".Search_resultBox").append(`<a class='searchResult nullResult'><span>Nenhum resultado encontrado</span></a>`);
    }

    if(searchTerm === ""){
        $('.Search_resultBox').addClass('hide');
        $('.Search_resultBox').text(' ');
    }
}

//MENU LATRERAL
function menuToggle(){
    if($('.side_menu').hasClass('hide')){
        $('.side_menu').removeClass('hide');
        $('.side_menu').animate({ right: "0"});
    }
    else{
        $('.side_menu').animate({ right: "-20vw"});
        setTimeout(() => { $('.side_menu').addClass('hide'); }, 500);
    }
}

//EFEITO MENU SCROLL
window.addEventListener('scroll', function() {
    if(window.pageYOffset > 150){
        $('header').addClass('back_dark');
    }
    else{
        $('header').removeClass('back_dark');
    }
});