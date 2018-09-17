<table>
    <thead>
    <?php foreach(reset($users) as $key => $values): ?>
        <th><?php echo $key?></th>
    <?php endforeach; ?>
    <th>action</th>
    </thead>
    <tbody>
    <?php foreach($users as $key => $values): ?>
    <tr>
        <td><?php echo $values['id']?></td>
        <td><?php echo $values['name']?></td>
        <td><a href="<?php echo $this->baseUrl("user/show/{$values['id']}")?>">show</a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>