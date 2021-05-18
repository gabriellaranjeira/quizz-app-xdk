/*
 * Please see the included README.md file for license terms and conditions.
 */


// This file is a suggested starting place for your code.
// It is completely optional and not required.
// Note the reference that includes it in the index.html file.


/*jslint browser:true, devel:true, white:true, vars:true */
/*global $:false, intel:false app:false, dev:false, cordova:false */



// This file contains your event handlers, the center of your application.
// NOTE: see app.initEvents() in init-app.js for event handler initialization code.

// function myEventHandler() {
//     "use strict" ;
// // ...event handler code here...
// }


// ...additional event handlers here...

document.addEventListener('deviceready', onDeviceReady, false);
document.addEventListener('backbutton', onBack, false);

var abecedario = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
var contAlt = 0;

function openOnImageClick(){
    accessCamera();
}

function onBack(){
    if(page == "cadastro"){
        page = "inicial";
        activate_subpage("#page_87_29");
    }else if(page == "perfil"){
        page = "home";
        activate_subpage("#page_25_56");
    }else if(page == "game"){
        limpaConfig();
        page = "home";
        activate_subpage("#page_25_56");
    }else if(page == "ongame"){
        navigator.notification.confirm("Tem certeza que deseja sair?", function(buttonID){
            if(buttonID == 1){
                limpaConfig();
                sync();
                page = "home";
                activate_subpage("#page_25_56");
            }
        }, "(se sair seu nivel não será salvo.)", ["Sim", "Não"]);
    }else if(page == "inicial"){
         navigator.app.exitApp();
    }else if(page == "home"){
         navigator.app.exitApp();
    }else if(page == "materia"){
        page = "home";
        activate_subpage("#page_25_56");
    }else if(page == "quiz"){
        page = "materia";
        activate_subpage("#uib_page_6");
    }      
}

function cSuccess(imageData){
    var user = JSON.parse(localStorage.getItem('usuario'));
    var idUser = user.id;
    var data = {
        id : idUser,
        foto : imageData
    };
    $.ajax({
        url: 'http://quizapp.pe.hu/api/foto.php',
        type: 'POST',
        data: data,
        success:function(retorno){
            if(retorno == "sucesso"){
                 navigator.notification.alert("Foto de perfil atualizada com sucesso!", null, "Sucesso!", 'OK');
                sync();
                perfil();
            }
        },
        error:function(){
             navigator.notification.alert("Ocorreu um erro ao conectar com o banco de dados!", null, "ERRO!", 'OK');
        }
        
    });
}

function cError(){
     navigator.notification.alert("Ocorreu um erro ao selecionar a foto!", null, "ERRO!", 'OK');
}

function accessCamera(){
    var options = {
        destinationType: Camera.DestinationType.DATA_URL,
        sourceType: Camera.PictureSourceType.PHOTOLIBRARY,
        encodingType: Camera.EncodingType.PNG
    };
    
    navigator.camera.getPicture(cSuccess, cError, options);
}

var finalRes = 1;
var page;
var iniciado = false;
var idcurso;
var config = {
    id : 0,
    npeg: 0,
    pegs : [],
    res: [],
    nres : 0,
    maxpeg : 0,
    vidas : 5,
    acertos: 0,
    erros : 0
};

function btnEntrar(){
    page = "cadastro";
    activate_subpage("#uib_page_2");
}

function btnRegistrar(){
    page = "cadastro";
    activate_subpage("#uib_page_1");
}

function perfil(){
    page = "perfil";
    activate_subpage("#uib_page_3");
}

function getCom(id){
    var retorno = [];
    var completo = JSON.parse(localStorage.getItem('completo'));
    for(var i = 0; i < completo.length; i++){
        if(completo[i].id_user == id){
            retorno.push(completo[i].quiz_id);
        }
    }
    return retorno;
}



function getNivel(nv){
    var nivel = JSON.parse(localStorage.getItem('nivel'));
    var retorno = "";
    for(var i = 0; i < nivel.length; i++){
        if(nivel[i].nivel == nv){
            retorno = nivel[i].patente;
            break;
        }
    }
    
    return retorno;
}

function setUser(){
    var user = JSON.parse(localStorage.getItem('usuario'));
    var nivel = parseFloat(user.pegc) - parseFloat(user.pege);
    var conta = (parseFloat(user.pegc) * 100) / (parseFloat(user.pegc) + parseFloat(user.pege));
    var porcentagem = parseFloat(conta.toFixed(2));
    var patente = getNivel(nivel);
    var foto = "http://quizapp.pe.hu/api/img/"+user.foto; 
    var html = '<h3>'+user.nome+'</h3>                            <h3>Nivel: <strong>'+nivel+'</strong></h3>                            <h3>Patente:<strong> '+patente+'</strong></h3>                            <h3>Perguntas certas:<strong> '+user.pegc+'</strong></h3>                            <h3>Perguntas erradas:<strong> '+user.pege+'</strong></h3>                            <h3>Porcentagem:<strong> '+porcentagem+'%</strong></h3>                            <h2 style="font-style:italic">&nbsp;</h2>';
    document.getElementById('userInfo').innerHTML = html;
    document.getElementById('imgUser').src = foto;
}

function setQuiz(id){
    page = "quiz";
    var tmp = "";
    var quiz = JSON.parse(localStorage.getItem('quiz'));
    var user = JSON.parse(localStorage.getItem('usuario'));
    var completo = getCom(user.id);
    
    for(var i = 0;i < quiz.length;i++){
       if(quiz[i].idmat == id){
           if($.inArray(quiz[i].id, completo) > -1 ){
                tmp += '                    <a class="item item-avatar" onclick="startGame('+i+')" href="">                      <img src="images/true.png">                      <h2>'+ quiz[i].nome +'</h2>                      <p>'+quiz[i].descricao.substring(0, 30)+'...</p>                    </a>';
           }else{
                tmp += '                    <a class="item item-avatar" onclick="startGame('+i+')" href="">                      <img src="images/quiz.png">                      <h2>'+ quiz[i].nome +'</h2>                      <p>'+quiz[i].descricao.substring(0, 30)+'...</p>                    </a>';
           }
       }
    }
    document.getElementById('quizList').innerHTML = tmp;
    tmp = "";
    activate_subpage("#uib_page_7");
}

function btnEsqueci(){
    page = "cadastro";
    activate_subpage("#uib_page_8");
}

function esqueci(){
    $.ajax({
        url: 'http://quizapp.pe.hu/api/esqueci.php',
        type: 'POST',
        data: $('form#esqueci').serialize(),
        success:function(retorno){
            if(retorno == "sucesso"){
                navigator.notification.alert("Lhe enviamos um email para a redefinação de sua senha!", null, "Sucesso!", 'OK');
            }else{
                navigator.notification.alert(retorno, null, "ERRO!", 'OK');
            }
        },
        error:function(){
            navigator.notification.alert("Erro ao se conectar com o banco de dados.", null, "ERRO!", 'OK');
        }
    });
    page = "inicial";
    activate_subpage("#page_87_29"); 
}

function setMateria(id){
    page = "materia";
    idcurso = id;
    var tmp = "";
    var materia = JSON.parse(localStorage.getItem('materias'));    
    for(var i = 0;i < materia.length;i++){
            if(materia[i].idcurso == id){
                tmp += '                    <a class="item item-avatar" onclick="setQuiz('+materia[i].id+')" href="">                      <img src="images/materia.png">                      <h2>'+ materia[i].nome +'</h2>                      <p>'+materia[i].descricao+'</p>                    </a>';
            }
    }
    document.getElementById('materiaList').innerHTML = tmp;
    tmp = "";
    activate_subpage("#uib_page_6"); 
}

function setCurso(){
    var tmp = "";
    var curso = JSON.parse(localStorage.getItem('cursos'));    
    for(var i = 0;i < curso.length;i++){
            tmp += '                    <a class="item item-avatar" onclick="setMateria('+curso[i].id+')" href="">                      <img src="images/curso.png">                      <h2>'+ curso[i].nome +'</h2>                      <p>'+curso[i].descricao+'</p>                    </a>';
    }
    document.getElementById('cursoList').innerHTML = tmp;
    tmp = "";
}

function sync(){
    var id = localStorage.getItem('id');
    var data = {
        id : id
    };
    $.ajax({
        url: 'http://quizapp.pe.hu/api/sync.php',
        type: 'POST',
        data: data,
        success:function(retorno){
            var ret = JSON.parse(retorno);
            localStorage.setItem('usuario', JSON.stringify(ret.usuario));
            localStorage.setItem('quiz', JSON.stringify(ret.quiz));
            localStorage.setItem('perguntas', JSON.stringify(ret.peg));
            localStorage.setItem('respostas', JSON.stringify(ret.res));
            localStorage.setItem('completo', JSON.stringify(ret.completo));
            localStorage.setItem('ranking', JSON.stringify(ret.ranking));
            localStorage.setItem('usuarios', JSON.stringify(ret.usuarios));
            localStorage.setItem('nivel', JSON.stringify(ret.nivel));
            localStorage.setItem('liberado', JSON.stringify(ret.liberado));
            localStorage.setItem('cursos', JSON.stringify(ret.curso));
            localStorage.setItem('materias', JSON.stringify(ret.materia));
            setUser();
            setCurso();
        },
        error:function(){
            navigator.notification.alert("Ocorreu um erro ao conectar com o banco de dados!", null, "ERRO!", 'OK');
        }
    });
}



function limpaConfig(){
    config.id = 0;
    config.npeg = 0;
    config.pegs = [];
    config.res = [];
    config.nres = 0;
    config.maxpeg = 0;
    config.vidas = 5;
    config.acertos = 0;
    config.erros = 0;
}

function terminaJogo(modo){
    var user = JSON.parse(localStorage.getItem('usuario'));
    var quiz = JSON.parse(localStorage.getItem('quiz'));
    var idQuiz = quiz[config.id].id;
    var idUser = user.id;
    var acertos = config.acertos;
    var erros = config.erros;
    var data = {
        id : idUser,
        pegc : acertos,
        pege : erros,
        id_quiz : idQuiz
    }; 
    
    $.ajax({
        url: 'http://quizapp.pe.hu/api/final.php',
        type: 'POST',
        data: data,
        success:function(retorno){
            if(retorno == "sucesso"){
                 navigator.notification.alert("Parabéns! Você concluiu esse quiz!", null, "PARABÉNS!", 'OK');
            }else{
                 navigator.notification.alert("Ocorreu um erro consultar o banco de dados!", null, "ERRO!", 'OK');
            }
        },
        error:function(){
             navigator.notification.alert("Ocorreu um erro ao conectar com o banco de dados!", null, "ERRO!", 'OK');
        }
        
        
    });
    
    if(modo == "vida"){
        navigator.notification.confirm("Deseja Reiniciar o jogo?", function(buttonID){
            if(buttonID == 1){
                reiniciaJogo();
            }else{
                limpaConfig();
                sync();
                page = "quiz";
                activate_page("#home");
            }
        }, "(Deseja Reiniciar o jogo?)", ["Sim", "Não"]);
    }else{
        limpaConfig();
        sync();
    }
    
    
}

function logout(){
    localStorage.setItem('logado', 'nao');
    page = "inicial";
    activate_subpage("#page_87_29");    
}

function refresh(){
    sync();
    navigator.notification.alert("Atualizado com sucesso!", null, "SUCESSO!", 'OK');
}

function onGame(){
    contAlt = 0;
    var me = JSON.parse(localStorage.getItem('usuario'));
    var perguntas = JSON.parse(localStorage.getItem('perguntas'));
    var respostas = JSON.parse(localStorage.getItem('respostas'));
    var numPeg = config.pegs[config.npeg];
    var tmpContPeg = config.npeg + 1;
    var pergunta = tmpContPeg + " - " + perguntas[numPeg].pergunta;
    var pontuacao = (parseInt(me.pegc) - parseInt(me.pege)) + (parseInt(config.acertos) - parseInt(config.erros));
    var nv = getNivel(pontuacao);
    var html = "";
    document.getElementById('nivelOn').innerHTML = nv;
    document.getElementById('pegResp').innerHTML = "&nbsp;"+config.npeg+"/"+config.maxpeg;
    document.getElementById('perguntaGame').innerHTML = pergunta;
    document.getElementById('vidasGame').innerHTML = config.vidas;
    var iniRes = finalRes;
    if(config.npeg === 0){
        finalRes = config.nres;
        iniRes = 0;
    }else{
        finalRes = (config.npeg + 1) * config.nres;        
    }
    for(var i = iniRes;i < finalRes ; i++){
        var num = config.res[i];
        html += '<div onclick="responder('+respostas[num].n+')" class="resposta">                        <a>'+abecedario[contAlt]+") " +respostas[num].resposta+'</a>                            </div>';
        contAlt++;
    
    }
    document.getElementById('respostaGame').innerHTML = html;
}

function getRespostaCerta(idQuiz, idPeg, n){
    var respostas = JSON.parse(localStorage.getItem('respostas'));
    var retorno = "";
    for(var i = 0; i < respostas.length; i++){
        if(respostas[i].id_quiz == idQuiz){
            if(respostas[i].id_pergunta == idPeg){
                if(respostas[i].n == n){
                    retorno = respostas[i].resposta;
                    break;
                }
            }
        }
    }
    return retorno;
}

function responder(resposta){
    var perguntas = JSON.parse(localStorage.getItem('perguntas'));
    var numPeg = config.pegs[config.npeg];
    var certo = perguntas[numPeg].certo;
    var idpeg = perguntas[numPeg].id;
    var quiz = JSON.parse(localStorage.getItem('quiz'));
    var idquiz = quiz[config.id].id;
    if(resposta == certo){
         navigator.notification.alert("Você acertou a questão!", null, "PARABÉNS!", 'OK');
        config.acertos += 1;
    }else{
        if(config.vidas <= 0){
            terminaJogo('vida');
        }else{
            var resCerta = getRespostaCerta(idquiz, idpeg, certo);
            var forMA = "Resposta certa: "+ resCerta;
            navigator.notification.alert(forMA, null, "Você errou a questão!", 'OK');
            config.erros += 1;
            config.vidas = config.vidas - 1;
        }
    }
    config.npeg += 1;
    if(config.npeg != config.maxpeg){
        onGame();
        activate_page("#ongame");
    }else{
        terminaJogo("normal");
        page = "home";
        activate_subpage("#page_25_56");
    }
}

function getUser(id){
    var usuarios = JSON.parse(localStorage.getItem('usuarios'));
    var retorno = 0;
    for(var i = 0; i < usuarios.length ; i++){
        if(usuarios[i].id == id){
            
            retorno = i;
            break;
        } 
    }
    return retorno;
}

function setGame(id){
    var quiz = JSON.parse(localStorage.getItem('quiz'));
    var ranking = JSON.parse(localStorage.getItem('ranking'));
    var usuarios = JSON.parse(localStorage.getItem('usuarios'));
    var tmp = "";
    for(var i = 0; i < ranking.length; i++){
        if(ranking[i].id_quiz == quiz[id].id){
            var userId = getUser(ranking[i].user);
            tmp += '                    <a class="item item-avatar" href="">                      <img src="http://quizapp.pe.hu/api/img/'+usuarios[userId].foto+'">                      <h2>'+usuarios[userId].nome+'</h2>                      <p>ACERTOU '+ranking[i].pegs+' PERGUNTAS</p>                    </a>';
        }
    }
    document.getElementById('gameTit').innerHTML = quiz[id].nome;
    document.getElementById('gameTitOn').innerHTML = quiz[id].nome;
    document.getElementById('gameDesc').innerHTML = quiz[id].descricao;
    document.getElementById('gameDescOn').innerHTML = quiz[id].descricao;
    document.getElementById('rankingList').innerHTML = tmp;
    
}

function pacote(url){
    document.getElementById("webview").src = url;
    activate_page("#web");
}

function iniciaJogo(){
    var quiz = JSON.parse(localStorage.getItem('quiz'));
    var liberado = JSON.parse(localStorage.getItem('liberado'));
    var id = quiz[config.id].id;
    var tem = false;
    for(var i = 0; i < liberado.length; i++){
        if(liberado[i].id_quiz == idcurso){
            tem = true;
        }else{
            continue;
        }
    }
    if(tem === true){
        page = "ongame";
        onGame();
        activate_page("#ongame");
    }else{
        activate_page("#pagamento");
    }
    
}

function reiniciaJogo(){
    var id = config.id;
    limpaConfig();
    startGame(id);
}

function startGame(id){
    config.id = id;
    var perguntas = JSON.parse(localStorage.getItem('perguntas'));
    var respostas = JSON.parse(localStorage.getItem('respostas'));
    var quiz = JSON.parse(localStorage.getItem('quiz'));
    var total = 0;
    var tmpPeg = [];
    for(var i = 0; i < perguntas.length; i++){ 
        if(perguntas[i].id_quiz == quiz[config.id].id){
            for(var a = 0; a < respostas.length; a++){
                var laloli = perguntas[i].id + " : " + respostas[a].id_pergunta;

                if(perguntas[i].id == respostas[a].id_pergunta){
                    config.res.push(a);
                }
            }
            tmpPeg.push(i);
            total += 1;
        }
    }
    config.pegs = tmpPeg;
    config.maxpeg = total;
    config.nres = quiz[config.id].alt;
    //--------------------------------------------------------------------------
    setGame(config.id);
    page = "game";
    activate_page("#game");
    
    
}

function cadastrar(){
    if(document.getElementById("checkReg").checked){
                $.ajax({
                url: 'http://quizapp.pe.hu/api/register.php',
                type: 'POST',
                data: $('form#cadastro').serialize(),
                success:function(retorno){
                    document.getElementById("cadastro").reset();
                    if(retorno == "sucesso"){
                        navigator.notification.alert("Cadastrado com sucesso", null, "SUCESSO!", 'OK');
                       activate_subpage("#uib_page_2");
                    }else{ navigator.notification.alert(retorno, null, "ERRO!", 'OK'); }
                },
                error:function(){
                    document.getElementById("cadastro").reset();
                    navigator.notification.alert("Ocorreu um erro ao conectar com o banco de dados!", null, "ERRO!", 'OK');
                }
            }); 
            }else{
                navigator.notification.alert("Aceite os termos para se registar!", null, "ERRO!", 'OK');
            }
}

function login(){
    $.ajax({
                    url: 'http://quizapp.pe.hu/api/login.php',
                    type: 'POST',
                    data: $('form#login').serialize(),
                    success:function(retorno){
                        var obj = JSON.parse(retorno);
                        if(obj.status == "sucesso"){
                            localStorage.setItem('logado', 'sim');
                            localStorage.setItem('id', obj.id);
                            navigator.notification.alert("Logado com sucesso!", null, "Sucesso!", 'OK');
                            sync();
                            activate_page("#home");          
                            document.getElementById("login").reset();
                            
                        }else{
                            document.getElementById("login").reset();
                            navigator.notification.alert(obj.motivo, null, "ERRO!", 'OK');
                        }
                    },
                    error:function(){
                        document.getElementById("login").reset();
                        navigator.notification.alert("Erro ao se conectar com o banco de dados.", null, "ERRO!", 'OK');
                    }
                });
}

function onDeviceReady(){
    var logado = localStorage.getItem('logado');
    if(logado == 'sim'){
        sync();
        activate_page("#home");
    }
    page = "inicial";
    intel.xdk.device.hideSplashScreen();
    
}

