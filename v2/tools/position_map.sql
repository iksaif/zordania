
map_cid 	map_x 	map_y 	map_climat 	map_type 	map_rand 	map_region
	Modifier 	Effacer 	25024 	23 	50 	1 	7 	2 	1
	Modifier 	Effacer 	53524 	23 	107 	1 	7 	3 	1
	Modifier 	Effacer 	61479 	478 	122 	1 	7 	3 	6
	Modifier 	Effacer 	70422 	421 	140 	1 	7 	1 	6
	Modifier 	Effacer 	85084 	83 	170 	3 	7 	3 	1
	Modifier 	Effacer 	89277 	276 	178 	3 	7 	1 	5
	Modifier 	Effacer 	96258 	257 	192 	3 	7 	2 	5
	Modifier 	Effacer 	120852 	351 	241 	3 	7 	3 	6
	Modifier 	Effacer 	130916 	415 	261 	3 	7 	2 	6
	Modifier 	Effacer 	131605 	104 	263 	3 	7 	2 	4
	Modifier 	Effacer 	137458 	457 	274 	3 	7 	2 	6
	Modifier 	Effacer 	140834 	333 	281 	3 	7 	3 	5
	Modifier 	Effacer 	141945 	444 	283 	3 	7 	3 	6
	Modifier 	Effacer 	151323 	322 	302 	3 	7 	3 	9
	Modifier 	Effacer 	167955 	454 	335 	5 	7 	1 	6
	Modifier 	Effacer 	173180 	179 	346 	5 	7 	1 	8
	Modifier 	Effacer 	177885 	384 	355 	5 	7 	1 	9
	Modifier 	Effacer 	195572 	71 	391 	5 	7 	1 	7
	Modifier 	Effacer 	211843 	342 	423 	5 	7 	1 	9
	Modifier 	Effacer 	233123 	122 	466 	5 	7 	2 	7

-- liste des terrains de type village (7) qui n'ont pas de lien dans la table des membres
SELECT * FROM zrd_map
WHERE map_type=7 
AND map_cid NOT IN (SELECT mbr_mapcid FROM zrd_mbr)


-- 1: déplacer d'abord les légions au village de 47x167 en 47x168
UPDATE zrd_leg SET leg_cid=(SELECT map_cid FROM zrd_map WHERE map_x=47 AND map_y=168)
WHERE leg_mid=(
  SELECT mbr_mid 
  FROM zrd_mbr INNER JOIN zrd_map ON mbr_mapcid=map_cid 
  WHERE map_x=47 AND map_y=167)
AND leg_cid=(SELECT map_cid FROM zrd_map WHERE map_x=47 AND map_y=167);
-- 1 bis: déplacer ensuite le membre
UPDATE zrd_mbr SET mbr_mapcid=(SELECT map_cid FROM zrd_map WHERE map_x=47 AND map_y=168)
WHERE mbr_mapcid=(SELECT map_cid FROM zrd_map WHERE map_x=47 AND map_y=167);
-- 2: initialiser la nouvelle case à l'état village
UPDATE zrd_map SET map_type=7 WHERE map_x=47 AND map_y=168;
-- 3: réinitialiser l'ancien emplacement à l'état vide
UPDATE zrd_map SET map_type=5 WHERE map_x=47 AND map_y=167;

-- 1: déplacer d'abord les légions au village
UPDATE zrd_leg SET leg_cid=(SELECT map_cid FROM zrd_map WHERE map_x=47 AND map_y=167)
WHERE leg_mid=(
  SELECT mbr_mid 
  FROM zrd_mbr INNER JOIN zrd_map ON mbr_mapcid=map_cid 
  WHERE map_x=6 AND map_y=146)
AND leg_cid=(SELECT map_cid FROM zrd_map WHERE map_x=6 AND map_y=146);
-- 1 BIS: déplacer le membre de 6x146 en 47x167
UPDATE zrd_mbr SET mbr_mapcid=(SELECT map_cid FROM zrd_map WHERE map_x=47 AND map_y=167)
WHERE mbr_mapcid=(SELECT map_cid FROM zrd_map WHERE map_x=6 AND map_y=146);
-- 2: initialiser la nouvelle case à l'état village
UPDATE zrd_map SET map_type=7 WHERE map_x=47 AND map_y=167;
-- 3: réinitialiser l'ancien emplacement à l'état vide
UPDATE zrd_map SET map_type=5 WHERE map_x=6 AND map_y=146;



17047
39466
70293
71304
73297
73796
75801
84048
100265
121281

-- déplacer Mal (mid=5707) (cid=39466) vers son ancienne position (cid=27361)
-- 1: déplacer d'abord les légions au village de 223x333 vers 225x328
UPDATE zrd_leg SET leg_cid=27361 WHERE leg_mid=5707
-- 1 bis: déplacer ensuite le membre
UPDATE zrd_mbr SET mbr_mapcid=27361 WHERE mbr_mid=5707;
-- 2: initialiser la nouvelle case à l'état village
UPDATE zrd_map SET map_type=7 WHERE map_cid=27361;
-- et l'ancienne à l'état de case vide
UPDATE zrd_map SET map_type=6 WHERE map_cid=39466;


-- déplacer musicienXXX id 2757 position 223x333 vers 225x328 
-- légions en 91310 (309x182) !?!
-- 1: déplacer d'abord les légions au village de 223x333 vers 225x328
UPDATE zrd_leg SET leg_cid=(SELECT map_cid FROM zrd_map WHERE map_x=225 AND map_y=328)
WHERE leg_mid=2757
-- 1 bis: déplacer ensuite le membre
UPDATE zrd_mbr SET mbr_mapcid=(SELECT map_cid FROM zrd_map WHERE map_x=225 AND map_y=328)
WHERE mbr_mid=2757;
-- 2: initialiser la nouvelle case à l'état village
UPDATE zrd_map SET map_type=7 WHERE map_x=225 AND map_y=328;

-- vérifier aussi pour mid 2585 et 2994
