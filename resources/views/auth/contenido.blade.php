<html>

<head>
    <title>Login</title>
    <link href="application.min.css" rel="stylesheet">
    <!-- Icons -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="all.min.css">
    <link rel="stylesheet" href="font-awesome.min.css"> -->
    <!-- Icons -->
    <!-- Icons -->
    
    <link href="css/plantilla.css" rel="stylesheet">
    <link href="css/application.min.css" rel="stylesheet">


    <link rel="shortcut icon" href="signin.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script async="" src="https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js"></script>
    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        https://code.google.com/p/chromium/issues/detail?id=332189
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        */
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-36759672-9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-36759672-9');
    </script>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m, e, t, r, i, k, a) {
            m[i] = m[i] || function() {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })(window, document, "script", "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js", "ym");
        ym(48020168, "init", {
            id: 48020168,
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true,
            trackHash: true,
            ecommerce: "dataLayer"
        });
    </script>
    <!-- /Yandex.Metrika counter -->
</head>

<body class="login-page">
    <div class="container-fluid">
        <!-- main page content. the place to put widgets in. usually consists of .row > .col-lg-* > .widget.  -->
        @yield('login')
    </div>
    <!-- The Loader. Is shown when pjax happens -->
    <div class="loader-wrap hiding hide ">
        <i class="fa fa-circle-o-notch fa-spin-fast "></i>
    </div>

    <!-- Bootstrap and necessary plugins -->
    <script src="js/plantilla.js"></script>

</body>

</html>
