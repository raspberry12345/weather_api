<?php if(empty($weather)): ?>
    <h2>Das Wetter konnte nicht abgerufen werden!</h2>
    
<?php else: ?>

<h2>Temperatur in Budapest: <?php echo e($weather->temperature); ?>°C. <br>  <?php if(!$weather->raining){echo 'Es ist sonnig';}else{echo 'Es regnet';} ?> </h2>

<?php endif; ?>