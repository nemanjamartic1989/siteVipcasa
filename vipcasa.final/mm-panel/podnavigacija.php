<li><a href="./index.php?modul=vrste&LID=<?php echo $LID; ?>">Lista Vrsta</a></li>
<li><a href="#" onClick="$('#divMiddle').html(''); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'nova_vrsta',  LID:'<?php echo $LID; ?>'}).fadeIn('slow');">Nova vrsta</a></li>
<li><a href="./index.php?modul=tip&LID=<?php echo $LID; ?>">Lista tipova</a></li>
<li><a href="#" onClick="$('#divMiddle').html(''); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'novi_tip',  LID:'<?php echo $LID; ?>'}).fadeIn('slow');">Novi tip</a></li>
<li><a href="./index.php?modul=lokacija&LID=<?php echo $LID; ?>">Lista lokacija</a></li>
<li><a href="#" onClick="$('#divMiddle').html(''); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'nova_lokacija',  LID:'<?php echo $LID; ?>'}).fadeIn('slow');">Nova lokacija</a></li>
<li><a href="./index.php?modul=stan&LID=<?php echo $LID; ?>">Lista stanova</a></li>
<li><a href="#" onClick="$('#divMiddle').html(''); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'novi_stan',  LID:'<?php echo $LID; ?>'}).fadeIn('slow');">Novi stan</a></li>
        