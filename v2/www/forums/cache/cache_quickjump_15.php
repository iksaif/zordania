<?php

if (!defined('PUN')) exit;
define('PUN_QJ_LOADED', 1);

?>				<form id="qjump" method="get" action="viewforum.php">
					<div><label><?php echo $lang_common['Jump to'] ?>

					<br /><select name="id" onchange="window.location=('viewforum.php?id='+this.options[this.selectedIndex].value)">
						<optgroup label="Zordania">
							<option value="30"<?php echo ($forum_id == 30) ? ' selected="selected"' : '' ?>>News</option>
							<option value="5"<?php echo ($forum_id == 5) ? ' selected="selected"' : '' ?>>Discussions générales</option>
							<option value="25"<?php echo ($forum_id == 25) ? ' selected="selected"' : '' ?>>Discussions générales Zordaniennes</option>
							<option value="6"<?php echo ($forum_id == 6) ? ' selected="selected"' : '' ?>>Suggestions</option>
							<option value="7"<?php echo ($forum_id == 7) ? ' selected="selected"' : '' ?>>Entraide</option>
							<option value="8"<?php echo ($forum_id == 8) ? ' selected="selected"' : '' ?>>Rapports de bugs</option>
						</optgroup>
						<optgroup label="L'univers de Zordania">
							<option value="9"<?php echo ($forum_id == 9) ? ' selected="selected"' : '' ?>>Haute Place</option>
							<option value="29"<?php echo ($forum_id == 29) ? ' selected="selected"' : '' ?>>Bas Quartiers</option>
							<option value="12"<?php echo ($forum_id == 12) ? ' selected="selected"' : '' ?>>Hall des Batailles</option>
							<option value="14"<?php echo ($forum_id == 14) ? ' selected="selected"' : '' ?>>La Cour des Légendes</option>
					</optgroup>
					</select>
					<input type="submit" value="<?php echo $lang_common['Go'] ?>" accesskey="g" />
					</label></div>
				</form>
