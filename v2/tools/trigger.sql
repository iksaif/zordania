CREATE TRIGGER tr_hro_mbr AFTER UPDATE
ON zrd_hero FOR EACH ROW
UPDATE zrd_mbr SET mbr_lmodif_date = NOW() WHERE mbr_mid = NEW.hro_mid;

