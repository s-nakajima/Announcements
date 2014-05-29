<?php
if ($User = AuthComponent::user() && $can_edit) {
	echo $this->Html->link(__d('announcements', 'Edit'), array('action' => 'edit', $block_id), array('ng-click' => 'show($event)'));
}
?>
