<?php

// No need to import Schedule here as it's passed as a parameter
// to the closure in bootstrap/app.php

// Process the queue every minute
$schedule->command('app:process-queue')->everyMinute()->withoutOverlapping();

// You can add more scheduled tasks here as needed