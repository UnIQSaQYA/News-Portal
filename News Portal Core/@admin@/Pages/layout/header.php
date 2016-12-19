<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? ucfirst($title) : 'Login'; ?></title>
    <link rel="stylesheet" href="<?= ASSET . 'css/bootstrap.css'; ?>">
    <link rel="stylesheet" href="<?= ASSET . 'fancybox/source/jquery.fancybox.css'; ?>">
    <link rel="stylesheet" href="<?= ASSET . 'datetime/bootstrap-datetimepicker.css'; ?>">

    <link rel="stylesheet" href="<?= ASSET . 'select2/css/select2.css'; ?>">
    <link rel="stylesheet" href="<?= ASSET . 'alertifyjs/alertify.css'; ?>">
    <script src="<?= ASSET . 'ckeditor/ckeditor.js'; ?>"></script>

    <link rel="stylesheet" href="<?= ASSET . 'css/custom.css'; ?>">
    <link rel="stylesheet" href="<?= ASSET . 'font-awesome/css/font-awesome.css'; ?>">

    <script>
        var baseUrl = '<?=HTTP?>';
    </script>


</head>
<body>