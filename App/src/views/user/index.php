<table>
    <thead>
    <th>id</th>
    <th>name</th>
    <th>action</th>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user->getId(); ?></td>
        <td><?php echo $user->getName(); ?></td>
        <td><a href="<?php echo $view->baseUrl("user/show/{$user->getId()}") ?>">show</a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>