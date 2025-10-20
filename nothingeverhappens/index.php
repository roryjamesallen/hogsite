<?php
include '../lib/generic_content.php';
openSqlConnection('wildhog_nothingeverhappens', '../sql_login_wildhog_nothingeverhappens.php');

ob_start(); // Begin output buffering to allow output to be rendered after html head

function getUsernameById($user_id){
	return json_decode(sqlQuery("SELECT username FROM users WHERE user_id='".$user_id."'"),true)['0']['username'];
}
function getUserIdByUsername($username){
	return json_decode(sqlQuery("SELECT user_id FROM users WHERE username='".$username."'"),true)['0']['user_id'];
}
function getGroupNameById($group_id){
	return json_decode(sqlQuery("SELECT name FROM groups WHERE group_id='".$group_id."'"),true)['0']['name'];
}
function getGroupUsernamesById($group_id){
	$usernames = [];
	$query = 'SELECT user_id FROM group_users WHERE group_id="'.$group_id.'"';
	foreach (json_decode(sqlQuery($conn,$query),true) as $group_user){
		$usernames[] = getUsernameById($group_user['user_id']);
	}
	return $usernames;
}
function addUserToGroup($user_id, $group_id){
	$group_exists = !empty(json_decode(sqlQuery("SELECT * FROM groups WHERE group_id='".$group_id."'"),true));
	$user_not_already_in_group = empty(json_decode(sqlQuery("SELECT * FROM group_users WHERE user_id='".$user_id."' AND group_id='".$group_id."'"),true));
	if ($group_exists and $user_not_already_in_group){ // If user not already in group
		sqlQuery('INSERT INTO group_users (group_id, user_id) VALUES ("'.$group_id.'", "'.$_SESSION['user_id'].'")');
		return '';
	} else if (!$group_exists){
		return 'Group does not exist';
	} else {
		return 'User already in group';
	}
}
function removeUserFromGroup($user_id, $group_id){
	sqlQuery('DELETE FROM group_users WHERE group_id="'.$group_id.'" AND user_id="'.$user_id.'"');
}
function createGroup($group_id, $group_name){
	sqlQuery('INSERT INTO groups (group_id, name) VALUES ("'.$group_id.'", "'.$group_name.'")');
}
function createUser($user_id, $username, $password, $email){
	sqlQuery('INSERT INTO users (user_id, username, password, email) VALUES ("'.$user_id.'", "'.$username.'", "'.$password.'", "'.$email.'")');
}
// Validation Functions
function validateUsername($username){
	if (!empty(json_decode(sqlQuery("SELECT * FROM users WHERE username='".$username."'")))){
		return "Username Taken";
	} elseif ('' == str_replace(' ','',$username)){
		return "Username Can't Be Blank";
	} else {
		return '';
	}
}
function validateEmail($email){
	if (!str_contains($email,'@')){
		return 'Invalid Email Address';
	} else {
		return '';
	}
}
function attemptLogin($username, $guessed_password){
	$maybe_user_password = sqlQuery("SELECT password FROM users WHERE username='".$username."'");
	if (empty(json_decode($maybe_user_password))){
		return 'User Does Not Exist';
	} elseif (!password_verify($guessed_password, json_decode($maybe_user_password,true)[0]['password'])){
		return 'Incorrect Password';
	} else {
		return '';
	}
}
// Session Functions
function addUserDetailsToSession($user_id, $username){
	$_SESSION['user_id'] = $user_id;
	$_SESSION['username'] = $username;
	$_SESSION['logged_in'] = true;
}
function removeUserDetailsFromSession(){
	$_SESSION['user_id'] = '';
	$_SESSION['username'] = '';
	$_SESSION['logged_in'] = false;
}
// Rendering Functions
function renderForm($method, $new_page_mode, $submit_text, $content){
	return '<form action="" method="'.$method.'">'.$content.'<input type="hidden" value="'.$new_page_mode.'" name="page_mode"><input type="submit" value="'.$submit_text.'"></form>';
}
function renderLabel($for, $label){
	return '<label for="'.$for.'">'.$label.'</label>';
}
function renderInput($name, $type, $label, $value=''){
	return renderLabel($name, $label).'<input name="'.$name.'" type="'.$type.'" value="'.$value.'">';
}
function renderButton($text, $mode){
	return renderForm('POST',$mode,$text,'');
}
function renderFunctionButtons(){
	$function_buttons = renderButton('Logout', 'logout');
	$function_buttons .= renderButton('View Groups', 'attempt_login');
	$function_buttons .= renderButton('Join Group', 'join_group');
	$function_buttons .= renderButton('Create Group', 'create_group');
	if (isset($_POST['page_mode'])){
		if ($_POST['page_mode'] == 'view_group'){
			$function_buttons .= renderButton('Leave Group', 'leave_group');
		}
	}
	return $function_buttons;
}
// Rendering Pages
function renderLoginPage(){
	return renderForm(
		'POST',
		'attempt_login',
		'Enter',
		renderInput('username','text','Name').
		renderInput('password','password','Password')
	).
	renderForm(
		'POST',
		'create_account',
		'Create Account',
		''
	);
}
function renderCreateAccountPage(){
	return renderForm(
		'POST',
		'submit_new_account',
		'Create Account',
		renderInput('username','text','Username').
		renderInput('password','password','Password').
		renderInput('email','text','Email Address')
	);
}
function renderCreateGroupPage(){
	return renderForm(
		'POST',
		'submit_new_group',
		'Create New Group',
		renderInput('group_name','text','Group Name')
	);
}
function renderGroupsPage($conn){
	echo 'Groups:';
	$query = 'SELECT group_id FROM group_users WHERE user_id="'.$_SESSION['user_id'].'"';
	foreach (json_decode(sqlQuery($conn,$query),true) as $group_user){
		$group_id = $group_user['group_id'];
		$group_name = getGroupNameById($group_id);
		echo renderForm(
			'POST',
			'view_group',
			$group_name,
			renderInput('group_id','hidden','',$group_id)
		);
	}
}
function renderGroupEventsPage($group_id){
	$_SESSION['group_to_leave'] = $group_id;
	echo renderFunctionButtons();
	$group_name = getGroupNameById($group_id);
	$group_usernames = getGroupUsernamesById($group_id);
	echo 'Viewing: '.$group_name.' ('.$group_id.')<br>Members:<br>';
	foreach ($group_usernames as $username){
		echo $username.'<br>';
	}
}
function renderJoinGroupPage(){
	return renderForm(
		'POST',
		'attempt_join_group',
		'Join',
		renderInput('group_id','text','Group ID')
	);
}
function renderGroupListView($conn){
	echo 'Hello '.$_SESSION['username'];
	echo renderFunctionButtons();
	echo renderGroupsPage($conn);
}


// Get Page Mode
if (isset($_GET['page_mode'])){
	$page_mode = $_GET['page_mode'];
} else if (isset($_POST['page_mode'])){
	$page_mode = $_POST['page_mode'];
} else {
	$page_mode = 'render_login';
}

// Start Session
session_start(['cookie_lifetime' => 86400,]);
if (!isset($_SESSION['logged_in'])){
	$_SESSION['logged_in'] = false;
} else if ($_SESSION['logged_in'] and $page_mode == 'render_login'){
	$page_mode = 'attempt_login';
}
echo '<h1><a href="">home<br></a>'.$page_mode.'</h1>';

// Login
if ($page_mode == 'render_login' or $page_mode == 'logout'){
	$_SESSION['logged_in'] = false;
	echo renderLoginPage();
} else if ($page_mode == 'attempt_login'){
	$just_logged_in = false;
	if (!$_SESSION['logged_in']){
		$login_message = attemptLogin($_POST['username'], $_POST['password']);
		if ($login_message == ''){
			addUserDetailsToSession(getUserIdByUsername($_POST['username']), $_POST['username']);
			$just_logged_in = true;
		} else {
		echo $login_message;
		echo renderLoginPage();
		}
	}
	if ($_SESSION['logged_in']){
		renderGroupListView($conn);
	}
} else if ($page_mode == 'create_account'){
	echo renderCreateAccountPage();
} else if ($page_mode == 'submit_new_account'){
	[$user_id, $username, $password, $email] = array('usr'.uniqid(), $_POST['username'], password_hash($_POST['password'], PASSWORD_BCRYPT), $_POST['email']);
	[$valid_username, $valid_email] = array(validateUsername($username), validateEmail($email));
	if ($valid_username == '' and $valid_email == ''){
		createUser($user_id, $username, $password, $email);
		echo 'User "'.$username.'" Created';
		echo renderLoginPage();
	} else {
		echo $valid_username.'<br>'.$valid_email;
		echo renderCreateAccountPage();
	}
} else if ($page_mode == 'create_group'){
	echo renderCreateGroupPage();
} else if ($page_mode == 'submit_new_group'){
	$new_group_id = 'grp'.uniqid();
	createGroup($new_group_id, $_POST['group_name']);
	addUserToGroup($_SESSION['user_id'], $new_group_id);
	echo 'Group "'.$_POST['group_name'].'" Created';
	renderGroupListView($conn);
} else if ($page_mode == 'view_group'){
	renderGroupEventsPage($_POST['group_id']);
} else if ($page_mode == 'join_group'){
	echo renderJoinGroupPage();
} else if ($page_mode == 'attempt_join_group'){
	$add_user_to_group_message = addUserToGroup($_SESSION['user_id'], $_POST['group_id']);
	if ($add_user_to_group_message == ''){
		echo 'User "'.$_SESSION['username'].'" added to "'.getGroupNameById($_POST['group_id']).'"';
		renderGroupEventsPage($_POST['group_id']);
	} else {
		echo $add_user_to_group_message;
		echo renderJoinGroupPage();
	}
} else if ($page_mode == 'leave_group'){
	$user_id = $_SESSION['user_id'];
	$group_id = $_SESSION['group_to_leave'];
	removeUserFromGroup($user_id, $group_id);
	echo getUsernameById($user_id).' removed from '.getGroupNameById($group_id);
	renderGroupListView($conn);
}
?>
