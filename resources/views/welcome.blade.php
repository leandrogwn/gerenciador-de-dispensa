<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html>

<head>
    <title>Gurski Assessoria</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <noscript>
        <link rel="stylesheet" href="{{ asset('css/noscript.css') }}" />
    </noscript>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}?v={{ date('YmdHis') }}">
</head>

<body id="inicio" class="is-preload landing">
    <div id="page-wrapper">

        <!-- Header -->
        <header id="header">

            <nav id="nav">
                <ul>
                    <li><a href="#inicio">Ínicio</a></li>
                    <li><a href="#cultura" class="scrolly">Cultura</a></li>
                    <li><a href="#treinamento" class="scrolly">Treinamentos</a></li>
                    <li><a href="#servico" class="scrolly">Serviços</a></li>
                    <li><a href="#" class="scrolly">Sistemas</a>
                        <ul>
                            <li><a href="{{ route('login') }}">Gerenciador de Despesas</a></li>

                        </ul>
                    </li>
                    <li><a href="#contato" class="scrolly">Entre em contato</a></li>
                </ul>
            </nav>
        </header>

        <!-- Banner -->
        <section id="banner">
            <div class="content">
                <header>
                    <span class="logo"><img src="{{ asset('images/logo.svg') }}" alt="" /></span>
                    <h2>Gurski Assessoria</h2>
                    <p>Gestão pública simples, transparente e segura.</p>
                </header>
            </div>
            <a href="#cultura" class="goto-next scrolly">Próximo</a>
        </section>

        <!-- One -->
        <section id="cultura" class="spotlight style1 bottom">
            <span class="image fit main"><img src="{{ asset('images/lovely.jpg') }}" alt="" /></span>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-4 col-12-medium">

                            <h2>Missão</h2>
                            <p>Proporcionar segurança e transparência nas contratações públicas, afastando o
                                fracionamento de despesa para garantir que o interesse público seja alcançado da
                                melhor maneira possível.</p>

                        </div>
                        <div class="col-4 col-12-medium">

                            <h2>Visão</h2>
                            <p>Empresa idônea, de confiança e qualidade, reconhecidos pela Administração Pública e
                                pela sociedade.</p>

                        </div>
                        <div class="col-4 col-12-medium">

                            <h2>Valores</h2>
                            <div class="row">
                                <div class="col"> Confiança<br>
                                    Segurança<br>
                                    Solidariedade<br>
                                </div>
                                <div class="col"> Seriedade<br>
                                    Qualidade<br>
                                    Austeridade
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <a href="#treinamento" class="goto-next scrolly">Próximo</a>
        </section>

        <!-- Two -->
        <section id="treinamento" class="spotlight style2 right">
            <span class="image fit main"><img src="{{ asset('images/pic17.jpg') }}" alt="" /></span>
            <div class="content">
                <header>
                    <h2>Treinamentos</h2>
                    <p>Capacitação de servidores</p>
                </header>
                <p>Cursos de aperfeiçoamento e treinamento para servidores públicos relacionados a compras
                    públicas e processos licitatórios, orientando desde a fase interna até a fase de fiscalização e
                    atuação da comissão processante de fornecedores.</p>
                <!-- <ul class="actions">
                    <li><a href="#" class="button">Saiba mais</a></li>
                </ul>-->    
            </div>
            <a href="#servico" class="goto-next scrolly">Próximo</a>
        </section>

        <!-- Three -->
        <section id="servico" class="spotlight style3 left">
            <span class="image fit main bottom"><img src="{{ asset('images/pic18.jpg') }}" alt="" /></span>
            <div class="content">
                <header>
                    <h2>Serviços</h2>
                    <p>Consultoria pública</p>
                </header>
                <p>Ajudar empresas sérias e idôneas a fornecer seus serviços e produtos para a Administração Pública,
                    visando possibilitar uma politica pública de qualidade, seriedade e desburocratizada. Assim, tanto
                    empresa, quanto órgão público e sociedade serão beneficiadas com compras públicas através de
                    empresas capacitadas e qualificadas para atender o interesse público.</p>
                <!-- <ul class="actions">
                    <li><a href="#" class="button">Saiba mais</a></li>
                </ul>-->
            </div>
            <a href="#contato" class="goto-next scrolly">Próximo</a>
        </section>

        <!-- Four -->
        <section id="contato" class="wrapper style1 special fade-up">
            <div class="container">
                <header class="major">
                    <h2>Entre em contato</h2>
                    <p>Solicite mais informações</p>
                </header>
                <div class="box alt">
                    <div class="row gtr-uniform">
                        <section class="col-4 col-6-medium col-12-xsmall">
                            <i class="icon major bi-envelope"></i>
                            <h3>E-mail</h3>
                            <p><a href="mailto:contato@gurskiassessoria.com.br">contato@gurskiassessoria.com.br</a></p>
                        </section>
                        <section class="col-4 col-6-medium col-12-xsmall">
                            <i class="icon major bi-telephone"></i>
                            <h3>Suporte jurídico</h3>
                            <p><a class="text-decoration-none" href="https://api.whatsapp.com/send?phone=45999157595&text=Olá,%20gostaria%20de%20ter%20mais%20detalhes%20sobre%20o%20suporte%20jurídico.">(45) 9 9915-7595</a></p>
                        </section>
                        <section class="col-4 col-6-medium col-12-xsmall">
                            <i class="icon major bi-whatsapp"></i>
                            <h3>Suporte técnico</h3>
                            <p><a class="text-decoration-none" href="https://api.whatsapp.com/send?phone=45999157595&text=Olá,%20gostaria%20de%20auxílio%20técnico.">(45) 9 9940-6202</a></p>
                        </section>

                    </div>
                </div>

            </div>
        </section>

        <!-- Footer -->
        <footer id="footer">
            <ul class="icons">
                <!--<li><a href="#" class="icon major bi-facebook" style="color: #fff;"><span class="label">Facebook</span></a>
                </li>-->
                <li><a href="https://www.instagram.com/gurskiassessoria/" class="icon major bi-instagram" style="color: #fff;" target="_blank"><span class="label">Instagram</span></a>
                </li>
            </ul>
            <ul class="copyright">
                <li>&copy; Gurski Assessoria LTDA - CNPJ: 47.506.914/0001-92</li>
            </ul>
        </footer>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.scrolly.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dropotron.min.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollex.min.js') }}"></script>
    <script src="{{ asset('js/browser.min.js') }}"></script>
    <script src="{{ asset('js/breakpoints.min.js') }}"></script>
    <script src="{{ asset('js/util.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
