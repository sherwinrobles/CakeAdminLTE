<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<div class="row">
    <div class="col-xs-12">
		
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo "<?php  echo __('{$singularHumanName}'); ?>"; ?></h3>
				<div class="box-tools pull-right">
	                <?php echo "<?php echo \$this->Html->link(__('<i class=\"glyphicon glyphicon-pencil\"></i> Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>\n"; ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="<?php echo str_replace(' ', '', $pluralHumanName); ?>" class="table table-bordered table-striped">
					<tbody>
						<?php
						foreach ($fields as $field) {
							$isKey = false;
							if (!empty($associations['belongsTo'])) {
								foreach ($associations['belongsTo'] as $alias => $details) {
									if ($field === $details['foreignKey']) {
										$isKey = true;
										echo "<tr>";
										echo "\t\t<td><strong><?php echo __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></strong></td>\n";
										echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}']), array('class' => '')); ?>\n\t\t\t&nbsp;\n\t\t</td>\n";
										echo "</tr>";
										break;
									}
								}
							}
							if ($isKey !== true) {
								echo "<tr>";
								echo "\t\t<td><strong><?php echo __('" . Inflector::humanize($field) . "'); ?></strong></td>\n";
								echo "\t\t<td>\n\t\t\t<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>\n\t\t\t&nbsp;\n\t\t</td>\n";
								echo "</tr>";
							}
						}
						?>
					</tbody>
				</table><!-- /.table table-striped table-bordered -->
			</div><!-- /.table-responsive -->
			
		</div><!-- /.view -->

		<?php
		if (!empty($associations['hasOne'])) :
			foreach ($associations['hasOne'] as $alias => $details): ?>
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title"><?php echo "<?php echo __('Related " . Inflector::humanize($details['controller']) . "'); ?>"; ?></h3>
						<div class="box-tools pull-right">
		                	<?php echo "<li><?php echo \$this->Html->link(__('<i class=\"glyphicon glyphicon-plus\"></i> Edit " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$singularVar}['{$alias}']['{$details['primaryKey']}']), array('class' => 'btn btn-primary', 'escape' => false)); ?>\n"; ?>         
		                </div>
					</div>
					<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n"; ?>
						<div class="box-body table-responsive">
                			<table class="table table-bordered table-striped">
							<?php
							foreach ($details['fields'] as $field) {
								echo "<tr>";
								echo "\t\t<td class=\"text-center\"><strong><?php echo __('" . Inflector::humanize($field) . "'); ?></strong></td>\n";
								echo "\t\t<td class=\"text-center\"><strong><?php echo \${$singularVar}['{$alias}']['{$field}']; ?>\n&nbsp;</strong></td>\n";
								echo "</tr>";
							}
							?>
							</table><!-- /.table table-striped table-bordered -->
						</div>
					<?php echo "<?php endif; ?>\n"; ?>
				</div><!-- /.related -->
			<?php
			endforeach;
		endif;

		if (empty($associations['hasMany'])) {
			$associations['hasMany'] = array();
		}
		if (empty($associations['hasAndBelongsToMany'])) {
			$associations['hasAndBelongsToMany'] = array();
		}
		$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
		$i = 0;
		foreach ($relations as $alias => $details):
			$otherSingularVar = Inflector::variable($alias);
			$otherPluralHumanName = Inflector::humanize($details['controller']);
			?>
			
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title"><?php echo "<?php echo __('Related " . $otherPluralHumanName . "'); ?>"; ?></h3>
					<div class="box-tools pull-right">
						<?php echo "<?php echo \$this->Html->link('<i class=\"glyphicon glyphicon-plus\"></i> '.__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>"; ?>
					</div><!-- /.actions -->
				</div>
				<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n"; ?>
					
					<div class="box-body table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<?php
										foreach ($details['fields'] as $field) {
											echo "\t\t<th class=\"text-center\"><?php echo __('" . Inflector::humanize($field) . "'); ?></th>\n";
										}
									?>
									<th class="text-center"><?php echo "<?php echo __('Actions'); ?>"; ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								echo "\t<?php
										\$i = 0;
										foreach (\${$singularVar}['{$alias}'] as \${$otherSingularVar}): ?>\n";
										echo "\t\t<tr>\n";
											foreach ($details['fields'] as $field) {
												echo "\t\t\t<td class=\"text-center\"><?php echo \${$otherSingularVar}['{$field}']; ?></td>\n";
											}

											echo "\t\t\t<td class=\"text-center\">\n";
											echo "\t\t\t\t<?php echo \$this->Html->link(__('<i class=\"glyphicon glyphicon-eye-open\"></i>'), array('controller' => '{$details['controller']}', 'action' => 'view', \${$otherSingularVar}['{$details['primaryKey']}']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => 'view')); ?>\n";
											echo "\t\t\t\t<?php echo \$this->Html->link(__('<i class=\"glyphicon glyphicon-pencil\"></i>'), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$otherSingularVar}['{$details['primaryKey']}']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => 'edit')); ?>\n";
											echo "\t\t\t\t<?php echo \$this->Form->postLink(__('<i class=\"glyphicon glyphicon-trash\"></i>'), array('controller' => '{$details['controller']}', 'action' => 'delete', \${$otherSingularVar}['{$details['primaryKey']}']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => 'delete'), __('Are you sure you want to delete # %s?', \${$otherSingularVar}['{$details['primaryKey']}'])); ?>\n";
											echo "\t\t\t</td>\n";
										echo "\t\t</tr>\n";

								echo "\t<?php endforeach; ?>\n";
								?>
							</tbody>
						</table><!-- /.table table-striped table-bordered -->
					</div><!-- /.table-responsive -->
					
				<?php echo "<?php endif; ?>\n\n"; ?>
				
				
			</div><!-- /.related -->

		<?php endforeach; ?>
	
	</div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->

