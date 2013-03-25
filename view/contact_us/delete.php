<h1><?=$contact_us['title']?></h1>
<form name="contact_us" action="contact_us.php?action=delete&step=process" method="post">
<input type="hidden" name="id" value="<?=$contact_us['form']['id']?>">
<table>
    <tr><td>id:</td><td><?=$contact_us['form']['id']?></td></tr>
    <tr><td>Email:</td><td><?=$contact_us['form']['email']?></td></tr>
    <tr><td>Тема:</td><td><?=$contact_us['form']['subject']?></td></tr>
    <tr><td>Сообщение:</td><td><?=$contact_us['form']['message']?></td></tr>
</table>    
<input type="submit" value="Удалить">
</form>
<p><a href="index.php">На главную</a> :: <a href="contact_us.php">Назад к списку</a></p>
