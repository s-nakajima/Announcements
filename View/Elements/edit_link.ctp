<?php
if ($User = AuthComponent::user() && $canEdit) {
	echo $this->Html->link(__d('announcements', 'Edit'), array('action' => 'edit', $blockId), array('ng-click' => 'show($event)'));
}
