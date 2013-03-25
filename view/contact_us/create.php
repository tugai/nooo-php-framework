<h1><?=$contact_us['title']?></h1>
<form name="contact_us" action="contact_us.php?action=create&step=process" method="post">
<div><?=$contact_us['form']['error_msg']?></div>
<table>
    <tr><td>Email:</td><td><input type="email" name="email" value="<?=$contact_us['form']['email']?>"></td></tr>
    <tr><td>Тема:</td><td><input type="text" name="subject" value="<?=$contact_us['form']['subject']?>"></td></tr>
    <tr><td>Сообщение:</td><td><textarea name="message"><?=$contact_us['form']['message']?></textarea></td></tr>
</table>    
<input type="submit" value="Создать">
</form>
<p><a href="index.php">На главную</a> :: <a href="contact_us.php">Назад к списку</a></p>
