<?php
/**
 * @version     3.1.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2014. Alle Rechte vorbehalten.
 * @license     GNU General Public License Version 2 oder später; siehe LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@einsatzkomponente.de> - http://einsatzkomponente.de
 */
// no direct access
defined('_JEXEC') or die;

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_einsatzkomponente', JPATH_ADMINISTRATOR);


JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canCreate = $user->authorise('core.create', 'com_einsatzkomponente');
$canEdit = $user->authorise('core.edit', 'com_einsatzkomponente');
$canCheckin = $user->authorise('core.manage', 'com_einsatzkomponente');
$canChange = $user->authorise('core.edit.state', 'com_einsatzkomponente');
$canDelete = $user->authorise('core.delete', 'com_einsatzkomponente');
?>

<form action="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzberichte_neu'); ?>" method="post" name="adminForm" id="adminForm">

    <?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
    <table class="table table-striped" id = "einsatzberichtList" >
        <thead >
            <tr class="mobile_hide_480 ">
			
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_DATE1', 'a.date1', $listDirn, $listOrder); ?>
				</th>
				
    			<th class='left'>
				<?php echo ''; ?>
				</th>
				
           <?php if ($this->params->get('display_home_image')) : ?>
				<th class='left mobile_hide_480 '>
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_IMAGE', 'a.image', $listDirn, $listOrder); ?>
				</th>
			<?php endif;?>
				
		<!--		<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_IMAGES', 'a.images', $listDirn, $listOrder); ?>
				</th> -->
				<th class='left mobile_hide_480'>
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_SUMMARY', 'a.summary', $listDirn, $listOrder); ?>
				</th>
		<!--		<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_AUSWAHLORGA', 'a.auswahl_orga', $listDirn, $listOrder); ?>
				</th> -->
		<!--		<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_VEHICLES', 'a.vehicles', $listDirn, $listOrder); ?>
				</th> -->
				<?php if ($this->params->get('display_home_counter','1')) : ?>
				<th class='left mobile_hide_480 '>
				<?php echo JHtml::_('grid.sort',  'Zugriffe', 'a.counter', $listDirn, $listOrder); ?>
				</th>
				<?php endif;?>
		<!--		<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_EINSATZKOMPONENTE_EINSATZBERICHTE_CREATED_BY', 'a.created_by', $listDirn, $listOrder); ?>
				</th> -->


    <?php if (isset($this->items[0]->id)): ?>
      <!--  <th width="1%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
        </th> -->
    <?php endif; ?>

    		<?php if ($canEdit || $canDelete): ?>
             <?php if (isset($this->items[0]->state)): ?>
				<th width="1%" class="nowrap center">
				<?php echo JHtml::_('grid.sort', 'Actions', 'a.state', $listDirn, $listOrder); ?>
				</th>
			<?php endif; ?>  
			<?php endif; ?>
	

    </tr>
    </thead>
	
    <tbody>
    <?php foreach ($this->items as $i => $item) : ?>
        <?php $canEdit = $user->authorise('core.edit', 'com_einsatzkomponente'); ?>

        				<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_einsatzkomponente')): ?>
					<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
				<?php endif; ?>

		<?php $curTime = strtotime($item->date1);?>
		
        <tr class="row<?php echo $i % 2; ?>">

	
           <?php if ($this->params->get('display_home_date_image','1')=='1') : ?>
		   <td class="eiko_td_kalender_main_1"> 
			<div class="home_cal_icon">
			<div class="home_cal_monat"><?php echo date('M', $curTime);?></div>
			<div class="home_cal_tag"><?php echo date('d', $curTime);?></div>
			<div class="home_cal_jahr"><span style="font-size:10px;"><?php echo date('Y', $curTime);?></span></div>
			</div>
           </td>
           <?php endif;?>
           <?php if ($this->params->get('display_home_date_image','1')=='2') : ?>
		   <td class="eiko_td_datum_main_1"> <?php echo date('d.m.Y ', $curTime);?><br /><?php echo date('H:i ', $curTime); ?>Uhr</td>
           <?php endif;?>
           <?php if ($this->params->get('display_home_date_image','1')=='0') : ?>
		   <td class="eiko_td_datum_main_1"> <?php echo date('d.m.Y ', $curTime);?></td>
           <?php endif;?>
           <?php if ($this->params->get('display_home_date_image','1')=='3') : ?>
		   <td class="eiko_td_kalender_main_1"> 
			<div class="home_cal_icon">
			<div class="home_cal_monat"><?php echo date('M', $curTime);?></div>
			<div class="home_cal_tag"><?php echo date('d', $curTime);?></div>
			<div class="home_cal_jahr"><span style="font-size:10px;"><?php echo date('Y', $curTime);?></span></div>
			 <?php echo '<div style="font-size:12px;white-space: nowrap;">'.date('H:i ', $curTime).' Uhr</div>'; ?>
			</div>
           </td>
           <?php endif;?>

            	<td>
					<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'einsatzberichte_neu.', $canCheckin); ?>
					<?php endif; ?> 
					<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&id='.(int) $item->id); ?>">
					<span class="eiko_nowrap"><b><?php echo $item->data1; ?></b></span></a>
					<br/>
					<?php if ($item->address): ?>
					<?php echo '<i class="icon-arrow-right"></i> '.$this->escape($item->address); ?>
					<br/>
					<?php endif;?>
					<?php if ($this->params->get('display_list_icon')) : ?>
					<img class="eiko_icon hasTooltip" src="<?php echo JURI::Root();?><?php echo $item->list_icon;?>" alt="<?php echo $item->list_icon;?>" title="Einsatzart: <?php echo $item->data1;?>"/>
					<?php endif;?>

					<?php if ($this->params->get('display_tickerkat_icon')) : ?>
					<img class="eiko_icon hasTooltip" src="<?php echo JURI::Root();?><?php echo $item->tickerkat_image;?>" alt="<?php echo $item->tickerkat;?>" title="Kategorie: <?php echo $item->tickerkat;?>"/>
					<?php endif;?>
					
					<?php if ($this->params->get('display_home_alertimage','0')) : ?>
					<img class="eiko_icon hasTooltip" src="<?php echo JURI::Root();?><?php echo $item->alerting_image;?>" title="Alarmierung über: <?php echo $item->alerting;?>" />
					<?php endif;?>

				</td>
				
           <?php if ($this->params->get('display_home_image')) : ?>
		   <td class="mobile_hide_480  eiko_td_einsatzbild_main_1">
		   <?php if ($item->image) : ?>
					<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'einsatzberichte_neu.', $canCheckin); ?>
					<?php endif; ?> 
					<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&view=einsatzbericht&id='.(int) $item->id); ?>">
		   <img  class="img-rounded eiko_img_einsatzbild_main_1" style="width:<?php echo $this->params->get('display_home_image_width','80px');?>;" src="<?php echo JURI::Root();?><?php echo $item->image;?>"/>
					</a>
           <?php endif;?>
		   </td>
           <?php endif;?>
		<!--		<td>

					<?php echo $item->images; ?>
				</td> -->
				
				<td class="mobile_hide_480">

					<?php echo $item->summary; ?>
				</td>
		<!--		<td>

					<?php echo $item->auswahl_orga; ?>
				</td> -->
		<!--		<td>

					<?php echo $item->vehicles; ?>
				</td> -->
				
				<?php if ($this->params->get('display_home_counter','1')) : ?>
				<td class="mobile_hide_480 ">

					<?php echo $item->counter; ?>
				</td>
				<?php endif; ?>
				
		<!--		<td>

							<?php echo JFactory::getUser($item->created_by)->name; ?>				</td> -->


            <?php if (isset($this->items[0]->id)): ?>
          <!--      <td class="center hidden-phone">
                    <?php echo (int)$item->id; ?>
                </td> -->
            <?php endif; ?>

			
            <?php if (isset($this->items[0]->state)): ?>
                <?php $class = ($canEdit || $canChange) ? 'active' : 'disabled'; ?>
                <td class="center">
					<?php if ($canEdit): ?>
                    <a class="btn btn-micro <?php echo $class; ?>"
                       href="<?php echo ($canEdit || $canChange) ? JRoute::_('index.php?option=com_einsatzkomponente&task=einsatzberichtform.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
                        <?php if ($item->state == 1): ?>
                            <i class="icon-publish"></i>
                        <?php else: ?>
                            <i class="icon-unpublish"></i>
                        <?php endif; ?>
                    </a>
					<?php endif; ?>
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=einsatzberichtform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
						<?php endif; ?>
						<?php if ($canDelete): ?>
							<button data-item-id="<?php echo $item->id; ?>" class="btn btn-mini delete-button" type="button"><i class="icon-trash" ></i></button>
						<?php endif; ?>
                </td>
            <?php endif; ?>

        </tr>
		
		
    <?php endforeach; ?>
    </tbody>
	
    <tfoot>
    				<!--Prüfen, ob Pagination angezeigt werden soll-->
    				<?php if ($this->params->get('display_home_pagination')) : ?>
					<tr>
					<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
                    	<form action="#" method=post>
						<?php echo $this->pagination->getListFooter(); ?><!--Pagination anzeigen-->
						</form> 
					</td></tr>
		   			<?php endif;?><!--Prüfen, ob Pagination angezeigt werden soll   ENDE -->
		
		<?php if (!$this->params->get('eiko')) : ?>
        <tr><!-- Bitte das Copyright nicht entfernen. Danke. -->
        <td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
			<span class="copyright">Einsatzkomponente V<?php echo $this->version; ?>  (C) 2013 by Ralf Meyer ( <a class="copyright_link" href="http://einsatzkomponente.de" target="_blank">www.einsatzkomponente.de</a> )</span></td>
        </tr>
	<?php endif; ?>
    </tfoot>

    </table>

    <?php if ($canCreate): ?>
        <a href="<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=einsatzberichtform.edit&id=0', false, 2); ?>"
           class="btn btn-success btn-small"><i
                class="icon-plus"></i> <?php echo JText::_('Einsatz einreichen'); ?></a>
    <?php endif; ?>

    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
    <?php echo JHtml::_('form.token'); ?>
</form>

<script type="text/javascript">

    jQuery(document).ready(function () {
        jQuery('.delete-button').click(deleteItem);
    });

    function deleteItem() {
        var item_id = jQuery(this).attr('data-item-id');
        if (confirm("<?php echo JText::_('Möchten Sie diesen Einsatzbericht wirklich löschen ?'); ?>")) {
            window.location.href = '<?php echo JRoute::_('index.php?option=com_einsatzkomponente&task=einsatzberichtform.remove&id=', false, 2) ?>' + item_id;
        }
    }
</script>


