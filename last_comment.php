<?php 
include ('includes/db_connect.php');
include ('includes/functions.php');
include ('includes/db.php');
spl_autoload_register('autoload');
function autoload($class){
	require 'class/' . str_replace('\\', '/', $class) . '.php';
};?>
<?php $comments_cls = new Comments($pdo); ?>
<?php $comments =$comments_cls->findLast();?>
<?php foreach ($comments as $comment): ?>
	<?php $departement = $comment['address_postal_code']; ?>
	<?php $ville = encode($comment['address_city']); ?>
	 <?php $namerestaurant = encode($comment['name']); ?>
			<div class="comment row" style="border:solid 1px #DDD">
				<div class="col-s-2">
					<img src="http://www.gravatar.com/avatar/<?= md5($comment['email']); ?>">
				</div>
				<div class="col-s-10">
				<p>

					<strong><?= $comment['username']; ?> </strong>-> <a href="http://localhost/jap/jap/restaurant/
		<?php echo $departement[0],$departement[1]; ?>/
		<?php echo $ville; ?>/
		<?php echo $namerestaurant; ?>
		.html"><?= $comment['name']; ?></a> (<?= $comment['address_city'];?>, <?= $comment['address_department'];?>)
					<em><?= date('d/m/Y à H:i:s', strtotime($comment['created'])); ?></em>
					<?php $note_moyenne = ($comment['note1'] + $comment['note2'])/2;?>
					<?php $notes_moyenne = str_replace(".", "", $note_moyenne); ?>
					<div class="note">
						<div class="notes<?= $notes_moyenne; ?>">
							
						</div>
					</div>
					
					
				</p>
				<p>
					<?= $comment['content']; ?>
				</p>
				</div>
			</div>
	<?php endforeach ?>