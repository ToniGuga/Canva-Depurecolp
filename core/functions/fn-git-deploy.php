<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

function canva_git_deploy($git_user = '', $git_token = '')
{
	if (isset($_GET["git_user"]) && (trim($_GET["git_user"]) != "")) {
		$git_user = sanitize_text_field($_GET["git_user"]);
	} elseif (isset($_POST['git_user']) && '' != trim($_POST['git_user'])) {
		$git_user = sanitize_text_field($_POST["git_user"]);
	}

	if (isset($_GET["git_token"]) && (trim($_GET["git_token"]) != "")) {
		$git_token = sanitize_text_field($_GET["git_token"]);
	} elseif (isset($_POST['git_token']) && '' != trim($_POST['git_token'])) {
		$git_token = sanitize_text_field($_POST["git_token"]);
	}


	$git_user_email = get_field('git_user_email','opstions');
	$git_user_name = get_field('git_user_name','opstions');

	$commands = array(
		'git config user.email "'.$git_user_email.'"',
		'git config user.name  "'.$git_user_name.'"',

		'echo $PWD',
		'whoami',
		'git pull',

		'git status',
		// 'git submodule sync',
		// 'git submodule update',
		// 'git submodule status',
		// 'test -e /usr/share/update-notifier/notify-reboot-required && echo "system restart required"',

	);

	$output = "\n";

	$log = "####### " . date('Y-m-d H:i:s') . " #######\n";


	// Run it
	$tmp = shell_exec("$command 2>&1");
	// Output
	$output .= "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$command}\n</span>";
	$output .= htmlentities(trim($tmp)) . "\n";

	$log  .= "\$ $command\n" . trim($tmp) . "\n";

	$log .= "\n";

}
add_action('wp_ajax_canva_git_deploy', 'canva_git_deploy');
add_action('wp_ajax_nopriv_canva_git_deploy', 'canva_git_deploy');
