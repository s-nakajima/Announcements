<?php /*  「下書き中」ラベル表示 */
if (!$this->data['Announcement']['is_published']) {
	echo "<span class=\"label label-default\">".__d('announcements', 'Draft in')."</span>";
}
?>