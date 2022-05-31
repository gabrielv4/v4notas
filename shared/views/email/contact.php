<?php $v->layout("_theme", ["subject" => 'Contato do site']); ?>

<h2>Contato recebido no site Edune Cursos</h2>
<p><b>Nome:</b><?= $data['fullname']; ?></p>
<p><b>E-mail:</b><?= $data['email']; ?></p>
<p><b>Telefone:</b><?= $data['phone']; ?></p>
<p><?= str_textarea($data['message']); ?></p>
