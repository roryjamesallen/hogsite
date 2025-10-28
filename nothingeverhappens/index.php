<style>
:root {
	--pale-grey: #f4f4f4;
	--medium-grey: #888888;
	--border-radius: 0.5rem;
}
    body {
    font-family: Arial;
 }
	.neh-function-buttons {
		display: flex;
		gap: 0.5rem;
	}
.neh-input, select {
		padding: 0.5rem;
		outline: 2px solid black;
		border: none;
		background: white;
	}
	.neh-input:hover {
		background: #f4f4f4;
	}
	.neh-message {
	  margin: 0.5rem 0;
	}
label {
    display: block;
    margin: 0.5rem 0;
}
label:empty {
     display: none;
 }
</style>

<?php
include '../lib/generic_content.php';
openSqlConnection('wildhog_nothingeverhappens', '../sql_login_wildhog_nothingeverhappens.php');

ob_start(); // Begin output buffering to allow output to be rendered after html head

$button_modes = json_decode('{
	"Logout": "render_login",
	"View Groups": "attempt_login",
	"Join Group": "join_group",
	"Create Group": "create_group",
	"Leave Group": "leave_group",
	"Create Event": "create_event"
}',true);

function getUsernameById($user_id){
	return sqlQuery("SELECT username FROM users WHERE user_id='".$user_id."'")['0']['username'];
}
function getUserIdByUsername($username){
	return sqlQuery("SELECT user_id FROM users WHERE username='".$username."'")['0']['user_id'];
}
function getGroupNameById($group_id){
	return sqlQuery("SELECT name FROM groups WHERE group_id='".$group_id."'")['0']['name'];
}
function getGroupUsernamesById($group_id){
	$usernames = [];
	$query = 'SELECT user_id FROM group_users WHERE group_id="'.$group_id.'"';
	foreach (sqlQuery($query) as $group_user){
		$usernames[] = getUsernameById($group_user['user_id']);
	}
	return $usernames;
}
function getGroupEventsById($group_id){
	return sqlQuery("SELECT * FROM events where group_id='".$group_id."'");
}
function addUserToGroup($user_id, $group_id){
	$group_exists = !empty(sqlQuery("SELECT * FROM groups WHERE group_id='".$group_id."'"));
	$user_not_already_in_group = empty(sqlQuery("SELECT * FROM group_users WHERE user_id='".$user_id."' AND group_id='".$group_id."'"));
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
function getEventFromId($event_id){
	return sqlQuery('SELECT * FROM events WHERE event_id="'.$event_id.'"')[0];
}
function createOption($event_id, $option_string){
    sqlQuery('INSERT INTO options (option_id, event_id, option_text) VALUES ("opt'.uniqid().'", "'.$event_id.'", "'.$option_string.'")');
}
function submitNewEventOptions($event_id){
    $option_strings = [];
    for ($option_index = 1; $option_index <= 100; $option_index++) {
        if (isset($_POST['option_input_'.$option_index])){
            $option_strings[] = $_POST['option_input_'.$option_index];
        } else {
            break; // Reached the end of the posted options
        }
    }
    if (count($option_strings) < 2){
        return 'You must have at least 2 options';
    } else {
        foreach ($option_strings as $option_string){
            createOption($event_id, $option_string);
        }
        return '';
    }
}
// Validation Functions
function validateUsername($username){
	if (!empty(sqlQuery("SELECT * FROM users WHERE username='".$username."'"))){
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
	if (empty($maybe_user_password)){
		return 'User Does Not Exist';
	} elseif (!password_verify($guessed_password, $maybe_user_password[0]['password'])){
		return 'Incorrect Password';
	} else {
		return '';
	}
}
function createEvent($event_id, $group_id, $user_id, $question, $deadline){
    $deadline = intval(strtotime($deadline));
	if ($deadline < time()){
		return 'Date cannot have already passed';
	} else if (!empty(sqlQuery("SELECT * FROM events WHERE question='".$question."' AND deadline='".$deadline."' AND user_id='".$user_id."'"))) {
		return '';
	}
	$submit_options_message = submitNewEventOptions($event_id);
	if ($submit_options_message != '') {
        return $submit_options_message;
    } else {
		sqlQuery('INSERT INTO events (event_id, group_id, user_id, question, deadline, cancelled, option_id) VALUES ("'.$event_id.'", "'.$group_id.'", "'.$user_id.'", "'.$question.'", "'.$deadline.'", "0", "null")');	
	}
}
function checkIfDeadlineHasPassed($event_id){
    $event_deadline = sqlQuery('SELECT deadline FROM events WHERE event_id="'.$event_id.'"')[0]['deadline'];
    if (intval($event_deadline) < time()){
        return true;
    } else {
        return false;
    }
}
function checkIfEventIsCancelled($event_id){
    $event_cancelled = sqlQuery('SELECT cancelled FROM events WHERE event_id="'.$event_id.'"')[0]['cancelled'];
    if ($event_cancelled == '1'){
        return true;
    } else {
        return false;
    }
}
function getCreatorByEventId($event_id){
    return sqlQuery('SELECT user_id FROM events WHERE event_id="'.$event_id.'"')[0]['user_id'];
}
function getEventOutcome($event_id){
    return sqlQuery('SELECT option_id FROM events WHERE event_id="'.$event_id.'"')[0]['option_id'];
}
function getFirstOption($event_id){
    return sqlQuery('SELECT option_id FROM options WHERE event_id="'.$event_id.'"')[0]['option_id'];
}
function getUsersCall($event_id){
    $users_call = sqlQuery('SELECT option_id FROM user_calls WHERE event_id="'.$event_id.'" AND user_id="'.$_SESSION['user_id'].'"');
    if ($users_call == []){
        return null;
    } else {
        return $users_call[0]['option_id'];
    }
}
function submitUserCall($event_id, $option_id){
    $user_id = $_SESSION['user_id'];
    sqlQuery('INSERT INTO user_calls (event_id, user_id, option_id) VALUES ("'.$event_id.'", "'.$user_id.'", "'.$option_id.'")');
}
function getOptionTextFromId($option_id){
    return sqlQuery('SELECT option_text FROM options WHERE option_id="'.$option_id.'"')[0]['option_text'];
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
	return '<form action="" method="'.$method.'">'.$content.'<input type="hidden" value="'.$new_page_mode.'" name="page_mode"><input class="neh-input" type="submit" value="'.$submit_text.'"></form>';
}
function renderLabel($for, $label){
	return '<label id="label_'.$for.'" for="'.$for.'">'.$label.'</label>';
}
function renderInput($name, $type, $label, $value=''){
	return renderLabel($name, $label).'<input class="neh-input" id="'.$name.'"name="'.$name.'" type="'.$type.'" value="'.$value.'">';
}
function renderButton($text, $mode){
	return renderForm('POST',$mode,$text,'');
}
function renderFunctionButtons($button_destinations=[]){
	global $button_modes;
	$function_buttons = '<div class="neh-function-buttons">';
	foreach ($button_destinations as $destination){
		$function_buttons .= renderButton($destination, $button_modes[$destination]);
	}
	return $function_buttons.'</div>';
}
function renderMessage($message){
	echo '<div class="neh-message">'.$message.'</div>';
}
function renderOption($number, $text='', $hidden=false){
    if ($hidden){
        $style = 'display: none;';
    } else {
		$style = '';
	}
    $option = '<div class="option-container" id="option_'.$number.'" style="'.$style.'">';
    $option .= renderInput('option_input_'.$number,'text','Option '.$number, $text);
    $option .= renderInput('delete_option_'.$number,'button','','Delete', $text);
    return $option.'</div>';
}
function renderDefaultOptions(){
    return '<div id="create-options-list">'.
        renderOption('0', '', true).
        renderOption('1', 'Yes').
        renderOption('2', 'No').
        '</div>'.
        renderInput('add_option','button','','Add Option');
}
function renderViewEventOptions($event_id){
    $option_selector = '<label for="option_selector">Your call</label><select id="option_selector" name="option_selector">';
    foreach (sqlQuery('SELECT * from options WHERE event_id="'.$event_id.'"') as $option){
        $option_selector .= '<option value="'.$option['option_id'].'">'.$option['option_text'].'</option>';
    }
    $option_selector .= '</select>';
    return renderForm(
		'POST',
		'make_call',
		'Make Call',
	    $option_selector.
        renderInput('event_id','hidden','',$event_id)
	);
}
function unixToDate($unix){
	return gmdate('d M Y', $unix);
}
function unixToHours($unix){
	return $unix / 3600;
}
function hoursToHoursMins($hours){
	$whole_hours = floor($hours);
	$mins = floor(($hours - $whole_hours) * 60);
	return [$whole_hours, $mins];
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
	return renderFunctionButtons(['View Groups']).
	renderForm(
		'POST',
		'submit_new_group',
		'Create New Group',
		renderInput('group_name','text','Group Name')
	);
}
function renderGroupsPage(){
	renderMessage('Groups');
	$query = 'SELECT group_id FROM group_users WHERE user_id="'.$_SESSION['user_id'].'"';
	foreach (sqlQuery($query) as $group_user){
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
	$_SESSION['active_group'] = $group_id;
	echo renderFunctionButtons(['View Groups','Leave Group','Create Event']);
	$group_name = getGroupNameById($group_id);
	$group_usernames = getGroupUsernamesById($group_id);
	$members = '';
	foreach ($group_usernames as $key => $username){
		$members .= $username;
		if ($key != array_key_last($group_usernames)){
			$members .= ', ';
		}
	}
	renderMessage('Viewing: '.$group_name.' ('.$members.')');
	$group_events = getGroupEventsById($group_id);
	renderMessage('Events');
	foreach ($group_events as $event){
		echo renderForm(
			'POST',
			'view_event',
			$event['question'],
			renderInput('event_id','hidden','',$event['event_id'])
		);
	}
}
function renderJoinGroupPage(){
	return renderFunctionButtons(['View Groups']).
	renderForm(
		'POST',
		'attempt_join_group',
		'Join',
		renderInput('group_id','text','Group ID')
	);
}
function renderGroupListView(){
	echo renderFunctionButtons(['Logout','Join Group','Create Group']);
	echo renderGroupsPage();
}
function renderCreateEventPage($group_id){
	echo  renderFunctionButtons(['View Groups']).
        renderForm(
		'POST',
		'attempt_create_event',
		'Create Event',
		renderInput('question','text','Question').
		renderInput('deadline','datetime-local','Deadline').
        renderDefaultOptions().
		renderInput('group_id','hidden','',$group_id)
	);
}
function renderEventPage($event_id){
	echo renderFunctionButtons(['View Groups']);
	$event = getEventFromId($event_id);
	echo $event['question'].' by '.unixToDate($event['deadline']).'?<br>';
    $deadline_passed = checkIfDeadlineHasPassed($event_id);
    $event_creator = getCreatorByEventId($event_id);
    $event_outcome = getEventOutcome($event_id);
    $event_cancelled = checkIfEventIsCancelled($event_id);
    $users_call = getUsersCall($event_id);

    if ($deadline_passed){
		renderMessage('Betting ended on '.unixToDate($event['deadline']));
        if ($users_call != null){
            echo 'You called '.getOptionTextFromId($users_call);
        } else {
            echo 'You did not make a call';
        }
        if ($event_outcome != 'null'){
            // the event result was event_outcome,
            // you lost/gained calculatePoints() points
        } else if ($event_cancelled){
            // the event was cancelled.
            //you didn't lose or gain any points
        } else if ($_SESSION['user_id'] == $event_creator){
            // points won't be calculated until the you resolve the event
            // render event resolution form
			renderMessage('Points will be calculated once you set the outcome');
			echo renderForm(
				'POST',
				'resolve_event',
				'Set Outcome',
				renderInput('event_id','hidden','',$event_id)
			);
			echo renderButton('Cancel Event', 'cancel_event');
        } else {
            renderMessage('Points will be calculated once '.getUsernameById($user_id).' sets the outcome');
        }
    } else {
		[$hours, $mins] = hoursToHoursMins(unixToHours($event['deadline'] - time()));
		if ($users_call == null) {
			renderMessage('You have '.$hours.' hours and '.$mins.' minutes left to make a call');
			echo renderViewEventOptions($event_id); // Show selector to make call
		} else {
			renderMessage('You have called '.getOptionTextFromId($users_call)); // Add user call date field? You called x on y date
			renderMessage('Betting ends in '.$hours.' hours and '.$mins.' minutes.');
		}
    }
}
function renderResolveEventPage($event_id){
	echo  renderFunctionButtons(['View Groups']).
        renderForm(
		'POST',
		'attempt_resolve_event',
		'Set Outcome',
        renderViewEventOptions($event_id).
		renderInput('event_id','hidden','',$event_id)
	);
	echo renderButton('Cancel Event', 'cancel_event');
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

// User isn't logged in and hasn't tried to yet
if ($page_mode == 'render_login'){
	$_SESSION['logged_in'] = false;
	echo renderLoginPage();
// User has typed in login details and pressed enter
} else if ($page_mode == 'attempt_login'){
	$just_logged_in = false;
	if (!$_SESSION['logged_in']){
		$login_message = attemptLogin($_POST['username'], $_POST['password']);
		if ($login_message == ''){
			addUserDetailsToSession(getUserIdByUsername($_POST['username']), $_POST['username']);
			$just_logged_in = true;
		} else {
// User's login details were rejected
		renderMessage($login_message);
		echo renderLoginPage();
		}
	}
// User's login details were accepted
	if ($_SESSION['logged_in']){
		renderGroupListView();
	}
// User has clicked create new account but hasn't tried to submit one yet
} else if ($page_mode == 'create_account'){
	echo renderCreateAccountPage();
// User has entered new account details and pressed create account
} else if ($page_mode == 'submit_new_account'){
	[$user_id, $username, $password, $email] = array('usr'.uniqid(), $_POST['username'], password_hash($_POST['password'], PASSWORD_BCRYPT), $_POST['email']);
	[$valid_username, $valid_email] = array(validateUsername($username), validateEmail($email));
// User's new account details were accepted
	if ($valid_username == '' and $valid_email == ''){
		createUser($user_id, $username, $password, $email);
		renderMessage('User "'.$username.'" Created');
		echo renderLoginPage();
// User's new account details were rejected
	} else {
		renderMessage($valid_username.'<br>'.$valid_email);
		echo renderCreateAccountPage();
	}
// User has clicked create new group but hasn't tried to submit one yet
} else if ($page_mode == 'create_group'){
	echo renderCreateGroupPage();
// User has entered new group details and clicked create new group
} else if ($page_mode == 'submit_new_group'){
	$new_group_id = 'grp'.uniqid();
	createGroup($new_group_id, $_POST['group_name']);
	addUserToGroup($_SESSION['user_id'], $new_group_id);
	renderMessage('Group "'.$_POST['group_name'].'" Created');
	renderGroupListView();
// User has clicked a group in their group list
} else if ($page_mode == 'view_group'){
	renderGroupEventsPage($_POST['group_id']);
// User has clicked join group but hasn't entered the group's id yet
} else if ($page_mode == 'join_group'){
	echo renderJoinGroupPage();
// User has entered the id of a group to join and pressed enter
} else if ($page_mode == 'attempt_join_group'){
	$add_user_to_group_message = addUserToGroup($_SESSION['user_id'], $_POST['group_id']);
// User corrrectly entered the group id and gets added to the group
	if ($add_user_to_group_message == ''){
		renderMessage('User "'.$_SESSION['username'].'" added to "'.getGroupNameById($_POST['group_id']).'"');
		renderGroupEventsPage($_POST['group_id']);
// User entered an incorrect group id to join
	} else {
		renderMessage($add_user_to_group_message);
		echo renderJoinGroupPage();
	}
// User clicked leave group
} else if ($page_mode == 'leave_group'){
	$user_id = $_SESSION['user_id'];
	$group_id = $_SESSION['active_group'];
	removeUserFromGroup($user_id, $group_id);
	echo getUsernameById($user_id).' removed from '.getGroupNameById($group_id);
	renderGroupListView();
// User clicked create event but hasn't entered event details yet
} else if ($page_mode == 'create_event'){
	$group_id = $_SESSION['active_group'];
	echo renderCreateEventPage($group_id);
// User has clicked to submit their new event details
} else if ($page_mode == 'attempt_create_event'){
	$group_id = $_SESSION['active_group'];
	$event_id = 'evt'.uniqid();
	$create_event_message = createEvent($event_id, $_POST['group_id'], $_SESSION['user_id'], $_POST['question'], $_POST['deadline']);
// User's new event details were accepted and it was submitted
	if ($create_event_message == ''){
		renderMessage('Event submitted');
		renderGroupEventsPage($group_id);
// User's event was rejected
	} else {
		renderMessage($create_event_message);
		echo renderCreateEventPage($group_id);
	}
} else if ($page_mode == 'view_event'){
	$event_id = $_POST['event_id'];
	renderMessage('Viewing event '.$event_id);
	renderEventPage($event_id);
} else if ($page_mode == 'make_call'){
    $event_id = $_POST['event_id'];
    $option_id = $_POST['option_selector'];
    submitUserCall($event_id, $option_id);
    renderEventPage($event_id);
} else if ($page_mode == 'resolve_event'){
	$event_id = $_POST['event_id'];
	renderMessage('Setting outcome of event '.$event_id);
	renderResolveEventPage($event_id);
}
?>

<script>
    var page_mode = '<?php echo $page_mode?>'

    function replaceNumber(original_field, new_number){
        if (original_field != ''){
            if (original_field.includes(' ')){
                var separator = ' ';
            } else {
                var separator = '_';
            }
            var split = original_field.split(separator);
            return original_field.replace(split[split.length - 1],'') + new_number;
        } else {
            return original_field;
        }
    }
    
    function reorderOptions(){
        //var container = document.getElementById('create-options-list');
        var options = document.getElementsByClassName('option-container');
        for (var i = 0; i < options.length; i++) {
            options[i].id = replaceNumber(options[i].id, i);
            var option_elements = options[i].querySelectorAll('input, label');
            for (var j = 0; j < option_elements.length; j++) {
                var element = option_elements[j];
                var element_tag = element.tagName.toLowerCase();
                if (element_tag == 'label'){
                    element.htmlFor = replaceNumber(element.getAttribute('for'), i);
                }
                if (element_tag == 'input'){
                    element.name = replaceNumber(element.getAttribute('name'), i);
                    if (element.id.includes('delete')){
                        element.addEventListener('click', deleteOption);
                    }
                }
                if (element.innerHTML.includes('Option')){
                    element.innerHTML = replaceNumber(element.innerHTML, i);
                }
                element.id = replaceNumber(element.id, i);
            }
        }
    }
    
    function deleteOption(event){
        var delete_button_id = event.target.id;
        var option_id = delete_button_id.replace('delete_','');
        document.getElementById(option_id).remove();
        reorderOptions();
    }

    function addOption(){
        var container = document.getElementById('create-options-list');
        var template_option = document.getElementById('option_0');
        var new_option = template_option.cloneNode(true);
        new_option.id = 'option_99'; // Will get reordered later
        new_option.removeAttribute('style'); // Remove display: none
        container.append(new_option);
        reorderOptions();
    }
    
    function initialiseCreateOptionsList(){
        var container = document.getElementById('create-options-list');
        var inputs = container.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            input = inputs[i];
            if (input.id.includes('delete_')){
                input.addEventListener('click', deleteOption);
            }
        }
        document.getElementById('add_option').addEventListener('click', addOption);
    }

if (document.getElementById('create-options-list') != null){
    initialiseCreateOptionsList();
}
</script>
