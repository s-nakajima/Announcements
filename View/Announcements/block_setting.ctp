<div ng-controller="Announcements.setting">
	<?php echo $this->Form->create(); ?>
	<h3><?php echo __('お知らせ');?></h3>

	<h4><?php echo __('記事投稿権限'); ?></h4>
	<div class="form-group container">
		<?php
		foreach($partList as $k=>$i){
			?><label class="pull-left" style="padding:0 10px;"><?php
			if($k < 3)
			{
				?>
				<span class="glyphicon glyphicon-ok"></span>
				<?php
				echo h($i['name']).'<br>';
			}else{
				echo $this->Form->input(
					'',
					array(
						'type'=>'checkbox',
						'name'=>' '.'part['.$i['id'].']',
						'lavel'=>false,
						'div' => false,
						'id'=>false,
						'value'=>$i['id'],
						'separator'=>'<br>'
					)
				);
				echo " ".h($i['name']);
			}
			?></label><?php
		}
		?>
	</div>
	<div style="clear: both;"></div>


	<h4><?php echo __('投稿の承認設定'); ?></h4>
	<div class="container">
		<label class="pull-left" style="padding:0 5px;">
				<?php
				echo $this->Form->radio('',
					array(
						1=>" ".__("ルーム管理者の承認が必要"),
						2=>" ".__("自動的に承認する"),),
					array(
					'div'=>false,
					'name'=>'name',
					'legend'=>false,
					'id'=>false,
					'label'=>false,
					'separator'=>'</label><label class="pull-left" style="padding:0 10px;">',
				));
				?>
			</label>
	</div>
	<div style="clear: both;"></div>


	<h4><?php echo __('メール配信設定'); ?></h4>
	<div class="container">
		<label class="pull-left" style="padding:0 5px;">
			<?php
			echo $this->Form->radio('',
				array(
					1=>"  ".__("投稿をメールで通知する"),
					2=>"  ".__("投稿をメールで通知しない"),),
				array(
					'div'=>false,
					'name'=>'name',
					'legend'=>false,
					'id'=>false,
					'label'=>false,
					'separator'=>'</label><label class="pull-left" style="padding:0 10px;">',
				));
			?>
		</label>
	<div style="clear: both;"></div>
	</div>



	<h5><?php echo __('通知する権限'); ?></h5>
	<div class="container">
	<label class="pull-left" style="padding:0 5px;">
	<?php
	echo $this->Form->radio('',
		array(
			1=>" ".__("ルーム管理者"),
			2=>" ".__("編集長"),
			3=>" ".__("編集者"),
			4=>" ".__("一般"),
			5=>" ".__("参観者")),
		array(
			'div'=>false,
			'name'=>'name',
			'legend'=>false,
			'id'=>false,
			'separator'=>'</label><label class="pull-left" style="padding:0 5px;">',
		));
	?>
	</label>
	<div style="clear: both;"></div>
	</div>


	<h5><?php echo __('件名'); ?></h5>
	<div>
	<?php echo $this->Form->input('hoge',
		array(
			'div'=>false,
			'name'=>'name',
			'legend'=>false,
			'id'=>false,
			'label'=>false,
			'class'=>'form-control'
		));
	?>
	</div>

	<h5><?php echo __('内容'); ?></h5>
	<div>
	<?php echo $this->Form->textarea("",
		array(
			"cols"=>20,
			"rows"=>5,
			"value"=>"",
			"class"=>"form-control"));
	?>
	</div>

	<p>
		<?php echo __('件名と本文には、{X-SITE_NAME}、{X-ROOM}、{X-ANNOUNCEMENT_NAME}、{X-USER}、{X-TO_DATE}、{X-BODY}、{X-URL}というキーワードを使えます。'); ?>
   </p>
	<p>
		<?php echo __('それぞれのキーワードは、サイト名称、ルーム名称、お知らせタイトル、投稿者ハンドル名称、投稿日時、記事本文、投稿内容のURLに変換されて送信されます。'); ?>
	</p>

	<p class="container text-center">
		<button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
		<button type="button" class="btn btn-primary"><?php echo __("登録")?></button>
	</p>
	<?php echo $this->Form->end(); ?>
</div>