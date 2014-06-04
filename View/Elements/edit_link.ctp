<?php
if ($User = AuthComponent::user() && $canEdit) {
	echo $this->Html->link(__d('announcements', 'Edit'), array('action' => 'edit', $frameId), array('ng-click' => 'show($event)'));
}
