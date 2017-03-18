<?= '<?php' ?>

<?php if(isset($nameSpace) && strlen($nameSpace)>0){ ?>
<?="\n"?>namespace <?= $nameSpace ?>;<?="\n"?>
<?php } ?>

<?php foreach ($importList as $import){ ?>
use <?= "{$import}"?>;
<?php } ?>


<?php if(isset($extendedClass) && strlen($extendedClass)>0){?>
class <?= $object ?> extends <?= $extendedClass ?> {
<?php }else{ ?>
class <?= $object ?> {
<?php } ?>

<?php foreach ($attributeList as $attribute){ ?>
<?= "\n\t{$attribute[0]} {$attribute[1]}" ?><?= !is_null($attribute[2]) ? ' = ' . $attribute[2] : null ?>;
<?php } ?>

<?php if(count($constructor) == 2){ ?>
<?= "\n\n\tpublic function __construct(". implode(', ', $constructor[0]).'){'."\n" ?>
<?= $constructor[1]."\n" ?>
<?= "\t}" ?>
<?php }?>

<?php foreach ($methodList as $method){ ?>
<?= "\n\n\t{$method[0]} function {$method[1]}(". implode(', ', $method[2]).'){'."\n" ?>
<?= $method[3]."\n" ?>
<?= "\t}" ?>
<?php } ?>

}