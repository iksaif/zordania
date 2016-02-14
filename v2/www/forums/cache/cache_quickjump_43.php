<?php

if (!defined('PUN')) exit;
define('PUN_QJ_LOADED', 1);

?>				<form id="qjump" method="get" action="viewforum.php">
					<div><label><?php echo $lang_common['Jump to'] ?>

					<br /><select name="id" onchange="window.location=('viewforum.php?id='+this.options[this.selectedIndex].value)">
						<optgroup label="Zordania">
							<option value="5"<?php echo ($forum_id == 5) ? ' selected="selected"' : '' ?>>Discussions générales</option>
							<option value="25"<?php echo ($forum_id == 25) ? ' selected="selected"' : '' ?>>Discussions générales Zordaniennes</option>
							<option value="6"<?php echo ($forum_id == 6) ? ' selected="selected"' : '' ?>>Suggestions</option>
							<option value="7"<?php echo ($forum_id == 7) ? ' selected="selected"' : '' ?>>Entraide</option>
							<option value="8"<?php echo ($forum_id == 8) ? ' selected="selected"' : '' ?>>Rapports de bugs</option>
						</optgroup>
						<optgroup label="L'univers de Zordania">
							<option value="9"<?php echo ($forum_id == 9) ? ' selected="selected"' : '' ?>>Haute Place</option>
							<option value="12"<?php echo ($forum_id == 12) ? ' selected="selected"' : '' ?>>Hall des Batailles</option>
							<option value="14"<?php echo ($forum_id == 14) ? ' selected="selected"' : '' ?>>La Cour des Légendes</option>
						</optgroup>
						<optgroup label="Equipe">
							<option value="18"<?php echo ($forum_id == 18) ? ' selected="selected"' : '' ?>>Admin</option>
							<option value="16"<?php echo ($forum_id == 16) ? ' selected="selected"' : '' ?>>VIP</option>
							<option value="15"<?php echo ($forum_id == 15) ? ' selected="selected"' : '' ?>>Modération</option>
						</optgroup>
						<optgroup label="Staff Code">
							<option value="21"<?php echo ($forum_id == 21) ? ' selected="selected"' : '' ?>>Question techniques et Ressources</option>
							<option value="24"<?php echo ($forum_id == 24) ? ' selected="selected"' : '' ?>>Travaux en Cours</option>
							<option value="20"<?php echo ($forum_id == 20) ? ' selected="selected"' : '' ?>>Bugs à Régler</option>
							<option value="23"<?php echo ($forum_id == 23) ? ' selected="selected"' : '' ?>>Bugs Corrigés</option>
							<option value="17"<?php echo ($forum_id == 17) ? ' selected="selected"' : '' ?>>Suggestions intéressantes</option>
							<option value="22"<?php echo ($forum_id == 22) ? ' selected="selected"' : '' ?>>Suggestions retenues</option>
						</optgroup>
						<optgroup label="Archives">
							<option value="28"<?php echo ($forum_id == 28) ? ' selected="selected"' : '' ?>>Topics Archivés</option>
					</optgroup>
					</select>
					<input type="submit" value="<?php echo $lang_common['Go'] ?>" accesskey="g" />
					</label></div>
				</form>
