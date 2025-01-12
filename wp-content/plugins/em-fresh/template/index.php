<?php

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$compare_id = isset($_GET['compare_id']) ? intval($_GET['compare_id']) : 0;
$action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : '';

$title = $action == 'new' || $id > 0 ? 'Form' : 'List';

?><!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title . ' - ' . $manager ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
<div class="container">
<?php
    if ($compare_id > 0 && $id > 0) {
        require_once 'compare.php';
    } else if ($action == 'new' || $id > 0) {
        require_once 'edit.php';
    } else {
        require_once 'list.php';
    }
?>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>