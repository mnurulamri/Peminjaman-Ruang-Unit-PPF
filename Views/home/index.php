<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PPF FISIP UI</title>

    <!-- Bootstrap core CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="<?=base_url()?>assets/cover/css/style.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900' rel='stylesheet' type='text/css'>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="site-wrapper video-background">
    <!--
    Video from YouTube
    Have Questions? How To:
    https://github.com/pupunzi/jquery.mb.YTPlayer/wiki
    -->
    <a id="bgndVideo" class="player" data-property="{videoURL:'https://www.youtube.com/watch?v=FEgH3UbjffA', containment:'body', autoPlay:true, mute:true, startAt:3, stopAt: 3, opacity:0.3 }"></a>

    <div class="overlay"></div>

    <div class="site-wrapper-inner">

            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand">
                    	<img src="<?=base_url()?>assets/images/ppf-fisip-ui.png"/>
                    </h3>
                    <nav>
                        <ul class="nav masthead-nav">
                            <li>
                            <li>&nbsp;</li>
								<div class="dropdown">
									<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										Aplikasi
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
										<li><a href="<?=base_url()?>penggunaan/ruang">Peminjaman Ruang</a></li>
										<!--
										<li role="separator" class="divider"></li>
										<li><a href="#"> </a></li>
										-->
									</ul>
								</div>
                            </li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                        </ul>
                    </nav>
                </div>
            </div>

        <div class="cover-container">
            <div class="inner cover">
                <h1 class="cover-heading">P P F</h1>
                <p class="lead"></p>
                <p class="lead"><font class="btn btn-lg btn-default" style="font-size:30px; font-style: normal">Unit Pengelolaan dan Pemeliharaan</font></p>
				<p class="lead">Fakultas Ilmu Sosial dan Ilmu Politik</p>
				<p class="lead">Universitas Indonesia</p>
            </div>

            <div class="mastfoot">
                <div class="inner">
                    <p><a href="fisip.ui.ac.id" style="border:1px solid gold; padding:1px 2px; color:gold">Fakultas Ilmu Sosial dan Ilmu Politik</a><!--</p>
                    <p>--><a href="ui.edu"><font style="border:1px solid gold; color:#000; padding:1px 2px; background:gold">U  n  i  v  e  r  s  i  t  a  s&nbsp;&nbsp;&nbsp;I  n  d  o  n  e  s  i  a</font></a></p>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- jQuery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- Bootstrap core JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<!-- Plugins and Custom JavaScript -->
<script src="<?=base_url()?>assets/cover/js/device.min.js"></script>
<script src="<?=base_url()?>assets/cover/js/jquery.mb.YTPlayer.js"></script>
<script src="<?=base_url()?>assets/cover/js/custom.js"></script>

<!--
Google Analitics
Demo Purpose Only
Change UA-XXXXXXX-X to be your site's ID

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-1057679-2', 'auto');
    ga('send', 'pageview');
</script>
 -->
</body>
</html>
