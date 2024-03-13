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
        const tipo = e.children[2].innerHTML;

        listItems.push({
            img: img,
            nome: nome,
            tipo: tipo
        });
    });
}

function filterData(searchTerm) {
    listItems.forEach(item => {
        if(item.nome.toLowerCase().includes(searchTerm.toLowerCase())) {
            $('.Search_resultBox').removeClass('hide');
            if(item.tipo === "sub_categorias"){
                $(".Search_resultBox").append(`<a href='#'><p>${item.nome}</p><span>${item.tipo}</span></a>`);
            }
            if(item.tipo === "categorias"){
                $(".Search_resultBox").append(`<a href='#'><img src='assets/categorias/${item.img}'><p>${item.nome}</p><span>${item.tipo}</span></a>`);
            }
            if(item.tipo === "produto"){
                $(".Search_resultBox").append(`<a href='#'><img src='assets/produtos/${item.img}'><p>${item.nome}</p><span>${item.tipo}</span></a>`);
            }
        }
    });
    if(searchTerm === ""){
        $('.Search_resultBox').addClass('hide');
        $('.Search_resultBox').text(' ');
    }
}

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

window.addEventListener('scroll', function() {
    if(window.pageYOffset > 150){
        $('header').addClass('back_dark');
    }
    else{
        $('header').removeClass('back_dark');
    }
});