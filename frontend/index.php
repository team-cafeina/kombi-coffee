
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./assets/styles/tailwind-output.css">
    <link rel="stylesheet" href="./assets/styles/style.css">

    <title>KOMBI coffee</title>
</head>

<body>
    <header>
        <div class="logo">
            <h1><span>KOMBI</span>coffee</h1>
        </div>

        <nav>
            <a href="#produtos">Produtos</a>
            <a href="pages/cardapio.php">Cardápio</a>
            <a href="#historia">História</a>
            <a href="#localidade">Localidade</a>
            <a href="#franqueado">Quer ser um franqueado?</a>
        </nav>

        <div class="mascote">
            <img src="./assets/images/KOMBI (2) 2.png" alt="Mascote KOMBIcoffee">
        </div>

    </header>

    <main>

        <section class="banner" id="inicio">

            <div class="slider">
                <img src="./assets/images/banner1.png" alt="Banner 1">
                <img src="./assets/images/kombi kd.png" alt="Banner 2">
                <img src="./assets/images/banner3.png" alt="Banner 3">
                <img src="./assets/images/kombii.png" alt="Banner 4">
                <img src="./assets/images/banner5.png" alt="Banner 5">
            </div>

        </section>

        <section class="galeria">

            <div class="texto-kombi">
                <p>
                    Mais do que servir café, nós criamos uma atmosfera.
                    Nosso espaço combina a estética acolhedora das décadas
                    passadas — tons terrosos, luzes quentes e com a
                    praticidade que o seu dia pede.
                </p>
            </div>

            <div class="galeria-kombi">
                <img src="./assets/images/Rectangle 115.png" alt="">
                <img src="./assets/images/Rectangle 116.png" alt="">
                <img src="./assets/images/Rectangle 118.png" alt="">
                <img src="./assets/images/Rectangle 119 (1).png" alt="">
                <img src="./assets/images/Rectangle 117.png" alt="">
            </div>

        </section>

        <section class="style" id="produtos">

            <h2>kombi <span>style</span></h2>

            <div class="produtos">

                <figure>
                    <img src="assets/images/17 3.png" alt="Bolsas">
                </figure>

                <figure>
                    <img src="assets/images/19 3.png" alt="Boné">
                </figure>

                <figure>
                    <img src="assets/images/22 3.png" alt="Camiseta">
                </figure>

                <figure>
                    <img src="assets/images/27 1.png" alt="Canecas">
                </figure>

                <figure>
                    <img src="assets/images/32 3.png" alt="Camisetas baby look">
                </figure>

            </div>

        </section>

<section id="cardapio"
    class="relative flex min-h-[320px] w-full items-center justify-center overflow-hidden border-b-2 border-[#F8F8D9] px-6 py-16">

    <img
        src="./assets/images/Rectangle 115 (1).png"
        alt="Kombi da KOMBIcoffee"
        class="absolute inset-0 h-full w-full object-cover"
    >

    <div class="absolute inset-0 bg-[#F8F8D9]/65"></div>

    <div class="relative z-10 flex flex-col items-center gap-6 text-center">

        <h2 class="text-[30px] font-medium text-[#E35336] md:text-[40px]">
            acesse o nosso cardápio
        </h2>

        <a
            href="pages/cardapio.php"
            class="flex h-11 w-36 items-center justify-center rounded-full bg-[#E35336] text-sm text-white transition duration-300 hover:scale-105 hover:bg-[#8D4805]"
        >
            Acesse
        </a>

    </div>
</section>

<section id="historia" class="w-full bg-[#F8F8D9] px-8 py-20 md:px-16">

    <h2 class="mb-14 text-center text-[30px] font-medium text-[#8D4805] md:text-[36px]">
        a história por trás da xícara
    </h2>

    <div class="mx-auto grid max-w-[1100px] grid-cols-1 items-center gap-10 md:grid-cols-[380px_1fr] md:gap-16">

        <img
            src="./assets/images/Rectangle 112.png"
            alt="História da fundadora"
            class="block h-[280px] w-full object-cover"
        >

        <p class="text-justify text-[16px] leading-[1.8] text-[#8D4805] md:text-[18px]">
            A nossa cafeteria nasceu de um sonho de infância
            e de uma homenagem cheia de carinho. Fundada por
            Sophia Vergara que cresceu vendo o pai transformar
            a paixão pelo café.
        </p>

    </div>

    <div class="mx-auto mt-14 max-w-[1100px]">

        <p class="text-justify text-[16px] leading-[1.8] text-[#8D4805] md:text-[18px]">
            "Quando decidi abrir este espaço em 2018, sabia que não
            seria apenas um negócio, mas uma forma de honrar os
            ensinamentos do meu pai e a arte de acolher pessoas.
            Unimos a nostalgia dos anos 70 com processos modernos
            para que cada cliente sinta que este lugar também é
            um pouco seu."
        </p>

        <p class="mt-4 text-[16px] font-semibold italic text-[#8D4805] underline">
            — Sophia Vergara, Fundadora
        </p>

    </div>

</section>

<section class="localidade" id="localidade">

    <div class="localidade-conteudo">

        <div class="localidade-imagem">
            <img src="./assets/images/banner4.png" alt="Fachada da KOMBIcoffee">

            <p>Avenida Não Sei Oque, 112 - São Paulo, SP</p>
        </div>

        <div class="localidade-texto">
            <h2>localidade</h2>

            <p>
                Um espaço pensado para você dar uma pausa no dia,
                encontrar amigos ou trabalhar com um bom café ao lado.
            </p>
        </div>

    </div>

</section>

<section class="franqueado" id="franqueado">

    <div class="franqueado-texto">

        <h2>
            quer ser um<br>
            franqueado?
        </h2>

        <p>
            Na KOMBI Coffee, tradição e inovação caminham juntas.
            Procuramos parceiros com visão de futuro, dedicados a
            construir relacionamentos e a levar nossa paixão pelo
            café e pelo bem-receber para novas cidades.
        </p>

    </div>


    <form class="form-franqueado">

        <div class="campo">
            <label for="nome">nome</label>
            <input
                type="text"
                id="nome"
                name="nome"
                placeholder="digite seu nome"
                required
            >
        </div>

        <div class="campo">
            <label for="email">e-mail</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="digite seu e-mail"
                required
            >
        </div>

        <div class="campo">
            <label for="mensagem">mensagem</label>
            <textarea
                id="mensagem"
                name="mensagem"
                placeholder="escreva sua mensagem"
                required
            ></textarea>
        </div>

        <button type="submit">Enviar</button>

    </form>

</section>

<footer class="footer">

    <div class="footer-esquerda">

        <p class="copyright">
            team cafeína @ 2026 - Centro Universitário Senac Santo Amaro
        </p>

        <div class="footer-marcas">

            <div class="marca-equipe">
                <span class="icone-cafe">☕</span>
                <span>team cafeína</span>
            </div>

            <div class="marca-kombi">
                <span class="icone-kombi">☮</span>
                <span>kombi coffee</span>
            </div>

        </div>

    </div>

    <div class="footer-redes">

        <a href="#" aria-label="Facebook" class="rede facebook">f</a>

        <a href="#" aria-label="Figma" class="rede figma">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path fill="#F24E1E" d="M8 2h4v6H8a3 3 0 1 1 0-6Z"/>
                <path fill="#FF7262" d="M12 2h4a3 3 0 1 1 0 6h-4V2Z"/>
                <path fill="#A259FF" d="M8 8h4v6H8a3 3 0 1 1 0-6Z"/>
                <path fill="#1ABCFE" d="M12 8h4a3 3 0 1 1-3 3V8Z"/>
                <path fill="#0ACF83" d="M8 14h4v3a3 3 0 1 1-4-3Z"/>
            </svg>
        </a>

        <a href="#" aria-label="GitHub" class="rede github">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path fill="currentColor" d="M12 .8a11.2 11.2 0 0 0-3.54 21.83c.56.1.77-.24.77-.54v-2.1c-3.13.68-3.79-1.33-3.79-1.33-.51-1.3-1.25-1.65-1.25-1.65-1.02-.7.08-.69.08-.69 1.13.08 1.72 1.16 1.72 1.16 1 1.72 2.63 1.22 3.27.93.1-.73.39-1.22.71-1.5-2.5-.28-5.13-1.25-5.13-5.55 0-1.23.44-2.24 1.16-3.03-.12-.28-.5-1.44.11-2.99 0 0 .95-.3 3.08 1.16a10.7 10.7 0 0 1 5.6 0c2.13-1.45 3.08-1.16 3.08-1.16.61 1.55.23 2.71.11 2.99.72.79 1.16 1.8 1.16 3.03 0 4.31-2.63 5.27-5.14 5.55.4.35.75 1.03.75 2.08v3.1c0 .3.2.65.78.54A11.2 11.2 0 0 0 12 .8Z"/>
            </svg>
        </a>

        <a href="#" aria-label="Notion" class="rede notion">N</a>

    </div>

</footer>


    </main>


    <script src="./assets/js/script.js"></script>

</body>
</html>
