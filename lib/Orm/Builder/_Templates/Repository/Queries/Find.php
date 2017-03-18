<?="\t\t"?>$this->from("<?= $table ?>");
<?php foreach ($where as $whereElem){?>
<?="\t\t"?>$this->where("<?= $whereElem[0] ?>", "<?= $whereElem[1] ?>");
<?php } ?>
<?php foreach ($join as $joinElem){?>
<?="\t\t"?>$this->join("<?= $joinElem[0] ?>", "<?= $joinElem[1] ?>", "<?= $joinElem[2] ?>");
<?php } ?>
<?="\t\t"?>return $this->get<?= $single ? 'One' : null ?>();