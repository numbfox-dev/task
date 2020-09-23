<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">

        
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<link rel="stylesheet" href="<?= dynamic_file_name('/css/style.css'); ?>">
		<script src="<?= dynamic_file_name('/js/jquery-3.3.1.min.js'); ?>"></script>
		<script src="<?= dynamic_file_name('/js/functions.js'); ?>"></script>
		
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

        <title><?= $data['title']; ?></title>
    </head>
    <body>
	
        <header>
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<a class="navbar-brand" href="<?= home(); ?>">Task Manager</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<div class="form-inline my-2 my-lg-0">
						<? if (!login_admin()): ?>
						<input class="form-control mr-sm-2" type="text" id="login" placeholder="Логин">
						<input class="form-control mr-sm-2" type="password" id="password" placeholder="Пароль">
						<button class="btn btn-outline-success mr-sm-2" type="button" onclick="login()">Войти</button>
						<? else: ?>
						<button class="btn btn-outline-success mr-sm-2" type="button" onclick="logout()">Выйти</button>
						<? endif; ?>
						<a href="<?= home('/new'); ?>" type="button" class="btn btn-outline-primary mr-sm-2">Создать новую задачу</a>
					</div>
				</div>
			</nav>
        </header>
		
		<? include_once(DOCUMENT_ROOT . '/core/templates/' . $content_view . '.php'); ?>
    </body>
</html>