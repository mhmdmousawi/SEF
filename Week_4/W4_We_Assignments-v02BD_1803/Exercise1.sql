

--Query 1 (What is the total number of movies per actor?)
SELECT Concat(A.first_name," ",A.last_name), count(FA.film_id)
from film_actor as FA
join actor as A on A.actor_id = FA.actor_id  
group by Concat(A.first_name," ",A.last_name);

--Query 2 (What are the top 3 languages for movies released in 2006?)
select L.name, count(F.film_id) as filmCount
from film as F
left join language as L on L.language_id = F.language_id
where release_year = 2006
group by L.name
order by filmCount DESC
limit 1