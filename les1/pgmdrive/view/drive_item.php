<div class="item">
    <?php if (is_file( $folder . $item)) : ?>
        <i class="fa fa-file"></i>
        <a class="name" href="/view.php?item=<?= $folder . $item; ?>"><?= $item; ?></a>
        <div class="size"><?php echo filesize($folder . $item); ?> bytes</div>
    <?php elseif(is_dir($folder . $item)) : ?>
        <i class="fa fa-folder"></i>
        <a class="name" href="/index.php?folder=<?= $item; ?>"><?= $item; ?></a>
    <?php endif; ?>
</div>