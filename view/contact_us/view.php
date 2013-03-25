<h1><?=$contact_us['title']?></h1>
<p><a href="contact_us.php?action=create">Создать запись</a></p>
<table border="1">
    <tr><td><?=implode('</td><td>',$contact_us['table']['fields'])?></td><td>Управление</td></tr>
    <?php foreach ($contact_us['data'] as $row):?>
    <tr><td><?=implode('</td><td>', $row)?></td>
        <td>
            <a href="contact_us.php?action=update&id=<?=$row['id']?>">Редактировать</a>
            <a href="contact_us.php?action=delete&id=<?=$row['id']?>">Удалить</a>
        </td>
    </tr>
    <?php endforeach;?>            
</table>
<p><a href="index.php">На главную</a></p>
