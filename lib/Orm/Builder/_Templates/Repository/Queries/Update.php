<?php foreach ($where as $whereElem){?>
<?="\t\t"?>$this->where("<?= $whereElem[0] ?>", "<?= $whereElem[1] ?>");
<?php } ?>
<?="\t\t"?>return $this->update("<?= $table ?>", <?= $data ?>);