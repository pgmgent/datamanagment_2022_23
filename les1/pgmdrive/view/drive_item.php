<div class="item">
    <?php if (is_file('drive/' . $item)) : ?>
        <i class="fa fa-file"></i>
        <a class="name" href="/view.php?item=<?= $item; ?>"><?= $item; ?></a>
        <div class="size"><?php echo filesize('drive/' . $item); ?> bytes</div>
    <?php elseif(is_dir('drive/' . $item)) : ?>
        <i class="fa fa-folder"></i>
        <div class="name"><?= $item; ?></div>
    <?php endif; ?>
</div>