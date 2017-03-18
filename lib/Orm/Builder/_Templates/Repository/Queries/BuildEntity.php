<?="\t\t"?>$entity = new <?= $entity_name ?>();
<?="\t\t"?>foreach($this->columnList as $kColumn => $column){  
<?="\t\t"?>$entity->{'set'. str_replace(' ', '', ucwords(str_replace(['-','_'], [' ', ' '], $column)))}($data->{$column});
<?="\t\t"?>}
<?="\t\t"?>return $entity;