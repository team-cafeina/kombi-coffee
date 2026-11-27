
const imagens = document.querySelectorAll(".slider img");

let imagemAtual = 0;

// Esconde todas as imagens
imagens.forEach((imagem) => {
    imagem.style.display = "none";
});

// Mostra a primeira imagem
imagens[imagemAtual].style.display = "block";

// Função para trocar as imagens
function trocarImagem() {

    // Esconde a imagem atual
    imagens[imagemAtual].style.display = "none";

    // Avança para a próxima imagem
    imagemAtual++;

    // Verifica se chegou ao final
    if (imagemAtual >= imagens.length) {
        imagemAtual = 0;
    }

    // Mostra a nova imagem
    imagens[imagemAtual].style.display = "block";
}

// Troca a imagem a cada 4 segundos
setInterval(trocarImagem, 4000);
