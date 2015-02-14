<?php
/**
 * @var string $title
 * @var string|null $content
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php print $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/css/bootstrap-theme.min.css" rel="stylesheet" />
    <link href="/css/style.css" rel="stylesheet" />
</head>
<body>
<div id="content">
    <?php print $content; ?>
</div>
<div id="footer">
    <script src="/js/bootstrap.min.js"></script>
</div>
</body>
</html>