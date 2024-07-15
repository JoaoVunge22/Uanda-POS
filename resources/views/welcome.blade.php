<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background-image: url('img/fundo.webp'); background-repeat: no-repeat; background-size: cover; background-position: 50%;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg border-start ">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#"><img src="img/uanda.png" style="height: 4em" class="img-fluid" alt=""></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                                </li>
                                <span class="mx-2"></span>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Sobre nós</a>
                                </li>
                                <span class="mx-2"></span>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Contacta-nós</a>
                                </li>
                                <span class="mx-2"></span>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Planos</a>
                                </li>
                                <span class="mx-5"></span>
                                <li>
                                    <a href="#" class="btn btn-outline-primary">Conecta-se</a>
                                </li>
                                <span class="mx-2"></span>
                                <li>
                                    <a href="#" class="btn btn-success">Comece Gratuitamente</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            {{-- Home --}}

            <div class="col-12 mt-5">
                <div class="row m-0 align-items-center">
                    <div class="col">
                        <h1 class="fw-bold" style="font-size: 2.700em">
                            Um sistema POS para <br> gerir todo o seu negócio
                        </h1>

                        <p class="text-muted mt-5" style="font-size: 1.200em">
                            Gerencie seu negócio, desde vendas e faturamento, seus livros, sua clientela e força de trabalho até seu estoque e operações. Com módulos de gerenciamento de negócios poderosos e totalmente integrados implementados para atender às suas necessidades de negócios em qualquer lugar, a qualquer hora, rastreie perfeitamente em tempo real, controle e expanda seu negócio enquanto nosso software complementa seu trabalho.
                        </p>
                        <a href="#" class="btn btn-lg btn-success mt-3">Comece Gratuitamente</a>

                        <div class="mt-4">
                            <small>Teste gratuito de 14 dias</small>
                            <span class="mx-1">|</span>
                            <small>Não é necessário cartão de crédito</small>
                            <span class="mx-1">|</span>
                            <small>Sem configuração</small>
                        </div>
                    </div>
                    <div class="col">
                        <img src="img/pos.webp" class="d-block m-auto" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
