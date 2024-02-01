function resetIndex() { window.location='./index.php'; }
function VoltarPage() {  history.back(); }

//UPLOAD DE IMAGENS
function carregarImagem(inputId, targetId, defaultImagePath, imgContainerClass) {
    var target = document.getElementById(targetId);
    var fileInput = document.querySelector("#" + inputId);
    var file = fileInput.files[0];
    var reader = new FileReader();

    reader.onloadend = function () { target.src = reader.result; };

    if (file) {
        reader.readAsDataURL(file);
        document.querySelector('.' + imgContainerClass).classList.add('imgSelected');
    } else {
        target.src = defaultImagePath;
        document.querySelector('.' + imgContainerClass).classList.remove('imgSelected');
    }
}
function Banner_Web(){ $('#Banner_Web').click(); }
function Banner_Mobile(){ $('#Banner_Mobile').click();}
function carregarImgWeb(){ carregarImagem('Banner_Web', 'target_imgWeb', "../../assets/Banner_Links/Default_Banner_Web.jpg", 'Banner_Img_Web'); }
function carregarImgMobile(){ carregarImagem('Banner_Mobile', 'target_imgMobile', "../../assets/Banner_Links/Default_Banner_Mobile.jpg", 'Banner_Img_Mobile'); }

//FUNÇÃO DE VISUALIZAR SENHA
function setupPasswordToggle(inputId, toggleId) {
    var passwordInput = document.getElementById(inputId);
    var passwordToggle = document.getElementById(toggleId);

    if (passwordInput != null && passwordToggle != null) {
        function passwordToggleHandler() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.classList.remove('fa-eye-slash');
                passwordToggle.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                passwordToggle.classList.remove('fa-eye');
                passwordToggle.classList.add('fa-eye-slash');
            }
        }
    }
    passwordToggleHandler();
}

//VERICAÇÃO QUANTIDADE DE CARACTERES INPUT
function verificaTamanhoInput(inputId, displayClass, maxLen) {
    var inputElement = document.getElementById(inputId);
    var displayElement = document.querySelector('.' + displayClass);
    if (inputElement !== null && displayElement !== null) {
        var tamInput = inputElement.value.length;

        if (tamInput < maxLen - 20) {
            displayElement.innerHTML = '';
            displayElement.classList.remove('text-warning', 'text-danger');
        } else if (tamInput < maxLen - 10) {
            displayElement.innerHTML = (maxLen - tamInput) + '/' + maxLen;
            displayElement.classList.remove('text-danger');
            displayElement.classList.add('text-warning');
        } else {
            displayElement.innerHTML = (maxLen - tamInput) + '/' + maxLen;
            displayElement.classList.remove('text-warning');
            displayElement.classList.add('text-danger');
        }
    }
}
setInterval(
    function () {
        verificaTamanhoInput('nomeCompEdit', 'NomeCompEditInput', 75);
        verificaTamanhoInput('antigoEmail', 'emailAntigoEditInput', 50);
        verificaTamanhoInput('novoEmail', 'novoEmailEditInput', 50);
        verificaTamanhoInput('confirmaNovoEmail', 'ConfirmaNovoEmailEditInput', 50);
        verificaTamanhoInput('antigaSenha', 'SenhaAntigaEditInput', 25);
        verificaTamanhoInput('novaSenha', 'NovaSenhaEditInput', 25);
        verificaTamanhoInput('confirmaNovaSenha', 'ConfirmaNovaSenhaEditInput', 25);

        verificaTamanhoInput('nomeLink', 'nomeLinkInput', 50);
        verificaTamanhoInput('link', 'linkInput', 250);

        verificaTamanhoInput('nomeCateg', 'categoriaInput', 75);
}, 50);

//VERIFICAÇÃO DE TAB ATIVA MENU LATERAL
const indicator = document.querySelector('.star_indicator');
const items = document.querySelectorAll('.nav-item');
function handleIndicator(el) {
  items.forEach(item => {
    item.classList.remove('activeStar');
  });

  indicator.style.height = `${el.offsetHeight}px`;
  indicator.style.top = `${el.offsetTop}px`;
  el.classList.add('activeStar');
}
items.forEach((item, index) => {
  item.addEventListener('click', e => {handleIndicator(e.target);});
  item.classList.contains('activeStar') && handleIndicator(item);
});

//ALTERNAÇÃO DE LISTAGEM DE LINKS
function ToggleListagemLinks(){ 
    document.querySelector('.linksAtivos').classList.toggle("hide");
    document.querySelector('.LinkDesativados').classList.toggle("hide");
    var btnShowListagem = document.getElementById("ListagemLinksbtn");
    if(btnShowListagem.innerHTML === "Ver links desativados"){
        btnShowListagem.innerHTML = 'Ver links ativos';
    }
    else{
        btnShowListagem.innerHTML = 'Ver links desativados';
    }
}


// UPLOAD INFOS
$(document).ready(function () {
    $('#telefoneContatoEdit').mask('(00) 00000 - 0000');
    
    $('#formEditUser').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"Main_Configs/EditCadastro.php",
            method:"post",
            data: $('form').serialize(),
            dataType: "text",
            success: function(msg){
                $('#msgErro_EditUser').removeClass('text-danger');
                $('#msgErro_EditUser').addClass('text-warning');
                $('#msgErro_EditUser').text('carregando..');
                if(msg.trim() === 'Cadastro alterado com Sucesso!!'){
                    $('#msgErro_EditUser').removeClass('text-danger');
                    $('#msgErro_EditUser').removeClass('text-warning');
                    $('#msgErro_EditUser').addClass('text-success');
                    $('#msgErro_EditUser').text(msg);
                    setTimeout(() => { location.reload(); }, 4000);
                }
                else{
                    $('#msgErro_EditUser').removeClass('text-warning');
                    $('#msgErro_EditUser').addClass('text-danger');
                    $('#msgErro_EditUser').text(msg);
                }
            }
        })
    });

    $('#formEditEmailUser').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"Main_Configs/EditEmail.php",
            method:"post",
            data: $('form').serialize(),
            dataType: "text",
            success: function(msg){
                $('#msgErro_EditUser').removeClass('text-danger');
                $('#msgErro_EditUser').addClass('text-warning');
                $('#msgErro_EditUser').text('carregando..');
                if(msg.trim() === 'E-mail alterado com Sucesso!'){
                    $('#msgErro_EditUser').removeClass('text-danger');
                    $('#msgErro_EditUser').removeClass('text-warning');
                    $('#msgErro_EditUser').addClass('text-success');
                    $('#msgErro_EditUser').text(msg);
                    setTimeout(() => { 
                        $('#msgErro_EditUser').text('Necessario relogar para alteração completa do email');
                        setTimeout(() => { window.location='../../configs/logout.php'; }, 5000);
                    }, 2000);
                }
                else{
                    $('#msgErro_EditUser').removeClass('text-warning');
                    $('#msgErro_EditUser').addClass('text-danger');
                    $('#msgErro_EditUser').text(msg);
                }
            }
        })
    });

    $('#formEditSenhaUser').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"Main_Configs/EditSenha.php",
            method:"post",
            data: $('form').serialize(),
            dataType: "text",
            success: function(msg){
                $('#msgErro_EditUser').removeClass('text-danger');
                $('#msgErro_EditUser').addClass('text-warning');
                $('#msgErro_EditUser').text('carregando..');
                if(msg.trim() === 'Senha alterada com Sucesso!'){
                    $('#msgErro_EditUser').removeClass('text-danger');
                    $('#msgErro_EditUser').removeClass('text-warning');
                    $('#msgErro_EditUser').addClass('text-success');
                    $('#msgErro_EditUser').text(msg);
                    setTimeout(() => { location.reload(); }, 5000);
                }
                else{
                    $('#msgErro_EditUser').removeClass('text-warning');
                    $('#msgErro_EditUser').addClass('text-danger');
                    $('#msgErro_EditUser').text(msg);
                }
            }
        });
    });
    
    // **LINKS** //
    $("#formLinks").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "Links/insert.php",
            type: 'POST',
            data: formData,
            success: function (msg) {
                $('#msgErro_Links').removeClass('text-danger');
                $('#msgErro_Links').addClass('text-warning');
                $('#msgErro_Links').text('carregando...');
                if (msg.trim() === "Link adicionado com Sucesso!!" || msg.trim() === "Link atualizado com Sucesso!!" ) {
                    $('#msgErro_Links').removeClass('text-warning');
                    $('#msgErro_Links').removeClass('text-danger');
                    $('#msgErro_Links').addClass('text-success');
                    $('#msgErro_Links').text(msg);
                    setTimeout(() => { $('.CloseBtn').click(); }, 1500);
                }
                else {
                    $('#msgErro_Links').removeClass('text-warning');
                    $('#msgErro_Links').addClass('text-danger');
                    $('#msgErro_Links').text(msg);
                }
            },
            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload){ myXhr.upload.addEventListener('progress', function() {}, false); }
                return myXhr;
            }
        });
    });

    $('#formDeletLink').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Links/delet.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                if (msg.trim() === "Excluído com Sucesso!!") {
                    $('#msgErro_DeletLink').removeClass('text-warning');
                    $('#msgErro_DeletLink').removeClass('text-danger');
                    $('#msgErro_DeletLink').addClass('text-success');
                    $('#msgErro_DeletLink').text(msg);
                    setTimeout(() => { $('.CloseBtn').click(); }, 1500);
                }
                else{
                    $('#msgErro_DeletLink').removeClass('text-success');
                    $('#msgErro_DeletLink').removeClass('text-warning');
                    $('#msgErro_DeletLink').addClass('text-danger');
                    $('#msgErro_DeletLink').text(msg)
                }
            }
        })
    })

    // **CATEGORIAS** //
    $('#formCategorias').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"Links/Categorias/insert.php",
            method:"post",
            data: $('form').serialize(),
            dataType: "text",
            success: function(msg){
                $('#msgErro_Categoria').removeClass('text-danger');
                $('#msgErro_Categoria').addClass('text-warning');
                $('#msgErro_Categoria').text('carregando..');
                if(msg.trim() === 'Nova categoria adicionada com Sucesso!!' || msg.trim() === 'Categoria atualizada com Sucesso!!'){
                    $('#msgErro_Categoria').removeClass('text-danger');
                    $('#msgErro_Categoria').removeClass('text-warning');
                    $('#msgErro_Categoria').addClass('text-success');
                    $('#msgErro_Categoria').text(msg);
                    setTimeout(() => { $('.CloseBtn').click(); }, 2500);
                }
                else{
                    $('#msgErro_Categoria').removeClass('text-warning');
                    $('#msgErro_Categoria').addClass('text-danger');
                    $('#msgErro_Categoria').text(msg);
                }
            }
        })
    });

    $('#formDeletCategoria').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Links/Categorias/delet.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (mensagem) {
                if (mensagem.trim() === "Excluído com Sucesso!!") {
                    $('#msgErro_DeletCateg').removeClass('text-warning');
                    $('#msgErro_DeletCateg').removeClass('text-danger');
                    $('#msgErro_DeletCateg').addClass('text-success');
                    $('#msgErro_DeletCateg').text(mensagem);
                    setTimeout(() => { $('.CloseBtn').click(); }, 2500);
                }
                else{
                    $('#msgErro_DeletCateg').removeClass('text-success');
                    $('#msgErro_DeletCateg').removeClass('text-warning');
                    $('#msgErro_DeletCateg').addClass('text-danger');
                    $('#msgErro_DeletCateg').text(mensagem)
                }
            }
        })
    })
});