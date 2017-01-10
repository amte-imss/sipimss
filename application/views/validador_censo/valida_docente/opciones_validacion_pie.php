<?php
// pr( $identificador); 
$can_bot = count($botones_validador);

$num_column = ($can_bot > 0) ? 12 / $can_bot : 12;

$columnClass_division = 'col-xs-' . $num_column . ' col-sm-' . $num_column . ' col-md-' . $num_column;
?>
<?php if (!empty($botones_validador)) { ?>
    <div class="list-group-item text-center center ">
        <div class="row">
            <?php $count = 0;
            foreach ($botones_validador as $value) {
                ?>
                <div class="<?php echo $columnClass_division; ?> text-center" >
                <?php echo $value; ?>
                </div>
    <?php } ?>
        </div>
    </div>
<?php } ?>