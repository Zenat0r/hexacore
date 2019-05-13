<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hexacore Erreur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <header>
        <h1><?php echo $this->content ?></h1>
        <h3><?php echo "In file : " . $this->headers['file'] . " on line " . $this->headers['line'] ?></h3>
    </header>
    <main>
        <?php echo $this->headers['trace'] ?>
    </main>
</body>
</html>