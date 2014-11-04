<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<?php echo "<?php echo \$this->Html->css('datatables/dataTables.bootstrap'); ?>\n"; ?>
<div class="row">
    <div class="col-xs-12">

    <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></h3>
			<div class="box-tools pull-right">
                <?php echo "<?php echo \$this->Html->link(__('<i class=\"glyphicon glyphicon-plus\"></i> New ".$singularHumanName."'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>\n"; ?>
            </div>
		</div>	
			<div class="box-body table-responsive">
                <table id="<?php echo str_replace(' ', '', $pluralHumanName); ?>" class="table table-bordered table-striped">
					<thead>
						<tr>
						<?php foreach ($fields as $field): ?>
							<th class="text-center"><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th>
						<?php endforeach; ?>
						<th class="text-center"><?php echo "<?php echo __('Actions'); ?>"; ?></th>
						</tr>
					</thead>
					<tbody>
					<?php 
						echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
						echo "\t<tr>\n";
						foreach ($fields as $field) {
							$isKey = false;
							if (!empty($associations['belongsTo'])) {
								foreach ($associations['belongsTo'] as $alias => $details) {
									if ($field === $details['foreignKey']) {
										$isKey = true;
										echo "\t\t<td class=\"text-center\">\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
										break;
									}
								}
							}
							if ($isKey !== true) {
								echo "\t\t<td class=\"text-center\"><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
							}
						}

						echo "\t\t<td class=\"text-center\">\n";
						echo "\t\t\t<?php echo \$this->Html->link(__('<i class=\"glyphicon glyphicon-eye-open\"></i>'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => 'view')); ?>\n";
						echo "\t\t\t<?php echo \$this->Html->link(__('<i class=\"glyphicon glyphicon-pencil\"></i>'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => 'edit')); ?>\n";
						echo "\t\t\t<?php echo \$this->Form->postLink(__('<i class=\"glyphicon glyphicon-trash\"></i>'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => 'delete'), __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
						echo "\t\t</td>\n";
						echo "\t</tr>\n";

						echo "<?php endforeach; ?>\n";
					?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
			
			
		</div><!-- /.index -->
	
	</div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->

<?php echo "<?php
	echo \$this->Html->script('jquery.min');
	echo \$this->Html->script('plugins/datatables/jquery.dataTables');
	echo \$this->Html->script('plugins/datatables/dataTables.bootstrap');
?>\n"; ?>
<script type="text/javascript">
    $(function() {
        $("#<?php echo str_replace(' ', '', $pluralHumanName); ?>").dataTable();
    });
</script>