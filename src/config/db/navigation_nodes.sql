INSERT INTO `SITE_DB`.`navigation_nodes` (node_name, node_link, navigation_id)
SELECT 'Pages', '/janitor/page/list', (SELECT id FROM `SITE_DB`.`navigation` WHERE handle = 'main-janitor')
WHERE '/janitor/page/list' NOT IN (
	SELECT node_link FROM `SITE_DB`.`navigation_nodes`
);