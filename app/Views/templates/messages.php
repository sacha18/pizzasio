<?php
if (isset($messages)) {
    foreach ($messages as $m) {  ?>
<div class="alert <?= $m['class']?>"><?= $m['txt'] ?></div><?php

    }
}