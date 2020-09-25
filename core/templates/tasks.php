<div class="container">
	
	<div class="row justify-content-md-center">
		<div class="col col-lg-2 clicked" onclick="sort_by('username')">Имя</div>
		<div class="col col-lg-2 clicked" onclick="sort_by('email')">E-mail</div>
		<div class="col clicked" onclick="sort_by('text')">Задача</div>
		<div class="col col-lg-2 clicked">Статус</div>
	</div>

	<? for ($i = 0, $limit = sizeof($data['tasks']); $i < $limit; $i++): ?>
	<div class="row justify-content-md-center">
		<div class="col col-lg-2"><?= $data['tasks'][$i]->username; ?></div>
		<div class="col col-lg-2"><?= $data['tasks'][$i]->email; ?></div>
		<div class="col"><?= $data['tasks'][$i]->text; ?></div>
		<? if (login_admin()): ?>
		<? $checked = ($data['tasks'][$i]->status == 1) ? 'checked' : '' ; ?>
		<div><a href="<?= home('/edit/' . $data['tasks'][$i]->id); ?>"><img src="<?= home('/img/edit.png'); ?>"></a></div>
		<? endif; ?>
		<div class="col">
			<div class="col col-lg-2" id="status_<?= $data['tasks'][$i]->id; ?>"><?= $data['status'][$data['tasks'][$i]->status]; ?></div>
			<? if ($data['tasks'][$i]->edited == 1): ?>
			<div class="col col-lg-2" >Отредактировано администратором</div>
			<? endif; ?>
		</div>
		<? if (login_admin()): ?>
		<? $checked = ($data['tasks'][$i]->status == 1) ? 'checked' : '' ; ?>
		<div><input type="checkbox" <?= $checked; ?> onclick="change('<?= $data['tasks'][$i]->id; ?>')" id="status_checkbox_<?= $data['tasks'][$i]->id; ?>"></div>
		<? endif; ?>
	</div>
	<? endfor; ?>
</div>

<div class="container">
	<div class="row">
		<nav id="pagination">
		  <ul class="pagination">			
			
			<? if (1 != $data['pagination']->current): ?>
				<li class="page-item"><a class="page-link" href="/?page=1" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
			<? endif; ?>
		
			<? if ($data['pagination']->second_prev): ?>				
				<li class="page-item"><a class="page-link" href="/?page=<?= $data['pagination']->second_prev; ?>"><?= $data['pagination']->second_prev; ?></a></li>
			<? endif; ?>
			
			<? if ($data['pagination']->first_prev): ?>
				<li class="page-item"><a class="page-link" href="/?page=<?= $data['pagination']->first_prev; ?>"><?= $data['pagination']->first_prev; ?></a></li>
			<? endif; ?>
			
			<li class="page-item active"><a class="page-link" href="/?page=<?= $data['pagination']->current; ?>"><?= $data['pagination']->current; ?></a></li>
			
			<? if ($data['pagination']->first_next): ?>
				<li class="page-item"><a class="page-link" href="/?page=<?= $data['pagination']->first_next; ?>"><?= $data['pagination']->first_next; ?></a></li>
			<? endif; ?>
			
			<? if ($data['pagination']->second_next): ?>
				<li class="page-item"><a class="page-link" href="/?page=<?= $data['pagination']->second_next; ?>"><?= $data['pagination']->second_next; ?></a></li>
			<? endif; ?>
			
			<? if ($data['pagination']->last != $data['pagination']->current): ?>
				<li class="page-item"><a class="page-link" href="/?page=<?= $data['pagination']->last; ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
			<? endif; ?>

		  </ul>
		</nav>
	</div>
</div>
