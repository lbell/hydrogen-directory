<?php
function hydir_thumb($id, $size = "thumb") {
	if (has_post_thumbnail($id)) {
		return get_the_post_thumbnail($id, $size, array('class' => ''));
	} else {
		return '<img class="" src="' . HYDIR_URL . 'public/img/avatar_blank.jpg" alt="" />';
	}
}
