<?php

function menu_active_class($key) {
	return CURRENT_PAGE === $key ? ' active' : '';
}

function menu_active_sr($key) {
	return CURRENT_PAGE === $key ? ' <span class="sr-only">(otvorené)</span>' : '';
}

?>