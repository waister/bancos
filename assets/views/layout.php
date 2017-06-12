<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?php
        if ($pageTitle) {
            echo $pageTitle . " - " . APP_NAME;
        } else {
            echo APP_TITLE;
        }
    ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta name="title" content="<?php echo $pageTitle; ?>" />
    <meta name="description" content="<?php echo $pageDescription; ?>" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="Waister Nunes <waisters@gmail.com>" />
    <meta property="og:title" content="<?php echo $pageTitle; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo $pageUrl; ?>" />
    <meta property="og:image" content="<?php echo imageShare($pageName); ?>" />
    <meta property="og:site_name" content="<?php echo APP_NAME; ?>" />
    <meta property="fb:admins" content="100000195697112" />
    <meta itemprop="name" content="<?php echo APP_NAME; ?>" />
    <meta itemprop="description" content="<?php echo $pageDescription; ?>" />
    <meta itemprop="image" content="<?php echo imageShare($pageName); ?>" />
    <link rel="canonical" href="<?php echo $pageUrl; ?>" />
    <link rel="shortcut icon" href="<?php echo SERVER_URL; ?>favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo SERVER_URL; ?>favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <style><?php
        css("app");

        css($pageName);
    ?></style>
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 600;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-weight: 100;
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .line {
            margin-bottom: 20px;
        }

        .line .label {
            margin-bottom: 3px;
            font-size: 18px;
            color: #888888;
        }

        .line .data {}

        .line .link {
            color: #636b6f;
            text-decoration: none;
        }

        .line .link:hover,
        .line .link:focus {
            color: #286cec;
        }

        .line .link .tag {
            display: inline;
            margin: 0 5px;
            padding: 2px 5px;
            color: white;
            font-size: 12px;
            background: #636b6f;
            border-radius: 2px;
        }

        .line .link:hover .tag,
        .line .link:focus .tag {
            background: #286cec;
        }
    </style>
</head>
<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <?php view($pageName); ?>
        </div>
    </div>

    <script src="<?php echo JS_URL; ?>jquery.min.js"></script>
    <script src="<?php echo JS_URL; ?>app.js"></script>
</body>
</html>