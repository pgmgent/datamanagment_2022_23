<?php
 $isSelected = ($teacher['short_name'] == $selected_teacher) ? 'selected' : ''; 
?> 
<option 
    value="<?= $teacher['short_name']; ?>" 
    <?= $isSelected; ?> 
>
    <?= $teacher['firstname'] . ' ' .$teacher['lastname']; ?>
</option>