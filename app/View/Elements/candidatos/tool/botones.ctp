<div class="control"> 
	<div class="area clearfix">

		<div class="bottons text-left float-left" > 
			<?php foreach ($botones as $key => $value) : ?>
				

				<button class="btn btn-success  <?=$value['class']?> "> 
					<?=$value['title']?>
				</button>

			<?php endforeach ?>

		</div>

		<div class="text-center float-left">

			<div class="status">  </div> 							
		</div>
	</div>
</div>		