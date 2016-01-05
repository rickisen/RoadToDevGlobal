SELECT *
FROM language, user
WHERE language.steam_id = user.steam_id
AND lang = $variabel

SELECT *
FROM role, user
WHERE role.steam_id = user.steam_id
AND name = $variabel

SELECT *
FROM user
WHERE user.rank = $variabel

SELECT *
FROM user
WHERE user.age = $variabel

SELECT *
FROM user
WHERE user.age = $variabel