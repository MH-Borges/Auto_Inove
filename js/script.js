$(document).ready(function () {
    let codigo = Cookies.get('Cookie_Codigo');
    if(codigo !== ''){ $('#selected_val_Codigos').text(codigo); }

    //atualiza valores carrinho
    if(Cookies.get('Carrinho') !== undefined && Cookies.get('Carrinho') !== ''){
        let CarrinhoCookie = Cookies.get('Carrinho');
        
        const CookieToArray = CarrinhoCookie.split("&").map(function(item) {
            var obj = {};
            item.split("_").forEach(function(pair) {
                var parts = pair.split(":");
                obj[parts[0]] = parts[1];
            });
            return obj;
        });

        var itensCarrinho = 0;
        $('.dropdownCarrinho').text(' ');

        CookieToArray.forEach(item => { 
            itensCarrinho = itensCarrinho + Number(item.quant); 
            
            if(item.imgProd == "placeholder.jpg" || item.imgProd == ""){
                var img = "<img src='assets/produtos/placeholder.jpg'>";
            }else{
                var img = `<img src='assets/produtos/${item.imgProd}'>`;
            }
            
            let nome_url = item.nomeProd.replaceAll(' ','_');

            $('.dropdownCarrinho').append(`<a class='itensCarrinho' href='produto_${nome_url}'>${img}<p>${item.nomeProd}</p><span>Quant:${item.quant}</span></a>`);

        });

        if(itensCarrinho !== 0){
            $('.CartNotf').removeClass('hide');
            $('.CartNotf').text(itensCarrinho);
        }

        $('.dropdownCarrinho').append(`<a class='btn-carrinho' href="./carrinho">Ver pagina de carrinho</a>`);

    }
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
        expires: 0.01
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

//CARRINHO
function moveProgressBar() {
    var getPercent = ($('.progress-wrap').data('progress-percent') / 100);
    var getProgressWrapWidth = $('.progress-wrap').width();
    var progressTotal = getPercent * getProgressWrapWidth;
    var animationLength = 3000;

    $('.progress-bar').stop().animate({ left: progressTotal }, animationLength);
    
    setTimeout(() => {
        $('.progress-bar').stop().animate({ left: 0 }, 0);
    }, 3500);
}

function addCarrinho(idProd, imgProd, nomeProd, codigo){
    if(Cookies.get('Carrinho') !== undefined && Cookies.get('Carrinho') !== ''){
        let CarrinhoCookie = Cookies.get('Carrinho');
        //string to array
        const CookieToArray = CarrinhoCookie.split("&").map(function(item) {
            var obj = {};
            item.split("_").forEach(function(pair) {
                var parts = pair.split(":");
                obj[parts[0]] = parts[1];
            });
            return obj;
        });

        var updated = false;
        CookieToArray.forEach(item => {
            if(item.idProd === idProd.toString()) {
                let newValue = Number(item.quant) + 1;
                item.quant = newValue;
                updated = true;
            }
        });

        if(!updated){
            CookieToArray.push({
                idProd: `${idProd}`,
                quant: '1',
                imgProd: imgProd,
                codigo: codigo,
                nomeProd: nomeProd
            })
        }

        //array to string
        var CarrinhoToString = CookieToArray.map(function(obj) {
            return 'idProd:'+obj.idProd+'_quant:'+obj.quant+'_imgProd:'+obj.imgProd+'_nomeProd:'+obj.nomeProd+'_codigo:'+obj.codigo;
        }).join('&');

        Cookies.set('Carrinho', CarrinhoToString, {
            expires: 1
        });

        var itensCarrinho = 0;
        $('.dropdownCarrinho').text(' ');

        CookieToArray.forEach(item => { 
            itensCarrinho = itensCarrinho + Number(item.quant); 

            if(item.imgProd == "placeholder.jpg" || item.imgProd == ""){
                var img = "<img src='assets/produtos/placeholder.jpg'>";
            }else{
                var img = `<img src='assets/produtos/${item.imgProd}'>`;
            }

            let nome_url = item.nomeProd.replaceAll(' ','_');

            $('.dropdownCarrinho').append(`<a class='itensCarrinho' href='produto_${nome_url}'>${img}<p>${item.nomeProd}</p><span>Quant:${item.quant}</span></a>`);

        });

        if(itensCarrinho !== 0){
            $('.CartNotf').removeClass('hide');
            $('.CartNotf').text(itensCarrinho);
        }

        $('.dropdownCarrinho').append(`<a class='btn-carrinho' href="./carrinho">Ver pagina de carrinho</a>`);
    
        //msg que foi adicionado item ao carrinho
        $('.msg_Carrinho').removeClass('hide');
        $(".msg_Carrinho").css("bottom", "2vh");
        moveProgressBar();
        setTimeout(() => {
            $('.msg_Carrinho').addClass('hide');
            $(".msg_Carrinho").css("bottom", "-25vh"); 
        }, 3200);
    }
    else{
        const carrinho = [];

        carrinho.push({
            idProd: idProd,
            quant: 1,
            imgProd: imgProd,
            codigo: codigo,
            nomeProd: nomeProd
        });

        //array to string
        var CarrinhoToString = carrinho.map(function(obj) {
            return 'idProd:'+obj.idProd+'_quant:'+obj.quant+'_imgProd:'+obj.imgProd+'_nomeProd:'+obj.nomeProd+'_codigo:'+obj.codigo;
        }).join(';');

        Cookies.set('Carrinho', CarrinhoToString, {
            expires: 1
        });

        $('.CartNotf').removeClass('hide');
        $('.CartNotf').text(1);

        if(imgProd == "placeholder.jpg" || imgProd == ""){
            var img = "<img src='assets/produtos/placeholder.jpg'>";
        }else{
            var img = `<img src='assets/produtos/${imgProd}'>`;
        }

        $('.dropdownCarrinho').text(' ');
        $('.dropdownCarrinho').append(`<a class='itensCarrinho' href='produto_${nomeProd}'>${img}<p>${nomeProd}</p><span>Quant:1</span></a>`);
        $('.dropdownCarrinho').append(`<a class='btn-carrinho' href="./carrinho">Ver pagina de carrinho</a>`);
    
        //msg que foi adicionado item ao carrinho
        $('.msg_Carrinho').removeClass('hide');
        $(".msg_Carrinho").css("bottom", "2vh");
        moveProgressBar();
        setTimeout(() => {
            $('.msg_Carrinho').addClass('hide');
            $(".msg_Carrinho").css("bottom", "-25vh"); 
        }, 3200);
    }
}