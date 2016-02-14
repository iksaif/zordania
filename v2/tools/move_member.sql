DROP PROCEDURE `move_member`//
CREATE PROCEDURE `move_member`( in member int, in move_to int)
BEGIN
  -- position de départ
  declare move_from int;
  select mbr_mapcid into move_from from zrd_mbr where mbr_mid = member;

-- déplacer toutes les légions
UPDATE zrd_leg SET leg_cid= move_to, leg_dest = 0, leg_etat = IF(leg_etat > 3, 3, leg_etat)
  WHERE leg_mid=member;
-- rentrer les légions ennemies
UPDATE zrd_leg SET leg_cid= (SELECT mbr_mapcid FROM zrd_mbr WHERE mbr_mid=leg_mid), leg_dest = 0, leg_etat = IF(leg_etat > 3, 3, leg_etat)
  WHERE leg_dest=move_from;
-- déplacer le village
UPDATE zrd_mbr SET mbr_mapcid= move_to
WHERE mbr_mid = member;
-- type des cases
UPDATE zrd_map SET map_type=7 WHERE map_cid = move_to;
UPDATE zrd_map SET map_type=6 WHERE map_cid = move_from;

END

