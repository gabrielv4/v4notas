<?php $v->layout("_theme", ["subject" => $subject]); ?>

    <h2><?= $title; ?></h2>
<?= $subtitle; ?>
<?= $message; ?>

<?php if (!empty($link)): ?>
    <p><a title='<?= $linkTitle; ?>' href='<?= $link; ?>'><?= $linkTitle; ?></a></p>
<?php endif; ?>