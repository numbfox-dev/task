function new_task() {
    var username = $('#username').val();
    var email = $('#email').val();
    var text = $('#text').val();
	
	$('#result').html('');
	
	$.post('action.php', {new: 'new_task', username: username, email: email, text: text}, result);
	function result(data) {
		$('#result').html(data);
	}
}

function edit_task(id) {
    var username = $('#username').val();
    var email = $('#email').val();
    var text = $('#text').val();
	
	$('#result').html('');
	
	$.post('/action.php', {edit: 'edit_task', id: id, username: username, email: email, text: text}, result);
	function result(data) {
		$('#result').html(data);
	}
}

function login() {
    var login = $('#login').val();
    var password = $('#password').val();

    $.post('action.php', {template: 'login', login: login, password: password}, result);
    function result(data) {
		if (data) {
			alert(data);
		} else {
			location.href = '';
		}
    }
}

function logout() {
    $.post('action.php', {template: 'logout'}, result);
    function result() {
        location.href = '';
    }
}

function change(id) {
	var status = $('#status_checkbox_' + id).is(':checked');
	
	$.post('action.php', {template: 'change', id: id, status: status}, result);
    function result(data) {
		$('#status_' + id).html(data);
    }
}

function sort_by(sort) {
	$.post('action.php', {template: 'sort_by', sort: sort});
	location.reload();
}
