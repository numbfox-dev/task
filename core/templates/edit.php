<? if (login_admin()): ?>
<div class="col-sm-4">
	<input type="text" class="form-control mr-sm-2" id="username" placeholder="Имя" value="<?= $data['task']->username; ?>">
	<input type="text" class="form-control mr-sm-2" id="email" placeholder="E-mail" value="<?= $data['task']->email; ?>">
	<textarea class="form-control mr-sm-2" id="text" placeholder="Задача"><?= $data['task']->text; ?></textarea>
	
	<div id="result"></div>
	
	<button type="button" class="btn btn-outline-primary mr-sm-2" onclick="edit_task(<?= $data['task']->id; ?>)">Изменить задачу</button>
</div>
<? else: ?>
<div>Нет доступа</div>
<? endif; ?>