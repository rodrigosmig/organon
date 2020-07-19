<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>{{ config('app.name', 'Órganon') }}</title>
    
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/landing-page.min.css') }}" rel="stylesheet">
    </head>

    <body>

        <nav class="navbar navbar-light bg-light static-top">
            <div class="container">
                <a class="navbar-brand" href="#">{{ config('app.name', 'Órganon') }}</a>
                {{-- <a class="btn btn-primary" href="#">Sign In</a> --}}
                @auth
                    <a class="btn btn-primary" href="{{ url('/home') }}">Home</a>
                @else
                    <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
                @endauth
            </div>
        </nav>

        <header class="masthead text-white text-center">
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-10 mx-auto">
                        <h1 class="mb-5">
                            Órganon: Organizado do seu jeito.                          
                        </h1>
                    </div>
                </div>
                <div class="col-12 col-md-2 mx-auto">
                    <a href="{{ route('register') }}" type="submit" class="btn btn-block btn-lg btn-primary">Registre-se</a >
                </div>
            </div>
        </header>

        <section class="features-icons bg-light text-center">
            <div class="container">
                <div class="row">
                    <h1>
                        O Órganon é um gerenciador de projetos e tarefas, que permite otimizar sua rotina e a de sua equipe. 
                        Ideal para freelancers que querem visualizar melhor seu  fluxo de trabalho e para gerentes de projetos que comandam um time.
                    </h1>
                </div>
            </div>
        </section>


        <section class="showcase">
            <div class="container-fluid p-0">
                <div class="row no-gutters">

                    <div class="col-lg-6 order-lg-2 text-white bg-info showcase-img" style="background-image: url('img/bg-showcase-1.jpg');"></div>
                    <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                        <h2>Quando tudo é urgente, nada é urgente!</h2>
                        <p class="lead mb-0">
                            Quem nunca iniciou o dia com tanta tarefa que nem sabia por onde começar? No Órganon, as tarefas que tem prazos menores ficam no topo da lista de prioridades.
                        </p>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-6 text-white bg-info showcase-img" style="background-image: url('img/bg-showcase-2.jpg');"></div>
                    <div class="col-lg-6 my-auto showcase-text">
                        <h2>Quanto tempo o tempo tem?</h2>
                        <p class="lead mb-0">
                            Não sabemos, mas com  o Órganon você pode cronometrar quanto tempo gasta para executar cada tarefa. Com as opções de play, pause e stop, você consegue analisar seu perfil no trabalho e quais tarefas demandam mais tempo. 
                            Também te  ajuda a responder a próxima pergunta.
                        </p>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-6 order-lg-2 text-white bg-info showcase-img" style="background-image: url('img/bg-showcase-3.jpg');"></div>
                    <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                        <h2>Estou cobrando pouco pelo meu trabalho?</h2>
                        <p class="lead mb-0">
                            Quem nunca fez essa pergunta que atire o primeiro comprovante de pagamento! Saber quanto tempo você gastou para executar a tarefa e acessar de forma fácil quanto foi pago e quanto você gastou para executar o projeto é essencial para você cobrar um preço justo, tanto para você quanto para o cliente.
                        </p>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-6 text-white bg-info showcase-img" style="background-image: url('img/bg-showcase-2.jpg');"></div>
                    <div class="col-lg-6 my-auto showcase-text">
                        <h2>De quem é a culpa?</h2>
                        <p class="lead mb-0">
                            Quem gerencia equipe, precisa entender as responsabilidades de todas as pessoas envolvidas, para cobrar de forma mais efetiva o andamento do projeto.
                        </p>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-6 order-lg-2 text-white bg-info showcase-img" style="background-image: url('img/bg-showcase-3.jpg');"></div>
                    <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                        <h2>Quem manda é o cliente!</h2>
                        <p class="lead mb-0">
                            Com o cadastro de clientes, além das informações de quem te contratou, é possível organizar melhor seu fluxo de trabalho. 
                            Assim, é possível perceber quais clientes te demandam mais tarefas e se você não está deixando nenhum de lado. 
                        </p>
                    </div>
                </div>
            </div>
        </section>


        <footer class="footer bg-light">
            <div class="container">
            <div class="row">
                <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
                <ul class="list-inline mb-2">
                    <li class="list-inline-item">
                    <a href="#">About</a>
                    </li>
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                    <a href="#">Contact</a>
                    </li>
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                    <a href="#">Terms of Use</a>
                    </li>
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                    <a href="#">Privacy Policy</a>
                    </li>
                </ul>
                <p class="text-muted small mb-4 mb-lg-0">&copy; Your Website 2019. All Rights Reserved.</p>
                </div>
                <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item mr-3">
                    <a href="#">
                        <i class="fab fa-facebook fa-2x fa-fw"></i>
                    </a>
                    </li>
                    <li class="list-inline-item mr-3">
                    <a href="#">
                        <i class="fab fa-twitter-square fa-2x fa-fw"></i>
                    </a>
                    </li>
                    <li class="list-inline-item">
                    <a href="#">
                        <i class="fab fa-instagram fa-2x fa-fw"></i>
                    </a>
                    </li>
                </ul>
                </div>
            </div>
            </div>
        </footer>



    </body>
</html>
