<h1><?php echo $user->getName() ?>
    <small>(<?= $user->getId() ?>)</small>
</h1>
<a href="<?php echo $this->baseUrl("user") ?>">retour</a>
<a href="<?php echo $this->baseUrl("user/del/{$user->getID()}") ?>">delete</a>