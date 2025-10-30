<?php
session_start(['cookie_lifetime' => 86400,
               'gc_maxlifetime' => 86400]);
include '../lib/generic_content.php';
openSqlConnection('wildhog_nothingeverhappens', '../sql_login_wildhog_nothingeverhappens.php');
?>

<style>
:root {
	--pale-grey: #f4f4f4;
	--medium-grey: #dddddd;
    --dark-grey: #888;
	--border-radius: 0.5rem;
    --page-width: 750px;
}
@media screen and (max-width: 900px) {
    :root {
        --page-width: 90vw;
    }
}
    body {
    font-family: Arial;
        background: var(--medium-grey);
 }
	.neh-function-buttons {
		display: flex;
		gap: 0.5rem;
	}
.neh-input, select {
		padding: 0.5rem;
		border: 1px solid black;
		background: white;
        font-size: 1.5rem;
        text-wrap-mode: wrap;
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
h1, h1 a {
    color: black;
    text-decoration: underline;
    text-decoration-color: white;
    margin: 1rem auto 2rem;
    width: fit-content;
    font-size: 3rem;
}
.neh-message {
    display: flex;
    gap: 1rem;
    max-width: var(--page-width);
    margin: 0 auto 1rem;
    background: var(--pale-grey);
    padding: 0.5rem;
    color: var(--dark-grey);
    box-sizing: border-box;
    font-size: 1.5rem;
}
form, .option-container {
    display: flex;
    flex-wrap: wrap;
    max-width: var(--page-width);
    margin: 0 auto;
}
.neh-event-tab-list {
    background: var(--pale-grey);
    display: flex;
    flex-wrap: wrap;
    max-width: var(--page-width);
    margin: 0 auto;
    gap: 1rem;
    padding: 1rem 0;
}
.neh-event-tab-list .neh-block {
    background: white;
    border: 1px solid black;
    width: calc(100% - 2rem);
}
.neh-event-tab-container {
    display: flex;
    width: calc(100% - 2rem);
    margin: 0 auto;
}
.neh-event-tab-container form {
    flex-grow: 1;
}
.neh-event-tab-note {
    flex-basis: 20%;
    flex-shrink: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background: var(--medium-grey);
    text-align: center;
    line-height: 40px;
    font-size: 1.5rem;
    border: 1px solid black;
    border-left: none;
    padding: 0 0.5rem;
}
#create-options-list {
    width: 100%;
margin-bottom: 1rem;
}
form input, label, select {
    flex-basis: 70%;
    flex-grow: 1;
    font-size: 1.5rem;
}
.full-width {
    flex-basis: 100% !important;
}
.neh-input[type="submit"], .neh-input[type="button"]{
    flex-basis: 30%;
    flex-grow: 1;
}
.neh-input[type="submit"]:hover, .neh-input[type="button"]:hover{
    text-decoration: underline;
    cursor: pointer;
}
.neh-input:focus-visible, select:focus-visible {
    outline: none;
    border: 1px solid var(--medium-grey);
    background: var(--pale-grey);
}
.neh-input[type="submit"]:focus-visible, .neh-input[type="button"]:focus-visible{
    background: var(--dark-grey);
    border: none;
}
.neh-function-buttons {
    justify-content: center;
    margin-bottom: 1rem;
}
.neh-function-buttons form {
    margin: 0;
}
.neh-heading, .neh-block {
    max-width: var(--page-width);
    margin: 0 auto;
    box-sizing: border-box;
    padding: 0.5rem;
    text-align: center;
    font-size: 1.5rem;
    background: var(--pale-grey);
}
.neh-block {
    text-align: left;
    border: none;
    background: none;
}
.neh-copy-text-button {
    display: inline-block;
    font-size: 1rem;
    padding: 0.25rem;
    background: var(--dark-grey);
    color: white;
    cursor: pointer;
}
.neh-points-positive {
    color: green;
}
.neh-points-negative {
    color: red;
}
.neh-unstyled-link {
    color: var(--dark-grey);
    text-decoration: none;
}
.neh-unstyled-link:hover {
    text-decoration: underline;
}
.neh-admin {
    font-weight: bold;
}
</style>

<?php
$button_modes = json_decode('{
    "Login": "render_login",
	"Logout": "render_login",
    "Create Account": "create_account",
    "Forgot Password": "forgot_password",
    "View Events": "view_group",
	"View Groups": "attempt_login",
	"Join Group": "join_group",
	"Create Group": "create_group",
	"Leave Group": "leave_group",
    "Admin Settings": "admin_settings",
	"Add User": "add_user",
    "Kick User": "kick_user",
    "Make Group Private": "make_group_private",
    "Make Group Public": "make_group_public",
	"Create Event": "create_event"
}',true);

function setGroupPrivate($group_id){
    sqlQuery("UPDATE groups SET public='0' WHERE group_id='".$group_id."'");
}
function setGroupPublic($group_id){
	sqlQuery("UPDATE groups SET public='1' WHERE group_id='".$group_id."'");
}
function isGroupPublic($group_id){
    if (sqlQuery('SELECT public FROM groups WHERE group_id="'.$group_id.'"')[0]['public'] == '1'){
        return true;
    } else {
        return false;
    };
}
function getUsernameById($user_id){
	return sqlQuery("SELECT username FROM users WHERE user_id='".$user_id."'")['0']['username'];
}
function getUserIdByUsername($username){
	return sqlQuery("SELECT user_id FROM users WHERE username='".$username."'")['0']['user_id'];
}
function getUserIdByEmail($email){
	return sqlQuery("SELECT user_id FROM users WHERE email='".$email."'")['0']['user_id'];
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
	if ($group_exists and $user_not_already_in_group and (isGroupPublic($group_id) or $_SESSION['admin'])){ // If group exists, user not already in group, and group is public or admin is logged in
		sqlQuery('INSERT INTO group_users (group_id, user_id) VALUES ("'.$group_id.'", "'.$user_id.'")');
		return '';
	} else if (!$group_exists){
		return 'Group does not exist';
    } else if (!isGroupPublic($group_id)){
        return 'Group is private. Ask the admin to add you';
	} else {
		return 'User already in group';
	}
}
function removeUserFromGroup($user_id, $group_id){
	sqlQuery('DELETE FROM group_users WHERE group_id="'.$group_id.'" AND user_id="'.$user_id.'"');
}
function createGroup($group_id, $group_name, $user_id){
	sqlQuery('INSERT INTO groups (group_id, name, created_at, user_id) VALUES ("'.$group_id.'", "'.$group_name.'", "'.time().'", "'.$user_id.'")');
}
function createUser($user_id, $username, $password, $email){
	sqlQuery('INSERT INTO users (user_id, username, password, email, created_at) VALUES ("'.$user_id.'", "'.$username.'", "'.$password.'", "'.$email.'", "'.time().'")');
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
	if ($deadline < time() and false){ // temporarily disabled for testing
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
function checkIfEventIsResolved($event_id){
    if (sqlQuery('SELECT option_id FROM events WHERE event_id="'.$event_id.'"')[0]['option_id'] != 'null'){
        return true;
    } else {
        return false;
    };
}
function getEventQuestionById($event_id){
    return sqlQuery('SELECT question FROM events WHERE event_id="'.$event_id.'"')[0]['question'];
}
function getCreatorByEventId($event_id){
    return sqlQuery('SELECT user_id FROM events WHERE event_id="'.$event_id.'"')[0]['user_id'];
}
function getEventOutcome($event_id){
    return sqlQuery('SELECT option_id FROM events WHERE event_id="'.$event_id.'"')[0]['option_id'];
}
function getOptionsForEvent($event_id){
    return sqlQuery('SELECT * FROM options WHERE event_id="'.$event_id.'"');
}
function getCallsForEvent($event_id){
    return sqlQuery('SELECT * FROM user_calls WHERE event_id="'.$event_id.'"');
}
function getCallsByUser($user_id){
    return sqlQuery('SELECT * FROM user_calls WHERE user_id="'.$user_id.'"');
}
function getFirstOption($event_id){
    return sqlQuery('SELECT option_id FROM options WHERE event_id="'.$event_id.'"')[0]['option_id'];
}
function getUsersCall($event_id){
    return getUsersCallById($event_id, $_SESSION['user_id']);
}
function getGroupAdmin($group_id){
    return sqlQuery('SELECT user_id FROM groups WHERE group_id="'.$group_id.'"')[0]['user_id'];
}
function getUsersCallById($event_id, $user_id){
    $users_call = sqlQuery('SELECT option_id FROM user_calls WHERE event_id="'.$event_id.'" AND user_id="'.$user_id.'"');
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
function setEventOutcome($event_id, $option_id){
    sqlQuery('UPDATE events SET option_id="'.$option_id.'" WHERE event_id="'.$event_id.'"');
}
function cancelEvent($event_id){
    sqlQuery('UPDATE events SET cancelled=1 WHERE event_id="'.$event_id.'"');
}
function calculateUserPoints($event_id, $user_id){
    if (checkIfEventIsResolved($event_id)){
        $user_call = getUsersCallById($event_id, $user_id);
        $outcome = getEventOutcome($event_id);
        $points = 0;
        if ($user_call == $outcome){
            foreach (getCallsForEvent($event_id) as $call){
                if ($call['option_id'] != $outcome){ // User who predicted a wrong outcome when you were right
                    $points += 1;
                }
            }
            return $points;
        } else if ($user_call != $outcome and $user_call != null){
            foreach (getCallsForEvent($event_id) as $call){
                if ($call['option_id'] == $user_call){ // User who predicted the same wrong outcome as you
                    $points -= 1;
                }
            }
            return $points;
        } else if ($user_call == null){
            return 0;
        }
    } else {
        return 0;
    }
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
function removeGETParameters($url){
    return strtok($url, '?');
}
$current_url_without_parameters = removeGetParameters($current_url);
    
function checkIfAccountExists($field, $field_value){
    $users_with_field = sqlQuery('SELECT user_id FROM users WHERE '.$field.'="'.$field_value.'"');
    if ($users_with_field == []){
        return false;
    } else {
        return true;
    }
}
function checkIfAccountExistsByUsername($username){
    return checkIfAccountExists('username', $username);
}
function checkIfAccountExistsForEmail($email){
    return checkIfAccountExists('email', $email);
}
function sendForgotPasswordEmail($email){
    $code = str_pad(strval(rand(0, 999999)), 6, '0', STR_PAD_LEFT);
    $subject = 'Nothing Ever Happens - Password Reset';
    $message = 'Enter the code: '.$code.' to reset your password. If you did not request this code please change your password as soon as possible.';
    $headers = 'From: accounts@hogwild.uk'       . "\r\n" .
                 'Reply-To: accounts@hogwild.uk' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();
    mail($email, $subject, $message, $headers,'-f accounts@hogwild.uk');
    return $code;
}
function renderSetNewPasswordPage($email){
    $user_id = getUserIdByEmail($email);
    echo renderForm(
        'POST',
        'change_user_password',
        'Set',
        renderInput('new_password','password','New Password').
            renderInput('user_id','hidden','',$user_id)
    );
}
// Session Functions
function addUserDetailsToSession($user_id, $username){
	$_SESSION['user_id'] = $user_id;
	$_SESSION['username'] = $username;
}
function removeUserDetailsFromSession(){
	$_SESSION['user_id'] = '';
	$_SESSION['username'] = '';
    $_SESSION['active_event'] = null;
}
// Rendering Functions
function renderPoints($points, $hide_prefix=false){
    $prefix = '<span class="';
    if ($points > 0){
        $prefix .= 'neh-points-positive">';
        if ($hide_prefix != true){
            $prefix .= '+';
        }
    } else if ($points < 0){
        $prefix .= 'neh-points-negative">';
    } else {
        $prefix .= '">';
    }
    if ($points == ''){
        $points = '🕑';
    }
    return $prefix.$points.'</span>';
}
function renderForm($method, $new_page_mode, $submit_text, $content, $name='page_mode'){
    global $current_url_without_parameters;
	return '<form action="'.$current_url_without_parameters.'" method="'.$method.'">'.$content.'<input type="hidden" value="'.$new_page_mode.'" name="'.$name.'"><input class="neh-input" type="submit" value="'.$submit_text.'"></form>';
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
function renderHeading($message){
	echo '<div class="neh-heading">'.$message.'</div>';
}
function renderBlock($message){
	echo '<div class="neh-block">'.$message.'</div>';
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
        renderInput('add_option','button','','Add Option').
        renderInput('placeholder','hidden','','');
}
function renderOptions($event_id, $label_text, $submit_button_text, $page_mode){
    $option_selector = '<label for="option_selector">'.$label_text.'</label><select id="option_selector" name="option_selector">';
    foreach (sqlQuery('SELECT * from options WHERE event_id="'.$event_id.'"') as $option){
        $option_selector .= '<option value="'.$option['option_id'].'">'.$option['option_text'].'</option>';
    }
    $option_selector .= '</select>';
    return renderForm(
		'POST',
	    $page_mode,
		$submit_button_text,
	    $option_selector.
        renderInput('event_id','hidden','',$event_id)
	);
}
function renderViewEventOptions($event_id){
    return renderOptions($event_id, 'Your Call', 'Call', 'make_call');
}
function renderResolveEventOptions($event_id){
    return renderOptions($event_id, 'The Actual Outcome', 'Submit', 'attempt_resolve_event');
}
function renderSetOutcomeForm(){
    return renderForm('POST','resolve_event','Set Outcome','');
}
function renderResolveEventButtons(){
    echo renderSetOutcomeForm();
    renderBlock('');
    echo renderButton('Cancel Event', 'cancel_event');
    renderBlock('');
}
function renderAllCallsForEvent($event_id){
    $calls = getCallsForEvent($event_id);
    $options = getOptionsForEvent($event_id);
    foreach ($options as $option){
        $zero_calls = true;
        renderHeading($option['option_text']);
        echo '<div class="neh-event-tab-list">';
        foreach ($calls as $call){
            if ($call['option_id'] == $option['option_id']){
                echo renderUserTab($call['user_id'], renderPoints(calculateUserPoints($event_id, $call['user_id'])));
                //renderBlock(getUsernameById($call['user_id']).' '.renderPoints(calculateUserPoints($event_id, $call['user_id'])));
                $zero_calls = false;
            }
        }
        if ($zero_calls){
            echo renderBlock('Zero calls');
        }
        echo '</div>';
    }
}
function renderKey(){
    return '⏳: It\'s time to make a call!<br>'.
        '🐌: You didn\'t make a call before the deadline<br>'.
        '⚠️✎: You need to set the outcome now the deadline has passed<br>'.
        '✖️: Event cancelled<br>';
}
function renderEventTabNote($event_id){
    if (checkIfEventIsCancelled($event_id)){ // Cancelled
        return '✖️';
    } else if (checkIfEventIsResolved($event_id)){ //  Resolved
        if (getUsersCall($event_id) != null){
            return renderPoints(calculateUserPoints($event_id, $_SESSION['user_id'])); // User called resolved event, show points
        } else {
            return '🐌'; // User didn't place a call and event is now resolved
        }
    } else { // Still live
        if (checkIfDeadlineHasPassed($event_id) and getCreatorByEventId($event_id) == $_SESSION['user_id']){ // Unresolved, deadline passed and user is creator
            return '⚠️✎';
        } else if (getUsersCall($event_id) != null){ // Unresolved and user has placed bet
            return getOptionTextFromId(getUsersCall($event_id));
        } else { // Unresolved and user hasn't bet yet
            return '⏳';
        }
    }
}
function renderEventTab($event_id){
    $tab = '<div class="neh-event-tab-container">'.
        renderForm(
        'POST',
        'view_event',
        getEventQuestionById($event_id),
        renderInput('event_id','hidden','',$event_id)).
        '<div class="neh-event-tab-note">'.renderEventTabNote($event_id).'</div>'.
        '</div>';
    return $tab;
}
function renderUserTab($user_id, $note){
    $tab = '<div class="neh-event-tab-container">'.
        renderForm(
        'GET',
        getUsernameById($user_id),
        getUsernameById($user_id),
        '',
        'usr').
        '<div class="neh-event-tab-note">'.$note.'</div>'.
            '</div>';
    return $tab;
}
function renderCopyTextButton($group_id, $button_text){
    return '<div id="'.$group_id.'" class="neh-copy-text-button" onclick="copyText(this.id)">'.$button_text.'</div>';
}
// Rendering Pages
function renderLoginPage(){
	return renderFunctionButtons(['Create Account','Forgot Password']).
        renderForm(
            'POST',
		'attempt_login',
		'Enter',
		renderInput('username','text','Name').
		renderInput('password','password','Password')
        );
}
function renderCreateAccountPage(){
	return renderFunctionButtons(['Login']).
        renderForm(
		'POST',
		'submit_new_account',
		'Submit',
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
		'Create',
		renderInput('group_name','text','Group Name')
	);
}
function renderGroupsPage(){
	renderHeading('Groups');
	$query = 'SELECT group_id FROM group_users WHERE user_id="'.$_SESSION['user_id'].'"';
    echo '<div class="neh-event-tab-list">';
	foreach (sqlQuery($query) as $group_user){
		$group_id = $group_user['group_id'];
		$group_name = getGroupNameById($group_id);
		echo '<div class="neh-event-tab-container">'.
            renderForm(
			'POST',
			'view_group',
			$group_name,
			renderInput('group_id','hidden','',$group_id)
		).'</div>';
	}
    echo '</div>';
}
function renderGroupEventsPage($group_id){
	$_SESSION['active_group'] = $group_id;
    $group_admin = getGroupAdmin($group_id);
    $function_buttons = ['View Groups','Leave Group','Create Event'];
    if ($group_admin == $_SESSION['user_id']){
        $_SESSION['admin'] = true;
        $function_buttons[] = 'Admin Settings';
    } else {
        $_SESSION['admin'] = false;
    }
	echo renderFunctionButtons($function_buttons);
	$group_name = getGroupNameById($group_id);
	$group_usernames = getGroupUsernamesById($group_id);
	$members = '';
	foreach ($group_usernames as $key => $username){
        $admin_class = '';
        if ($username == getUsernameById($group_admin)){
            $admin_class = 'neh-admin';
        }
        $members .= '<a class="neh-unstyled-link '.$admin_class.'" href="'.$current_url_without_parameters.'?usr='.$username.'">'.$username.'</a>';
		if ($key != array_key_last($group_usernames)){
			$members .= ', ';
		}
	}
	renderMessage(renderCopyTextButton($group_id, "Copy ID").'<span>'.$group_name.' ('.$members.')</span>');
	$group_events = getGroupEventsById($group_id);
	renderHeading('Make A Call');
    echo '<div class="neh-event-tab-list">';
	foreach ($group_events as $event){
        $event_id = $event['event_id'];
        if (!checkIfDeadlineHasPassed($event_id) and !checkIfEventIsCancelled($event_id) and getUsersCall($event_id) == null){
            echo renderEventTab($event_id);
        }
    }
    echo '</div>';
    renderBlock('');
    renderHeading('Called Events');
    echo '<div class="neh-event-tab-list">';
	foreach ($group_events as $event){
        $event_id = $event['event_id'];
        if (!checkIfDeadlineHasPassed($event_id) and !checkIfEventIsCancelled($event_id) and getUsersCall($event_id) != null){
            echo renderEventTab($event_id);
        }
        
    }
    echo '</div>';
    renderBlock('');
    renderHeading('Past Events');
    echo '<div class="neh-event-tab-list">';
    foreach ($group_events as $event){
        $event_id = $event['event_id'];
        if (checkIfDeadlineHasPassed($event_id) and !checkIfEventIsCancelled($event_id)){
            echo renderEventTab($event_id);
        }
    }
    echo '</div>';
    renderBlock('');
    renderHeading('Cancelled Events');
    echo '<div class="neh-event-tab-list">';
    foreach ($group_events as $event){
        $event_id = $event['event_id'];
        if (checkIfEventIsCancelled($event_id)){
            echo renderEventTab($event_id);
        }
    }
    echo '</div>';
    renderBlock('');
    renderBlock(renderKey());
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
		'Create',
		renderInput('question','text','Question').
		renderInput('deadline','datetime-local','Deadline').
        renderDefaultOptions().
		renderInput('group_id','hidden','',$group_id)
	);
}
function renderEventPage($event_id){
	echo renderFunctionButtons(['View Groups','View Events']);
	$event = getEventFromId($event_id);
    renderHeading($event['question'].' by '.unixToDate($event['deadline']).'?<br>');
    $deadline_passed = checkIfDeadlineHasPassed($event_id);
    $event_creator = getCreatorByEventId($event_id);
    $event_outcome = getEventOutcome($event_id);
    $event_cancelled = checkIfEventIsCancelled($event_id);
    $users_call = getUsersCall($event_id);

    if ($deadline_passed or $event_outcome != 'null' or $event_cancelled){
        if ($users_call != null){
            renderMessage('You called '.getOptionTextFromId($users_call));
        } else {
            renderMessage('You did not make a call');
        }
        if ($event_cancelled){
            renderMessage('The event was cancelled');
        } else if ($event_outcome != 'null'){
            renderMessage('The outcome was '.getOptionTextFromId($event_outcome));
        } else if ($_SESSION['user_id'] == $event_creator){
			renderMessage('Points will be calculated once you set the outcome');
        } else {
            renderMessage('Points will be calculated once '.getUsernameById($event_creator).' sets the outcome');
        }
    } else {
		[$hours, $mins] = hoursToHoursMins(unixToHours($event['deadline'] - time()));
		if ($users_call == null) {
			renderMessage('You have '.$hours.' hours and '.$mins.' minutes left to make a call');
			echo renderViewEventOptions($event_id); // Show selector to make call
            renderBlock('');
		} else {
			renderMessage('You have called '.getOptionTextFromId($users_call)); // Add user call date field? You called x on y date
			renderMessage('Betting ends in '.$hours.' hours and '.$mins.' minutes.');
		}
    }
    renderAllCallsForEvent($event_id);
    if ($_SESSION['user_id'] == $event_creator and !$event_cancelled and !checkIfEventIsResolved($event_id)){
        renderBlock('');
        renderResolveEventButtons();
    }
}
function renderResolveEventPage($event_id){
	echo renderFunctionButtons(['View Groups','View Events']);
    echo renderResolveEventOptions($event_id);
    renderBlock('');
	echo renderButton('Cancel Event', 'cancel_event');
}
function renderCancelEventPage($event_id){
    echo renderFunctionButtons(['View Groups']);
    echo renderButton('Back to Event', 'view_event');
    renderBlock('');
    echo renderButton('Seriously Cancel Event', 'attempt_cancel_event');
}
function renderForgotPasswordPage(){
    echo renderFunctionButtons(['Login']);
    echo renderForm(
        'POST',
        'attempt_forgot_password',
        'Send Email',
        renderInput('email','text','Your Email Address')
    );
}
function renderForgotPasswordCodeForm($code, $email){
    echo renderForm(
        'POST',
        'enter_password_reset_code',
        'Reset',
        renderInput('code','text','Password Reset Code').
            renderInput('email','hidden','',$email)
    );
}
function renderAddUserPage($group_id){
	echo renderFunctionButtons(['View Events']);
	echo renderForm(
        'POST',
        'attempt_add_user',
        'Add',
        renderInput('username','text','Username').
            renderInput('group_id','hidden','',$group_id)
    );
}
function renderKickUserPage($group_id){
	echo renderFunctionButtons(['View Events']);
	echo renderForm(
        'POST',
        'attempt_kick_user',
        'Kick',
        renderInput('username','text','Username').
            renderInput('group_id','hidden','',$group_id)
    );
}
function renderUserPage($username){
    echo renderFunctionButtons(['Login','Create Account']);
    $user_id = getUserIdByUsername($username);
    $users_calls = getCallsByUser($user_id);
    $total_points = 0;
    $total_correct_calls = 0;
    $total_wrong_calls = 0;
    foreach ($users_calls as $call){
        $event_id = $call['event_id'];
        $points_from_event = calculateUserPoints($event_id, $user_id);
        if ($points_from_event > 0){
            $total_correct_calls += 1;
        } else if ($points_from_event < 0){
            $total_wrong_calls += 1;
        }
        $total_points += $points_from_event;
    }
    renderMessage(renderCopyTextButton($user_id, 'Copy ID').'Viewing stats for: '.$username);
    renderMessage(count($users_calls). ' calls made');
    renderMessage(renderPoints($total_points). 'total points');
    renderMessage(renderPoints($total_correct_calls, true). ' correct calls');
    renderMessage(renderPoints($total_wrong_calls, true). ' incorrect calls');
}
function renderAdminSettingsPage(){
    $group_id = $_SESSION['active_group'];
    $function_buttons = ['View Events','Add User','Kick User'];
    if (isGroupPublic($group_id)){
        $function_buttons[] = 'Make Group Private';
    } else {
        $function_buttons[] = 'Make Group Public';
    }
    echo renderFunctionButtons($function_buttons);
}

// Get Page Mode
// Public page modes (GET)
if (isset($_GET['usr'])){ // Anyone can view a user (as long as they exist)
    $page_mode = 'view_user';
// Private page modes (POST)
} else if (isset($_POST['page_mode'])){ // Coming from an internal page
	$page_mode = $_POST['page_mode'];
    if ($page_mode == 'render_login'){ // Deliberate logout
        removeUserDetailsFromSession();
    }
} else if (isset($_SESSION['user_id'])){ // Coming from internal or external but logged in
    $page_mode = 'attempt_login';
} else {
	$page_mode = 'render_login';
}

echo '<h1><a href="'.$current_url_without_parameters.'">nothing ever happens</a></h1>';
echo '<p style="display: none">'.$page_mode.'</p>';

// User isn't logged in and hasn't tried to yet
if ($page_mode == 'render_login'){
	echo renderLoginPage();
// User has typed in login details and pressed enter
} else if ($page_mode == 'attempt_login'){
	$just_logged_in = false;
	if (!$_SESSION['user_id']){
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
	if ($_SESSION['user_id']){
		renderGroupListView();
	}
// User clicked forgot password but hasn't entered email yet
} else if ($page_mode == 'forgot_password'){
    echo renderForgotPasswordPage();
// User clicked forgot password and pressed Send Email
} else if ($page_mode == 'attempt_forgot_password'){
    if (checkIfAccountExistsForEmail($_POST['email'])){
        $code = sendForgotPasswordEmail($_POST['email']);
        $_SESSION['real_code'] = $code;
        renderForgotPasswordCodeForm($code, $_POST['email']);
    } else {
        renderMessage('Email address not associated with an account');
        echo renderForgotPasswordPage();
    }
// User entered password reset code and clicked go
} else if ($page_mode == 'enter_password_reset_code'){
    if ($_POST['code'] == $_SESSION['real_code']){
        $_SESSION['real_code'] = '';
        echo renderSetNewPasswordPage($_POST['email']);
    } else {
        renderMessage('Wrong password reset code');
        echo renderForgotPasswordPage();
    }
// User has clicked set new password
} else if ($page_mode == 'change_user_password'){
    if ($_POST['new_password'] != ''){
        renderMessage('Password updated');
        sqlQuery('UPDATE users SET password="'.password_hash($_POST['new_password'], PASSWORD_BCRYPT).'" WHERE user_id="'.$_POST['user_id'].'"');
        echo renderLoginPage();
    } else {
        renderMessage('New password cannot be blank');
        echo renderForgotPasswordPage();
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
    if ($_SESSION['group_already_created'] != true){
        $new_group_id = 'grp'.uniqid();
        createGroup($new_group_id, $_POST['group_name'], $_SESSION['user_id']);
        addUserToGroup($_SESSION['user_id'], $new_group_id);
        renderMessage('Group "'.$_POST['group_name'].'" Created');
        $_SESSION['group_already_created'] = true;
    }
    renderGroupListView();
// User has clicked a group in their group list
} else if ($page_mode == 'view_group'){
    if (!isset($_POST['group_id']) and !isset($_SESSION['active_group'])){
        echo renderLoginPage();
    } else {
        if (isset($_POST['group_id'])){
            $group_id = $_POST['group_id'];
            $_SESSION['active_group'] = $group_id;
        } else if (isset($_SESSION['active_group'])){
            $group_id = $_SESSION['active_group'];
        }
        renderGroupEventsPage($group_id);
    }
// User has clicked Admin Settings
} else if ($page_mode == 'admin_settings'){
    renderAdminSettingsPage();
// User has clicked make private
} else if ($page_mode == 'make_group_private'){
    setGroupPrivate($_SESSION['active_group']);
    renderAdminSettingsPage();
// User has clicked make public
} else if ($page_mode == 'make_group_public'){
    setGroupPublic($_SESSION['active_group']);
    renderAdminSettingsPage();
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
	renderMessage(getUsernameById($user_id).' removed from '.getGroupNameById($group_id));
	renderGroupListView();
// User clicked add user (to group)
} else if ($page_mode == 'add_user'){
	$group_id = $_SESSION['active_group'];
	renderAddUserPage($group_id);
// User clicked kick user (from group)
} else if ($page_mode == 'kick_user'){
	$group_id = $_SESSION['active_group'];
	renderKickUserPage($group_id);
} else if ($page_mode == 'attempt_add_user'){
	$group_id = $_POST['group_id'];
	$username = $_POST['username'];
	$user_id = getUserIdByUsername($username);
	if ($user_id != null){
		addUserToGroup($user_id, $group_id);
        renderMessage($username.' added to '.getGroupNameById($group_id));
		renderGroupEventsPage($group_id);
	} else {
		renderMessage('User does not exist');
		renderAddUserPage($group_id);
	}
} else if ($page_mode == 'attempt_kick_user'){
	$group_id = $_POST['group_id'];
	$username = $_POST['username'];
	$user_id = getUserIdByUsername($username);
	if ($user_id != null){
		removeUserFromGroup($user_id, $group_id);
        renderMessage($username.' kicked out of '.getGroupNameById($group_id));
		renderGroupEventsPage($group_id);
	} else {
		renderMessage('User does not exist');
		renderAddUserPage($group_id);
	}
// User clicked create event but hasn't entered event details yet
} else if ($page_mode == 'create_event'){
    $_SESSION['event_already_created'] = false;
	$group_id = $_SESSION['active_group'];
	echo renderCreateEventPage($group_id);
// User has clicked to submit their new event details
} else if ($page_mode == 'attempt_create_event'){
	$group_id = $_SESSION['active_group'];
    if ($_SESSION['event_already_created'] != true){
        $event_id = 'evt'.uniqid();
        $create_event_message = createEvent($event_id, $_POST['group_id'], $_SESSION['user_id'], $_POST['question'], $_POST['deadline']);
// User's new event details were accepted and it was submitted
        if ($create_event_message == ''){
            $_SESSION['event_already_created'] = true;
            $_SESSION['active_event'] = $event_id;
            renderMessage('Event submitted');
            renderEventPage($event_id);
// User's event was rejected
        } else {
            renderMessage($create_event_message);
            echo renderCreateEventPage($group_id);
        }
    } else {
        renderEventPage($_SESSION['active_event']);
    }
// User clicked an event
} else if ($page_mode == 'view_event'){
    $_SESSION['call_already_submitted'] = false;
    if (isset($_POST['event_id'])){
        $event_id = $_POST['event_id'];
        $_SESSION['active_event'] = $event_id;
    } else {
        $event_id = $_SESSION['active_event'];
    }
	//renderMessage('Viewing event '.$event_id);
	renderEventPage($event_id);
// User clicked make call after selecting from the dropdown
} else if ($page_mode == 'make_call'){
    $event_id = $_SESSION['active_event'];
    if ($_SESSION['call_already_submitted'] != true){
        $option_id = $_POST['option_selector'];
        submitUserCall($event_id, $option_id);
        $_SESSION['call_already_submitted'] = true;
    }
    renderEventPage($event_id);
// User clicked Set Outcome from the event page
} else if ($page_mode == 'resolve_event'){
	$event_id = $_SESSION['active_event'];
	renderMessage('Setting outcome of event "'.getEventQuestionById($event_id).'"');
	renderResolveEventPage($event_id);
// User set the outcome with the dropdown and clicked Set Outcome
} else if ($page_mode == 'attempt_resolve_event'){
    $event_id = $_SESSION['active_event'];
    setEventOutcome($event_id, $_POST['option_selector']);
    renderMessage('Event outcome set');
    renderEventPage($event_id);
// User clicked cancel event from the event page
} else if ($page_mode == 'cancel_event'){
    $event_id = $_SESSION['active_event'];
    renderMessage('Do you really want to cancel this event?');
    renderCancelEventPage($event_id);
// User confirmed to cancel event
} else if ($page_mode == 'attempt_cancel_event'){
    $event_id = $_SESSION['active_event'];
    cancelEvent($event_id);
    renderMessage('Event cancelled');
    renderEventPage($event_id);
} else if ($page_mode == 'view_user'){
    if (checkIfAccountExistsByUsername($_GET['usr'])){
        renderUserPage($_GET['usr']);
    } else {
        renderMessage('User "'.urldecode($_GET['usr']).'" doesn\'t exist');
    }
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

function copyText(element_id){
    navigator.clipboard.writeText(element_id);
    document.getElementById(element_id).innerHTML = 'Copied';
}
if (document.getElementById('create-options-list') != null){
    initialiseCreateOptionsList();
}

if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
